<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Passwd extends Ctl_Ucenter
{
    /**
     * 密码设置
     */
    public function index(){
        if($data = $this->checksubmit('data')){
            $session = K::M('system/session')->start();
            if(!$data['mobile']){
                $this->msgbox->add('手机号没有填写',211);
            }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号格式不正确',212);
            }else if($mobile != $this->MEMBER['mobile']){
                $this->msgbox->add('手机号错误',213);
            }else if(!$code = $data['code']){
                $this->msgbox->add('手机验证码没有填写',214);
            }else if($code != $session->get('code_'.$mobile)){
                $this->msgbox->add('手机验证码不正确',215);
            }else if(!$passwd = $data['passwd']){
                $this->msgbox->add('密码没有填写',216);
            }else if(!$passwd2 = $data['passwd2']){
                $this->msgbox->add('确认密码没有填写',217);
            }else if($passwd !== $passwd2){
                $this->msgbox->add('两次密码输入不一致',218);
            }else{
                K::M('member/member')->update($this->uid,array('passwd'=>md5($passwd)));
                $this->msgbox->add('修改成功!');
            }
        }else{
            $this->tmpl = 'pchome/ucenter/passwd/index.html';
        }
    }

}
