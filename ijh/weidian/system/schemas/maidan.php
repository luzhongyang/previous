<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

return array (
  'shop_id' => 
  array (
    'field' => 'shop_id',
    'label' => '商户ID',
    'pk' => true,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
 
  'type' => 
  array (
    'field' => 'type',
    'label' => '优惠类型',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '0',
    'SO' => false,
  ),
  'config' => 
  array (
    'field' => 'config',
    'label' => '优惠',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'discount' => 
  array (
    'field' => 'discount',
    'label' => '折扣',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '100',
    'SO' => false,
  ),
  'max_youhui' => 
  array (
    'field' => 'max_youhui',
    'label' => '优惠上限',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '',
    'default' => '0.00',
    'SO' => false,
  ),
    'orders' => 
  array (
    'field' => 'orders',
    'label' => '订单数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '',
    'default' => '0',
    'SO' => false,
  ),
);