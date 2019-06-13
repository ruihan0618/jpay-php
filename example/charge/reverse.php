<?php
require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

$charge_id = 'ch_bTyjfTnzHCaHOyjbzP4mHmX1';
try {
    $charge = \JPay\Charge::reverse($charge_id);
    echo $charge;
} catch (\JPay\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
