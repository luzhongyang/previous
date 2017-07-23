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
  'staff_id' => 
  array (
    'field' => 'staff_id',
    'label' => '服务人员ID',
    'pk' => true,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '服务人员ID',
    'default' => '',
    'SO' => '=',
  ),
  'cate_id' => 
  array (
    'field' => 'cate_id',
    'label' => '服务人员ID',
    'pk' => true,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '服务项目分类ID',
    'default' => '',
    'SO' => '=',
  ),
);