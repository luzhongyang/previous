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
  'api_id' => 
  array (
    'field' => 'api_id',
    'label' => 'api_id',
    'pk' => true,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'platform' => 
  array (
    'field' => 'platform',
    'label' => 'platform',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'select',
    'comment' => '平台',
    'default' => 'baidu',
    'SO' => '=',
  ),
  'title' => 
  array (
    'field' => 'title',
    'label' => '接口名称',
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
  'url' => 
  array (
    'field' => 'url',
    'label' => '接口请求地址',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '外部url',
    'default' => '',
    'SO' => 'like',
  ),
  'url_type' => 
  array (
    'field' => 'url_type',
    'label' => '请求类型',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'radio',
    'comment' => 'post/get',
    'default' => 'post',
    'SO' => false,
  ),
  'url_param' => 
  array (
    'field' => 'url_param',
    'label' => '请求参数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'text',
    'comment' => '默认取回登录参数,这里是额外的请求参数,比如post参数等.',
    'default' => '',
    'SO' => false,
  ),
  'content' => 
  array (
    'field' => 'content',
    'label' => '备注',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '接口接收参数备注',
    'default' => '',
    'SO' => false,
  ),
);