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
  'pid' => 
  array (
    'field' => 'pid',
    'label' => 'ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => 'ID',
    'default' => '',
    'SO' => '=',
  ),
  'order_id' => 
  array (
    'field' => 'order_id',
    'label' => '订单ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '订单ID',
    'default' => '',
    'SO' => '=',
  ),
    'product_id' => 
  array (
    'field' => 'product_id',
    'label' => '商品ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '商品ID',
    'default' => '',
    'SO' => '=',
  ),
  'product_name' => 
  array (
    'field' => 'product_name',
    'label' => '商品名称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '商品名称',
    'default' => '',
    'SO' => '',
  ),
  'product_price' => 
  array (
    'field' => 'product_price',
    'label' => '商品价格',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'number',
    'comment' => '商品价格',
    'default' => '',
    'SO' => false,
  ),
  'product_number' => 
  array (
    'field' => 'product_number',
    'label' => '商品数量',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'int',
    'comment' => '商品数量',
    'default' => '',
    'SO' => false,
  ),
  'amount' => 
  array (
    'field' => 'amount',
    'label' => '总价',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '总价',
    'default' => '',
    'SO' => '=',
  ),
  'stock_name' => 
  array (
    'field' => 'stock_name',
    'label' => '组合ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '组合ID',
    'default' => '',
    'SO' => '',
  ),
     'stock_real_name' => 
  array (
    'field' => 'stock_real_name',
    'label' => '组合名称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '组合名称',
    'default' => '',
    'SO' => '',
  ),
);