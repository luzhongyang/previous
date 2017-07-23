<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Account extends Ctl
{

    public function index()
    {
        $this->login();
    }

    // 商户登陆
    public function login()
    {
        if($data = $this->checksubmit('data')){
            if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('登录帐号不正确',  211);
            }else if(!$passwd = $data['passwd']){
                $this->msgbox->add('登录密码不正确',  212);
            }else if($wuye = K::M('xiaoqu/wuye/auth')->login($mobile, $passwd)){
                $forward = $this->mklink('wuye/index');
                $this->msgbox->set_data('forward', $forward);
            }
        }else{
            $this->tmpl = 'wuye/account/login.html';
        }

    }


    // 商户退出登录
    public function loginout()
    {
        K::M('shop/auth')->loginout();
        header('Location:/wuye/account');
    }

   
    // 商户未审核指定跳转页面
    public function noaudit() {
        $this->tmpl = "wuye/noaudit.html";
    }
}
