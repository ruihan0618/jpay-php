<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

// 查询 charge 对象
try {
    $refund = \MasJPay\Refund::retrieve('ch_fc37312aa31fc628f65c8a30',[
        'refund_id' => 're_712f83a2f0291ab81602959d'
    ]);
    echo $refund."\r\n";
} catch (\MasJPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
