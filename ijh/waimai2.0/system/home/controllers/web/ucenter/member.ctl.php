<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Member extends Ctl_Web_Ucenter {


    public function index($page) 
    {
        $this->tmpl = 'web/ucenter/member/index.html';
    }

    public function face() 
    {
        $this->tmpl = 'web/ucenter/member/face.html';
    }
    
    public function upload_face(){
        if($attach = $_FILES['avatar']){
            $data = array();
            if($a = K::M('magic/upload')->upload($attach, 'car')){
                $data['face'] = $a['photo'];
            }   
            //修改头像
            if($up = K::M('member/member')->update($this->uid,$data)){
                $this->msgbox->add(L('更换图像成功'));
            }else{
                $this->msgbox->add(L('更换图像失败'),211);
            }  
        }
    }
    
    
    public function mobile(){
        $step = (int)$this->GP('step');
        if(!$step){
            $step = 1;
        }
        $this->pagedata['step'] = $step;
        $this->tmpl = 'web/ucenter/member/mobile.html';
    }

    
    public function verify_old(){
        $session =K::M('system/session')->start();
        if(!$mobile = $this->MEMBER['mobile']){
            $this->msgbox->add(L('手机号不正确'), 211);
        }else if(!$code = $this->GP('yzm')){
            $this->msgbox->add(L('验证码不能为空'), 211);
        }else if($code != $session->get('code_'.$mobile)){
            $this->msgbox->add(L('验证码不正确'), 211);
        }else{
            $this->msgbox->add(L('SUCCESS'));
        }
    }
    
    
    public function set_mobile(){
        $session =K::M('system/session')->start();
        if(!$mobile = $this->GP('mobile')){
            $this->msgbox->add(L('手机号不正确').$mobile, 211);
        }else if(!$code = $this->GP('yzm')){
            $this->msgbox->add(L('验证码不能为空'), 211);
        }else if($code != $session->get('code_'.$mobile)){
            $this->msgbox->add(L('验证码不正确').$code, 211);
        }else if(K::M('member/account')->update_mobile($this->uid, $mobile)){
            $this->msgbox->add(L('手机号更换成功'));
        }
    }
    
    public function info(){
        $this->tmpl = 'web/ucenter/member/info.html';
    }
    
    public function set_nickname(){
        $nickname = $this->GP('nickname');
        if(!$nickname){
            $this->msgbox->add(L('请填写昵称'),211);
        }else if(!$up = K::M('member/member')->update($this->uid,array('nickname'=>$nickname))){
            $this->msgbox->add(L('修改昵称失败'),211);
        }else{
             $this->msgbox->add(L('修改昵称成功'));
             //$this->msgbox->set_data("forward", $this->mklink('web/ucenter/member:index',null));
        }
    }
    
    
    public function passwd(){
        $this->tmpl = 'web/ucenter/member/passwd.html';
    }
    
    public function set_passwd(){
        $session =K::M('system/session')->start();
        if(!$old_passwd = $this->GP('old_passwd')){
            $this->msgbox->add(L('请填写当前密码'), 211);
        }else if(!$new_passwd = $this->GP('new_passwd')){
            $this->msgbox->add(L('请填写新密码'), 212);
        }else if(!$new_passwd2 = $this->GP('new_passwd2')){
            $this->msgbox->add(L('请填写确认新密码'), 213);
        }else if($new_passwd != $new_passwd2){
            $this->msgbox->add(L('新密码两次输入不一致'), 214);
        }else if(md5($old_passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add(L('当前密码不正确'), 215);
        }else if($old_passwd == $new_passwd){
            $this->msgbox->add(L('新密码不能和当前密码相同'), 216);
        }else if(K::M('member/account')->up_passwd($this->uid, $new_passwd)){
            $this->msgbox->add(L('密码修改成功'));
            $this->msgbox->set_data("forward", $this->mklink('web/ucenter/index',null));
        }
    }
    
    public function account(){
        
        $money_pack = array();
        if($money_pack = K::M('member/money')->package()) {
            $this->pagedata['money_pack'] = $money_pack;
            $this->pagedata['uid'] = $this->uid;
        }
        
        $this->tmpl = 'web/ucenter/member/account.html';
    }
    
}
