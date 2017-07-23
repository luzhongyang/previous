<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tuan extends Ctl_Biz
{
    

    public function index()
    {

       $this->tmpl = 'biz/tuan/index.html';

    }

}