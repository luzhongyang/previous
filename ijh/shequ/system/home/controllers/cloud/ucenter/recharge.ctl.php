<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Recharge extends Ctl_Cloud_Ucenter 
{

    public function index() 
    {
        $this->pagedata['items'] = K::M('member/member')->getRecharge(); 
        $this->tmpl = 'cloud/ucenter/recharge.html';
    }


}
