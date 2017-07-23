<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller{

	/**
	 * 前台用户登录
	 * @return [type] [description]
	 */
	public function login(){
		//已登录跳转
		if(check_login()){
			$this->error('请勿重复登录，如需切换账号，请登出后重新登录。','/');
		}

		//第三方登录
		$type = I('get.type');
		if(!empty($type)){
			import('ThinkOauth');
			$ins = \ThinkOauth::getInstance($type);
			$dialog_url = $ins->getRequestCodeURL();
			redirect($dialog_url);//跳转到授权页面
		}

		//登录表单验证
		if(!empty($_POST)){
			if(empty($_POST['username'])){
				$this->error('用户名不能为空');
			}
			if(empty($_POST['password'])){
				$this->error('密码不能为空');
			}
			//验证码
			if(C('is_checkcode')){
				captcha($_POST);
			}
			$User = D('User');

			//检查用户
			$where['username'] = I('username');
			$where['phone'] = I('username');
			$where['email'] = I('username');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$map['password'] = substr_pwd(I('password'));
			$result = $User->where($map)->find();
			if(empty($result)){
				$this->error('请检查用户名或者密码是否正确');
			}

			//当天第一次登录奖励经验值
			if($result['last_login_time'] < strtotime(date('Ymd'))){
				$experience =(int)C('experience_login');
				if(!$experience) break;
				$intro = '用户登录';
				$log = array('user_id'=>$result['id'],'number'=>$experience, 'action'=>'login', 'intro'=>$intro);
				$ch = D('Experiencelog')->change($log);
				if(!$ch) $this->error('用户登录经验值奖励失败');
			}

			//更新user表
			$User->last_login_time = time();
			$User->id = $result['id'];
			$User->count = $result['count']+1;
			$User->last_login_ip = get_client_ip();
			$User->save();

			//一个月内免登陆
			if(I('post.memberPass') == 'on'){
				setcookie("user_id",$result['id'],time()+3600*24*30);
   				setcookie("password",$result['password'],time()+3600*24*30);
			}
			//设置session
			session('user',$result);

			$this->success('欢迎进入社区问答','/');

		}else{
			$this->assign('checkcode_type',C('checkcode_type'));
			$this->assign('title','用户登录');
			$this->display();
		}
	}

	//第三方登录回调方法
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('回调参数错误');
		//加载ThinkOauth类并实例化一个对象
		import('ThinkOauth');
		$sns  = \ThinkOauth::getInstance($type);
		$token = $sns->getAccessToken($code);
		//获取当前登录用户信息
		if(is_array($token)){
			$ins = \ThinkOauth::getInstance($type, $token);
			//查询是否是第一次授权
			$User = M('User');
			$oauth = M('Oauth_user');
			$where['from'] = $type;
			$where['openid'] = $token['openid'];
			$old = $oauth->where($where)->find();
			if($old){
				//更新字段
				$oauth->access_token  = $token['access_token'];
				$oauth->expires_in 	  = $token['expires_in'];
				$oauth->refresh_token = $token['refresh_token'];
				$oauth->last_login_ip = get_client_ip();
				$oauth->last_login_time = time();
				$oauth->login_num = 'login_num+1';
				$oauth->id = $old->id;
				$oauth->save();
			}else{
				//新增记录
				if(strtolower($type) == 'qq'){
					$data = $ins->call('user/get_user_info'); //调用接口
					if($data['ret']<0){
						$this->error($data['msg']);
					}
					$User->username = $data['nickname'].rand(1,9999);
					$User->avatar = $data['figureurl_qq_1'];
					$User->sex = $data['gender'] == '女'? '2':'1';

					$oauth->name=$data['nickname'];
					$oauth->from = 'qq';
					$oauth->avatar = $data['figureurl_qq_1'];

				}elseif(strtolower($type) == 'sina'){
					$data = $ins->call('users/show');
					$User->username = $data['screen_name'].rand(1,9999);
					$User->city = $data['city'];
					$User->description = $data['description'];
					$User->avatar = $data['profile_image_url'];
					$User->sex = $data['gender'] == 'f'? '2':'1';

					$oauth->name = $data['screen_name'];
					$oauth->from = 'sina';
					$oauth->avatar = $data['profile_image_url'];
				}elseif(strtolower($type) == 'wechat'){
					$data = $ins->call('userinfo');
					$User->username = $data['nickname'].rand(1,9999);
					$User->sex = $data['sex'];
					$User->city = $data['city'];
					$User->avatar = $data['headimgurl'];

					$oauth->name = $data['nickname'];
					$oauth->from = 'wechat';
					$oauth->avatar = $data['headimgurl'];
				}else{
					$this->error('暂不支持该回调类型');
				}
				$User->created_time = time();
				//设置session
				session('user.username',$User->username);
				$id=$User->add();
				session('user.id',$id);

				$oauth->access_token = $token['access_token'];
				$oauth->expires_in = $token['expires_in'];
				$oauth->refresh_token = $token['refresh_token'];
				$oauth->openid = $data['openid'];
				$oauth->uid = $id;
				$oauth->created_time = time();
				$oauth->last_login_time = time();
				$oauth->last_login_ip = get_client_ip();
				$oauth->login_num = 1;
				$oauth->status = 1;
				$oauth->add();
			}
			$this->success('欢迎进入社区问答','/');
		}else{
			$this->error('token错误');
		}
	}

	/**前台用户登出**/
	public function logout(){
		session(null);
		$this->success('用户已登出','/');
	}

	/**
	 * 前台用户注册
	 * @return [type] [description]
	 */
	public function register(){
		//网站注册功能是否开启
		if(C('open_register') !== 1){
			$this->error('抱歉，网站没有开放注册。');
		}

		//验证注册表单
		if(!empty($_POST)){
			//var_dump($_POST);exit;
			//用户不同意注册协议
			if(I('post.agree') !== 'on'){
				$this->error('请仔细阅读注册协议，勾选同意后点击注册');
			}
			//手机验证码
			/*
			$phone = I('post.phone');
			$code = I('post.code');
			if($code !== session('code_'.$phone)){
				$this->error('手机验证码错误');
			}
			*/

			//防灌水检查
			$ip = get_client_ip();
			if(C('ip_register_limit') > 0 and S('ip_register_'.md5($ip)) >= C('ip_register_limit')){
				$this->error('抱歉，您的IP地址注册用户数量已达到今天的上限。');
			}

			//用I过滤表单数据
			$userinfo['username']=I('post.username');
			$userinfo['phone']=I('post.phone');
			$userinfo['password']=I('post.password');
			$userinfo['repassword']=I('post.repassword');
			$userinfo['__hash__']=I('post.__hash__');	
			//检测用户名
			if(check_nickname($userinfo['username']) or check_word($userinfo['username'])) {
				$this->error('用户名包含特殊词语，请更换');
			}

			$User=D('User');
			$result = $User->create($userinfo,1);
			if(!$result){
				$this->error($User->getError());
			}

			$user_id=$User->add();

			//奖励经验值
			if(C('experience_login')){
				$data['user_id'] = $user_id;
				$data['action'] = 'register';
				$data['number'] = C('experience_login');
				D('Experiencelog')->change($data);
			}
			
			//缓存该ip今日注册数目
			if(S('ip_register_'.md5($ip))){
				$num = S('ip_register_'.md5($ip));
				S('ip_register_'.md5($ip),$num+1,3600);
			}else{
				S('ip_register_'.md5($ip), 1,3600);
			}
			//设置session
			session(array('user.username'=>$userinfo['username'],'expire'=>3600));
			session(array('user.id'=>$user_id,'expire'=>3600));
			$this->success('注册成功,欢迎加入社区问答','/');
		}else{
			$this->display();
		}
	}

	//忘记密码
	public function forget_password(){
		if(!empty($_POST)){
			//手机验证码


			$User = D('User');
			$User->password = I('post.password');
			$User->repassword = I('post.password');
			if(!$User->create()){
				$this->error($User->getError());
			}else{
				$User->updated_time = time();
				if($User->save()){
					$this->success('密码重置成功，请使用新密码登录','/login');
				}else{
					$this->error('密码重置失败');
				}
			}
		}else{
			$this->display();
		}
	}

	/*发送短消息*/
	public function send_sms()
	{
		if(IS_AJAX) {
			$phone = I('phone');
			if($phone or is_phone($phone)) {
				$this->ajaxReturn(array('status'=>0,'message'=>'手机号码不正确'));
			}else {
				if(M('User')->where(array('phone'=>$phone))->count('id')) {
					$this->ajaxReturn(array('status'=>0,'message'=>'此手机号已被注册'));
				}
				$this->ajaxReturn(sendsms());
			}
		}
	}

}