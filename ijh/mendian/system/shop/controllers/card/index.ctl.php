<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Card_Index extends Ctl_Card
{

    public function index()
    {
        $this->pagedata['shop'] = K::M('shop/shop')->detail(SHOP_ID);
        $this->tmpl = 'shop/card/index.html';
    }
    
    public function cookie()
    {
        $a = $_COOKIE;        
        $this->cookie->clear();
        echo "<pre>";
        print_r($a);
        echo 'clear cookie success';
        echo "</pre>";
        exit();		
    }

}
