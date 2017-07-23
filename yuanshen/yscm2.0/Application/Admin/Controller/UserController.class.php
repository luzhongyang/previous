<?php
/**
* 用户管理
*/
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['status'] = array('egt',0); //大于等于0
		if($_POST['action']=="用户名"){
			$map['username'] = array('like',"%".I('post.name')."%");
		}
		if($_POST['action']=="邮箱") {
			$map['email'] = array('like',"%".I('post.name')."%");
		}
	}

	public function _before_insert(){
		if(empty($_POST['avatar'])){
			if(trim($_POST['sex'])){
				$_POST['avatar'] = '/Uploads/avatar/avatar_1.png';
			}else{
				$_POST['avatar'] = '/Uploads/avatar/avatar_2.png';
			}
			
		}
	}

	//授权登录
	public function userlogin(){
		if($_GET){
			$uid = I('get.uid');
			$obj = D('user');
			$str = $obj->where('id='.(int)$uid)->find();
			if(!$str){
				$this->error('用户授登录失败！');
			}else{
				$_SESSION['user_id'] = $str['id'];
				$_SESSION['user_expire'] = time() + C('SESSION_EXPIRE');
				$_SESSION['start_time'] = time();
				header("location:/User");
			}
		}else{
			$this->error('操作错误！');
		}
		
		
	}
}