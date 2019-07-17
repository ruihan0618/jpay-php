<?php
require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$payload = json_decode(file_get_contents('php://input'), true);

//$payload = '{"status":"success","message":"\u652f\u4ed8\u6210\u529f","event":"charge.succeeded","data":{"id":"ch_98f9a63ef67f2106b966dd03","mode":"sandbox","paid":false,"reversed":false,"refunded":false,"channel":"903","channel_name":"\u652f\u4ed8\u5b9d","pay_mode":"link","order_no":"20190717181833575752","out_order_no":"23f18051f3aa2c115b","client_ip":"219.143.242.250","amount":"0.0100","settle":"0.0003","currency":"CNY","subject":"\u6d4b\u8bd5\u5546\u54c1","body":"\u6d4b\u8bd5\u5546\u54c1","metadata":"\u81ea\u5b9a\u4e49\u6570\u636e","time_create":"1563358713","time_expire":1564654713,"time_paid":"","time_settle":"","time_close":"","transaction_no":"","refunds":{"url":"\/v1\/refunds\/","id":null,"data":{"amount":"0.0100","refund":null}},"description":"","sign":"8B64A10AADC86B97FEEBD964370D5C7C"}}';

try {
    $webhook = \MasJPay\Webhook::constructEvent($payload);
    echo $webhook."\r\n";
}  catch(\MasJPay\Error\SignatureVerification $e) {
   echo $e->getMessage()."\r\n";
}