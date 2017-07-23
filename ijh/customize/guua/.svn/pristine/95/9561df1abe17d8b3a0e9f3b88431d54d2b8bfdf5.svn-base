<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Account extends Ctl
{

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if($data = $this->checksubmit('data')){
            if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add(L('账号不存在'),  211);
            }else if(!$passwd = $data['passwd']){
                $this->msgbox->add(L('密码不正确'),  212);
            }else if($biz = K::M('shop/auth')->login($mobile, $passwd)){
                $forward = $this->mklink('biz/index');
                $this->msgbox->set_data('forward', $forward);
            }
        }else{
            $this->tmpl = 'biz/account/login.html';
        }
    }

    public function signup()
    {
        $session =K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'mobile,passwd,title,phone,city_id,cate_id,addr,info,code')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else if(!$data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 211);
            }else if(!$data['code']){
                $this->msgbox->add(L('验证码不能为空'), 212);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add(L('验证码不正确'), 213);
            }else if($shop = K::M('shop/shop')->find(array('mobile'=>$data['mobile']))){
                $this->msgbox->add(L('该手机号已存在'), 213);
            }else{
                $data['passwd'] = md5(rand(1,999999));
                unset($data['code']);
                if($r = K::M('shop/shop')->create($data)){
                   $this->msgbox->add(L('申请成功，请等待网站审核通知')); 
                }else{
                    $this->msgbox->add(L('申请失败，系统错误'),214);
                }
            }
        }else{
            $this->pagedata['citys'] = K::M('data/city')->items(null,array('pinyin'=>'asc'));
            $this->pagedata['cates'] = K::M('shop/cate')->fetch_all();
            $this->tmpl = 'biz/account/signup.html';
        }
    }

    public function loginout()
    {
        K::M('shop/auth')->loginout();
        header('Location:/biz/account');
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
                $this->msgbox->add(L('请填写新密码'), 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add(L('请填写确认新密码'), 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add(L('新密码两次输入不一致'), 214);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 216);
            }else if(!$shop = K::M('shop/shop')->shop($data['mobile'],'mobile')){
                $this->msgbox->add(L('商家不存在'));
            }else if(K::M('shop/shop')->update($shop['shop_id'],array('passwd'=>md5($data['new_passwd'])))){
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),217);
            }    
        }else{
            $this->tmpl = 'biz/account/forgot.html';
        }
    }
}
