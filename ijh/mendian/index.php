<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 9343 2015-03-24 07:07:00Z youyi $
 */
define('IN_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
if(preg_match("/^(shop|)(\d+)\.([\w\-\.]+)$/i", $_SERVER['HTTP_HOST'], $m)){
	require(IN_DIR.'system/shop/index.php');
}elseif(preg_match("/^(biz)\.([\w\-\.]+)$/i", $_SERVER['HTTP_HOST'], $m)){
	require(IN_DIR.'system/biz/index.php');
}else{
	require(IN_DIR.'system/home/index.php');
}
new Index();
