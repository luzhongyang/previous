<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Index extends Ctl_Ucenter
{
    
    /**
     * 分销户中心首页
     */
    public function index($shop_id)
    {

        $this->tmpl = 'fenxiao/ucenter/index.html';
        
    }
    
    
    


}
