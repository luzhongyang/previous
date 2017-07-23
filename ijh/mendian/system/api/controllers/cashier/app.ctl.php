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

class Ctl_Cashier_App extends Ctl
{
    
    public function test($params)
    {
    	$this->msgbox->add('API SUCCESS');    
    }

    public function info($params)
    {
    	//处理版本，升级提示等信息
    }
}