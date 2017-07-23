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
     * 微店用户中心首页
     */
    public function index($shop_id)
    {

        
        $this->tmpl = 'weidian/ucenter/index.html';

    }





}
