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
'order_id' => 
  array (
    'field' => 'order_id',
    'label' => '订单ID',
    'pk' => true,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '订单ID',
    'default' => '',
    'SO' => '=',
  ),
  'product_number' => 
  array (
    'field' => 'product_number',
    'label' => '商品数量',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '商品数量',
    'default' => '0',
    'SO' => '=',
  ),
  'product_price' => 
  array (
    'field' => 'product_price',
    'label' => '商品总价',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '商品总价',
    'default' => '0.00',
    'SO' => '',
  ),
  'package_price' => 
  array (
    'field' => 'package_price',
    'label' => '打包费',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '打包费, 0:免打包费',
    'default' => '0.00',
    'SO' => 'between',
  ),
  'freight' => 
  array (
    'field' => 'freight',
    'label' => '运费',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '运费',
    'default' => '0.00',
    'SO' => '',
  ),
   'spend_number' => 
  array (
    'field' => 'spend_number',
    'label' => 'spend_number',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '自提单核销密码',
    'default' => '0',
    'SO' => '=',
  ),
   'spend_status' => 
  array (
    'field' => 'spend_status',
    'label' => 'spend_status',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '自提单核销状态',
    'default' => '0',
    'SO' => '=',
  ),
);