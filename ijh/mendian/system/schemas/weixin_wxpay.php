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
    'shop_id' =>
        array (
            'field' => 'shop_id',
            'label' => '商户ID',
            'pk' => true,
            'add' => true,
            'edit' => false,
            'html' => false,
            'empty' => false,
            'show' => false,
            'list' => true,
            'type' => 'int',
            'comment' => '',
            'default' => '',
            'SO' => '=',
        ),
    'mch_id' =>
        array (
            'field' => 'mch_id',
            'label' => '商户号',
            'pk' => false,
            'add' => true,
            'edit' => true,
            'html' => false,
            'empty' => true,
            'show' => false,
            'list' => true,
            'type' => 'text',
            'comment' => '',
            'default' => '',
            'SO' => 'like',
        ),
    'mch_key' =>
        array (
            'field' => 'mch_key',
            'label' => '商户密钥',
            'pk' => false,
            'add' => true,
            'edit' => true,
            'html' => false,
            'empty' => true,
            'show' => false,
            'list' => true,
            'type' => 'text',
            'comment' => '',
            'default' => '',
            'SO' => false,
        ),
    'total_amount' =>
        array (
            'field' => 'total_amount',
            'label' => '总收款',
            'pk' => false,
            'add' => true,
            'edit' => true,
            'html' => false,
            'empty' => true,
            'show' => false,
            'list' => true,
            'type' => 'number',
            'comment' => '',
            'default' => '0.00',
            'SO' => false,
        ),
    'expire_time' =>
        array (
            'field' => 'expire_time',
            'label' => '过期时间',
            'pk' => false,
            'add' => true,
            'edit' => true,
            'html' => false,
            'empty' => false,
            'show' => false,
            'list' => true,
            'type' => 'unixtime',
            'comment' => '',
            'default' => '',
            'SO' => 'betweendate',
        ),
    'status' =>
        array (
            'field' => 'status',
            'label' => '审核状态',
            'pk' => false,
            'add' => true,
            'edit' => true,
            'html' => false,
            'empty' => false,
            'show' => false,
            'list' => true,
            'type' => 'int',
            'comment' => '',
            'default' => '',
            'SO' => false,
        ),
);