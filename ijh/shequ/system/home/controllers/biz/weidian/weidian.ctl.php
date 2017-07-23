<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('biz/biz');

class Ctl_Biz_Weidian extends Ctl_Biz
{
    
    public function __construct($system)
    {
        parent::__construct($system);
        $this->check_weidian();
    }
     
}