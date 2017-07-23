<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan extends Ctl
{
    

    public function index()
    {

       $this->tmpl = 'merchant:tuan/index.html';

    }

}