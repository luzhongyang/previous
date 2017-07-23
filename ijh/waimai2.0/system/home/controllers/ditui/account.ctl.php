<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_Account extends Ctl
{

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        //K::M('ditui/auth')->login('17756570802', '123456');
        //header("Location: /ditui/");exit;
        if($data = $this->checksubmit('data')){
            if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add(L('账号不存在'),  211);
            }else if(!$passwd = $data['passwd']){
                $this->msgbox->add(L('密码不正确'),  212);
            }else if($ditui = K::M('ditui/auth')->login($mobile, $passwd)){
                $forward = $this->mklink('ditui/index');
                $this->msgbox->set_data('forward', $forward);
            }
        }else{
            $this->tmpl = 'ditui/account/login.html';
        }
    }

    public function signup()
    {
        $session =K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'mobile,name,city_id,code')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else if(!$data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 212);
            }else if(!$data['code']){
                $this->msgbox->add(L('验证码不能为空'), 213);
            }else if(!$data['name']){
                $this->msgbox->add(L('姓名不能为空'), 214);
            }else if(!$data['city_id']){
                $this->msgbox->add(L('请选择所在城市'), 215);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add(L('验证码不正确'), 216);
            }else if($shop = K::M('ditui/ditui')->find(array('mobile'=>$data['mobile']))){
                $this->msgbox->add(L('该手机号已存在'), 217);
            }else{
                $data['passwd'] = md5(rand(1,999999));
                K::M('ditui/ditui')->create($data);
                $this->msgbox->add(L('申请成功，请等待网站审核通知'));
            }
        }else{
            $this->pagedata['citys'] = K::M('data/city')->items(null,array('pinyin'=>'asc'));
            $this->tmpl = 'ditui/account/signup.html';
        }
    }

    public function loginout()
    {
        K::M('ditui/auth')->loginout();
        header('Location:/ditui/account');
    }

    public function forgot()
    {
        $session =K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 211);
            }else if(!$data['code']){
                $this->msgbox->add(L('验证码不能为空'), 212);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add(L('验证码不正确'), 213);
            }else if(!$data['new_passwd']){
                $this->msgbox->add(L('请填写新密码'), 214);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add(L('请填写确认新密码'), 215);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add(L('新密码两次输入不一致'), 216);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 217);
            }else if(!$ditui = K::M('ditui/ditui')->ditui($data['mobile'],'mobile')){
                $this->msgbox->add(L('地推人不存在'));
            }else if(K::M('ditui/ditui')->update($ditui['ditui_id'],array('passwd'=>md5($data['new_passwd'])))){
                $this->msgbox->add(L('操作成功'));
            }else{
                $this->msgbox->add(L('FAIL'),218);
            }    
        }else{
            $this->tmpl = 'ditui/account/forgot.html';
        }
    }
}
