# JPay PHP bindings

[![Build Status](https://travis-ci.org/JPay/JPay-php.svg?branch=master)](https://travis-ci.org/JPay/JPay-php)
[![Latest Stable Version](https://poser.pugx.org/JPay/JPay-php/v/stable.svg)](https://packagist.org/packages/JPay/JPay-php)
[![Total Downloads](https://poser.pugx.org/JPay/JPay-php/downloads.svg)](https://packagist.org/packages/JPay/JPay-php)
[![License](https://poser.pugx.org/JPay/JPay-php/license.svg)](https://packagist.org/packages/JPay/JPay-php)
[![Code Coverage](https://coveralls.io/repos/JPay/JPay-php/badge.svg?branch=master)](https://coveralls.io/r/JPay/JPay-php?branch=master)

You can sign up for a JPay account at https://jpay.weidun.biz.

## Requirements

PHP 5.6.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require chuangxiangjpay/jpay-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/chuangxiangjpay/jpay-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/jpay-php/init.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started

Simple usage looks like:

```php
\JPay\JPay::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
$charge = \JPay\Charge::create([
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
echo $charge;
```

## Documentation

Please see https://jpay.weidun.biz/docs/api for up-to-date documentation.

## Development

Get [Composer][composer]. For example, on Mac OS:

```bash
brew install composer
```

Install dependencies:

```bash
composer install
```

Install dependencies as mentioned above (which will resolve [PHPUnit](http://packagist.org/packages/phpunit/phpunit)), then you can run the test suite:

```bash
./vendor/bin/phpunit
```

Or to run an individual test file:

```bash
./vendor/bin/phpunit tests/UtilTest.php
```

The method should be called once, before any request is sent to the API. The second and third parameters are optional.