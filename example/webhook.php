<?php
require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$payload = file_get_contents('php://input');
try {
    $webhook = \MasJPay\Webhook::constructEvent($payload);
    echo $webhook."\r\n";
}  catch(\MasJPay\Error\SignatureVerification $e) {
   echo $e->getMessage()."\r\n";
}