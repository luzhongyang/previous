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
    public function login()
    {
        //增加session,判断 http_referer
        $session =K::M('system/session')->start();
        if($data = $this->checksubmit('data')){

            if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号不正确', 211);
            }else if($passwd = $data['passwd']){
                if($m = $this->auth->login($mobile, $passwd, 'mobile')){
                    $this->msgbox->add("欢迎您回来!");
                }else{
                    $this->msgbox->add('帐号或密码不正确!',215);
                }
            }else if($sms_code = $data['sms_code']){

                if($sms_code != $session->get('code_'.$mobile)){
                    $this->msgbox->add('验证码不正确', 212);
                }else if($m = K::M('member/member')->member($mobile, 'mobile')){
                    if($member = $this->auth->manager($m['uid'])){
                        if(strpos($session->get('login_url'), 'passport') !== false){
                            $forward = $this->mklink('ucenter:index', null, null, 'base');
                        }
                        else{
                            $forward = $session->get('login_url');
                        }

                        $this->msgbox->set_data('forward', $forward);
                        $this->msgbox->add("欢迎您回来!");
                    }else{
                        $this->msgbox->add('验证码不正确!',215);
                    }
                }
            }
        }else{
            $session->set('login_url',$_SERVER['HTTP_REFERER']);
            $this->tmpl = 'fenxiao/passport/login.html';
        }
    }

    //微信登录
    public function wxlogin()
    {
        // 已授权
        if($wx_openid = $this->token_openid()){
            // 已绑定
            if($member = K::M('member/member')->member($wx_openid, 'wx_openid')){
                $ret = $this->system->auth->manager($member['uid']);
                header("Location:".$this->mklink('ucenter/info',null,null,'base'));
                exit;
            }else if($this->uid){
                // 需要绑定
                K::M('member/member')->update($this->uid, array('wx_openid'=>$wx_openid));
                header("Location:".$this->mklink('ucenter/info',null,null,'base'));
                exit;
            }else{
                header("Location:".$this->mklink('passport/wxbinding',null,null,'base'));
            }
        }else{
            $this->msgbox->add('授权获取失败', 211);
        }
    }

    //微信绑定
    public function wxbind()
    {
        $data = array();
        if(!$wx_openid = $this->token_openid()){
            $this->wxlogin();
        }else if(!empty($_POST)){
            if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add('手机号不正确', 211);
            }else if(!$sms_code = $this->GP('yzm')){
                $this->msgbox->add('验证码不能为空', 212);
            }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
                $this->msgbox->add('验证码不正确', 213);
            }else if($member = K::M('member/member')->member($mobile, 'mobile')){
                K::M('member/member')->update($member['uid'], array('wx_openid'=>$wx_openid));
                $this->system->auth->manager($member['uid']);
                $this->msgbox->add('bindone');
            }else{
                $data['mobile'] = $mobile;
                $data['wx_openid'] = $wx_openid;
                $data['paypasswd'] = $data['passwd'] = md5(uniqid());
                $data['nickname'] = substr($mobile, 0,3).'****'.substr($mobile, -4);
                if($uid = K::M('member/account')->create($data)){
                    if($this->system->auth->manager($uid)){
                        $this->msgbox->add('createdone');
                    }
                }
            }
        }
    }
    //微信绑定
    public function wxbinding()
    {
        $this->tmpl = 'fenxiao/passport/wxbind.html';
    }

    //注册
    public function register()
    {
        $session =K::M('system/session')->start();


        if($this->checksubmit()){
            $data['nickname'] = '';
            if(!$data['mobile'] = $this->GP('mobile')){
                $this->msgbox->add('手机号没有填写', 211);
            }else if(!K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号有误', 211);
            }else if(!$yzm_code = $this->GP('yzm')){
                $this->msgbox->add('手机验证码错误', 212);
            }else if($yzm_code != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add('手机验证码错误或已过期',212);
            }else if(!$data['passwd'] = $this->GP('passwd')){
                $this->msgbox->add('密码没有填写', 213);
            }else if($data['passwd'] !== $this->GP('repasswd')){
                $this->msgbox->add('两次输入的密码不一致', 215);
            }else if(K::M('member/member')->check_mobile($data['mobile'])){
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
                        $forward = $this->mklink('ucenter:index', null, null, 'base');
                    }
                    else{
                        $forward = $session->get('login_url');
                    }
                    $this->msgbox->set_data('forward', $forward);
                    $this->msgbox->add('恭喜您，注册会员成功!');
                }
            }
        }else{
            $this->tmpl = 'fenxiao/passport/register.html';
        }

    }

    /*  发送短信*/
    public function sendsms()
	{
         if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
             $mobile = $this->GP('mobile');
             $is_register = $this->GP('is_register');
            if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add('电话号码有误', 212);
            }
            else if(!K::M('member/member')->count(array('mobile'=>$mobile))  && 1!=$is_register ) {
                $this->msgbox->add('手机号码不存在',213);
            }
            else{
                $code = rand(100000,999999);
                $session =K::M('system/session')->start();
                $session->set('code_'.$mobile, $code,900); //15分钟缓存
                $smsdata =  array('code'=>$code);
                if(K::M('sms/sms')->send($mobile, 'login', $smsdata) || $code){
                    if(__DEBUG){
                        $this->msgbox->add('短信发送成功');
                    }else{
                        $this->msgbox->add('短信发送成功');
                    }
                    
                }
            }
        }else{
             $this->error(404);
        }
	}

    /* 短信登录 */
    public function handle()
    {
        $session =K::M('system/session')->start();

        $phone = $this->GP('mobile');

        $yzm = $this->GP('yzm');
        $yzm_config = $this->system->config->get('access');

        if($yzm_config['verifycode']['reg'] == 'on'){
            $yzm_val = $this->GP('yzm_val');
            if(!$yzm_val){
                $this->msgbox->add('网页安全验证码没有填写', 212);
                return false;
            }else if(!K::M('magic/verify')->check($yzm_val)){
                $this->msgbox->add('网页安全验证码不正确', 212);
                return false;
            }
        }

        if(!$a = K::M('verify/check')->mobile($phone)){
            $this->msgbox->add('电话号码有误', 212);
        }else if(!$yzm){
            $this->msgbox->add('手机验证码错误',212);
        }else if(!($_SESSION['code_'.$phone]) || $yzm != $_SESSION['code_'.$phone]){
            $this->msgbox->add('手机验证码错误或已过期',212);
        }else if($member = K::M('member/member')->member($phone, 'mobile')){
            if($member = $this->auth->manager($member['uid'])){
                $this->msgbox->add("欢迎您回来!");
            }else{
                $this->msgbox->add('登录失败!',215);
            }
        }
	}
    //密码登录
    public function handle2()
	{
        $phone = $this->GP('mobile');
        $password = $this->GP('password');

        if(!$a = K::M('verify/check')->mobile($phone)){
            $this->msgbox->add('电话号码有误', 212);
        }else if(!$password){
            $this->msgbox->add('密码没有填写',213);
        }else if($member = K::M('member/member')->find(array('mobile'=>$phone))){
            if($member['passwd'] == md5($password)){
                if($member = $this->auth->manager($member['uid'])){
                    $this->msgbox->add("欢迎您回来!");
                }
            }else{
                $this->msgbox->add("密码错误!",215);
            }
        }else{
          $this->msgbox->add("不存在!",214);
        }

	}
    //退出登录
    public function loginout()
    {
        $this->auth->loginout();
        header("location:".$this->mklink('fenxiao/passport/login'));
    }
    //找回密码
    public function forget()
    {
        if($d=$this->GP('submit')){
            if(!K::M('member/member')->items(array('mobile'=>$d['mobile']))){
                $this->msgbox->add("手机号码不存在!",101);
            }elseif(K::M('system/session')->start()->get('code_'.$d['mobile']) != $d['verify']){
                $this->msgbox->add("短信验证码不正确!",101);
            }elseif(strlen($d['pswd'])<5){
                $this->msgbox->add("新密码至少6位!",101);
            }elseif(!K::M('member/member')->update_by_mobile($d['mobile'], array('passwd'=>md5($d['pswd'])))){
                $this->msgbox->add("未知错误,重置密码失败!",101);
            }else{
                $this->msgbox->add("重置密码成功!");
            }
        }else{
            $this->tmpl = "fenxiao/passport/forget.html";
        }
    }
}
