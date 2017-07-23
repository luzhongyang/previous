<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Base extends Ctl_Ditui
{
    

    public function index()
    {
        if($ditui = K::M('ditui/ditui')->detail($this->ditui_id)) {
            $this->pagedata['info'] = $ditui;
        }
        $this->tmpl = 'ditui/base/index.html';  
    }

    public function passwd()
    {
        if($data = $this->checksubmit('data')){
            $session =K::M('system/session')->start();
            if(!$data['passwd']){
                $this->msgbox->add(L('请填写当前密码'), 211);
            }else if(!$data['new_passwd']){
                $this->msgbox->add(L('请填写新密码'), 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add(L('请填写确认新密码'), 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add(L('新密码两次输入不一致'), 214);
            }else if(md5($data['passwd']) != $this->ditui['passwd']){
                $this->msgbox->add(L('当前密码不正确'), 215);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 216);
            }else{
                $new_passwd = md5($data['new_passwd']);
                if(K::M('ditui/ditui')->update($this->ditui_id,array('passwd'=>$new_passwd))){
                    $this->msgbox->add(L('SUCCESS'));
                }        
            }
        }else{
            $this->tmpl = 'ditui/base/passwd.html';
        }        
    }
    
    public function license()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'name,id_number,id_photo')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else{
                if($attach = $_FILES['id_photo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'ditui')){
                            $data['id_photo'] = $a['photo'];
                        }
                    }
                }
                if($detail = K::M('ditui/ditui')->detail($this->ditui_id)){
                    K::M('ditui/ditui')->update($this->ditui_id, $data);
                    $this->msgbox->add(L('身份认证资料提交成功'));
                }else{
                    $data['ditui_id'] = $this->ditui_id;
                    K::M('ditui/ditui')->create($data);
                    $this->msgbox->add(L('身份认证资料提交成功'));
                }
            }
        }else{
            $this->pagedata['detail'] = K::M('ditui/ditui')->detail($this->ditui_id);
            $this->tmpl = 'ditui/base/license.html';
        } 
    }
    
    
    public function mobile()
    {
        $session =K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 211);
            }else if(!$data['code']){
                $this->msgbox->add(L('验证码不能为空'), 212);
            }else if($data['code'] != $session->get('code_'.$data['mobile'])){
                $this->msgbox->add(L('验证码不正确'), 213);
            }else if(K::M('ditui/ditui')->update($this->ditui_id,array('mobile'=>$data['mobile']))){
                $this->msgbox->add(L('SUCCESS'));
            }
        }else{
            $this->tmpl = 'ditui/base/mobile.html';
        }        
    }

    public function account()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'account_type,account_name,account_number')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else {
                if($detail = K::M('ditui/ditui')->detail($this->ditui_id)){
                    K::M('ditui/ditui')->update($this->ditui_id, $data);
                    $this->msgbox->add(L('修改提现帐号成功'));
                }else{
                    $data['ditui_id'] = $this->ditui_id;
                    K::M('ditui/ditui')->create($data);
                    $this->msgbox->add(L('添加提现帐号成功'));
                }
            }
        }else{
            $this->pagedata['bank_list'] = K::M('data/data')->bank_list();
            $this->tmpl = 'ditui/base/account.html';
        }          
    }
    
    
    
}