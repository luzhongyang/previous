<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
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
            header("Location:".$detail['linkurl']);
            exit;
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'shop/card/page/page.html';
        }
    }
}