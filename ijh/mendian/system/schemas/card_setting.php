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
    'label' => '商家ID',
    'pk' => true,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
    'explain' => 
  array (
    'field' => 'explain',
    'label' => '会员卡说明',
    'pk' => true,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '会员卡说明',
    'default' => '',
    'SO' => false,
  ),
  'birthday' => 
  array (
    'field' => 'birthday',
    'label' => '生日惊喜',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '生日惊喜',
    'default' => '',
    'SO' => '',
  ),
    'member' => 
  array (
    'field' => 'member',
    'label' => '会员专属',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '会员专属',
    'default' => '',
    'SO' => '',
  ),
      'jifen' => 
  array (
    'field' => 'jifen',
    'label' => '积分兑换',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '积分兑换',
    'default' => '',
    'SO' => '',
  ),
);