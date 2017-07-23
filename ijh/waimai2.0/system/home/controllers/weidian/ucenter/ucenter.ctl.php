<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian/weidian');

class Ctl_Weidian_Ucenter extends Ctl_Web
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->pagedata['act'] = $this->request['act'];
        
        $ctl = explode('/',$this->request['ctl']);
        $this->pagedata['ctl'] = $ctl[2];
        
        //print_r($this->request['ctl']);die;
        $this->check_login();
    }

}