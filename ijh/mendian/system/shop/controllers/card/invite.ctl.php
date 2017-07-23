<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Invite extends Ctl
{
    public function index($mobile=null)
    {
        if($mobile = K::M('verify/check')->mobile($mobile)){
            $this->pagedata['mobile'] = $mobile;
        }
        $this->pagedata['shop'] = $this->shop;
        $this->tmpl = 'shop/card/invite/index.html';
    }

    public function success()
    {
        $this->pagedata['shop'] = $this->shop;
        $this->system->config->get('app_download');
        $this->tmpl = 'shop/card/invite/success.html';
    }

    // 申请收银员
    public function invite()
    {
        $session = K::M('system/session')->start();
        if(!$mobile = $this->GP('mobile')){
            $this->msgbox->add('手机号没有填写', 211);
        }else if(!K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add('手机号有误', 212);
        }else if(!$code = $this->GP('code')){
            $this->msgbox->add('手机验证码错误', 213);
        }else if($code != $session->get('code_' . $mobile)){
            $this->msgbox->add('手机验证码错误或已过期', 214);
        }elseif(!$passwd = $this->GP('passwd')){
            $this->msgbox->add('密码不能为空', 215);
        }elseif($staff = K::M('cashier/staff')->find(array('mobile'=>$mobile))){
            $this->msgbox->add('该手机号已经存在', 218);
        }else{
            $data = array('mobile'=>$mobile,'passwd'=>md5($passwd),'name'=>$mobile,'shop_id'=>SHOP_ID,'dateline'=>__TIME);
            if($staff_id = K::M('cashier/staff')->create($data)){
                $this->msgbox->add('恭喜您加入店铺成功');
                $this->msgbox->set_data('shop_id',$shop_id);
            }
        }
    }

}
