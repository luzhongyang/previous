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
  'id' => 
  array (
    'field' => 'id',
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
    'SO' => false,
  ),
    'sid' => 
  array (
    'field' => 'sid',
    'label' => '分销店铺id',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '分销店铺id',
    'default' => '',
    'SO' => false,
  ),
  'invite1' => 
  array (
    'field' => 'invite1',
    'label' => '一级用户ID',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '一级用户ID',
    'default' => '',
    'SO' => false,
  ),
    'invite2' => 
  array (
    'field' => 'invite2',
    'label' => '二级用户ID',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '二级用户ID',
    'default' => '',
    'SO' => false,
  ),
    'invite3' => 
  array (
    'field' => 'invite3',
    'label' => '三级用户ID',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '三级用户ID',
    'default' => '',
    'SO' => false,
  ),
);