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
  'product_id' => 
  array (
    'field' => 'product_id',
    'label' => '商品ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '商品ID',
    'default' => '',
    'SO' => '=',
  ),
  'shop_id' => 
  array (
    'field' => 'shop_id',
    'label' => '商户ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '商户ID',
    'default' => '',
    'SO' => '=',
  ),
  'cate_id' => 
  array (
    'field' => 'cate_id',
    'label' => '分类ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '分类ID',
    'default' => '',
    'SO' => '=',
  ),
  'title' => 
  array (
    'field' => 'title',
    'label' => '商品名称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '商品名称',
    'default' => '',
    'SO' => 'like',
  ),
  'photo' => 
  array (
    'field' => 'photo',
    'label' => '图片',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'photo',
    'comment' => '图片',
    'default' => '',
    'SO' => false,
  ),
  'price' => 
  array (
    'field' => 'price',
    'label' => '价格',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '价格',
    'default' => '0.00',
    'SO' => 'between',
  ),
  'package_price' => 
  array (
    'field' => 'package_price',
    'label' => '打包费',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '打包费, 0:免打包费',
    'default' => '0.00',
    'SO' => 'between',
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
    'SO' => 'between',
  ),
  'sale_type' => 
  array (
    'field' => 'sale_type',
    'label' => '是否限购',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '是否限购 0：普通，1：限量',
    'default' => '',
    'SO' => '=',
  ),
  'sale_sku' => 
  array (
    'field' => 'sale_sku',
    'label' => '限购数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '限购数',
    'default' => '',
    'SO' => 'between',
  ),
  'sale_count' => 
  array (
    'field' => 'sale_count',
    'label' => '已购数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '已购数',
    'default' => '',
    'SO' => 'between',
  ),
  'intro' => 
  array (
    'field' => 'intro',
    'label' => '描述',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'textarea',
    'comment' => '描述',
    'default' => '',
    'SO' => false,
  ),
  'orderby' => 
  array (
    'field' => 'orderby',
    'label' => '排序',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '排序',
    'default' => '50',
    'SO' => '=',
  ),
  'closed' => 
  array (
    'field' => 'closed',
    'label' => '删除标识',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '删除标识',
    'default' => '',
    'SO' => false,
  ),
  'clientip' => 
  array (
    'field' => 'clientip',
    'label' => '创建IP',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '创建IP',
    'default' => '',
    'SO' => 'betweendate',
  ),
  'dateline' => 
  array (
    'field' => 'dateline',
    'label' => '创建时间',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'dateline',
    'comment' => '创建时间',
    'default' => '',
    'SO' => false,
  ),
  'spec' => 
  array (
    'field' => 'spec',
    'label' => '商品规格冗余',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'textarea',
    'comment' => '商品规格冗余',
    'default' => '',
    'SO' => false,
  ),
  'is_spec' => 
  array (
    'field' => 'is_spec',
    'label' => '是否有规格',
    'pk' => false,
    'add' => false,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '0:无规格,1:有规格',
    'default' => '',
    'SO' => false,
  ),
    'is_onsale' => 
  array (
    'field' => 'is_onsale',
    'label' => '上架状态',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '0:上架,1:下架',
    'default' => '',
    'SO' => false,
  ),
);