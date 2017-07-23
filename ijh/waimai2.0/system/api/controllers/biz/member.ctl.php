<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Member extends Ctl_Biz
{
    
    public function fans($params)
    {
        $this->check_login();
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $member_list = array();
        if($items = K::M('shop/collect')->items(array('shop_id'=>$this->shop_id), array('uid'=>'desc'), $page, $limit, $count)){
            $uids = array();
            foreach($items as $v){
                $uids[$v['uid']] = $v['uid'];
            }
            if($uids){
                $member_list = K::M('member/member')->items_by_ids($uids);
            }else {
                $member_list = array();
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($member_list), 'total_count'=>$count));
    }

    public function order($params)
    {
        $this->check_login();
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $member_list = array();
        if($items = K::M('order/order')->customs_by_shop(array('shop_id'=>$this->shop_id), $page, $limit, $count)){
            $uids = array();
            foreach($items as $v){
                $uids[$v['uid']] = $v['uid'];
            }
            if($uids){
                $member_list = K::M('member/member')->items_by_ids($uids);
            }
            foreach($items as $k=>$v){
                if($m = $member_list[$v['uid']]){
                    $v['nickname'] = $m['nickname'];
                    $v['mobile'] = $m['mobile'];
                    $v['face'] = $m['face'];
                }
                $items[$k] = $v;
                if(!$member_list[$v['uid']]){
                    unset($items[$k]);
                }
            }
        }else {
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$uid = (int)$params['uid']){
            $this->msgbox->add(L('用户不存在'), 211);
        }else if(!$member = K::M('member/member')->detail($uid)){
            $this->msgbox->add(L('用户不存在或已被删除'), 212);
        }else{
            $page = (int)max($params['page'],1);
            $custom = array('uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'mobile'=>$member['mobile']);
            $custom['total_amount'] = $custom['total_order'] = 0;
            $items = array();
            if($custom_list = K::M('order/order')->customs_by_shop(array('shop_id'=>$this->shop_id,'uid'=>$uid,'order_status'=>8), 1, 1)){
                if($custom = $custom_list[$uid]){
                    $member['total_order'] = $custom['total_order'];
                    $member['total_amount'] = $custom['total_amount'];
                }
                if(!$items = K::M('order/order')->items(array('shop_id'=>$this->shop_id,'uid'=>$uid,'order_status'=>8), null, 1, $limit,$count)){
                    $items = array();
                }else {
                    $items = array_slice($items, ($page-1)*10, 10, true);
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'custom'=>$custom));
        }
    }

}