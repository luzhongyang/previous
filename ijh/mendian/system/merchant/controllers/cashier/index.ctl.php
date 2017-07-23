<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*收银首页控制器*/
Import::C('cashier');
class Ctl_Cashier_Index extends Ctl_Cashier 
{
    
    public function index()
    {
    	$this->tmpl = 'merchant/cashier/index.html';
    }
}