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
    'label' => '订单号',
    'pk' => true,
    'add' => true,
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
  'card_id' => 
  array (
    'field' => 'card_id',
    'label' => '会员卡ID',
    'pk' => false,
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
  'type' => 
  array (
    'field' => 'type',
    'label' => '类型',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => 'cash',
    'SO' => false,
  ),
  'give_money' => 
  array (
    'field' => 'give_money',
    'label' => '赠送金额',
    'pk' => false,
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
  'give_jifen' => 
  array (
    'field' => 'give_jifen',
    'label' => '赠送积分',
    'pk' => false,
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
  )
);