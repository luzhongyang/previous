<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

Import::C('merchant');

class Ctl_Weixin extends Ctl
{
    
    public $token = null;
    public $weixin = array();
    public $type = array();

    public function __construct(&$system)
    {
        parent::__construct($system); 
        //print_r($this->request['ctl']);die;
        if(!$res = K::M('weixin/weixin')->get_access_token($this->shop_id)){  //获取access_token
            if(!in_array($this->request['act'], array('wxcallback', 'bind', 'wxloginpage'))){
                $url = $this->mklink('merchant/weixin/index:bind');
                header("Location:{$url}");exit;
            }
        }else{
            $this->token = $res;
        }
        $this->weixin = K::M('weixin/weixin')->detail($this->shop_id);
        $this->pagedata['weixin'] = $this->weixin;
    }
    
    
}
