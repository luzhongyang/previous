<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        if($token = $this->GP('token')){  //检测是否是APP访问的
            K::M('system/cookie')->set('TOKEN',$token);
        }else{
            $this->check_login();
        }
    }
}