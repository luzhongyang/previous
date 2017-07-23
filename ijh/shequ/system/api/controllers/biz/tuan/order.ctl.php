<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tuan_Order extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array();
        $orderby = array('order_id'=>'DESC');
        $filter['closed'] = 0;
        
        $filter['from'] = 'tuan';
        $filter['shop_id'] = $this->shop_id;      
        if(!in_array($params['status'],array(0,1))){
            $params['status'] = 0;
        }
        if($params['status'] == 0){
            $filter['order_status'] = 5;
        }else{
            $filter['order_status'] = array(-1,-2,8);
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $items = array();
        }
        $ids = array();
        foreach($items as $k => $v){
            $ids[$v['order_id']] = $v['order_id'];
            $items[$k] = $this->filter_fields('order_id,order_status,total_price,from_name,shop_title,shop_logo,order_status_label,order_status_warning,comment_status', $v);
        }
        $tuans = K::M('tuan/order')->items_by_ids($ids);
        $comments = K::M('shop/comment')->select(array('order_id'=>$ids));
        $new_comments = array();
        foreach($comments as $ck => $cv){
            $new_comments[$cv['order_id']] = $cv;
        }

        foreach($items as $kk => $vv){
            $items[$kk]['tuan'] = $tuans[$kk];
            if($new_comments[$kk]){
                $items[$kk]['comment_status'] = 1;
                if($new_comments[$kk]['reply']){
                    $items[$kk]['comment_reply'] = 1;
                }else{
                    $items[$kk]['comment_reply'] = 0;
                }
            }else{
                $items[$kk]['comment_status'] = 0;
                $items[$kk]['comment_reply'] = 0;
            }
        }
        
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }
    
    
    public function detail($params)
    {
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单号错误',211);
        }elseif(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单错误',212);
        }elseif($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',213);
        }else{
            $order = $this->filter_fields('order_id,uid,order_status,total_price,from_name,shop_title,shop_logo,order_status_label,order_status_warning,dateline,contact,mobile',$order);
            $tuan = K::M('tuan/order')->detail($order_id);
            $tuan_order = $this->filter_fields('tuan_id,tuan_title,tuan_price,tuan_photo,tuan_number',$tuan);
            $tuan_ticket = K::M('tuan/ticket')->find(array('order_id'=>$order_id));
            $order['tuan'] = $tuan_order;
            if($tuan_ticket){
                $order['ticket'] = $tuan_ticket;
            }else{
                $order['ticket'] = array(
                    'ticket_id'=>0,
                    'uid'=>0,
                    'shop_id'=>0,
                    'tuan_id'=>0,
                    'order_id'=>0,
                    'number'=>0,
                    'count'=>0,
                    'ltime'=>0,
                    'use_time'=>0,
                    'status'=>0,
                    'dateline'=>0,
                    'type'=>0
                );
            }
            $member = K::M('member/member')->detail($order['uid']);
            if($comment = K::M('shop/comment')->find(array('order_id'=>$order['order_id']))) {
                $comment['contact'] = $order['contact'];
                $comment['mobile'] = $order['mobile'];
                $comment['face'] = $member['face'];
                $order['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,content,have_photo,reply,reply_ip,reply_time,dateline', $comment);
                $comment['have_photo'] = 0;
                $comment['photo_list'] = array();
                if($photo_list = K::M('shop/commentphoto')->items(array('comment_id'=>$comment['comment_id']), null, 1, 5)) {                    
                    foreach($photo_list as $k=>$v){
                        $comment['have_photo'] = 1;
                        $comment['photo_list'][] = $v['photo'];
                    }
                }
                $order['comment_info'] = $comment;
            }else{
                $order['comment_info'] = array('comment_id'=>0);
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('success');
        }
        
    }


}