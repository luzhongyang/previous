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
  'level_id' => 
  array (
    'field' => 'level_id',
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
  'group_id' => 
  array (
    'field' => 'group_id',
    'label' => '团ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '团ID',
    'default' => '',
    'SO' => '=',
  ),
  'product_id' => 
  array (
    'field' => 'product_id',
    'label' => '团产品id',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '团产品id',
    'default' => '',
    'SO' => '=',
  ),
    'level' => 
  array (
    'field' => 'level',
    'label' => '团级别',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '团级别',
    'default' => '',
    'SO' => '=',
  ),
  'user_num' => 
  array (
    'field' => 'user_num',
    'label' => '成团人数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '3表示 达到3人的价格,  10表示达到10人的价格, 如果是7人,则调用3人的价格',
    'default' => '',
    'SO' => '=',
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
    'comment' => '单价',
    'default' => '',
    'SO' => '=',
  ),
);