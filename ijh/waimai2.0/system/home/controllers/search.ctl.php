<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Search extends Ctl
{
    public function index()
    {
        $cfg = $this->system->config->get('hotsearch');
        $cfg = str_replace('，', ',', $cfg['hotsearch']);
        $this->pagedata['hotsearch'] = explode(',', $cfg);
        $this->tmpl = 'search.html';
    }

    public function searchrlt()
    {
        //查询商家分类
        $cate_list = K::M('shop/cate')->fetch_all();
        $pager = array();
        //分类
        if($cate_id = (int)$this->GP('cate_id')){
            if($cate = $cate_list[$cate_id]){
                $pager['cate'] = $cate;
                $pager['cate_id'] = $cate_id;
            }
        }
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cate_tree'] = K::M('shop/cate')->tree();
        $this->pagedata['total_count'] = K::M('shop/shop')->count(array('closed'=>0,'audit'=>'1','verify_name'=>1));
        if($this->GP('title')) {
            $this->pagedata['search_title'] = $this->GP('title');
        }
        //echo '<pre>';print_r($this->GP('title'));die;
        $this->tmpl = 'searchrlt.html';
    }
}
