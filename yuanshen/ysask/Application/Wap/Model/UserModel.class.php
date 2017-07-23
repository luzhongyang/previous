<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	//对用户名和密码进行校验
	function checklogin($name,$pwd){
	$info = $this -> getByusername($name);
		if($info != null){
			if($info['userpass'] != substr_pwd($pwd)){
				return false;
			} else {
				return $info;
			} 
		} else {
			return false;
		}
	}

	//判断原密码是否正确
	function checkpwd($id,$pwd){
	$info = $this -> getByid($id);
		if($info != null){
			if($info['userpass'] != substr_pwd($pwd)){
				return false;
			} else {
				return $info;
			} 
		} else {
			return false;
		}
	}
}
