<?php
/**
* 敏感词管理
*/
namespace Admin\Controller;
use Think\Controller;
class BadwordController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['badword'] = array('like',"%".$_REQUEST['name']."%");
		$_GET['name'] = $_REQUEST['name'];
	}
}