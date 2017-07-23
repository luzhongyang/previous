<?php
@session_start();
//移动端判断
if($_SERVER['HTTP_HOST'] == 'm.yscms.com') {
	require('wap.php');
	die();
}

// 应用入口文件
header("content-type:text/html;charset=utf-8");
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
//网站当前物理路径
define('SITE_PATH', dirname(__FILE__)."/");
//定义缓存存放物理路径
define("RUNTIME_PATH", SITE_PATH . "Runtime/");
//定义静态缓存目录物理路径
define("HTML_PATH", SITE_PATH . "Runtime/Html/");
//版本号
define("CMCMS_VERSION", 'V1.0');
// 定义应用目录
define('APP_PATH','./Application/');
// 定义应用绝对目录
define('APPS_PATH','./Include/');
require_once 'vendor/autoload.php';//引入第三方插件
// 引入ThinkPHP入口文件
require APPS_PATH.'ThinkPHP/ThinkPHP.php';