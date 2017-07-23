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
  'pf_order_detail_id' => 
  array (
    'field' => 'pf_order_detail_id',
    'label' => '主键',
    'pk' => true,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'pf_product_id' => 
  array (
    'field' => 'pf_product_id',
    'label' => '平台产品id',
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
    'SO' => '=',
  ),
  'product_name' => 
  array (
    'field' => 'product_name',
    'label' => '产品名称',
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
    'SO' => 'like',
  ),
  'price' => 
  array (
    'field' => 'price',
    'label' => '单价',
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
  'quantity' => 
  array (
    'field' => 'quantity',
    'label' => '数量',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '1',
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
    'type' => 'number',
    'comment' => '',
    'default' => '0.00',
    'SO' => false,
  ),
  'total' => 
  array (
    'field' => 'total',
    'label' => '总价',
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
);