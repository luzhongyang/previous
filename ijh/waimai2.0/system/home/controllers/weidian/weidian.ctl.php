<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian extends Ctl
{
    public function __construct(&$system)
    {
        $session =K::M('system/session')->start();
        parent::__construct($system);
        if($token = $this->GP('token')){  //检测是否是APP访问的
            K::M('system/cookie')->set('TOKEN',$token);
        }else{
            $this->check_login();
        }

        if(!$shop_id = $_SESSION['WEIDIAN_SHOP_ID']) {
            $this->msgbox->add('非法操作',210)->response();
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)) {
            $this->msgbox->add('商家不存在',211)->response()->response();
        }else if($shop['audit']!=1 || $shop['closed']!=0) {
            $this->msgbox->add('商家不存在或已被删除',212)->response();
        }else if($shop['weidian'] != 1) {
            $this->msgbox->add('该商家暂未开通微店功能',213)->response();
        }
        $this->shop = $shop;

        $weidian_theme = $this->default_weidian_theme();
        $this->pagedata['shop'] = $shop;
        $this->pagedata['theme_style'] = $weidian_theme;
        $this->pagedata['weidian_theme'] = "/themes/default/weidian/".$weidian_theme."/";
    }

    public function check_login()
    {
        if(!$this->uid){
            if($this->request['XREQ'] || $this->request['MINI']){
                $this->msgbox->add(L('NOLOGIN'), 101);
            }else{
                $this->tmpl = 'passport/login.html';
            }
            $this->msgbox->response();
            exit();
        }
        return true;
    }
    
    public function error($error)
    {
        if(is_numeric($error)){
            $this->system->response_code($error);
        }
        $this->tmpl = "web/{$error}.html";
        $this->output();
    }
}