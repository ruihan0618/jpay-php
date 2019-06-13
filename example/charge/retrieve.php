<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

// 查询 charge 对象
$charge_id = 'ch_4WjrXPPOm1K08yLqn1LmzbTO';
try {
    $charge = \JPay\Charge::retrieve(['ch'=>$charge_id]);
    echo $charge;
} catch (\JPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
