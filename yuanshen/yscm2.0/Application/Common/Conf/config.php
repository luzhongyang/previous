<?php
$db = require('./Data/Conf/db.php');
$tp = require('./Data/Conf/config.php');
$config = array(
	'MODULE_ALLOW_LIST'	=> array('Admin','Home','Api','Install'), //项目分组
);

return array_merge($db,$tp,$config);