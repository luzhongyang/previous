<?php
// 系统默认的核心行为扩展列表文件
return array(
	'app_init'	=> array('Behavior\BrowserCheckBehavior'), //浏览器防刷新
	"app_begin" => array("Behavior\GetcodingBehavior"),//解决中文乱码问题
	'view_filter' => array('Behavior\TokenBuildBehavior'),//开启表单令牌
);
