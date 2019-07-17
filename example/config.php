<?php

//获取方式：登录 [Dashboard](https://jpay.weidun.biz)->商户后台->右上角API开发-> APIKEY
const CLIENT_ID = '10030';
const APP_KEY = 'u6umnrba7fc4j47aujd3na8h27t5dxce';

\MasJPay\MasJPay::setDebug(true); //调试模式   true /false
\MasJPay\MasJPay::setApiMode('sandbox'); //环境  live 线上，sandbox 沙盒
\MasJPay\MasJPay::setClientId(CLIENT_ID);   // 设置 CLIENT ID
\MasJPay\MasJPay::setApiKey(APP_KEY);    // 设置 API Key