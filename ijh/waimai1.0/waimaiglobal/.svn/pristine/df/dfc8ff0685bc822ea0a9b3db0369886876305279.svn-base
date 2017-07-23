<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Comment extends Ctl_Biz
{
    
    protected $_allow_fields = 'comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo';

    public function items($params)
    {
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        if($items = K::M('shop/comment')->items($filter, array('comment_id'=>'desc'), $page, $limit, $count)){
            $comment_ids = $uids = array();
            foreach($items as $k=>$v){                
                $v = $this->filter_fields($this->_allow_fields, $v);
                $v['photo_list'] = array();
                $v['have_photo'] = 0;
                $items[$k] = $v;
                $comment_ids[$v['comment_id']] = $v['comment_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            if($photo_list = K::M('shop/photo')->items(array('comment_id'=>$comment_ids), null, 1, 40, $count)) {
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
                        $v['member'] = array('uid'=>$v['uid'], 'nickname'=>L('匿名评价'), 'face'=>'default/face.png');
                    }
                    $items[$k] = $v;
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public  function detail($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }if(!$detail = K::M('shop/comment')->detail_by_order($order_id)){
            $this->msgbox->add(L('评论不存在或已被删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $detail['have_photo'] = 0;
            $detail['photo_list'] = array();
            if($photo_list = K::M('shop/photo')->items(array('comment_id'=>$detail['comment_id']), null, 1, 5)) {
                $detail['have_photo'] = 1;
                foreach($photo_list as $k=>$v){
                    $detail['photo_list'][] = $v['photo'];
                }
            } 
            if($member = K::M('member/member')->member($detail['uid'])){
                $detail['member'] = array('uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'face'=>$member['face']);
            }else{
                $detail['member'] = array('uid'=>$detail['uid'], 'nickname'=>L('匿名评价'), 'face'=>'default/face.png');
            }
            $this->msgbox->set_data('data', $detail);
            $this->msgbox->add('success');
        }
    }

    public function reply($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add(L('评论不存在'), 211);
        }if(!$comment = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add(L('评论不存在'), 212);
        }else if($comment['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($comment['reply_time']){
            $this->msgbox->add(L('您已经回复过了'), 214);
        }else if(!$reply = $params['reply']){
            $this->msgbox->add(L('评论内容不能为空'), 215);
        }else if(K::M('shop/comment')->update($comment_id, array('reply'=>$reply, 'reply_time'=>__TIME, 'reply_ip'=>__IP))){
            $this->msgbox->add('success');
        }
    }

}