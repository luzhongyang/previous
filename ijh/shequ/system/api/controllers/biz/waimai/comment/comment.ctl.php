<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Comment_Comment extends Ctl_Biz
{
    
    protected $_allow_fields = 'comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo';

    public function items($params)
    {
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        
        $type = (int)$params['type'];
        if($type == 1){
            $filter['score'] = '>:3'; 
        }else if($type == 2){
            $filter['score'] = 3; 
        }else if($type == 3){
            $filter['score'] = '<:3'; 
        }
        
        if($items = K::M('waimai/comment')->items($filter, array('comment_id'=>'desc'), $page, $limit, $count)){
            $comment_ids = $uids = array();
            foreach($items as $k=>$v){
                $order = K::M('order/order')->detail($v['order_id']);
                
                if($order['pei_time'] && $order['jd_time']){
                    $ptime = $order['pei_time']*60 + $order['jd_time'];
                    $pei_time_label = '预计'.date('H:i',$ptime).'送达';
                }elseif($order['pei_time'] && !$order['jd_time']){
                    $ptime = $order['pei_time']*60 + $order['dateline'];
                    $pei_time_label = '预计'.date('H:i',$ptime).'送达';
                }else{
                    $pei_time_label = '预计'.date('H:i',$order['dateline']).'送达';
                }
                
                $v = $this->filter_fields($this->_allow_fields, $v);
                $v['pei_time_label'] = $v['pei_time'].'分钟送达';
                $v['photo_list'] = array();
                $v['have_photo'] = 0;
                $items[$k] = $v;
                $comment_ids[$v['comment_id']] = $v['comment_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            if($photo_list = K::M('waimai/commentphoto')->items(array('comment_id'=>$comment_ids), null, 1, 40, $count)) {
                foreach($photo_list as $k2=>$v2){
                    $items[$v2['comment_id']]['have_photo'] = 1;
                    $items[$v2['comment_id']]['photo_list'][] = $v2['photo'];
                }
            } 
            if($member_list = K::M('member/member')->items(array('uid'=>$uids),null, 1, 40, $count)) {
                foreach($items as $k=>$v){
                    if($m = $member_list[$v['uid']]){
                        $v['member'] = array('uid'=>$v['uid'], 'nickname'=>$m['nickname'], 'face'=>$m['face']);
                    }else{
                        $v['member'] = array('uid'=>$v['uid'], 'nickname'=>'匿名评价', 'face'=>'default/face.png');
                    }
                    $items[$k] = $v;
                }
            }
            $all_comment = K::M('waimai/comment')->count(array('shop_id'=>$this->shop_id)); 
            $g_comment = K::M('waimai/comment')->count(array('shop_id'=>$this->shop_id,'score'=>'>:3')); 
            $b_comment = K::M('waimai/comment')->count(array('shop_id'=>$this->shop_id,'score'=>'<:3')); 
            $z_comment = $all_comment - $g_comment - $b_comment;
            $comment = array(
                'all_comment' => $all_comment,
                'g_comment' => $g_comment,
                'z_comment' => $z_comment,
                'b_comment' => $b_comment
            );
        }else{
            $items = array();
            $comment = array(
                'all_comment' => 0,
                'g_comment' => 0,
                'z_comment' => 0,
                'b_comment' => 0
            );
        }
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        $shop_info = array();
        $shop_info['praise_bl'] = round(($waimai['praise_num']/$waimai['comments']*100),2);
        if($waimai['comments']){
            $shop_info['avg_score'] = round(($waimai['score']/$waimai['comments']),1);
            $shop_info['fuwu'] = round(($waimai['score_fuwu']/$waimai['comments']),1);
            $shop_info['kouwei'] = round(($waimai['score_kouwei']/$waimai['comments']),1);            
        }else{
            $shop_info['avg_score'] = $shop_info['fuwu'] = $shop_info['kouwei'] = 0;
        }        
        $this->msgbox->set_data('data', array('shop_info'=>$shop_info,'items'=>array_values($items), 'total_count'=>$count,'comment'=>$comment));
    }

    public  function detail($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('订单不存在', 211);
        }if(!$detail = K::M('waimai/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已被删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else{
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $detail['pei_time_label'] = $detail['pei_time'].'分钟送达';
            $detail['have_photo'] = 0;
            $detail['photo_list'] = array();
            if($photo_list = K::M('waimai/commentphoto')->items(array('comment_id'=>$detail['comment_id']), null, 1, 5)) {
                $detail['have_photo'] = 1;
                foreach($photo_list as $k=>$v){
                    $detail['photo_list'][] = $v['photo'];
                }
            } 
            if($member = K::M('member/member')->member($detail['uid'])){
                $detail['member'] = array('uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'face'=>$member['face']);
            }else{
                $detail['member'] = array('uid'=>$detail['uid'], 'nickname'=>'匿名评价', 'face'=>'default/face.png');
            }
            $this->msgbox->set_data('data', $detail);
            $this->msgbox->add('success');
        }
    }

    public function reply($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('评论不存在', 211);
        }if(!$comment = K::M('waimai/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在', 212);
        }else if($comment['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($comment['reply_time']){
            $this->msgbox->add('您已经回复过了', 214);
        }else if(!$reply = $params['reply']){
            $this->msgbox->add('回复内容不能为空', 215);
        }else if(K::M('waimai/comment')->update($comment_id, array('reply'=>$reply, 'reply_time'=>__TIME, 'reply_ip'=>__IP))){
            $title = sprintf("您在[%s]的外卖订单评价有新的回复", $this->shop['title']);
            $content = sprintf("您在[%s]的外卖订单(单号：%s)评价有新的回复(%s)", $this->shop['title'], $comment['order_id'], $reply);
            K::M('member/member')->send($comment['uid'], $title, $content, 'order', $comment['order_id']);
            $this->msgbox->set_data('data');
            $this->msgbox->add('回复评论成功');
        }else{
            $this->msgbox->add('回复失败');
        }
    }

}