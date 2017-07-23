<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Help extends Ctl
{

    public function index()
    {
        $this->items(2);
    }

    public function items($cate_id)
    {
        if(!$cate = K::M('article/cate')->detail($cate_id)){
            $this->error(404);
        }
        $pager = array('cate'=>$cate);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = K::M('article/article')->items(array('cate_id'=>$cate_id, 'audit'=>1, 'closed'=>0), null, 1, 10);
        $this->tmpl = 'home/www/help/items.html';
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
        $this->tmpl = 'home/www/help/detail.html';
    }

}