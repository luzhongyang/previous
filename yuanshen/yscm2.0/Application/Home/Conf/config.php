<?php
$ini = require('./Data/Conf/config.ini.php');
$rewrite = require('./Data/Conf/rewrite.php');
$tpl = require('./Data/Conf/webtpl.php');
$config = array(
	'VIEW_PATH'		=> './Theme/Pc/', //定义模板目录
	'TMPL_FILE_DEPR'	=> '_', //定义模板简化的目录层次
);

return array_merge($ini,$rewrite,$config,$tpl);