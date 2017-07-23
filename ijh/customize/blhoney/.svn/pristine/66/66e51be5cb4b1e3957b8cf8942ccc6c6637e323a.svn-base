<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Hotstyle extends Ctl
{
    public function index()
    {   
        $cat_items = K::M('article/cate')->items(array('parent_id'=>3),null,1,500,$count);
        foreach($cat_items as $k=>$v) {
            $catids[] = $v['cat_id'];
            $cate_tree[$k]['cate_id'] = $v['cat_id'];
            $cate_tree[$k]['title'] = $v['title'];
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        $filter['cat_id'] = $catids;
        if($style_items = K::M('article/article')->items($filter, array('article_id'=>'desc'),1,1000, $count)) {
            foreach($style_items as $k=>$v) {
                if($v['is_banner'] == 1) {
                    $banner_items[$k] = $v;
                }
            }     
        }
        $this->pagedata['cate_tree'] = $cate_tree;
        $this->pagedata['banners'] = $banner_items;
        $this->tmpl = 'hotstyle/index.html';
    }

    public function loaditems()
    {
        $filter = array();
        $page = max((int)$this->GP('page'), 1);
        $cate_id = $this->GP('cate_id');
        $sort = $this->GP('sort');
        if($cate_id > 0) {
            $filter['cat_id'] = $cate_id;
        }else {
            $cat_items = K::M('article/cate')->items(array('parent_id'=>3),null,1,500,$count);
            foreach($cat_items as $k=>$v) {
                $catids[] = $v['cat_id'];
            }
            $filter['cat_id'] = $catids;
        }
        if($sort == 'article_id') {
            $orderby = array('article_id'=>'desc');
        }else if($sort == 'ontime') {
            $orderby = array('ontime'=>'desc');
        }else if($sort == 'views') {
            $orderby = array('views'=>'desc');
        }else {
            $orderby = array('dateline'=>'desc');
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        
        if(($page<=10) && $style_items = K::M('article/article')->items($filter, $orderby,1,1000, $count)) {
            foreach($style_items as $k=>$v) {
                $v['url'] = $this->mklink('hotstyle:detail', array('arg0'=>$v['article_id']));
                $style_items[$k] = $v;
            }
            //uasort($style_items, array($this, 'sales_order'));
            $items = array_slice($style_items, ($page-1)*10, 10, true);
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items))); 
    }
	
	public function detail($article_id)
    {   
        $article_id = (int)$article_id;
        if($detail = K::M('article/article')->detail($article_id)) {
            K::M('article/article')->update($article_id,array('views'=>$detail['views']+1));
            $this->pagedata['detail'] = $detail;
        }

        $cat_items = K::M('article/cate')->items(array('parent_id'=>3),null,1,500,$count);
        foreach($cat_items as $k=>$v) {
            $catids[] = $v['cat_id'];
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        $filter['cat_id'] = $catids;
        $filter['article_id'] = '<>:'.$article_id;
        if($items = K::M('article/article')->items($filter,array('article_id'=>'desc'),1,4,$count)) {
            $this->pagedata['other'] = $items;
        }
        $this->tmpl = 'hotstyle/detail.html';
    }
}