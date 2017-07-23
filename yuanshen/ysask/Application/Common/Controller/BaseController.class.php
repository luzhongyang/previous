<?php
namespace Common\Controller;
use Think\Controller;
class BaseController extends Controller{
	protected function _initialize() {
		define('__APP__', 'pchome');
		define('IN_MOBILE', false);

		//网站关闭
		if (C('site_status')){
			echo C('site_colse');
			exit();
		}
		//广告
		$this->get_ad();
		//友情链接
		$this->get_link();
		$get_cfg = array(
			'site'=>C('site'),
			'site_title'=>C('site_title'),
			'site_name'=>C('site_name'),
			'site_url'=>C('site_url'),
		);
		$this->assign('SITE', $get_cfg);
		if (check_login()) {
            $this->assign('user', session('user'));
        }else if(strtolower(MODULE_NAME) != 'login'){
        	header("Location: /login.html");
        	exit;
        }
	}

	/** 空处理 */
	public function _empty() {
		header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码
		$this->display("Public:404");
	}

	/** 获取广告信息*/
	protected function get_ad() {
		$ads_mod = D('ad');
		$ads_list = $ads_mod->select();
		$ads = array();
		foreach ($ads_list as $val) {
			$ads[$val['name']] = htmlspecialchars_decode($val['content']);
		}
		$this->ads = $ads;
		$this->assign('ads',$this->ads);
	}

	/** 获取友情链接信息*/
	protected function get_link() {
		$link_mod = D('link');
		$link = $link_mod->order('id asc')->where('status=1')->select();
		$this->link = $link;
		$this->assign('link',$this->link);
	}


	//发送注册激活邮件
	protected  function _send_to_active(){
		if(C('mail_address')=='' or C('mail_loginname')=='' or C('mail_loginname')=='' or C('mail_password')=='' or C('mail_smtp')==''){
			$this->error('网站未配置账号激活信息，请联系网站管理员');
		}
		//生成激活链接
		$token =  md5($_SESSION['user']['id'].$_SESSION['user']['username'].$_SESSION['user']['email'].$_SESSION['user']['create_time']);
		$address = $_SESSION['user']['email'];
		$url = C('site_url').'/account/activate/email/'.$address.'/token/'.$token;
		//载入邮件模板
		$mailtpl = M('mailtpl')->getByKey('user_registration');
		//邮件标题<替换标签>
		$title = str_replace(array("{click}", "{url}", "{username}", "{sitemail}", "{password}", "{siteurl}", "{sitename}"), array("<a href=\"" . $url . "\">请点击</a>", $url, $_SESSION['user']["username"], C('site_email'), $password, C('site_url'), C('site_title')), $mailtpl['title']);
		//邮件内容<替换标签>
		$content = str_replace(array("{click}", "{url}", "{username}", "{sitemail}", "{password}", "{siteurl}", "{sitename}"), array("<a href=\"" . $url . "\">请点击</a>", $url, $_SESSION['user']["username"], C('site_email'), $password, C('site_url'), C('site_title')), htmlspecialchars_decode($mailtpl['content']));
		//发送邮件
		$send_result = send_email($address,$title,$content);
		if($send_result['error']){
			$this->ajaxReturn(array('err' => 0,'msg' =>'激活邮件发送失败,请查看以下错误信息：'.$send_result['message']));
		}
	}
}