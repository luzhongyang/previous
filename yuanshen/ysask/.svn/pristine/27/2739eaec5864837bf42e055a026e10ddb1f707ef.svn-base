<?php
namespace Admin\Controller;
use Think\Controller;

class AnswerController extends CommonController{
	public function _filter(&$map)
	{
		$map['closed'] = 0;
		$status = I('post.status');
		if($status === 'noaudit') {
			$map['status'] = 0;
		}else if($status === 'pass') {
			$map['status'] = 1;
		}else {
			$map['status'] = array('in','0,1');
		}
		$this->assign('status',$status);
	}

	public function _before_index()
	{
		$users = D('User')->getField('id,username,created_time');
		$this->assign('users',$users);
	}
}