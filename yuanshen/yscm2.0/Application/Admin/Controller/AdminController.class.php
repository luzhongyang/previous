<?php
/**
* 后台管理员管理
*/
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['status'] = array('egt',0); //大于等于0
		$map['username'] = array('like',"%".I('post.name')."%");
	}

	//添加前置操作
	public function _before_add() {
		//角色导入
		$role = D('AuthGroup')->select(); 
		$this->assign('adminid',$_SESSION['username']);
		$this->assign("role",$role);
	}

	//插入数据
	public function insert_admin(){
		$data=I('post.');
		$data['type'] = 9;
		$data['password'] = substr_pwd($data['password']);
		$data['create_time'] = time();
		$result=D('admin')->addData($data);
		if($result){
			if (!empty($data['group_id'])) {
				$group=array(
				'uid'=>$result,
				'group_id'=>$data['group_id']);
				D('AuthGroupAccess')->addData($group);
			}                   
			// 操作成功
			$this->success('添加成功',U('Admin/admin/index'));
		}else{
			$error_word = D('admin')->getError();
			// 操作失败
			$this->error($error_word);
		}
	}

	//修改前置操作
	public function _before_edit() {
		$obj = D('AuthGroupAccess');
		$group_id = $obj->where('uid='.trim(I('get.id')))->find();
		$this->assign('groupid',$group_id['group_id']);
		//角色导入
		$role = D('AuthGroup')->select(); 
		$this->assign('adminid',$_SESSION['username']);
		$this->assign("role",$role);
	}

	//删除前置操作
	//彻底删除记录
	public function _before_foreverdelete(){
		$id = $_REQUEST ['id'];
		$condition = array("uid" => array('in', explode(',', $id)));
		D('AuthGroupAccess')->where($condition)->delete();
	}

	//更新数据
	public function update_admin(){
		$data=I('post.');
		$uid = $data['id'];
		if($data['type']){
			// 如果修改密码则md5
			if (!empty($data['password'])) {
				$data['password'] = substr_pwd($data['password']);
			}
			$result=D('admin')->editData($map,$data);
			if($result){
				$this->success('编辑成功',U('Admin/admin/index'));
			}else{
				$this->error('编辑失败！');
			}
		}else{
			$data['type'] = 9;
			// 组合where数组条件			
			$map = array('id'=>$uid);
			// 修改权限
			D('AuthGroupAccess')->deleteData(array('uid'=>$uid));
			$group = array(
				'uid'=>$uid,
				'group_id'=>$data['group_id']
			);
			D('AuthGroupAccess')->addData($group);
			$data = array_filter($data);
			// 如果修改密码则md5
			if (!empty($data['password'])) {
				$data['password'] = substr_pwd($data['password']);
			}
			$result=D('admin')->editData($map,$data);
			if($result){
				$this->success('编辑成功',U('Admin/admin/index'));
			}else{

				$this->error('编辑失败！');
			}
		}			
	}

	//修改头像
	public function portrait(){
		if(IS_POST){
			$data['portrait'] = I('post.portrait');
			$ok = M('admin')->where('id='.$_SESSION['userid']) -> save($data);
			if($ok){
				$this->ajaxReturn(array('errno'=>1,'error'=>'更新头像成功!'));
			} else {
				$this->ajaxReturn(array('errno'=>0,'error'=>'更新密码失败!'));
			}
		}
	}

	//修改密码
	public function password(){
		if(IS_POST){
			$users = new \Admin\Model\AdminModel();
			$rst = $users -> checkpwd($_SESSION['userid'],I('post.old_password'));
			if($rst === false){
				$this->ajaxReturn(array('errno'=>0,'error'=>'原密码不正确请重启输入!'));
			} else {
				if(I('post.new_password') != I('post.confirm_password')){
					$this->ajaxReturn(array('errno'=>0,'error'=>'两次密码不一样,请重新输入!'));
				}else{
					if(I('post.new_password') != I('post.old_password')){
						$data['userpass'] = substr_pwd(I('post.new_password'));
						$data['updatetime'] = time();
						$ok = M('admin')->where('id='.$_SESSION['userid']) -> save($data);
						if($ok){
							session(null);
							$this->ajaxReturn(array('errno'=>1,'error'=>'更新密码成功,请重新登录!','url'=>U('User/login')));
						} else {
							$this->ajaxReturn(array('errno'=>0,'error'=>'更新密码失败!'));
						}
					}else{
						$this->ajaxReturn(array('errno'=>0,'error'=>'新密码和旧密码相同,无需修改!'));
					}
				}
			}
		}
	}

	//修改资料
	public function info(){
		if(IS_POST){
			$data['portrait'] = I('post.portrait');
			$ok = M('admin')->where('id='.$_SESSION['userid']) -> save($data);
			if($ok){
				$this->ajaxReturn(array('errno'=>1,'error'=>'更新头像成功!'));
			} else {
				$this->ajaxReturn(array('errno'=>0,'error'=>'更新密码失败!'));
			}
		}		
	}
	// 日志管理
	public function log(){
		$obj=D('login');
		$list=$obj->order('id desc')->select();
		$this->assign('list',$list);
		$this->display();
	}
	
}