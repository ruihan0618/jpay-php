<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

// 查询 charge 对象
$refund_id = 're_e39bf65e7759aa7082f805fe';
try {
    $refund = \MasJPay\Refund::retrieve($refund_id);
    echo $refund."\r\n";
} catch (\MasJPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
