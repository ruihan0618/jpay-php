<?php

namespace MasJPay;

use MasJPay\Error\InvalidRequest;

abstract class ApiResource extends MasJPayObject
{
    private static $HEADERS_TO_PERSIST = ['JPay-Version' => true];

    protected static $signOpts = [
        'uri' => true,
        'time' => true,
    ];

    public static function baseUrl()
    {
        return MasJPay::$apiBase;
    }

    /**
     * @return $this
     * @throws InvalidRequest
     */
    public function refresh()
    {
        $requestor = new ApiRequestor($this->_opts->apiKey, static::baseUrl(), $this->_opts->signOpts);
        $url = $this->instanceUrl();

        list($response, $this->_opts->apiKey) = $requestor->request(
            'get',
            $url,
            $this->_retrieveOptions,
            $this->_opts->headers
        );
        $this->refreshFrom($response, $this->_opts);
        return $this;
    }

    /**
     * @return string The name of the class, with namespacing and underscores
     *    stripped.
     */
    public static function className()
    {
        $class = get_called_class();
        // Useful for namespaces: Foo\Charge
        if ($postfix = strrchr($class, '\\')) {
            $class = substr($postfix, 1);
        }
        // Useful for underscored 'namespaces': Foo_Charge
        if ($postfixFakeNamespaces = strrchr($class, '')) {
            $class = $postfixFakeNamespaces;
        }
        if (substr($class, 0, strlen('JPay')) == 'JPay') {
            $class = substr($class, strlen('JPay'));
        }
        $class = str_replace('_', '', $class);
        $name = urlencode($class);
        $name = strtolower($name);
        return $name;
    }

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/v1/${base}s";
    }


    /**
     * @param $list
     * @return string
     * @throws InvalidRequest
     */
    public static function createSign($list){

        $_params = self::parseToArray($list,[]);

        ksort($_params);
        $md5str = "";
        foreach ($_params as $key => $val) {
            if (!empty($val)) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
        }
        $sign = strtoupper(md5($md5str . "key=" . MasJPay::$apiKey));
        return $sign;
    }


    /**
     * @param $params
     * @param $_params
     * @return mixed
     */
    public static function parseToArray($params,$_params){

        if(is_null($params)){
            return $_params;
        }

        if(is_string($params)){
            return $_params;
        }

        if(!is_array($params)){
            return $_params;
        }

        $params['client_id'] = MasJPay::$clientId;

        foreach ($params as $key=>$param){
            if(is_array($param)){
                foreach ($param as $k=>$p){
                    $_params[$k] = $p;
                }
            }else{
                $_params[$key] = $param;
            }
        }
        return $_params;
    }


    /**
     * @return string The full API URL for this API resource.
     */
    public function instanceUrl()
    {
        $id = $this['id'];
        $class = get_called_class();
        if ($id === null) {
            $message = "Could not determine which URL to request: "
                . "$class instance has invalid ID: $id";
            throw new Error\InvalidRequest($message, null);
        }
        $id = Util\Util::utf8($id);
        $base = static::classUrl();
        $extn = urlencode($id);
        return "$base/retrieve/$extn";
    }

    /**
     * @return string The full API URL for this API resource.
     */
    public static function instanceUrlWithId($id)
    {
        $class = get_called_class();
        if ($id === null) {
            $message = "Could not determine which URL to request: "
                . "$class instance has invalid ID: $id";
            throw new Error\InvalidRequest($message, null);
        }
        $id = Util\Util::utf8($id);
        $base = static::classUrl();
        $extn = urlencode($id);
        return "$base/$extn";
    }

    private static function _validateParams($params = null)
    {
        if ($params && !is_array($params)) {
            $message = "You must pass an array as the first argument to JPay API "
               . "method calls.";
            throw new Error\Api($message);
        }
    }

    protected function _request($method, $url, $params = [], $options = null)
    {
        $opts = $this->_opts->merge($options);
        return static::_staticRequest($method, $url, $params, $opts);
    }

    /**
     * @param $method
     * @param $url
     * @param $params
     * @param $options
     * @return array
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _staticRequest($method, $url, $params, $options)
    {
        $opts = Util\RequestOptions::parse($options);
        $opts->mergeSignOpts(static::$signOpts);

        //sign
        $sign = self::createSign($params);

        $params = array_merge($params, ['sign'=>$sign]);

        $requestor = new ApiRequestor($opts->apiKey, static::baseUrl(), $opts->signOpts);

        list($response, $opts->apiKey) = $requestor->request($method, $url, $params, $opts->headers);
        foreach ($opts->headers as $k => $v) {
            if (!array_key_exists($k, self::$HEADERS_TO_PERSIST)) {
                unset($opts->headers[$k]);
            }
        }
        return [$response, $opts];
    }

    /**
     * @param $params
     * @param null $options
     * @return mixed
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _retrieve($params, $options = null)
    {

        self::_validateParams($params);
        $url = static::classUrl()."/retrieve/".$params['ch'];

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        return Util\Util::convertToJPayObject($response, $opts);


    }

    protected static function _all($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $options);
        return Util\Util::convertToJPayObject($response, $opts);
    }

    protected static function _create($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        return Util\Util::convertToJPayObject($response, $opts);
    }

    protected function _save($options = null)
    {
        $params = $this->serializeParameters();
        if (count($params) > 0) {
            $url = $this->instanceUrl();
            list($response, $opts) = $this->_request('put', $url, $params, $options);
            $this->refreshFrom($response, $opts);
        }
        return $this;
    }

    protected function _delete($params = null, $options = null)
    {
        self::_validateParams($params);

        $url = $this->instanceUrl();
        list($response, $opts) = $this->_request('delete', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    protected static function _directRequest($method, $url, $params = null, $options = null)
    {
        self::_validateParams($params);

        list($response, $opts) = static::_staticRequest($method, $url, $params, $options);
        return Util\Util::convertToJPayObject($response, $opts);
    }
}
