<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card extends Ctl
{

    public function __construct(&$system)
    {
        parent::__construct($system);
    }
    

    //初始化当前应用程序控制器
    protected function InitializeApp()
    {
        if(defined('IN_WEIXIN') && IN_WEIXIN){
            if($this->wx_openid = $this->get_wx_openid()){
                if(defined('WX_UNIONID')){
                    $wxuser = K::M('weixin/user')->detail_by_unionid(WX_UNIONID);
                }else if(defined('WX_OPENID')){
                    $wxuser = K::M('weixin/user')->detail_by_openid(WX_OPENID);
                }
                if(empty($wxuser)){
                    $wxuser = $this->init_wxuser_by_openid($this->wx_openid);
                }
                $this->wxuserinfo = $wxuser;
            }else{
                $this->msgbox->add('微信授权失败', 121)->response();
            }
        }else{
            $this->msgbox->add('请在微信中打开', 121)->response();
        }
        if(!preg_match("/shop(\d+)/i", $this->request['host'], $m)){
            $this->error(404);
        }
        define('SHOP_ID', $m[1]); //店铺ID常量,继承父类方法，直接取收银商户信息
        if(!$shop = K::M('cashier/cashier')->detail(SHOP_ID, false)){
            $this->error(404);
        }else if($shop['closed']){
            $this->msgbox->add('店铺已关闭', 123);
        }
        $this->shop = $shop;
        $this->shop_id = SHOP_ID;
        if(!$this->card = K::M('card/card')->find(array('wx_openid'=>$this->wx_openid, 'shop_id'=>SHOP_ID))){
            //如果不是bind页面则跳转，否则无限重定向
            if($this->request['ctl'] != 'card/bind'){
                header("Location:" . $this->mklink('card/bind/index', null, null, 'base'));
                exit;
            }
        }
    }

    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['CARD'] = $this->card;
        $this->pagedata['SHOP_ID'] = SHOP_ID;
    }

}
