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
  'pintuan_level_id' => 
  array (
    'field' => 'pintuan_level_id',
    'label' => '主键',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '主键',
    'default' => '',
    'SO' => '=',
  ),
  'pintuan_product_id' => 
  array (
    'field' => 'pintuan_product_id',
    'label' => '团产品id',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '团产品id,',
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
    'default' => '1',
    'SO' => false,
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
    'comment' => '成团人数   3表示 达到3人的价格,  10表示达到10人的价格, 如果是7人,则调用3人的价格',
    'default' => '1',
    'SO' => false,
  ),
  'price' => 
  array (
    'field' => 'price',
    'label' => '团购价',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'number',
    'comment' => '团购价',
    'default' => '0.00',
    'SO' => false,
  ),
);