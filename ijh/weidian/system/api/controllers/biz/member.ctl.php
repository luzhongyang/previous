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
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $items = array();
        if($collect_list = K::M('member/collect')->items(array('can_id'=>$this->shop_id, 'type'=>1), null, $page, $limit, $count)){
            $uids = array();
            foreach($collect_list as $v){
                $uids[$v['uid']] = $v['uid'];
            }
            if($member_list = K::M('member/member')->items_by_ids($uids)){
                foreach($member_list as $k => $v) {
                    $items[$k] = $this->filter_fields('uid,mobile,nickname,face',$v);
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function order($params)
    {
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
            }
        }else {
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        if(!$uid = (int)$params['uid']){
            $this->msgbox->add(L('用户不存在'), 211);
        }else if(!$member = K::M('member/member')->detail($uid)){
            $this->msgbox->add(L('用户不存在或已被删除'), 212);
        }else{
            $custom = array('face'=>$member['face'],'uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'mobile'=>$member['mobile']);            
            $custom['total_amount'] = $custom['total_order'] = 0;
            $items = array();
            if($custom_list = K::M('order/order')->customs_by_shop(array('shop_id'=>$this->shop_id, 'uid'=>$uid, 'order_status'=>8, 'online_pay'=>1), 1, 1)){
                if($row = $custom_list[$uid]){
                    $custom['total_order'] = $row['total_order'];
                    $custom['total_amount'] = $row['total_amount'];
                }
                if($items = K::M('order/order')->items(array('shop_id'=>$this->shop_id, 'uid'=>$uid, 'order_status'=>8), array('order_id'=>'DESC'), 1, 10,$count)){
                    foreach($items as $k => $v){
                        $items[$k] = $this->filter_fields('order_id,dateline,amount', $v);
                    }
                }else{
                    $items = array();
                }
            }
            
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'custom'=>$custom));
        }
    }

    

}