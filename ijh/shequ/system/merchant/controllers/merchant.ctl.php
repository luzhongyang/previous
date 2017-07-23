<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Merchant extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->msgbox->template('view:page/notice.html');
        $this->system->auth = K::M('shop/auth');
        $this->auth = $this->system->auth;
        if($this->auth->token()){
            $this->shop_id = $this->auth->shop_id;
            $this->shop = $this->auth->shop;
            if(empty($this->shop['audit']) && ($this->request['ctl'] != 'biz/shop' || $this->request['act'] != 'index')) {
                $this->msgbox->add('店铺正在审核中,请耐心等待', 311);
                $this->msgbox->set_data('forward', $this->mklink('merchant/shop:index'));
                $this->msgbox->response();
            }
        }else{
//            header("Location:".$this->mklink('merchant/account/login'));
//            exit();
        }
        $this->ctlmaps  = include(dirname(__FILE__) . '/ctlmaps.bk.php');
        $ctlmap = $this->_check_priv();
        $this->request['ctlmap'] = $ctlmap;
        $this->pagedata['ctlgroup'] = $this->ctlgroup;
        $this->pagedata['menu_list'] = $this->ctlmaps[$this->ctlgroup];
    }

    /*检测外卖功能是否开通*/
    public function check_waiwami()
    {
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        if($this->shop['have_waimai'] != 1){
            header("Location:".$this->mklink('merchant/waimai/shop:have'));
        }
    }

    /*检测团购是否开通*/
    public function check_tuan()
    {
        if($this->shop['have_tuan'] != 1) {
            header("Location:".$this->mklink('merchant/shop/open:index'));
        }
    }



    /*检测代金券是否开通*/
    public function check_quan()
    {
        if($this->shop['have_quan'] != 1) {
            header("Location:".$this->mklink('merchant/shop/open:index'));
        }
    }

    /*检测优惠买单是否开通*/
    public function check_maidan()
    {
        if($this->shop['have_maidan']!= 1) {
            header("Location:".$this->mklink('merchant/shop/open:index'));
        }
    }

    protected function _check_priv()
    {
        $ctlmap  = array();
        $request = $this->request;
        foreach($this->ctlmaps as $group=>$menu){
            foreach($menu as $k=>$v){
                foreach ($v['items'] as $kk=>$vv) {
                    if($vv['ctl'] == $request['ctl'].':'.$request['act']){
                        $this->ctlgroup = $group;
                        $this->ctlmenu = $menu;
                        $ctlmap = $vv;
                    }
                }
            }
        }
        if($ctlmap){
            return $ctlmap;
        }elseif($this->request['XREQ'] || $this->request['MINI'] ){
            $this->msgbox->add('很抱歉，您没有权限访问', 201);
        }else{
            $this->tmpl = 'ucenter/nopriv.html';
        }
        $this->msgbox->response();
        exit();
    }

    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['shop'] = $this->shop;
    }

}
