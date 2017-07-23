<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->msgbox->template('view:page/notice.html');
        $this->system->auth = K::M('xiaoqu/wuye/auth');
        $this->auth = $this->system->auth;
        if($this->auth->token()){
            $this->wuye_id = $this->auth->wuye_id;
            $this->pagedata['wuye_id'] = $this->wuye_id;
            $this->wuye = $this->auth->wuye;
            $this->pagedata['wuye'] = $this->wuye;
            $this->xiaoqu_id = $this->wuye['xiaoqu']['xiaoqu_id'];
            $this->pagedata['xiaoqu_id'] = $this->xiaoqu_id;
        }else{
            header("Location:".$this->mklink('wuye/account/login'));
            exit();
        }
        $this->ctlmaps  = include(dirname(__FILE__).'/ctlmaps.php');     
        $ctlmap = $this->_check_priv();
        $this->request['ctlmap'] = $ctlmap;
        $this->pagedata['ctlgroup'] = $this->ctlgroup;
        $this->pagedata['menu_list'] = $this->ctlmaps[$this->ctlgroup];
    }
    
    
    /**
     * 检测该物业是否已有小区与其绑定
     */
  
    public function check_wuye_bind_xiaoqu(){
        if(!$check = K::M('xiaoqu/xiaoqu')->find(array('wuye_id'=>$this->wuye_id))){
            //如果没有检测到则跳入绑定页面，强制其绑定一个小区。
            header("Location:".$this->mklink('wuye/index/bind'));
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
            $this->tmpl = 'wuye/nopriv.html';
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
