<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Cashier extends Ctl
{
    public function __construct(&$system)
    {

        parent::__construct($system);
        
        $this->system->auth = K::M('shop/auth');
        $this->auth = $this->system->auth;
        if($this->auth->token()){
            $this->shop_id = $this->auth->shop_id;
            $this->shop = $this->auth->shop;

            if(empty($this->shop['audit']) && ($this->request['ctl'] != 'biz' || $this->request['act'] != 'index')) {
                $this->msgbox->add('店铺正在审核中,请耐心等待', 311);
                $this->msgbox->set_data('forward', $this->mklink('biz/shop:index'));
                $this->msgbox->response();
            }
        }else{
            header("Location:".$this->mklink('cashier/account:login'));
            exit();
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
            $this->tmpl = 'biz/page/nopriv.html';
        }
        $this->msgbox->response();
        exit();
    }

    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['shop'] = $this->shop;
    }

    public function index()
    {

        $this->tmpl = 'biz/cashier/index.html';


    }


}
