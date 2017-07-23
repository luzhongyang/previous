<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: adv.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

return array(
    'book_id'  =>
    array(
        'field'   => 'book_id',
        'label'   => 'ID',
        'pk'      => true,
        'add'     => false,
        'edit'    => false,
        'html'    => false,
        'empty'   => false,
        'show'    => true,
        'list'    => true,
        'type'    => 'text',
        'comment' => '',
        'default' => '',
        'SO'      => false,
    ),
    'content'  =>
    array(
        'field'   => 'content',
        'label'   => '内容',
        'pk'      => false,
        'add'     => true,
        'edit'    => true,
        'html'    => false,
        'empty'   => false,
        'show'    => true,
        'list'    => true,
        'type'    => 'text',
        'comment' => '',
        'default' => '',
        'SO'      => false,
    ),
    'uid'      =>
    array(
        'field'   => 'uid',
        'label'   => '用户ID',
        'pk'      => false,
        'add'     => true,
        'edit'    => true,
        'html'    => false,
        'empty'   => true,
        'show'    => false,
        'list'    => true,
        'type'    => 'int',
        'comment' => '',
        'default' => '',
        'SO'      => false,
    ),
    'nickname' =>
    array(
        'field'   => 'nickname',
        'label'   => '昵称',
        'pk'      => false,
        'add'     => true,
        'edit'    => true,
        'html'    => false,
        'empty'   => false,
        'show'    => false,
        'list'    => true,
        'type'    => 'text',
        'comment' => '',
        'default' => '',
        'SO'      => 'like',
    ),
    'dateline' =>
    array(
        'field'   => 'dateline',
        'label'   => '添加时间',
        'pk'      => false,
        'add'     => false,
        'edit'    => false,
        'html'    => false,
        'empty'   => false,
        'show'    => true,
        'list'    => true,
        'type'    => 'dateline',
        'comment' => '',
        'default' => '',
        'SO'      => false,
    ),
    'clientip' =>
    array(
        'field'   => 'clientip',
        'label'   => '创建ip',
        'pk'      => false,
        'add'     => true,
        'edit'    => true,
        'html'    => false,
        'empty'   => false,
        'show'    => false,
        'list'    => true,
        'type'    => 'clientip',
        'comment' => '',
        'default' => '',
        'SO'      => false,
    ),
);
