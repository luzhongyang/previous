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
  'tixian_id' => 
  array (
    'field' => 'tixian_id',
    'label' => '提现ID',
    'pk' => true,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'int',
    'comment' => '提现ID',
    'default' => '',
    'SO' => '=',
  ),
  'wuye_id' => 
  array (
    'field' => 'wuye_id',
    'label' => '物业ID',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => false,
    'type' => 'int',
    'comment' => '物业ID',
    'default' => '',
    'SO' => '=',
  ),
  'money' => 
  array (
    'field' => 'money',
    'label' => '提现金额',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => false,
    'type' => 'number',
    'comment' => '提现金额',
    'default' => '0.00',
    'SO' => false,
  ),
  'intro' => 
  array (
    'field' => 'intro',
    'label' => '体现描述',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'text',
    'comment' => '体现描述',
    'default' => '',
    'SO' => false,
  ),
  'account_info' => 
  array (
    'field' => 'account_info',
    'label' => '提现帐号信息',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => true,
    'list' => false,
    'type' => 'text',
    'comment' => '提现帐号信息',
    'default' => '',
    'SO' => false,
  ),
  'status' => 
  array (
    'field' => 'status',
    'label' => '提现状态',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'int',
    'comment' => '状态,0:待处理,1:通过,2:拒绝',
    'default' => '',
    'SO' => '=',
  ),
  'reason' => 
  array (
    'field' => 'reason',
    'label' => '拒绝原因',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'text',
    'comment' => '拒绝原因',
    'default' => '',
    'SO' => false,
  ),
  'updatetime' => 
  array (
    'field' => 'updatetime',
    'label' => '更新时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'dateline',
    'comment' => '更新时间',
    'default' => '',
    'SO' => 'betweendate',
  ),
  'clientip' => 
  array (
    'field' => 'clientip',
    'label' => '创建ip',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'text',
    'comment' => '创建IP',
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
    'list' => false,
    'type' => 'dateline',
    'comment' => '创建时间',
    'default' => '',
    'SO' => false,
  ),
  'end_money' => 
  array (
    'field' => 'end_money',
    'label' => '实际结算金额',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => false,
    'type' => 'number',
    'comment' => '实际结算金额',
    'default' => '0.00',
    'SO' => false,
  ),
);