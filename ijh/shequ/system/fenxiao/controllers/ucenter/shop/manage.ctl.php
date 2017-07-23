<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Manage extends Ctl
{

    /**
     * 店铺管理
     */
    public function index(){
        if($fenxiao = K::M('fenxiao/fenxiao')->find(array('uid'=>$this->uid))){
            
            $fx_shops = K::M('fenxiao/fenxiao')->items(array('uid'=>$this->uid));
            $shop_ids = array();
            foreach($fx_shops as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
            }
            $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            $this->pagedata['fx_shops'] = $fx_shops;
            $this->tmpl = 'fenxiao/ucenter/shop/manage/index.html';
        }else{
            $this->msgbox->add('您的申请已被拒绝,请重新申请!',211)->response();
            header("Location:".$this->mklink('ucenter/shop/index:tuike',null,null,'base'));
        }
    }

}
