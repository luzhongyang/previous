<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weidian_Yongjin extends Ctl
{
    public function index($page)
    {
        
        $filter = $pager = array();
        //删选金额大于0 的
        $filter['money_master_paid'] = ">:0";
        
        
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            
            if($SO['group_id']){
                $filter['group_id'] = $SO['group_id'];
            }
            
            if($SO['master_id']){
                $filter['master_id'] = $SO['master_id'];
            }
            if($SO['order_id']){
                $filter['order_id'] = $SO['order_id'];
            }
            
        }
        $SO = $filter;
        if($items = K::M('weidian/pintuan/order')->items($filter, array('group_id' => 'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));

            $arr_product_id = array();
            $arr_master_id = array();
            foreach($items as $k => $v){
                $arr_product_id[] = $v['product_id'];
                $arr_master_id[] = $v['master_id'];
            }
            $arr_product_id = array_unique($arr_product_id);
            $arr_product_title = K::M('weidian/pintuan/product')->select(" product_id in (" . implode(',', $arr_product_id) . ")");
            $arr_master_id = array_unique($arr_master_id);
            $arr_master_nickname = K::M('member/member')->select(" uid in (" . implode(',', $arr_master_id) . ")");
            $view_params = K::M('weidian/pintuan/group')->view_params;
            foreach($items as $k => $v){
                $v['start_time'] = date('Y-m-d H:i', $v['start_time']);
                $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
                $v['status_cn'] = $view_params['status']['select'][$v['status']];
                $v['pintuan_product_id_cn'] = $arr_product_title[$v['pintuan_product_id']]['title'];
                $v['master_id_cn'] = $arr_master_nickname[$v['master_id']]['nickname'];
                $items[$k] = $v;
            }
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = $this->status;
       
        $this->tmpl = 'admin:weidian/yongjin/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:weidian/yongjin/so.html';
    }
}
