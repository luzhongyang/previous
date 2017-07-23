<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('ucenter/ucenter');
class Ctl_Ucenter_Shop extends Ctl_Ucenter
{
    
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->check_shop();
    }
    
    public function check_shop()
    {
        if($this->FENXIAO['uid'] != $this->uid){
            $this->msgbox->add('非法操作分销店铺!',211)->response();
        }else if($this->FENXIAO['status'] == 0){ 
            $this->msgbox->add('该店铺正在审核中!',211);
        }
    }

}