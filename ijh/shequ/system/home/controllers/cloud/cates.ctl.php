<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Cates extends Ctl_Cloud
{
    
    public function index()
    {
        $cates = K::M('cloud/cate')->fetch_all();
        $this->pagedata['cates'] = $cates;
        $this->tmpl = 'cloud/cates.html';
    }

}
