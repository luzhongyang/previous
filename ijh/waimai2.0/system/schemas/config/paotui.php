<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * #fileid#
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

return array (
  'buy_price' => 
  array (
    'label' => '"帮我买"价格',
    'field' => 'buy_price',
    'type' => 'number',
    'default' => '8',
    'comment' => '',
    'html' => false,
    'empty' => false,
  ),
  'send_km' => 
  array (
    'label' => '"帮我送"起步公里数',
    'field' => 'send_km',
    'type' => 'number',
    'default' => '1',
    'comment' => '',
    'html' => false,
    'empty' => false,
  ),
  'send_price' => 
  array (
    'label' => '"帮我送"起步价格',
    'field' => 'send_price',
    'type' => 'number',
    'default' => '5',
    'comment' => '',
    'html' => false,
    'empty' => false,
  ),
  'send_pk' => 
  array (
    'label' => '"帮我送"每超出起步每公里价格',
    'field' => 'send_pk',
    'type' => 'number',
    'default' => '1',
    'comment' => '',
    'html' => false,
    'empty' => false,
  )
);