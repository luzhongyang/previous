<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Video extends Ctl
{
    public function index()
    {   
        $filter['cat_id'] = 4;
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        if($video_items = K::M('article/article')->items($filter, array('article_id'=>'desc'),1,1000, $count)) {
            foreach($video_items as $k=>$v) {
                if($v['is_banner'] == 1) {
                    $banner_items[$k] = $v;
                    unset($video_items[$k]);
                }
            }        
        }
        $this->pagedata['banners'] = $banner_items;
        $this->pagedata['items'] = $video_items;
        $this->tmpl = 'video/index.html';
    }
	
	public function detail($article_id)
    {   
        $article_id = (int)$article_id;
        if($detail = K::M('article/article')->detail($article_id)) {
            K::M('article/article')->update($article_id,array('views'=>$detail['views']+1));
            $this->pagedata['detail'] = $detail;
        }

        $filter['cat_id'] = 4;
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        $filter['article_id'] = '<>:'.$article_id;
        if($items = K::M('article/article')->items($filter,array('article_id'=>'desc'),1,4,$count)) {
            $this->pagedata['other'] = $items;
        }
        $this->tmpl = 'video/detail.html';
    }
}