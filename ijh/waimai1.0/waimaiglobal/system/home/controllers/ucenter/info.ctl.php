<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Info extends Ctl_Ucenter 
{
	public function index() {
		
		$this->tmpl = "ucenter/info/index.html";
	}
    
    public function upload_face(){
        if($attach = $_FILES['avatar']){
            $data = array();
            if($a = K::M('magic/upload')->upload($attach, 'car')){
                $data['face'] = $a['photo'];
            }   
            //修改头像
            if($up = K::M('member/member')->update($this->uid,$data)){
                $this->msgbox->add(L('SUCCESS'));
                $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
            }else{
                $this->msgbox->add(L('FAIL'),211);
            }  
        }
    }
    
    
    public function update_nickname() {
		$this->tmpl = "ucenter/info/update_nickname.html";
	}
    
    public function set_nickname(){
        $nickname = $this->GP('nickname');
        if(!$nickname){
            $this->msgbox->add(L('请填写昵称'),211);
        }else if(!$up = K::M('member/member')->update($this->uid,array('nickname'=>$nickname))){
            $this->msgbox->add(L('FAIL'),211);
        }else{
             $this->msgbox->add(L('SUCCESS'));
             $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
        }
    }
    
    public function update_mobile() {
		$this->tmpl = "ucenter/info/update_mobile.html";
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
            $this->msgbox->add(L('SUCCESS'));
            $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
        }
    }
    
    
    public function update_passwd(){
        $this->tmpl = "ucenter/info/update_passwd.html";
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
            $this->msgbox->add(L('SUCCESS'));
            $this->msgbox->set_data("forward", $this->mklink('ucenter',null));
        }
    }
    
    // 绑定微信
    public function wx_bind()
    {  
        if($wx_openid = $this->cookie->get('wx_openid')) {
            if($member = K::M('member/member')->detail($this->uid)) {
                if(!$member['wx_openid']) {
                    if(K::M('member/member')->update($this->uid,array('wx_openid'=>$wx_openid))) {
                        $this->msgbox->add(L('绑定成功'),210);
                    }
                }else {
                    if(K::M('member/member')->update($this->uid,array('wx_openid'=>''))) {
                        $this->msgbox->add(L('解绑成功'),211);
                    }
                }
            }
        }else {
            $this->msgbox->add(L('请从微信登录后再进行绑定解绑操作'),212);
        }
    }
}