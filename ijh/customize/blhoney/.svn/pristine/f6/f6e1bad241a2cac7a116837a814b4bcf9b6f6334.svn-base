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
                    $this->msgbox->add('头像设置成功');
                    $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
                }else{
                    $this->msgbox->add('设置失败',211);
                }  
            }
    }
    
    
    public function update_nickname() {
		$this->tmpl = "ucenter/info/update_nickname.html";
	}
    
    public function set_nickname(){
        $nickname = $this->GP('nickname');
        if(!$nickname){
            $this->msgbox->add('没有填写昵称!',211);
        }else if(!$up = K::M('member/member')->update($this->uid,array('nickname'=>$nickname))){
            $this->msgbox->add('设置失败',211);
        }else{
             $this->msgbox->add('昵称设置成功');
             $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
        }
    }
    
    public function update_mobile() {
		$this->tmpl = "ucenter/info/update_mobile.html";
	}
    
    public function set_mobile(){
        $session =K::M('system/session')->start();
        if(!$mobile = $this->GP('mobile')){
            $this->msgbox->add('手机号错误'.$mobile, 211);
        }else if(!$code = $this->GP('yzm')){
            $this->msgbox->add('验证码不能为空', 211);
        }else if($code != $session->get('code_'.$mobile)){
            $this->msgbox->add('验证码不正确'.$code, 211);
        }else if(K::M('member/account')->update_mobile($this->uid, $mobile)){
            $this->msgbox->add('修改手机成功');
            $this->msgbox->set_data("forward", $this->mklink('ucenter/info:index',null));
        }
    }
    
    
    public function update_passwd(){
        $this->tmpl = "ucenter/info/update_passwd.html";
    }
    
    public function set_passwd(){
        $session =K::M('system/session')->start();
        if(!$old_passwd = $this->GP('old_passwd')){
            $this->msgbox->add('旧密码没有填写', 211);
        }else if(!$new_passwd = $this->GP('new_passwd')){
            $this->msgbox->add('新密码没有填写', 212);
        }else if(!$new_passwd2 = $this->GP('new_passwd2')){
            $this->msgbox->add('确认新密码没有填写', 213);
        }else if($new_passwd != $new_passwd2){
            $this->msgbox->add('两次新密码输入不一致', 214);
        }else if(md5($old_passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add('旧密码不正确', 215);
        }else if($old_passwd == $new_passwd){
            $this->msgbox->add('新密码不能和旧密码一致', 216);
        }else if(K::M('member/member')->up_passwd($this->uid, $new_passwd)){
            $this->msgbox->add('修改密码成功');
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
                        $this->msgbox->add('已绑定',210);
                    }
                }else {
                    if(K::M('member/member')->update($this->uid,array('wx_openid'=>''))) {
                        $this->msgbox->add('已解除绑定',211);
                    }
                }
            }
        }else {
            $this->msgbox->add('请从微信登录后再进行绑定解绑操作',212);
        }
    }
}