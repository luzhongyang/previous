<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier extends Ctl
{
    
    public function __construct($system)
    {
        parent::__construct($system);
        if($this->staff_id){
            if(!$shop = K::M('cashier/cashier')->detail($this->staff['shop_id'])){                
                $this->msgbox->add('店铺不存在或已经关闭', 112)->response();
            }
            $this->shop = $shop;
            $this->shop_id = $this->staff['shop_id']; 
        }else{
            $this->msgbox->add('您没有登录', 101)->response();
        }

    }

    protected function check_owner()
    {
        if(!$this->staff['is_owner']){
            $this->msgbox->add('您不是店主不能操作', 111)->json();
        }
    }
}