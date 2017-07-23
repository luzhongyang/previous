<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_News extends Ctl
{

    public function index()
    {
        $this->items(9);
    }

    public function items($cate_id)
    {
        if(!$cate = K::M('article/cate')->detail($cate_id)){
            $this->error(404);
        }
        $pager = array('cate'=>$cate);
        $this->pagedata['pager'] = $pager;
        $filter = array('audit'=>1, 'closed'=>0);
        if($cate_ids = K::M('article/cate')->children_ids($cate_id)){
            $filter['cate_id'] = explode(',', $cate_ids);
        }else{
            $filter['cate_id'] = $cate_id;
        }
        $this->pagedata['items'] = K::M('article/article')->items($filter, null, 1, 10);
        $this->tmpl = 'home/www/news/items.html';
    }

    public function detail($article_id)
    {
        if(!$article_id = (int)$article_id){
            $this->error(404);
        }elseif(!$detail = K::M('article/article')->detail($article_id)){
            $this->error(404);
        }
        $pager['cate'] = K::M('article/cate')->detail($detail['cate_id']);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'home/www/news/detail.html';
    }

}