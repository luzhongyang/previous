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
  'group_id' => 
  array (
    'field' => 'group_id',
    'label' => '主键',
    'pk' => true,
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
  'platform' => 
  array (
    'field' => 'platform',
    'label' => '平台',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'select',
    'comment' => '',
    'default' => 'baidu',
    'SO' => '=',
  ),
  'group_name' => 
  array (
    'field' => 'group_name',
    'label' => '简称',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '英文字母',
    'default' => '',
    'SO' => 'like',
  ),
  'title' => 
  array (
    'field' => 'title',
    'label' => '接口标题',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => 'like',
  ),
  'api_list' => 
  array (
    'field' => 'api_list',
    'label' => 'api_id 的汇总',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => 'like',
  ),
);