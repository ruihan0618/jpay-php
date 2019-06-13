<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';


// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$input_data = json_decode(file_get_contents('php://input'), true);

$channel = '905';  $orderNo = substr(md5(time()), 0, 12);

try {
    $ch = \JPay\Charge::create([
            'product' =>[
                'name'      => '测试商品',   //商品名称
                'desc'      => '测试商品',   //商品描述
                'amount'    => '12.0',                 // 订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'currency'  => strtoupper('cny'),  //支付币种
                'quantity'  => '1'
            ],
            'openid'    => '23232323',
            'create'    => time(),
            'out_order_no' => $orderNo,
            'extra'     => '商品测试',                  //原样返回
            'channel'   => $channel,                // 支付使用的第三方支付渠道取值
            'client_ip' => '1.1.1.1', // 发起支付请求客户端的 IP 地址，格式为 IPV4，如: 127.0.0.1
            'notify'=> 'http://www.imerl.com',   //异步通知地址
            'callback'=>'http://www.imerl.com',  //同步地址
        ]);
    echo $ch;                                       // 输出 返回的支付凭据 Charge
} catch (\JPay\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}