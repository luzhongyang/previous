<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Collectstaff extends Ctl_Ucenter
{

    public function index($page)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['type'] = 2;
        $filter['status'] = 1;

        $items = K::M("member/collect")->items($filter, $orderby, $page, $limit, $count);
        $staff_ids = array();
        foreach($items as $k => $v){
            $staff_ids[$v['can_id']] = $v['can_id'];
        }
        if($staff_ids){
            $staffs =  K::M('staff/staff')->items_by_ids($staff_ids);
        }
        $house_attr = K::M('house/attr')->items(array('staff_id'=>$staff_ids));
        $weixiu_attr = K::M('weixiu/attr')->items(array('staff_id'=>$staff_ids));
        foreach($staffs as $k=>$v){
            foreach($house_attr as $k1=>$v1){
                if($v['staff_id'] == $v1['staff_id']){
                    $staffs[$k]['skill'][] = $v1['cate_title'];
                }
            }
            foreach($weixiu_attr as $k2=>$v2){
                if($v['staff_id'] == $v2['staff_id']){
                    $staffs[$k]['skill'][] = $v2['cate_title'];
                }
            }
        }
        $this->pagedata['staffs'] = $staffs;
        //print_r($staffs);die;
        
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = "pchome/ucenter/collect/staff.html";
    }

}
