<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';


// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$input_data = json_decode(file_get_contents('php://input'), true);

$channel = '903'; $orderNo = substr(md5(time()), 0, 18);
try {
    $refund = \MasJPay\Refund::create('ch_4cdcaed1cedb2a0650f2398d',
        [
        'total_fee' => '0.01',
        'refund_fee' =>'0.01',
        'refund_reason' => '东西不要了',
    ]);
    echo $refund;                                       // 输出 返回的支付凭据 Charge
} catch (\MasJPay\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
