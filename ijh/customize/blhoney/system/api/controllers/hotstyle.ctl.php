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
	// 热门发型首页
    public function items($params)
    {   
        $cat_items = K::M('article/cate')->items(array('parent_id'=>3),null,1,500,$count);
        $cate_tree = $sort = array();
        foreach($cat_items as $k=>$v) {
            $catids[] = $v['cat_id'];
            $cate_tree[$k]['cate_id'] = $v['cat_id'];
            $cate_tree[$k]['title'] = $v['title'];
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['hidden'] = 0;
        $page = max((int)$params['page'], 1);
        $cate_id = (int)$params['cate_id'];
        $sort = $params['sort'];
        if($cate_id > 0) {
            $filter['cat_id'] = $cate_id;
        }else {
            $cat_items = K::M('article/cate')->items(array('parent_id'=>3),null,1,500,$count);
            foreach($cat_items as $k=>$v) {
                $catids[] = $v['cat_id'];
            }
            $filter['cat_id'] = $catids;
        }
        if($sort == 'dateline') {
            $orderby = array('dateline'=>'desc');
        }else if($sort == 'ontime') {
            $orderby = array('ontime'=>'desc');
        }else if($sort == 'views') {
            $orderby = array('views'=>'desc');
        }else {
            $orderby = array('dateline'=>'desc');
        }
        if(($page<=10) && $style_items = K::M('article/article')->items($filter, $orderby,1,1000, $count)) {
        	$items = $banner_items = array();
        	foreach($style_items as $k=>$v) {
        		$items[] = $this->filter_fields('title,thumb,views,link',$v);
        	}
			K::M("system/logs")->log('style_items',$style_items);
        	$items = array_slice($items, ($page-1)*10, 10, true);
            foreach($style_items as $k=>$v) {
                if($v['is_banner'] == 1) {
                    $banner_items[] = $this->filter_fields('thumb,link',$v);
                }
            }    
        }
        $sort = array(
        	array('sort_id'=>'dateline','sort_title'=>'默认排序'),
        	array('sort_id'=>'ontime','sort_title'=>'发布时间'),
        	array('sort_id'=>'views','sort_title'=>'浏览数'),
        	);
        $this->msgbox->add('success');
	
        $data = array(
        	'items'=>$items,
        	'banner'=>$banner_items,
        	'cate'=>array_values($cate_tree),
        	'sort'=>$sort,
        	);
        $this->msgbox->set_data('data',$data);
    }

    // 根据名称搜索热门发型文章
    public function search($params)
    {
        if(!$title = $params['title']) {
        	$this->msgbox->add('请输入名称');
        }else {
        	$filter['closed'] = 0;
	        $filter['audit'] = 1;
	        $filter['hidden'] = 0;
	        $filter['title'] = "LIKE:%".$title."%";
	        if($style_items = K::M('article/article')->items($filter, $orderby,1,1000, $count)) {
	        	$items  = array();
	            foreach($style_items as $k=>$v) {
	                $items[] = $this->filter_fields('title,thumb,views,link',$v);
	            }
	        }
	        $this->msgbox->add('success');
	        $this->msgbox->set_data('data', array('items'=>array_values($items))); 
        }
        
    }

}