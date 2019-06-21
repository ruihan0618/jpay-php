<?php

namespace MasJPay;

class AppBase extends ApiResource
{
    /**
     * @return string
     * @throws Error\InvalidRequest
     */
    public static function appBaseUrl()
    {
        if (MasJPay::$clientId === null) {
            throw new Error\InvalidRequest(
                'Please set a global app ID by MasJPay::setAppId(<apiKey>)',
                null
            );
        }
        $appId = Util\Util::utf8(MasJPay::$clientId);
        return "/v1/apps/${appId}";
    }

    /**
     * @return string
     * @throws Error\InvalidRequest
     */
    public static function classUrl()
    {
        $base = static::appBaseUrl();
        $resourceName = static::className();
        return "${base}/${resourceName}s";
    }
}
