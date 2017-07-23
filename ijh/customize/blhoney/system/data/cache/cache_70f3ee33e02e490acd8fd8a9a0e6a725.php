<?php
/**
 * Copy Right IJH.CC
 * note:System cache file, DO NOT modify me!
 * hash:70f3ee33e02e490acd8fd8a9a0e6a725:adv-adv-list;
 * time:0
 */
if(!defined("__CORE_DIR")){	exit("Access Denied");}if(0===0 || __TIME<0){return array (
  1 => 
  array (
    'adv_id' => '1',
    'theme' => 'default',
    'theme_id' => '1',
    'page' => '',
    'title' => '首页轮播',
    'from' => 'lunzhuan',
    'limit' => '5',
    'config' => 
    array (
      'width' => '100%',
      'height' => '100%',
    ),
    'desc' => '',
    'tmpl' => '[loop]
<li><a href="<{$item.clickurl}>" <{$item.a_attr}>><img style="width:100%;height:117px;" src="<{$pager.img}>/<{$item.thumb}>" width="640" height="198" alt="<{$item.title}>" text="<{$item.title}>" <{$item.item_attr}> /></a></li>
[/loop]',
    'orderby' => '1',
    'audit' => '1',
    'closed' => '0',
    'dateline' => '1445221597',
    'from_title' => '轮转广告',
  ),
  2 => 
  array (
    'adv_id' => '2',
    'theme' => 'default',
    'theme_id' => '1',
    'page' => '',
    'title' => '商城轮播',
    'from' => 'lunzhuan',
    'limit' => '10',
    'config' => 
    array (
      'width' => '',
      'height' => '',
    ),
    'desc' => '',
    'tmpl' => '[loop]
<li><a href="<{$item.clickurl}>" <{$item.a_attr}>><img style="width:100%;height:117px;" src="<{$pager.img}>/<{$item.thumb}>" width="640" height="198" alt="<{$item.title}>" text="<{$item.title}>" <{$item.item_attr}> /></a></li>
[/loop]',
    'orderby' => '2',
    'audit' => '1',
    'closed' => '0',
    'dateline' => '1449217174',
    'from_title' => '轮转广告',
  ),
  3 => 
  array (
    'adv_id' => '3',
    'theme' => 'default',
    'theme_id' => '1',
    'page' => '',
    'title' => '热门发型',
    'from' => 'lunzhuan',
    'limit' => '10',
    'config' => 
    array (
      'width' => '100%',
      'height' => '100%',
    ),
    'desc' => '',
    'tmpl' => '[loop]
<li><a href="<{$item.clickurl}>" <{$item.a_attr}>><img src="<{$pager.img}>/<{$item.thumb}>"  width="640" height="198" alt="<{$item.title}>" text="<{$item.title}>" <{$item.item_attr}> /></a></li>
[/loop]',
    'orderby' => '3',
    'audit' => '1',
    'closed' => '0',
    'dateline' => '1462592426',
    'from_title' => '轮转广告',
  ),
);}return false;