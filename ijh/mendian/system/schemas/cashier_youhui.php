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
  'youhui_id' => 
  array (
    'field' => 'youhui_id',
    'label' => 'ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'shop_id' => 
  array (
    'field' => 'shop_id',
    'label' => '商户',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
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
  'youhui' => 
  array (
    'field' => 'youhui',
    'label' => '立减金额',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'number',
    'comment' => '',
    'default' => '0.00',
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
    'show' => false,
    'list' => true,
    'type' => 'number',
    'comment' => '',
    'default' => '100',
    'SO' => false,
  ),
);