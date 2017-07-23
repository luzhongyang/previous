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
    'add' => false,
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
  'goods_id' => 
  array (
    'field' => 'goods_id',
    'label' => '商品ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '商品ID',
    'default' => '',
    'SO' => '=',
  ),
  'uid' => 
  array (
    'field' => 'uid',
    'label' => '用户ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '用户ID',
    'default' => '',
    'SO' => '=',
  ),  
    'num' => 
  array (
    'field' => 'num',
    'label' => '购买次数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '购买次数',
    'default' => '',
    'SO' => '=',
  ),    
  'use_coin' => 
  array (
    'field' => 'use_coin',
    'label' => '使用夺宝币',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '使用夺宝币',
    'default' => '',
    'SO' => '=',
  ),   
      'order_status' => 
  array (
    'field' => 'order_status',
    'label' => '订单状态',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '订单状态',
    'default' => '',
    'SO' => '=',
  ), 
  'microtime' => 
  array (
    'field' => 'microtime',
    'label' => '毫秒数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '毫秒数',
    'default' => '000',
    'SO' => false,
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
    'clientip' => 
  array (
    'field' => 'clientip',
    'label' => '客户ip',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '客户ip',
    'default' => '',
    'SO' => '=',
  ),
);