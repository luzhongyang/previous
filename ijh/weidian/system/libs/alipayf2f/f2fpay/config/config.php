<?php

$config = array(
    //支付宝公钥
    'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB",
    //商户私钥
    'merchant_private_key' => "MIICXQIBAAKBgQDcn0oScnVrJ2z0bgcR16JESsrW/b16ioKdNRU8AS+cTLnKvNFUcw4Y98lpaDyhOeFp29gC91fuHakrje+uvk2L4CFd6TvMBXCveCuFR/7OfUihwWGw2pwh6bGmB6OR93MCJPp5pPJflH1uaLk2aWXhpSrUHNtZgJEfmzLsd/RqZwIDAQABAoGAD/MsJb1Eo+SLyfgSZsXSI2HM3FIn2q4c10S5Lkdfq8sYO4H/GD3hLQjs9MPmbjmDBGYybbR4FOzsCAwQ4e88J9g9+xjM5LYJVnR+GPZjIiM+fRCuVkYlXY7PbTYKSyMVkMm1nu9ZFdkevw9tGwH3+zrvvNIQlSuEjWFhb8MW13ECQQD3oM6+nzSS5r1JuD1lUwthWxqSWvq/S22tBq6Uy0l+wbUdGBNfussPZQVHA+XPH1YNfAKrMmeX/ER+eL//u3C9AkEA5BS/pPBdzMS0mFJZ59pPB5QJHqINuCIlJxw3BKXcxExgoRhJsIWlCtg2OZTDvTv/mh20D8mfBOip8onqhenz8wJBAJxf9m82RpMGFz74k/zqhmNCjvMhdPtcfLQpZhIclhrv5Jms3H81jIn6N2zzLyqvFT6Ks3y85eJ6sh5TzpuGGNkCQQCHjME84FGO0dTWthKSlY7kXRlyaDMpHLnh3YXhMEXdL9s5wnqA+1xT7p2DaSNPgqnsyPxraZMlUrU13LtRrPH7AkBIdsTyBjnQiQ6+bxt8NH7LLpPFU2sTV3prKq7YhDJggz1ly00ZbstLPNXKfNGd04BmHhxDSuu65icf96Os4lva",
    //编码格式
    'charset' => "UTF-8",
    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",
    'app_id' => "2016091900546607",
    //异步通知地址,只有扫码支付预下单可用
    'notify_url' => "http://map.feituochina.com/alipay/notify.php",
    //最大查询重试次数
    'MaxQueryRetry' => "10",
    //查询间隔
    'QueryDuration' => "3"
);

$old_config = $config;

$code = 'alipay';
$payment = K::M('payment/payment')->payment($code);
$config = $payment['config'];
$site = K::$system->config->get('site');
if(/* $code == 'wxpay' && */defined('IN_APP')){
    $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
    $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
}else{
    $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'www');
    $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
}
$config['show_url'] = $site['siteurl'];

//test
//$config['alipay_public_key'] = $old_config['alipay_public_key'];
//$config['merchant_private_key'] = $old_config['merchant_private_key'];
//$config['gatewayUrl'] = $old_config['gatewayUrl'];
//$config['app_id'] = $old_config['app_id'];
//test end

$config['alipay_public_key'] = $config['alipay_rsa_public'];
$config['merchant_private_key'] = $config['alipay_rsa_private'];
$config['gatewayUrl'] = "https://openapi.alipay.com/gateway.do";
$config['app_id'] = "2016030701192613";

$config['charset'] = "UTF-8";
$config['MaxQueryRetry'] = "10";
$config['QueryDuration'] = "3";
