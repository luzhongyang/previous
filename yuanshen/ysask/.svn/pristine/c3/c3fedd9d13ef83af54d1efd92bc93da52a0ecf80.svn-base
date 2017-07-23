<?php
/**
* 登录日志
*/
namespace Admin\Controller;
use Think\Controller;
class LogController extends CommonController{
	//搜索
	public function _filter(&$map){
		$username = $_REQUEST['name'];
		$map['username'] = array('like',"%".$username."%");
		$_GET['name'] =$username;
	}
}