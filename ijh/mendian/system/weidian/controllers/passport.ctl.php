<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Passport extends Ctl
{


    public function index()
    {
        $this->tmpl = 'weidian/passport/login.html';
    }
    
    public function login()
    {
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
                $session =K::M('system/session')->start();
                if($sms_code != $session->get('code_'.$mobile)){
                    $this->msgbox->add('验证码不正确', 212);
                }else if($m = K::M('member/member')->member($mobile, 'mobile')){
                    if($member = $this->auth->manager($m['uid'])){
                        if(strpos($this->request['forward'], 'passport') !== false){
                            $forward = $this->mklink('ucenter:index', null, null, 'base');
                            $this->msgbox->set_data('forward', $forward);
                        }
                        $this->msgbox->add("欢迎您回来!");
                    }else{
                        $this->msgbox->add('验证码不正确!',215);
                    }
                }
            }
        }else{
            $this->tmpl = 'weidian/passport/login.html';
        }
    }

    public function signup()
    {
        if($data = $this->checksubmit('data')){

        }else{
            $this->tmpl = 'weidian/passport/signup.html';
        }
    }

    public function wxlogin()
    {
        // 已授权
        if($wx_openid = $this->token_openid()){
            // 已绑定
            if($member = K::M('member/member')->member($wx_openid, 'wx_openid')){
                $ret = $this->system->auth->manager($member['uid']);
                header("Location:".$this->mklink('ucenter/info'));
                exit;
            }else if($this->uid){
                // 需要绑定
                K::M('member/member')->update($this->uid, array('wx_openid'=>$wx_openid));
                header("Location:".$this->mklink('ucenter/info'));
                exit;
            }else{
                header("Location:".$this->mklink('passport/wxbind'));
            }
        }else{
            $this->msgbox->add('授权获取失败', 211);
        } 
    }

    public function wxbind()
    {

    }

    public function wxcallback()
    {

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
    public function loginout()
    {
        $this->auth->loginout();
        $login_link = $this->weidian['url'];
        header("location:".$login_link);
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
                if($uid = K::M('member/account')->create($data)){
                    $this->msgbox->add('恭喜您，注册会员成功!');
                    $this->msgbox->set_data('forward', $this->mklink('ucenter'));
                }
            }
        }else{
            $this->tmpl = 'passport/register.html';
        }

    }
    public function sendsms()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            if($mobile = $this->checksubmit('mobile')){
                if(!$mobile = K::M('verify/check')->mobile($mobile)){
                    $this->msgbox->add('电话号码有误', 212);
                }else{
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
                $this->msgbox->add('短信发送失败', 211);
            }
        }
    }
}
