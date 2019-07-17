<?php

if (!function_exists('curl_init')) {
    throw new Exception('JPay needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('JPay needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
    throw new Exception('JPay needs the Multibyte String PHP extension.');
}

// singleton
require(dirname(__FILE__) . '/lib/MasJPay.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/Util.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');
require(dirname(__FILE__) . '/lib/Util/RequestOptions.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/RateLimit.php');
require(dirname(__FILE__) . '/lib/Error/SignatureVerification.php');

// Plumbing
require(dirname(__FILE__) . '/lib/JsonSerializable.php');
require(dirname(__FILE__) . '/lib/MasJPayObject.php');
require(dirname(__FILE__) . '/lib/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/AppBase.php');

// API Resources
require(dirname(__FILE__) . '/lib/Charge.php');
require(dirname(__FILE__) . '/lib/Refund.php');
require(dirname(__FILE__) . '/lib/Transfer.php');
require(dirname(__FILE__) . '/lib/WithDrawal.php');
require(dirname(__FILE__) . '/lib/Channel.php');
require(dirname(__FILE__) . '/lib/Webhook.php');
require(dirname(__FILE__) . '/lib/WebhookSignature.php');
