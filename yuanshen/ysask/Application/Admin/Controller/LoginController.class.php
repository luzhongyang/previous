<?php
/**
* 后台登录
*/
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
	public function index(){
		//判断登录入口
		if (!$_SESSION['AdminLogin']) {
			$this->error('请从后台管理入口登录!',U('/'));
		}
		//已登陆跳转
		if(isset($_SESSION['username'])) {
			redirect(U('/Admin/index'));
		}
		if(!empty($_POST)){
			//开启验证时
			if(C('is_checkcode')){
				if(C('checkcode_type')==2){
					//极验证判断
					$data['geetest_challenge'] = I('post.geetest_challenge');
					$data['geetest_validate'] =  I('post.geetest_validate');
					$data['geetest_seccode'] = I('post.geetest_seccode');
					if (!geetest_check_verify($data)) {
						$this->error('验证码错误，请先拖动验证码到相应位置！');
					}
				}
			}
			//判断用户名和密码，在model模型里制作一个专门方法进行验证
			$users = new \Common\Model\AdminModel();
			$str = $users->checklogin(I('post.username'),I('post.password'));
			if($str === false){
				if(login_log('用户名或密码错误,登录的账号为：'.I('post.username').'　密码为：'.I('post.password'))){ //记录登录日志
					$this->error('用户名或密码错误！');
				}
			} else {
				$obj = D('admin');
				$str = $obj->where("username='".I('post.username')."'")->find();
				if(!$str['status']) $this->error('该用户被锁定，暂时不可登录', U('/Admin/login'));
				$data['last_login_time'] = time();
				$data['login_ip'] = get_client_ip(0,true); //tp自带的方法获取IP
				$data['count'] = $str['count']+1;
				if($obj->where("username='".I('post.username')."'")->save($data)){  //记录最后登录时间、ip、次数
					$_SESSION['username']=$str['username'];
					$_SESSION['userid']=$str['id'];
					$_SESSION['logintime']=time();

					if(login_log('登录成功！')){ //记录登录日志
						$this->success('登录成功!',U('/Admin/index'));
					}
				}
			}
		}else{
			if(C('is_checkcode')){
				$this->assign('checkcode_type',C('checkcode_type'));
			}
			$this->display();
		}
	}

	//用户注销
	public function loginout(){
		session(null);
		$this -> success('退出成功！',U('/Admin/login'));
	}
}