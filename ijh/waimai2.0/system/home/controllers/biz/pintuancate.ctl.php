<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Pintuancate extends Ctl_Biz
{

    public function index($page)
    {

        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 500; //团购系统分类,不分页

       
        $condition = "1";
        if($items = K::M('pintuan/productcate')->items($condition, ' partent_id', $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            //获取上级分类
            $all_cate = K::M('pintuan/productcate')->options(1);
            foreach($items as $k => $v){
                $items[$k]['parent_id'] = $all_cate[$v['parent_id']] ? $all_cate[$v['parent_id']] : '一级分类';
            }
            
            //重组数据
            
        }


        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/pintuan/cate/index.html';
    }

}
