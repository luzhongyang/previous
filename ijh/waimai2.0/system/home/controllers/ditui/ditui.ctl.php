<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);        
        $this->system->auth = K::M('ditui/auth');
        $this->auth = $this->system->auth;
        if($this->auth->token()){
            $this->ditui_id = $this->auth->ditui_id;
            $this->ditui = $this->auth->ditui;
        }else{
            header("Location:".$this->mklink('ditui/account/login'));
        }

        $this->msgbox->template('view:page/notice.html');
        $this->ctlmaps  = include(dirname(__FILE__).'/ctlmaps.php');     
        $ctlmap = $this->_check_priv();
        $this->request['ctlmap'] = $ctlmap;
        $this->pagedata['ctlgroup'] = $this->ctlgroup;
        $this->pagedata['menu_list'] = $this->ctlmaps[$this->ctlgroup];
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
            $this->msgbox->add(L('很抱歉，您没有权限访问'), 201);
        }else{
            $this->tmpl = 'ucenter/nopriv.html';
        }
        $this->msgbox->response();
        exit();
    }

    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['ditui'] = $this->ditui;
    }

}
