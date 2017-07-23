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
  'log_id' => 
  array (
    'field' => 'log_id',
    'label' => '日志ID',
    'pk' => true,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '日志ID',
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
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '订单ID',
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
'staff_id' => 
  array (
    'field' => 'staff_id',
    'label' => '服务人员ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '服务人员ID',
    'default' => '',
    'SO' => '=',
  ),
  'reply' => 
  array (
    'field' => 'reply',
    'label' => '回复内容',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '回复内容',
    'default' => '',
    'SO' => false,
  ),
  'cuitime' => 
  array (
    'field' => 'cuitime',
    'label' => '催单时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '催单时间',
    'default' => '',
    'SO' => 'false',
  ),
  'replytime' => 
  array (
    'field' => 'replytime',
    'label' => '回复时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '回复时间',
    'default' => '',
    'SO' => 'false',
  ),
);