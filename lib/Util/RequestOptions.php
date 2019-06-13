<?php

namespace JPay\Util;

use JPay\Error;

class RequestOptions
{
    public $headers;
    public $apiKey;
    public $clientId;
    public $signOpts;

    public function __construct($key = null, $clientId = null, $headers = [], $signOpts = [])
    {
        $this->apiKey = $key;
        $this->clientId = $clientId;
        $this->headers = $headers;
        $this->signOpts = $signOpts;
    }


    public function merge($options)
    {
        $_options = self::parse($options);
        if ($_options->apiKey === null) {
            $_options->apiKey = $this->apiKey;
        }
        $_options->headers = array_merge($this->headers, $_options->headers);
        return $_options;
    }


    public static function parse($options)
    {

        if ($options instanceof self) {
            return $options;
        }

        if (is_null($options)) {
            return new RequestOptions(null, []);
        }

        if (is_string($options)) {
            return new RequestOptions($options, []);
        }

        if (is_array($options)) {
            $headers = []; $key = null; $signOpts = [];
            if (array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
            }
            if (array_key_exists('JPay_version', $options)) {
                $headers['JPay-Version'] = $options['JPay_version'];
            }
            if (array_key_exists('sign_opts', $options)) {
                $signOpts = $options['sign_opts'];
            }
            return new RequestOptions($key, $headers, $signOpts);
        }

        $message = 'The second argument to JPay API method calls is an '
           . 'optional per-request apiKey, which must be a string, or '
           . 'per-request options, which must be an array. (HINT: you can set '
           . 'a global apiKey by "JPay::setApiKey(<apiKey>)")';
        throw new Error\Api($message);
    }


    public static function parseWithSignOpts($opts, $signOpts)
    {
        $options = self::parse($opts);
        $options->signOpts = array_merge($options->signOpts, $signOpts);
        return $options;
    }

    
    public function mergeSignOpts($signOpts)
    {
        $this->signOpts = array_merge($this->signOpts, $signOpts);
        return $this;
    }
}
