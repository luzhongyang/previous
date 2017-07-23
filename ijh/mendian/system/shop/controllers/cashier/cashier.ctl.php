<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier extends Ctl
{
    public function __construct($system)
    {
        //print_r($_COOKIE);exit;
        parent::__construct($system);
        $this->system->auth = K::M('cashier/auth');
        if(!$this->auth->token()){
            $this->msgbox->add('没有权限操作', 211)->response();
        }
        $this->staff_id = $this->auth->staff_id;
        $this->staff = $this->auth->staff;
        if($this->staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('没有权限操作', 211)->response();
        }
    }

}