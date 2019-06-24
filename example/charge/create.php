<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';


// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$input_data = json_decode(file_get_contents('php://input'), true);

$channel = '901';  $orderNo = substr(md5(time()), 0, 18);

try {
    $ch = \MasJPay\Charge::create([
            'product' =>[
                'name'      => '测试商品',   //商品名称
                'desc'      => '测试商品',   //商品描述
                'amount'    => '0.01',                 // 订单总金额, 人民币单位：元
                'currency'  => strtoupper('usd'),  //支付币种
                'quantity'  => '1'
            ],
            'wechat'    =>[
                'mode'      => 'link',  //微信渠道901 ，支付模式，jsapi 微信公众号、native 扫码支付、mweb H5 支付 ,link 返回支付链接跳转
                'openid'    => '23232323',
            ],
            'alipay'    =>[
                'mode'      => 'native',  //支付宝渠道903 ，支付模式, native 扫码支付、mweb H5 支付,link 返回支付链接跳转
                'form'      =>  1  ////支付宝渠道903 ，支付模式, native 扫码支付、mweb H5 支付,link 返回支付链接跳转
            ],
            'create'    => time(),
            'out_order_no' => $orderNo,
            'extra'     => '商品测试',                  //原样返回
            'channel'   => $channel,                // 支付使用的第三方支付渠道取值
            'client_ip' => '1.1.1.1', // 发起支付请求客户端的 IP 地址，格式为 IPV4，如: 127.0.0.1
            'notify'=> 'http://localhost/notify.html',   //异步通知地址
            'callback'=>'http://localhost/callback.html',  //同步地址
        ]);
    echo $ch;                                       // 输出 返回的支付凭据 Charge
} catch (\MasJPay\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
