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
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '订单ID',
    'default' => '',
    'SO' => '=',
  ),
  'cate_id' => 
  array (
    'field' => 'cate_id',
    'label' => '服务项目分类ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '服务项目分类ID',
    'default' => '',
    'SO' => '=',
  ),
  'cate_title' => 
  array (
    'field' => 'cate_title',
    'label' => '服务项目名称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '服务项目名称',
    'default' => '',
    'SO' => 'like',
  ),
  'jiesuan_price' => 
  array (
    'field' => 'jiesuan_price',
    'label' => '结算价格',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '结算价格',
    'default' => '0.00',
    'SO' => false,
  ),
    'fuwu_time' => 
  array (
    'field' => 'fuwu_time',
    'label' => '服务时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '服务时间',
    'default' => '0',
    'SO' => false,
  ),
    'danbao_amount' => 
  array (
    'field' => 'danbao_amount',
    'label' => '担保金额',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '担保金额',
    'default' => '0',
    'SO' => false,
  ),
);