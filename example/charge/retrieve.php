<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

// 查询 charge 对象
$charge_id = 'ch_ebfd7acb2697400760d606d3';
try {
    $charge = \MasJPay\Charge::retrieve($charge_id);
    echo $charge."\r\n";
} catch (\MasJPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
