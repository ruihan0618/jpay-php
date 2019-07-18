<?php
require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$payload = file_get_contents('php://input');

//$payload = '{"status":"success","message":"\u652f\u4ed8\u6210\u529f","event":"charge.succeeded","data":{"id":"ch_74986947ca556dca01688d01","mode":"sandbox","paid":false,"reversed":false,"refunded":false,"channel":"903","channel_name":"\u652f\u4ed8\u5b9d","pay_mode":"link","order_no":"20190718115844529957","out_order_no":"a564865219d4fc8a75","client_ip":"219.143.242.250","amount":"0.0100","settle":"0.0003","currency":"CNY","subject":"\u6d4b\u8bd5\u5546\u54c1","body":"\u6d4b\u8bd5\u5546\u54c1","metadata":"\u81ea\u5b9a\u4e49\u6570\u636e","time_create":"1563422324","time_expire":1564718324,"time_paid":"","time_settle":"","time_close":"","transaction_no":"","refunds":{"url":"\/v1\/refunds\/","id":null,"data":{"amount":"0.0100","refund":null}},"description":"","sign":"A69E73BEF35BE4E0AF07F39D6F4EB258"}}';

try {
    $webhook = \MasJPay\Webhook::constructEvent($payload);
    echo $webhook."\r\n";
}  catch(\MasJPay\Error\SignatureVerification $e) {
   echo $e->getMessage()."\r\n";
}