<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';

//转账
$channel = '903'; $orderNo = substr(md5(time()), 0, 18);
try {
    $transfer = \MasJPay\Transfer::create([
        'out_order_no' => $orderNo,
        'amount'       => '1', //转账金额 人民币元
        'channel'      => $channel,    // 代付渠道，当前默认值 903
        'bank'  => [    //转账银行信息
            'name'=> '支付宝',  //名称，支付宝
            'sub'=> '支付宝',  //子名称，支付宝
            'account' => '陈云波',  //实名姓名
            'card' => 'cyb929@163.com',  //支付宝账号
            'province'  => 'beijing', //省份
            'city'  => 'beijing' //成分
        ],
        'extra'     => '用户转账',   //原样返回
        'notify'=> 'http://localhost/notify.html',   //异步通知地址
    ]);
    echo $transfer;                                       // 输出 返回的支付凭据 Charge
} catch (\MasJPay\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
