<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

// 查询 charge 对象
$charge_id = 'ch_4cdcaed1cedb2a0650f2398d';
try {
    $charge = \MasJPay\Refund::retrieve($charge_id);
    echo $charge."\r\n";
} catch (\MasJPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
