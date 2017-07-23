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

	//更新数据
	public function update_user(){
		$data = I('post.');
		if(!$data = check_fields($data,'id,avatar,username,password,email,sex,phone,level,status')) {
			$this->error('非法的数据提交');
		}
		if (!empty($data['password'])) {
			if($data['password'] == '******'){
                unset($data['password']);
            }else {
            	$data['password'] = substr_pwd($data['password']);
            }
		}
		$result=D('Common/User')->editData($map,$data);
		if($result){
			$this->success('编辑成功',U('Admin/user/index'));
		}else{
			$this->error('编辑失败！');
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

	public function forbid()
	{
		$this->forbid();
	}

	//	等级配置
	public function level()
	{
		if(IS_POST) {
			$data_edit = I('post.data_edit');
			$data_add = I('post.data_add');
			if($data_edit) {
				$level_error_count = $exper_error_count =  0;
				foreach($data_edit as $k=>$v) {
					if(!preg_match("/^\d*$/",$v['level'])) {
						$level_error_count ++;
					}
					if(!preg_match("/^\d*$/",$v['experience'])) {
						$exper_error_count ++;
					}
					$ids[] = $v['id'];
				}
				if($level_error_count > 0) {
					$this->error('等级格式不正确');
				}
				if($exper_error_count > 0) {
					$this->error('经验值格式不正确');
				}
				$id = implode(',',$ids);
				$list1 = D('Userlevel')->where(array('id'=>array('in',$id)))->select();
				foreach($data_edit as $k=>$v) {
					foreach($list1 as $kk=>$vv) {
						if($v['id'] == $vv['id']) {
							$a = array();

							if($vv['level'] != $v['level']) {
								$a['level'] = $v['level'];
							}
							if($vv['experience'] != $v['experience']) {
								$a['experience'] = $v['experience'];
							}
							if($vv['icon'] != $v['icon']) {
								$a['icon'] = $v['icon'];
							}
							if($a) {
								D('Userlevel')->where(array('id'=>$v['id']))->save($a);
							}
						}
					}
				}
			}
			if($data_add) {
				foreach($data_add as $k=>$v) {
					if(!preg_match("/^\d*$/",$v['level'])) {
						$this->error('等级格式不正确');
					}
					if(!preg_match("/^\d*$/",$v['experience'])) {
						$this->error('经验值格式不正确');
					}
					D('Userlevel')->add($v);
				}
			}
			$this->success('操作成功',U('user/level'));
		}else {
			$list = D('Userlevel')->select();
			$this->assign('list',$list);
			$this->display();
		}
	}
}