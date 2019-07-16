<?php

namespace MasJPay;

class Refund extends ApiResource
{
    /**
     * @return string
     * @throws Error\InvalidRequest
     */
    public function instanceUrl()
    {
        $id = $this['id'];
        $charge = $this['charge'];
        if (!$id) {
            throw new Error\InvalidRequest(
                "Could not determine which URL to request: " .
                "class instance has invalid ID: $id",
                null
            );
        }
        $id = Util\Util::utf8($id);
        $charge = Util\Util::utf8($charge);

        $base = Refund::classUrl();
        $chargeExtn = urlencode($charge);
        $extn = urlencode($id);
        return "$base/$chargeExtn/refunds/$extn";
    }

    public static function classUrlWithChargeId($charge_id)
    {
        return Refund::instanceUrlWithId($charge_id);
    }

    public static function instanceUrlWithRefundId($charge_id, $refund_id)
    {
        $base_url = Refund::instanceUrlWithId($charge_id);
        return $base_url . '/' . $refund_id;
    }

    /**
     * @param $charge_id
     * @param $params
     * @param $options
     * @return array|MasJPayObject
     */
    public static function create($charge_id, $params, $options = null)
    {
        $url = static::classUrl()."/";

        $params['ch'] = $charge_id;
        return static::_directRequest('post', $url, $params, $options);
    }

    /**
     * @param $charge_id
     * @param $params
     * @param $options
     * @return array|MasJPayObject
     */
    public static function retrieve($charge_id, $params, $options = null)
    {
        $url = static::classUrl()."/retrieve";

        $params['ch'] = $charge_id;

        return static::_directRequest('post', $url, $params, $options);
    }

    public static function all($charge_id, $params, $options = null)
    {
        $url = self::classUrlWithChargeId($charge_id);
        return static::_directRequest('get', $url, $params, $options);
    }
}
