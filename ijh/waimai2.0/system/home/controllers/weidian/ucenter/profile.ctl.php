<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Ucenter_Profile extends Ctl_Weidian
{
	public function index() {
        $this->pagedata['shop'] = K::M('shop/shop')->detail((int)$_SESSION['WEIDIAN_SHOP_ID']);
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/profile/index.html';           
	}
    
    public function upload_face(){
        if($attach = $_FILES['face']){
            $data = array();
            if($a = K::M('magic/upload')->upload($attach, 'member')){
                $data['face'] = $a['photo'];
            }
            //修改头像
            if($up = K::M('member/member')->update($this->uid,$data)){
                header('Location:/ucenter/profile/');
            }else{
                header('Location:/ucenter/profile/');
            }
        }else{
            header('Location:/ucenter/profile/');
        }
    }
    
    public function photo()
    {
        if(!$attach = $_FILES['imgFile']){
            $this->msgbox->add(L('上传文件失败'), 211);
        }else if(UPLOAD_ERR_OK != $attach['error']){
            $this->msgbox->add(L('上传文件失败'), 212);
        }else if($a = K::M('magic/upload')->upload($attach, 'photo')){
            $data['face'] = $a['photo'];
            if($up = K::M('member/member')->update($this->uid,$data)){
                $this->msgbox->add(L('操作成功'));
            }else{
                $this->msgbox->add(L('操作失败'), 213);
            }
        }
        $this->msgbox->json();
    }
    
    public function up_username() {
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/profile/up_username.html';         
	}
    
    public function set_nickname(){
        $nickname = $this->GP('nickname');
        if(!$nickname){
            $this->msgbox->add(L('请填写昵称'),211);
        }else if(!$up = K::M('member/member')->update($this->uid,array('nickname'=>$nickname))){
            $this->msgbox->add('修改失败',211);
        }else{
             $this->msgbox->add('修改成功');
        }
    }
    
    public function up_mobile() {
        $cfg = $this->system->config->get('site');
        $this->pagedata['phone'] = $cfg['phone'];
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/profile/up_mobile.html'; 
	}
	
	public function old_mobile(){
	    $session =K::M('system/session')->start();
	    if(!$mobile = $this->GP('mobile')){
	        $this->msgbox->add(L('手机号不正确').$mobile, 211);
	    }else if(!$code = $this->GP('yzm')){
	        $this->msgbox->add(L('验证码不能为空'), 211);
	    }else if($code != $session->get('code_'.$mobile)){
	        $this->msgbox->add(L('验证码不正确'), 211);
	    }else{
	        $this->msgbox->add('验证成功，请绑定新手机号');
	    }
	}
    
    public function set_mobile(){
        $member = K::M('member/member')->detail($this->uid);
        $session =K::M('system/session')->start();
        if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
            $this->msgbox->add(L('新手机号不正确').$mobile, 211);
        }else if(!$code = $this->GP('yzm')){
            $this->msgbox->add(L('验证码不能为空'), 211);
        }else if($code != $session->get('code_'.$member['mobile'])){
            $this->msgbox->add(L('验证码不正确'), 211);
        }else if($mobile == $member['mobile']){
            $this->msgbox->add('新手机号和原号码相同', 211);
        }else if(K::M('member/account')->update_mobile($this->uid, $mobile)){
            $this->msgbox->add(L('操作成功'));
        }
    }
    
    
    public function up_passwd(){
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/profile/up_passwd.html';           
    }
    
    public function passwd_by_old(){
        if($_POST){
            if(!$old_passwd = $this->GP('old_passwd')){
                $this->msgbox->add(L('请填写当前密码'), 211);
            }else if(!$new_passwd = $this->GP('new_passwd')){
                $this->msgbox->add(L('请填写新密码'), 212);
            }else if(md5($old_passwd) != $this->MEMBER['passwd']){
                $this->msgbox->add(L('当前密码不正确'), 215);
            }else if($old_passwd == $new_passwd){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 216);
            }else if(K::M('member/account')->up_passwd($this->uid, $new_passwd)){
                $this->msgbox->add(L('操作成功'));
            }else{
                $this->msgbox->add(L('更改失败'),217);
            }
        }else{
            $this->tmpl = "ucenter/profile/passwd_by_old.html";
        }
    }
    
    public function passwd_by_msg(){
        if($_POST){
            $member = K::M('member/member')->detail($this->uid);
            $session =K::M('system/session')->start();
            if(!$yzm = $this->GP('yzm')){
                $this->msgbox->add(L('验证码不正确'), 211);
            }else if($yzm != $session->get('code_'.$member['mobile'])){
                $this->msgbox->add(L('验证码不正确'), 212);
            }else if(!$new_passwd = $this->GP('new_passwd')){
                $this->msgbox->add(L('请填写新密码'), 213);
            }else if($member['passwd'] == md5($new_passwd)){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 214);
            }else if(K::M('member/account')->up_passwd($this->uid, $new_passwd)){
                $this->msgbox->add('修改成功');
            }else{
                $this->msgbox->add('修改失败',215);
            }
        }else{
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/profile/up_passwd.html';
        }
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
            $this->msgbox->add(L('新密码不能和当前密码相同！'), 216);
        }else if(K::M('member/account')->up_passwd($this->uid, $new_passwd)){
            $this->msgbox->add(L('操作成功'));
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
    
    public function suggestion()
    {
        if($data = $_POST) {
            $data['uid'] = $this->uid;
            if(K::M('member/suggestion')->create($data)){
                $this->msgbox->add('操作成功');
            }else{
                $this->msgbox->add('操作失败',212);
            }
        }else {
            $this->tmpl = "ucenter/profile/suggestion.html";
        }
    }
}