<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_Passport extends Ctl_Web
{
    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if (!empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) && !strstr($_SERVER['HTTP_REFERER'], 'passport')) {
            $backurl = $_SERVER['HTTP_REFERER'];
        } else {            
            $backurl = '/web/index';
        }
        $this->pagedata['backurl'] = $backurl;

        if($this->GP('give_wx') === 'shouquan'){
            if($open_id = $this->token_openid()){
                // 已授权 跳转到登录页面
                $this->pagedata['open_id'] = $open_id;
            }
            $this->pagedata['backurl'] = $this->mklink('ucenter/info');
            $this->tmpl = 'web/passport/login.html';

        }else{
            $yzm_config = $this->system->config->get('access');
            if($yzm_config['verifycode']['reg'] == 'on'){
                $this->pagedata['reg_yzm'] = $yzm_config['verifycode']['reg'];
            }
            if($this->uid){
                $this->tmpl = 'web/index.html';
            }else{
                if(2 == $type = $this->GP('type')){
                    $this->tmpl = 'web/passport/login2.html';
                }else{
                    $this->tmpl = 'web/passport/login.html';
                }
            }

        }
        
    }

    public function wxlogin()
    {
        // 已授权

        if($wx_openid = $this->token_openid()){
            if(defined('WX_UNIONID')){
                $wxtype = 'wx_unionid';
                $wxid = WX_UNIONID;
            }else{
                $wxtype = 'wx_openid';
                $wxid = $wx_openid;
            }
            // 已绑定
            if($member = K::M('member/member')->member($wxid, $wxtype)){
                $ret = $this->system->auth->manager($member['uid']);
                header("Location:".$this->mklink('ucenter/info'));
                exit;
            }else if($this->uid){// 需要绑定
                if(defined('WX_UNIONID')){
                    $a = array('wx_openid'=>$wx_openid, 'wx_unionid'=>WX_UNIONID);
                }else{
                    $a = array('wx_openid'=>$wx_openid);
                }
                K::M('member/member')->update($this->uid, $a);
                header("Location:".$this->mklink('ucenter/info'));
                exit;
            }else{
                header("Location:".$this->mklink('passport/wxbinding'));
            }
        }else{
            header("Location:".$this->mklink('ucenter'));
        }
    }
    
    public function wxbind()
    {
        $data = array();
        if(!$wx_openid = $this->access_openid()){
            $this->wxlogin();
        }else if(!empty($_POST)){
            if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add(L('手机号不正确'), 211);
            }else if(!$sms_code = $this->GP('yzm')){
                $this->msgbox->add(L('验证码不能为空'), 212);
            }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
                $this->msgbox->add(L('验证码不正确'), 213);
            }else if($member = K::M('member/member')->member($mobile, 'mobile')){
                if(defined('WX_UNIONID')){
                    $wxtype = 'wx_unionid';
                    $wxid = WX_UNIONID;
                    $a = array('wx_openid'=>$wx_openid, 'wx_unionid'=>WX_UNIONID);
                }else{
                    $wxtype = 'wx_openid';
                    $wxid = $wx_openid;
                    $a = array('wx_openid'=>$wx_openid);
                }
                K::M('member/member')->update($member['uid'], $a);
                $this->system->auth->manager($member['uid']);
                $this->msgbox->add('bindone');              
            }else{
                if(defined('WX_UNIONID')){
                    $data['wx_unionid'] = WX_UNIONID;
                }
                $data['mobile'] = $mobile;
                $data['wx_openid'] = $wx_openid;                
                //$data['paypasswd'] = md5(uniqid());
                $data['passwd'] = md5(uniqid());
                $data['nickname'] = substr($mobile, 0,3).'****'.substr($mobile, -4);
                if($uid = K::M('member/account')->create($data)){
                    if($this->system->auth->manager($uid)){
                        $this->msgbox->add('createdone');                     
                    }
                }
            }
        }
    }

    public function wxbinding()
    {
        $this->tmpl = 'passport/wxbind.html';
    }

    public function register()
    {
        $session =K::M('system/session')->start();
        if($this->checksubmit()){
            $data['nickname'] = '';
            if(!$data['mobile'] = $this->GP('mobile')){
                $this->msgbox->add(L('手机号不正确'), 211);
            }else if(!K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add(L('手机号不正确'), 211);
            }else if(!$yzm_code = $this->GP('yzm')){
                $this->msgbox->add(L('短信验证码错误'), 212);
            }else if($yzm_code != $_SESSION['code_'.$data['mobile']]){
                $this->msgbox->add(L('短信验证码错误或已过期'),212);
            }else if(!$data['passwd'] = $this->GP('passwd')){
                $this->msgbox->add(L('密码不正确'), 213);
            }else if($data['passwd'] !==  $this->GP('repasswd')){
                $this->msgbox->add(L('两次输入的密码不一致'), 215);
            }else if(K::M('member/member')->check_mobile($data['mobile'])){
                if(defined('IN_WEIXIN') && defined('WX_OPENID')){
                    $data['wx_openid'] = WX_OPENID;
                    if(defined('WX_UNIONID')){
                        $data['wx_unionid'] = WX_UNIONID;
                    }
                }
                $data['nickname'] = $data['mobile'];
                if($uid = K::M('member/account')->create($data)){
                    $this->msgbox->add(L('恭喜您，注册会员成功!'));
                }
            }
        }else{
            $this->tmpl = 'web/passport/register.html';
        }

    }


    public function sendsms()
    {
         if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
             $phone = $this->GP('mobile');
              if(!$a = K::M('verify/check')->mobile($phone)){
                    $this->msgbox->add(L('手机号不正确'), 212);
                }else{
                    $code = rand(100000,999999);
                    $session =K::M('system/session')->start();
                    $session->set('code_'.$phone, $code,900); //15分钟缓存
                    $smsdata =  array('code'=>$code);
                    $this->msgbox->add('success');
                    //$this->msgbox->set_data('data', array('code'=>$code));
                    if(K::M('sms/sms')->send($phone, 'login', $smsdata)){
                        $this->msgbox->add(L('SUCCESS'));
                    }
               }
         }else{
             $this->error(404);
         }
    }

    public function passwd()
    {
        $session =K::M('system/session')->start();
        if($this->checksubmit()){
            if(!$data['mobile'] = $this->GP('mobile')){
                $this->msgbox->add('手机号没有填写', 211);
            }else if(!$a = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号有误', 212);
            }else if(!$data['yzm'] = $this->GP('yzm')){
                $this->msgbox->add('手机验证码错误', 213);
            }else if(!($_SESSION['code_'.$data['mobile']]) || $data['yzm'] != $_SESSION['code_'.$data['mobile']]){
                $this->msgbox->add('手机验证码错误或已过期',214);
            }else if(!$data['password'] = $this->GP('password')){
                $this->msgbox->add('密码没有填写', 215);
            }else if(!$data['password2'] = $this->GP('password2')){
                $this->msgbox->add('确认密码没有填写', 216);
            }else if($data['password'] !== $data['password2']){
                $this->msgbox->add('两次输入的密码不一致', 217);
            }else{
                if($member = K::M('member/member')->member($data['mobile'],'mobile')){
                    if(flase !== K::M('member/account')->update_passwd($member['uid'],$data['password'])){
                        $this->auth->loginout();
                        $this->msgbox->add('修改密码成功!');
                    }
                }
            }
        }else{
            $this->tmpl = 'web/passport/passwd.html';
        }

    }
    
    
    public function handle()
    {
        $session =K::M('system/session')->start();
        $phone = $this->GP('mobile');
        $yzm = $this->GP('yzm');
        $yzm_config = $this->system->config->get('access');
        if($yzm_config['verifycode']['reg'] == 'on'){
            $yzm_val = $this->GP('yzm_val');
            if(!$yzm_val){
                $this->msgbox->add(L('验证码不正确'), 212);
                return false;
            }else if(!K::M('magic/verify')->check($yzm_val)){
                $this->msgbox->add(L('验证码不正确'), 212);
                return false;
            }
        }
        if(!$a = K::M('verify/check')->mobile($phone)){
            $this->msgbox->add(L('手机号不正确'), 212);
        }else if(!$yzm){
            $this->msgbox->add(L('短信验证码错误'),212);
        }else if(!($_SESSION['code_'.$phone]) || $yzm != $_SESSION['code_'.$phone]){
            $this->msgbox->add(L('短信验证码错误或已过期'), 212);
        }else if($member = K::M('member/member')->member($phone, 'mobile')){
            if($member = $this->auth->manager($member['uid'])){
                $this->msgbox->add(L("欢迎您回来"));
            }else{
                $this->msgbox->add(L('登录失败'),215);
            }
        }
    }

    public function handle2()
    {

        $phone = $this->GP('mobile');
        $password = $this->GP('password');

        if(!$a = K::M('verify/check')->mobile($phone)){
            $this->msgbox->add(L('手机号不正确'), 212);
        }else if(!$password){
            $this->msgbox->add(L('密码不正确'),213);
        }else if($member = K::M('member/member')->find(array('mobile'=>$phone))){
            if($member['passwd'] == md5($password)){
                if($member = $this->auth->manager($member['uid'])){
                    $this->msgbox->add(L("欢迎您回来"));
                }
            }else{
                $this->msgbox->add(L("密码不正确"),215);
            }
        }else{
          $this->msgbox->add(L("帐号不存在"),214);
        }
        
    }


    public function loginout()
    {
        $this->auth->loginout();
        $this->msgbox->add(L("退出登录成功"));
    }

}
