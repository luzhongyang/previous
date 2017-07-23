<?php
/**
* 举报管理
*/
namespace Admin\Controller;
use Think\Controller;
class ClaimController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['keyword'] = array('like',"%".$_REQUEST['name']."%");
	}

	public function _before_index()
	{
		$users = D('User')->getField('id,username,status');
		$this->assign('users',$users);
	}
}