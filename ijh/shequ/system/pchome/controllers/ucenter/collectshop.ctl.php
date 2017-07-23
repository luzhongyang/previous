<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Collectshop extends Ctl_Ucenter
{

    public function index($page)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['type'] = 1;
        $filter['status'] = 1;

        $items = K::M("member/collect")->items($filter, $orderby, $page, $limit, $count);
        $shop_ids = array();
        foreach($items as $k => $v){
            $shop_ids[$v['can_id']] = $v['can_id'];
        }
        if($shop_ids){
            $this->pagedata['shops'] =  K::M('shop/shop')->items_by_ids($shop_ids);
        }
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = "pchome/ucenter/collect/shop.html";
    }
    
    
    // 收藏
    public function collect($status, $type, $can_id)
    {
        $data = array();
        $type = (int) $type;
        $status = (int) $status;
        $can_id = (int) $can_id;
        $detail = K::M('member/collect')->find(array('uid' => $this->uid, 'can_id' => $can_id, 'type' => $type));
        if($detail){
            if(K::M('member/collect')->update($detail['collect_id'], array('status' => $status, 'dateline' => __TIME))){
                if($status == 0){
                    $this->msgbox->add('取消收藏成功');
                }
                else{
                    $this->msgbox->add('收藏成功');
                }
            }
        }
        else{
            if($collect_id = K::M('member/collect')->create(array('uid' => $this->uid, 'type' => $type, 'can_id' => $can_id, 'status' => 1, 'dateline' => __TIME))){
                $this->msgbox->add('恭喜您，收藏成功');
            }
        }
    }
    

}
