<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Page extends Ctl
{
    public $_call = 'index';

    public function index($page)
    {
        if(!$detail = K::M('article/article')->detail_by_page($page)){
            $this->error(404);
        }else if($detail['linkurl']){
            
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'page/page.html';
        }
    }
}
