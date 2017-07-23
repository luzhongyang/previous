<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Passport extends Ctl
{

    public function index()
    {

        $this->login();
    }

    //授权登录
    public function login($type)
    {
        //增加session,判断 http_referer
        $session = K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号不正确', 211);
            }
            else if($type == 1){
                if(!$passwd = $data['passwd']){
                    $this->msgbox->add('密码没有填写!', 212)->response();
                }else if($m = $this->auth->login($mobile, $passwd, 'mobile')){
                    if(strpos($session->get('login_url'), 'passport') !== false){
                        $forward = $this->mklink('ucenter/index', null, null, 'base');
                    }
                    else{
                        $forward = $session->get('login_url');
                    }
                    $msg = K::M('member/message')->count(array('is_read'=>0,'uid'=>$m['uid']));
                    $this->msgbox->set_data('forward', $forward);
                    $this->msgbox->set_data('msg', $msg);
                    $this->msgbox->set_data('nickname', $m['nickname']);
                    $this->msgbox->add("欢迎您回来!");
                }
                else{
                    $this->msgbox->add('帐号或密码不正确!', 213);
                }
            }
            else if($type == 2){
                if(!$code = $data['code']){
                    $this->msgbox->add('验证码没有填写', 211)->response();
                }
                if($code != $session->get('code_' . $mobile)){
                    $this->msgbox->add('验证码不正确', 212)->response();
                }else if($m = K::M('member/member')->member($mobile, 'mobile')){
                    if($member = $this->auth->manager($m['uid'])){
                        if(strpos($session->get('login_url'), 'passport') !== false){
                            $forward = $this->mklink('ucenter/index', null, null, 'base');
                        }
                        else{
                            $forward = $session->get('login_url');
                        }
                        $msg = K::M('member/message')->count(array('is_read'=>0,'uid'=>$m['uid']));
                        $this->msgbox->set_data('forward', $forward);
                        $this->msgbox->set_data('msg', $msg);
                        $this->msgbox->set_data('nickname', $m['nickname']);
                        $this->msgbox->add("欢迎您回来!");
                    }
                    else{
                        $this->msgbox->add('验证码不正确!', 213);
                    }
                }
            }
        }
        else{
            $session->set('login_url', $_SERVER['HTTP_REFERER']);
            $this->tmpl = 'pchome/passport/login.html';
        }
    }

    //注册
    public function register()
    {
        $session = K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            $data['nickname'] = '';
            if(!$data['mobile']){
                $this->msgbox->add('手机号没有填写', 211);
            }
            else if(!K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号有误', 212);
            }
            else if(!$data['code']){
                $this->msgbox->add('手机验证码错误', 213);
            }
            else if($data['code'] != $session->get('code_' . $data['mobile'])){
                $this->msgbox->add('手机验证码错误或已过期', 214);
            }
            else if(!$data['passwd']){
                $this->msgbox->add('密码没有填写', 215);
            }
            else if($data['passwd'] !== $data['repasswd']){
                $this->msgbox->add('两次输入的密码不一致', 216);
            }
            else if(K::M('member/member')->check_mobile($data['mobile'])){
                if(defined('IN_WEIXIN') && defined('WX_OPENID')){
                    $data['wx_openid'] = WX_OPENID;
                }
                if(strpos($session->get('login_url'), 'passport') !== false){
                    $forward = $this->mklink('ucenter:index', null, null, 'base');
                }
                else{
                    $forward = $session->get('login_url');
                }
                if($uid = K::M('member/account')->create($data)){

                    if(strpos($session->get('login_url'), 'passport') !== false){
                        $forward = $this->mklink('ucenter/index', null, null, 'base');
                    }
                    else{
                        $forward = $session->get('login_url');
                    }
                    $this->msgbox->set_data('forward', $forward);
                    $this->msgbox->add('恭喜您，注册会员成功!');
                }
            }
        }
        else{
            $this->tmpl = 'pchome/passport/register.html';
        }
    }
    
    
    //迷你弹出登录框，JS-GET请求获取HTML
    public function mini_login(){
        $this->tmpl = 'pchome/passport/mini_login.html';
    }

    /*  发送短信 */

    public function sendsms()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $mobile = $this->GP('mobile');
            if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add('电话号码有误', 212);
            }else{
                $code = rand(100000, 999999);
                $session = K::M('system/session')->start();
                $session->set('code_' . $mobile, $code, 900); //15分钟缓存
                $smsdata = array('code' => $code);
                if(K::M('sms/sms')->send($mobile, 'login', $smsdata) || $code){
                    if(__DEBUG){
                        $this->msgbox->add('短信发送成功' . $code);
                    }
                    else{
                        $this->msgbox->add('短信发送成功');
                    }
                }
            }
        }
        else{
            $this->error(404);
        }
    }



    //退出登录
    public function loginout()
    {
        $this->auth->loginout();
        header("location:" . $this->mklink('passport/login', null, null, 'base'));
    }

    //找回密码（步骤1）
    public function forget()
    {

        if($data = $this->checksubmit('data')){
            if(!K::M('member/member')->items(array('mobile' => $data['mobile']))){
                $this->msgbox->add("手机号码不存在!", 101);
            }
            else if(K::M('system/session')->start()->get('code_' . $data['mobile']) != $data['code']){
                $this->msgbox->add("短信验证码不正确!", 101);
            }
            else{
                $this->cookie->set('FORGET_MOBILE', $data['mobile'], 600);
                $this->msgbox->add('手机验证通过,请稍后');
            }
        }
        else{
            $this->tmpl = "pchome/passport/forget.html";
        }
    }

    //找回密码-设置新密码（步骤2）
    public function forget_pwd()
    {

        if($data = $this->checksubmit('data')){
            $mobile  = $this->cookie->get('FORGET_MOBILE');

            if(!$member = K::M('member/member')->find(array('mobile' => $mobile))){
                $this->msgbox->add("手机号码不存在!", 211);
            }
            
            else if(!$data['passwd']){
                $this->msgbox->add('密码没有填写', 212);
            }
            else if($data['passwd'] !== $data['repasswd']){
                $this->msgbox->add('两次输入的密码不一致', 213);
            }
            else{
                K::M('member/member')->update($member['uid'], array('passwd' => md5($data['passwd'])));
                $this->msgbox->add('修改成功');
            }
        }
        else{
            if(!$mobile = $this->cookie->get('FORGET_MOBILE')){
                header("location:" . $this->mklink('passport/forget', null, null, 'base'));
            }
            $this->tmpl = "pchome/passport/forget_pwd.html";
        }
    }

    /* 密码找回成功 */
    public function forget_success()
    {
        $this->tmpl = "pchome/passport/forget_success.html";
    }

    
    
    //WEIXIN 联合登录
    public function wxlogin($type=null)
    {
        if($url = K::M('member/wxlogin')->wxlogin_url($this->request)){
            header("Location: {$url}");
            die;
        }
        
    }
    
    
    public function wxcallback()
    {
        if(!$code = $this->GP('code')){
            die('回传地址有问题2');
        }elseif(!$state = $this->GP('state')){
            die('回传地址有问题1');
        }elseif(true == K::M('member/wxlogin')->wxcallback($code, $state)){
            $forward = K::M('helper/link')->mklink('ucenter/member:index', array(), array(), 'base');
            header("Location: {$forward}");
            die;
        }else{
            $this->wxbind();
        }
    }
    
    private function wxbind(){
        
        $cookie = $this->cookie->get('wxlogin');
        $wxlogin = json_decode(str_replace("\\","",$cookie), true);
        if(!$wxlogin){
            $forward = K::M('helper/link')->mklink('passport/login', array(), array(), 'base');
            header("Location: {$forward}");
            die;
        }
        
        $this->tmpl = "pchome/passport/wxbind.html";
    }

    
    public function wxbinding(){
        
        $cookie = $this->cookie->get('wxlogin');
        $wxlogin = json_decode(str_replace("\\","",$cookie), true);
        $session = K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if($data['type'] == 1){
                //没有帐号注册并绑定
                if(!$wxlogin){
                    $this->msgbox->add('微信登录错误', 210);
                }else if(true == K::M('member/member')->find(array('wx_unionid'=>$wxlogin['unionid'])) || true == K::M('member/member')->find(array('wx_openid'=>$wxlogin['openid']))){
                    $this->msgbox->add('您已经绑定过了！',211);
                }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                    $this->msgbox->add('手机号不正确', 212);
                }else if(!$data['code']){
                    $this->msgbox->add('手机验证码错误', 213);
                }else if($data['code'] != $session->get('code_' . $data['mobile'])){
                    $this->msgbox->add('手机验证码错误或已过期', 214);
                }else if(!$passwd = $data['passwd']){
                    $this->msgbox->add('密码没有填写!', 215);
                }else if(!$passwd2 = $data['passwd2']){
                    $this->msgbox->add('确认密码没有填写!', 216);
                }else if($passwd !== $passwd2){
                    $this->msgbox->add('两次密码输入不一致!', 217);
                }else if(K::M('member/member')->check_mobile($data['mobile'])){
                    $data['passwd'] = md5($data['passwd']);
                    $data['paypasswd'] = md5($passwd);
                    $data['nickname'] = $wxlogin['nickname'];
                    $data['face'] = $wxlogin['face'];
                    $data['wx_openid'] = $wxlogin['openid'];
                    $data['wx_unionid'] = $wxlogin['unionid'];
                    if($uid = K::M('member/member')->create($data)){
                        $this->auth->login($mobile, $passwd, 'mobile');
                        $this->msgbox->add('恭喜您，绑定成功!');
                    }
                }
            }else{
                //已有帐号绑定
                if(!$wxlogin){
                    $this->msgbox->add('微信登录错误', 210);
                }else if(true == K::M('member/member')->find(array('wx_unionid'=>$wxlogin['unionid'])) || true == K::M('member/member')->find(array('wx_openid'=>$wxlogin['openid']))){
                    $this->msgbox->add('您已经绑定过了！',211);
                }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                    $this->msgbox->add('手机号不正确', 212);
                }else if(!$passwd = $data['passwd']){
                    $this->msgbox->add('密码没有填写!', 213);
                }else if(!$u = K::M('member/member')->find(array('mobile'=>$mobile))){
                    $this->msgbox->add('不存在的账号!', 214);
                }else if(md5($passwd) !== $u['passwd']){
                    $this->msgbox->add('密码错误!', 215);
                }else{
                    K::M('member/member')->update($u['uid'],array('wx_openid'=>$wxlogin['openid'],'wx_unionid'=>$wxlogin['unionid']));
                    if($m = $this->auth->login($mobile, $passwd, 'mobile')){
                        $this->msgbox->add("绑定成功!");
                    }else{
                        $this->msgbox->add("绑定出错!",300);
                    }
                }
            }
        }
    }


    /*
	public function weixinreg($access_token,$openid)
	{
		if($account = $this->GP('account')){
			 if(K::M('member/wxlogin')->weixinreg($this->GP('access_token'),$this->GP('openid'),$account['uname'],$account['passwd'])){
				$this->err->add('恭喜您，注册会员成功');
				$forward = K::M('helper/link')->mklink('ucenter/member:index', array(), array(), 'base');
				$this->err->set_data('forward', $forward);
			 }
        }else{
			$this->pagedata['title'] = '微信第三方登录';
			$this->pagedata['openid'] = $openid;
			$this->pagedata['access_token'] = $access_token;
            $this->tmpl = 'passport/thirdreg3.html';
        }
	}

    public function weixin()
    {
        if($wechatCfg = $this->system->config->get('wechat')){
            if($client = K::M('weixin/weixin')->admin_wechat_client()){
                if($client->weixin_type == 1){
                    $data = array('uid'=>$uid, 'type'=>'login', 'addon'=>array('tenders_id'=>$tenders_id));
                    if($scene_id = K::M('weixin/authcode')->create($data)){
                        if($ticket = $client->getQrcodeTicket(array('scene_id'=>$scene_id, 'expire'=>1800))){
                            $wx_login_qr = $client->getQrcodeImgUrlByTicket($ticket);
                            $this->pagedata['wx_login_qr'] = $wx_login_qr;
                        }
                        $this->pagedata['qrcode_id'] = $scene_id;
                    }
                }
            }
            $this->tmpl = 'passport/weixin.html';
        }        
    }

    public function wxscanqr($scene_id)
    {
        $status = 0;
        if($row = K::M('weixin/authcode')->detail($scene_id)){
            if($row['status'] == 1){
                $status = 'scanqr';
            }else if($row['status'] == 2){
                if(K::M('member/auth')->manager($row['uid'])){

                }
                $status = 'login';
            }
        }
        echo '{"status":"'.$status.'"}';
        exit;
    }
    */
}