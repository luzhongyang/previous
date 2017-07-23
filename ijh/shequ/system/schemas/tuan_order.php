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
  'tuan_id' => 
  array (
    'field' => 'tuan_id',
    'label' => '团购ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '团购ID',
    'default' => '',
    'SO' => '=',
  ),
  'tuan_title' => 
  array (
    'field' => 'tuan_title',
    'label' => '标题',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '标题',
    'default' => '',
    'SO' => 'like',
  ),
  'tuan_price' => 
  array (
    'field' => 'tuan_price',
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
  'tuan_number' => 
  array (
    'field' => 'tuan_number',
    'label' => '团购券',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '团购券',
    'default' => '',
    'SO' => 'between',
  ),
  'use_time' => 
  array (
    'field' => 'use_time',
    'label' => '使用时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '使用时间,多张券时只要有一张了就时间了',
    'default' => '',
    'SO' => 'betweendate',
  ),
  'tuan_photo' => 
  array (
    'field' => 'tuan_photo',
    'label' => '图片',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '图片',
    'default' => '',
    'SO' => '',
  ),
  'type' => 
  array (
    'field' => 'type',
    'label' => '类型',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '类型',
    'default' => '',
    'SO' => '',
  ), 
  'ltime' => 
  array (
    'field' => 'ltime',
    'label' => '过期时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '过期时间',
    'default' => '',
    'SO' => 'betweendate',
  ),  
);