<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * #fileid#
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
return array (
  'app_id' => 
  array (
    'label' => 'APPID',
    'field' => 'app_id',
    'type' => 'text',
    'default' => '',
    'comment' => '支付宝开放平台应用APPID',
    'html' => false,
    'empty' => false,
  ),
  'redirect_uri' => 
  array (
    'label' => '授权回调地址',
    'field' => 'redirect_uri',
    'type' => 'text',
    'default' => '',
    'comment' => '授权回调地址',
    'html' => false,
    'empty' => false,
  ),
  'app_rsa_private_key' => 
  array (
    'label' => '应用私钥',
    'field' => 'app_rsa_private_key',
    'type' => 'text',
    'default' => '',
    'comment' => '支付宝应用私钥(RSA)',
    'html' => false,
    'empty' => false,
  ),
  'alipay_rsa_public_key' => 
  array (
    'label' => '支付宝公钥',
    'field' => 'alipay_rsa_public_key',
    'type' => 'text',
    'default' => '',
    'comment' => '支付宝公钥(RSA)',
    'html' => false,
    'empty' => false,
  ),
);