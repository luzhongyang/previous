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
  'relay_id' => 
  array (
    'field' => 'relay_id',
    'label' => '微接力',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'number',
    'comment' => '主键',
    'default' => '',
    'SO' => false,
  ),
   'shop_id' => 
  array (
    'field' => 'shop_id',
    'label' => '商家ID',
    'pk' => false,
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
  'keyword' => 
  array (
    'field' => 'keyword',
    'label' => '关键词',
    'pk' => false,
    'add' => true,
    'edit' => false,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '关键词',
    'default' => '',
    'SO' => false,
  ),
  'title' => 
  array (
    'field' => 'title',
    'label' => '标题',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'text',
    'comment' => '标题',
    'default' => '',
    'SO' => false,
  ),
  'intro' => 
  array (
    'field' => 'intro',
    'label' => '封面简介',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'textarea',
    'comment' => '封面简介',
    'default' => '',
    'SO' => false,
  ),
  'photo' => 
  array (
    'field' => 'photo',
    'label' => '封面图片',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'photo',
    'comment' => '封面图片',
    'default' => '',
    'SO' => false,
  ),
  'stime' => 
  array (
    'field' => 'stime',
    'label' => '开始时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '开始时间',
    'default' => '',
    'SO' => false,
  ),
  'ltime' => 
  array (
    'field' => 'ltime',
    'label' => '结束时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '结束时间',
    'default' => '',
    'SO' => false,
  ),
  'use_tips' => 
  array (
    'field' => 'use_tips',
    'label' => '使用说明',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'textarea',
    'comment' => '使用说明',
    'default' => '',
    'SO' => false,
  ),
  'end_tips' => 
  array (
    'field' => 'end_tips',
    'label' => '过期说明',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'textarea',
    'comment' => '过期说明',
    'default' => '',
    'SO' => false,
  ),
  'relay_num' => 
  array (
    'field' => 'relay_num',
    'label' => '分享参与次数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '分享参与次数',
    'default' => '',
    'SO' => false,
  ),
  'max_num' => 
  array (
    'field' => 'max_num',
    'label' => '每人最多次数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '每人最多次数',
    'default' => '1',
    'SO' => false,
  ),
   'max_gold' => 
  array (
    'field' => 'max_gold',
    'label' => '最大金币数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '最大金币数',
    'default' => '1',
    'SO' => false,
  ),
   'min_gold' => 
  array (
    'field' => 'min_gold',
    'label' => '最小金币数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '最小金币数',
    'default' => '1',
    'SO' => false,
  ),
    'time' => 
  array (
    'field' => 'time',
    'label' => '每次可玩时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '每次可玩时间',
    'default' => '1',
    'SO' => false,
  ),

  'follower_condtion' => 
  array (
    'field' => 'follower_condtion',
    'label' => '粉丝状态',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'radio',
    'comment' => '粉丝状态',
    'default' => '',
    'SO' => false,
  ),
  'member_condtion' => 
  array (
    'field' => 'member_condtion',
    'label' => '用户登录状态',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'radio',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'collect_count' => 
  array (
    'field' => 'collect_count',
    'label' => '已玩次数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '已玩次数',
    'default' => '',
    'SO' => false,
  ),
  'views' => 
  array (
    'field' => 'views',
    'label' => '浏览人数',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'int',
    'comment' => '浏览人数',
    'default' => '',
    'SO' => false,
  ),
  'end_photo' => 
  array (
    'field' => 'end_photo',
    'label' => '过期提示图片',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'photo',
    'comment' => '过期提示图片',
    'default' => '',
    'SO' => false,
  ),
  'lastupdate' => 
  array (
    'field' => 'lastupdate',
    'label' => '更新时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '更新时间',
    'default' => '',
    'SO' => false,
  ),
  'clientip' => 
  array (
    'field' => 'clientip',
    'label' => '创建IP',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => true,
    'list' => true,
    'type' => 'clientip',
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
    'comment' => '发布时间',
    'default' => '',
    'SO' => false,
  ),
);