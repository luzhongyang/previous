<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Info extends Ctl_Card
{
    public function index()
    {
        $this->tmpl = 'shop/card/info/index.html';
    }

}
