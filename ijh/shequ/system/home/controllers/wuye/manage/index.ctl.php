<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Manage_Index extends Ctl_Wuye
{

    /**
     * 编辑账户
     */
    public function index(){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/wuye')->detail($this->wuye_id)){
            $this->msgbox->add('错误',211);
        }else if($data = $this->checksubmit('data')){
            if(K::M('xiaoqu/wuye')->update($this->wuye_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/manage/index.html';
        }
    }

    /**
     * 修改密码
     */
    public function update_passwd(){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/wuye')->detail($this->wuye_id)){
            $this->msgbox->add('错误',211);
        }else if($data = $this->checksubmit('data')){
            if(!$data['passwd']){
                $this->msgbox->add('旧密码不能为空', 211);
            }else if(!$data['new_passwd']){
                $this->msgbox->add('新密码不能为空', 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add('确认密码不能为空', 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add('两次新密码输入不一致', 214);
            }else if(md5($data['passwd']) != $this->wuye['passwd']){
                $this->msgbox->add('旧密码不正确', 215);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add('新密码不能和旧密码一致', 216);
            }else if(K::M('xiaoqu/wuye')->update($this->wuye_id,array('passwd'=>md5($data['new_passwd'])))){
                $this->msgbox->add('修改密码成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/manage/passwd.html';
        }
            
    }
    
    /**
     * 修改手机号
     */
    public function update_mobile()
    {
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/wuye')->detail($this->wuye_id)){
            $this->msgbox->add('错误',211);
        }else if($data = $this->checksubmit('data')){
            $session =K::M('system/session')->start();
            if(!$passwd = $data['passwd']){
                $this->msgbox->add('密码不能为空', 211);
            }else if(md5($passwd) != $this->wuye['passwd']){
                $this->msgbox->add('登录密码不正确', 212);
            }else if(!$mobile = $data['mobile']){
                $this->msgbox->add('手机号不能为空', 213);
            }else if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add('手机号格式不正确', 214);
            }else if($mobile == $this->wuye['mobile']){
                $this->msgbox->add('新手机号与旧手机号相同', 215);
            }else if(!$sms_code = $data['code']){
                $this->msgbox->add('验证码不能为空', 216);
            }else if($sms_code != $session->get('code_'.$mobile)){
                $this->msgbox->add('验证码不正确', 217);
            }else if(K::M('xiaoqu/wuye')->update($this->wuye_id,array('mobile'=>$mobile))){
                $session->delete('code_'.$mobile);
                $this->msgbox->add('修改手机成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/manage/mobile.html';
        }
    }
    
    
}
