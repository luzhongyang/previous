<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 9343 2015-03-24 07:07:00Z youyi $
 */
define('IN_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
if(preg_match("/^(wd|fx)(\d+)\.([\w\-\.]+)$/i", $_SERVER['HTTP_HOST'], $m)){
	if($m[1] == 'wd'){
		require(IN_DIR.'system/weidian/index.php');
	}else if($m[1] == 'fx'){
		require(IN_DIR.'system/fenxiao/index.php');
	}
}else{
	require(IN_DIR.'system/home/index.php');
}
new Index();
