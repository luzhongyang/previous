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
                $this->msgbox->add('登录帐号不正确',  211);
            }else if(!$passwd = $data['passwd']){
                $this->msgbox->add('登录密码不正确',  212);
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
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$data['mobile']){
                $this->msgbox->add('手机号不能为空', 211);
            }else if(!$data['code']){
                $this->msgbox->add('验证码不能为空', 212);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add('验证码不正确', 213);
            }else if($shop = K::M('shop/shop')->find(array('mobile'=>$data['mobile']))){
                $this->msgbox->add('该手机号码已存在', 213);
            }else{
                $data['passwd'] = md5(rand(1,999999));
                unset($data['code']);
                if($r = K::M('shop/shop')->create($data)){
                   $this->msgbox->add('申请入驻成功，请等待网站审核通知'); 
                }else{
                    $this->msgbox->add('申请入驻失败，系统错误',214);
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
                $this->msgbox->add('手机号不能为空', 211);
            }else if(!$data['code']){
                $this->msgbox->add('验证码不能为空', 212);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add('验证码不正确', 213);
            }else if(!$data['new_passwd']){
                $this->msgbox->add('新密码不能为空', 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add('确认密码不能为空', 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add('两次新密码输入不一致', 214);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add('新密码不能和旧密码一致', 216);
            }else if(!$shop = K::M('shop/shop')->shop($data['mobile'],'mobile')){
                $this->msgbox->add('该商家不存在');
            }else if(K::M('shop/shop')->update($shop['shop_id'],array('passwd'=>md5($data['new_passwd'])))){
                $this->msgbox->add('修改登录密码成功');
            }else{
                $this->msgbox->add('登录密码修改失败',217);
            }    
        }else{
            $this->tmpl = 'biz/account/forgot.html';
        }
    }
}
