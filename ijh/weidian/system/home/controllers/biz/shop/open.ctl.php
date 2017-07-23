<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop_Open extends Ctl_Biz
{
    
    public function index()
    {
        $shop = K::M('shop/shop')->detail($this->shop_id);
        $this->pagedata['shop'] = $shop;
        $this->tmpl = 'biz/shop/open/index.html';
    }

    public function save(){
        if($have_tuan = (int)$this->GP('have_tuan')) {
            $data['have_tuan'] = 1;
        }else {
            $data['have_tuan'] = 0;
        }
        if($have_quan = (int)$this->GP('have_quan')) {
            $data['have_quan'] = 1;
        }else {
            $data['have_quan'] = 0;
        }
        if($have_maidan = (int)$this->GP('have_maidan')) {
            $data['have_maidan'] = 1;
        }else {
            $data['have_maidan'] = 0;
        }
        if($have_paidui = (int)$this->GP('have_paidui')) {
            $data['have_paidui'] = 1;
        }else {
            $data['have_paidui'] = 0;
        }
        if($have_dingzuo = (int)$this->GP('have_dingzuo')) {
            $data['have_dingzuo'] = 1;
        }else {
            $data['have_dingzuo'] = 0;
        }
        if($have_diancan = (int)$this->GP('have_diancan')) {
            $data['have_diancan'] = 1;
        }else {
            $data['have_diancan'] = 0;
        }

        if(K::M('shop/shop')->update($this->shop_id,$data)){
            $this->msgbox->add('配置成功!');
        }else{
            $this->msgbox->add('配置失败!',301);
        }

    }   
}