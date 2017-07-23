<?php
/**
* 系统消息管理
*/
namespace Admin\Controller;
use Think\Controller;
class UserMsgController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['status'] = array('egt',0); //大于等于0
		$map['content'] = array('like',"%".$_POST['title']."%");
	}
}