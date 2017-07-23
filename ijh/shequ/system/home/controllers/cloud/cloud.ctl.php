<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->pagedata['act'] = $this->request['act'];
        
        $ctl = explode('/',$this->request['ctl']);
        $this->pagedata['ctl'] = $ctl[1];
        $this->msgbox->template("cloud/page/notice.html");
        if($token = $this->GP('token')){
            K::M('system/cookie')->set('TOKEN',$token);
        }
    }

}
