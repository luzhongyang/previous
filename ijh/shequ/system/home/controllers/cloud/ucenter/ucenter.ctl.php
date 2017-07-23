<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('cloud/cloud');

class Ctl_Cloud_Ucenter extends Ctl_Cloud
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->check_login();
    }

}