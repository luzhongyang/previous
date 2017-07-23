<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Bind extends Ctl_Ucenter
{

    /**
     * 账户绑定
     */
    public function index()
    {
        $this->tmpl = 'pchome/ucenter/bind/index.html';
    }
    
    /**
     * 更换绑定手机
     */
    public function mobile(){
        if($data = $this->checksubmit('data')){
            $session = K::M('system/session')->start();
            if(!$data['old_mobile']){
                $this->msgbox->add('旧手机号没有填写',211);
            }else if(!$old_mobile = K::M('verify/check')->mobile($data['old_mobile'])){
                $this->msgbox->add('旧手机号格式不正确',212);
            }else if($old_mobile != $this->MEMBER['mobile']){
                $this->msgbox->add('旧手机号错误',213);
            }else if(!$passwd = $data['password']){
                $this->msgbox->add('密码没有填写',214);
            }else if(md5($passwd) != $this->MEMBER['passwd']){
                $this->msgbox->add('密码不正确',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('新手机号没有填写',216);
            }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('旧手机号格式不正确',217);
            }else if(!$code = $data['code']){
                $this->msgbox->add('手机验证码没有填写',218);
            }else if($code != $session->get('code_'.$mobile)){
                $this->msgbox->add('手机验证码不正确',219);
            }else if($true = K::M('member/member')->find(array('mobile'=>$mobile))){
                $this->msgbox->add('手机号已存在',220);
            }else{
                K::M('member/member')->update($this->uid,array('mobile'=>$mobile));
                $this->msgbox->add('修改成功!');
            }
        }else{
            $this->tmpl = 'pchome/ucenter/bind/mobile.html';
        }
    }

}
