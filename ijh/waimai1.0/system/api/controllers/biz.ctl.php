<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz extends Ctl
{

    public function index()
    {
        exit('{"error":"0", "message":"biz api test"}');
    }

    public function login($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不正确'),212);
        }else if($shop = K::M('shop/auth')->login($mobile, $passwd)){
            $shop = $this->filter_fields('shop_id,title,logo,mobile,money', $shop);
            $shop['token'] = $this->auth->token;
            $this->msgbox->set_data('data', $shop);
        }
    }

    public function signup($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不正确'),214);
        }else if($shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add(L('该手机号已经注册'),215);
        }else{

        }
    }

    public function forgot($params)
    {
        $session = K::M('system/session')->start();

    }

    public function passwd($params)
    {
        $this->check_login();
        $session = K::M('system/session')->start();
        if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add(L('新密码不正确'),214);
        }else if(K::M('shop/shop')->update($this->shop_id, array('passwd'=>$new_passwd))){
            $this->msgbox->set_data('data', array('shop_id'=>$this->shop_id));
        }
    }

    public function updatemobile($params)
    {
        $this->check_login();

    }

    //提交认证资料
    public function verify($params)
    {
        $this->check_login();

    }

    //结算帐号设置
    public function account($params)
    {
        $this->check_login();

    }

}
