<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz extends Ctl
{
    
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->check_login();
    }

}