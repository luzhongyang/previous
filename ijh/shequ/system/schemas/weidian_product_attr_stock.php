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
  'attr_stock_id' => 
  array (
    'field' => 'attr_stock_id',
    'label' => 'ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'product_id' => 
  array (
    'field' => 'product_id',
    'label' => '产品ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'stock_name' => 
  array (
    'field' => 'stock_name',
    'label' => '属性组合',
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
    'SO' => '',
  ),
  'stock_real_name' => 
  array (
    'field' => 'stock_real_name',
    'label' => '属性名称',
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
    'SO' => '',
  ),
    
  'price' => 
  array (
    'field' => 'price',
    'label' => '价格',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '价格',
    'default' => '',
    'SO' => '',
  ),
    'wei_price' => 
  array (
    'field' => 'wei_price',
    'label' => '微店价格',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '微店价格',
    'default' => '',
    'SO' => '',
  ),
  'photo' => 
  array (
    'field' => 'photo',
    'label' => '图片',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '图片',
    'default' => '',
    'SO' => '',
  ),  
  'stock' => 
  array (
    'field' => 'stock',
    'label' => '库存',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '库存',
    'default' => '',
    'SO' => '',
  ),
    'stock_sku' => 
  array (
    'field' => 'stock_sku',
    'label' => '商品编码',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '商品编码',
    'default' => '',
    'SO' => '',
  ),
    'sales' => 
  array (
    'field' => 'sales',
    'label' => '销量',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '销量',
    'default' => '',
    'SO' => '',
  ),
);