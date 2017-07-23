<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Welcome extends Ctl
{

    public function index()
    {
        $this->system->cookie->set("is_view", 1, 86400);
        $this->pagedata['site'] = K::M('system/config')->get('site');
        $this->tmpl = 'welcome/index.html';
    }

}