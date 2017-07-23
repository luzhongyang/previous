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
  'reply_id' => 
  array (
    'field' => 'reply_id',
    'label' => '素材ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '素材ID',
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
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),

  'title' => 
  array (
    'field' => 'title',
    'label' => '素材名称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '素材名称',
    'default' => '',
    'SO' => 'like',
  ),
  'intro' => 
  array (
    'field' => 'intro',
    'label' => '描述',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => true,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'html',
    'comment' => '描述',
    'default' => '',
    'SO' => false,
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
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),

  'jumpurl' => 
  array (
    'field' => 'jumpurl',
    'label' => '跳转URL',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => true,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),

'content' => 
  array (
    'field' => 'content',
    'label' => '图文详情',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => true,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'editor',
    'comment' => '图文详情',
    'default' => '',
    'SO' => false,
  ),

  'views' => 
  array (
    'field' => 'views',
    'label' => '排序',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'dateline' => 
  array (
    'field' => 'dateline',
    'label' => '创建时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'dateline',
    'comment' => '创建时间',
    'default' => '',
    'SO' => 'betweendate',
  )
);