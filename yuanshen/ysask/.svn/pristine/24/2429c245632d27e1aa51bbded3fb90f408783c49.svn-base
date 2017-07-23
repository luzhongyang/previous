<?php
/**
* 首页
*/
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController{
	public function index(){
		if($_SESSION['username']=='admin'){
			$authgroup = '超级管理员';
		}else{
			$uid = D('AuthGroupAccess')->where('uid='.$_SESSION['userid'])->find();
			$authgroup = D('AuthGroup')->where('id='.$uid['group_id'])->find();
			$authgroup = $authgroup['title'];
		}
		
		$this->assign('adminuser',$_SESSION['username']);
		$this->assign('authgroup',$authgroup);
		$this->display();
	}

	public function main(){
		$mysql= M()->query("select VERSION() as version");
		$mysql=$mysql[0]['version'];
		$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
		//$obj = M('joke');
		//$jokelist = $obj->order('id desc')->limit(12)->select();
		$this->assign('mysql',$mysql);
		//$this->assign('jokelist',$jokelist);
		$this->display();
	}

}