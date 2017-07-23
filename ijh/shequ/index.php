<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 9343 2015-03-24 07:07:00Z youyi $
 */
define('IN_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
$host = $_SERVER['HTTP_HOST'];
$explode_arr = explode('.',$host);
if(preg_match("/^(wd|fx)(\d+)\.([\w\-\.]+)$/i", $host, $m)){
	if($m[1] == 'wd'){
		require(IN_DIR.'system/weidian/index.php');
	}else if($m[1] == 'fx'){
		require(IN_DIR.'system/fenxiao/index.php');
	}
}else if($explode_arr[0] == 'pchome' || $explode_arr[0] == 'pc' ){
    require(IN_DIR.'system/pchome/index.php');
}else{
	require(IN_DIR.'system/home/index.php');
}
new Index();

