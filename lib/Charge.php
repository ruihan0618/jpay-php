<?php

namespace MasJPay;

class Charge extends ApiResource
{
    /**
     * @param null $params
     * @param null $options
     * @return mixed
     * @throws Error\Api
     * @throws Error\InvalidRequest
     */
    public static function retrieve($params = null, $options = null)
    {
        return self::_retrieve($params, $options);
    }

    /**
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return array An array of Charges.
     */
    public static function all($params = null, $options = null)
    {
        return self::_all($params, $options);
    }

    /**
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return Charge The created charge.
     */
    public static function create($params = null, $options = null)
    {
        return self::_create($params, $options);
    }

    /**
     * @param string $id The ID of the charge.
     * @param array|string|null $options
     *
     * @return Charge The reversed charge.
     */
    public static function reverse($id, $options = null)
    {
        $url = static::classUrl().'/'.$id.'/reverse';
        $params = [];
        return static::_directRequest('post', $url, $params, $options);
    }
}
