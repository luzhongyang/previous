<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Index extends Ctl_Cloud 
{

    public function index() 
    {
        //$this->check_login();
        //时间段
       
        $this->pagedata['backurl'] = $this->mklink('cloud/ucenter/index');
        $this->tmpl = 'cloud/ucenter/index.html';
    }


}
