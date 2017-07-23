<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_About extends Ctl
{
    //商家
    public function index()
    {
        $this->tmpl = 'about/index.html';
    }
    //跑腿
    public function paotui()
    {
        $this->tmpl = 'about/paotui.html';
    }
    //注册协议
    public function protocol($app = null)
    {
        $this->pagedata['is_app'] = $app;
        $this->tmpl = 'about/protocol.html';
    }
    //关于我们
    public function about($app = null)
    {
        $this->pagedata['is_app'] = $app;
        $this->tmpl = 'about/about.html';
    }
}
