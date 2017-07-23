<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 * check view code by shzhrui
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Waimai_Comment extends Ctl
{
    protected $_allow_fields = 'comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,reply,reply_time,dateline,comment_photos,nickname';
	public function items($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add('请选择商户！',211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在',212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中',213);
        }else{
            $filter['shop_id'] = $shop_id;
            $page = max((int)$params['page'], 1);
            $count = K::M('waimai/comment')->count($filter);
            if($comment_list = K::M('waimai/comment')->items($filter, array('comment_id'=>'desc'), $page, 10, $count)){
                $comment_ids = $uids = array();
                foreach ($comment_list as $k=>$v){
                    $v = $this->filter_fields($this->_allow_fields, $v);
                    $uids[$v['uid']] = $v['uid'];
                    $comment_ids[$v['comment_id']] = $v['comment_id'];
                    $v['nickname'] = '匿名';
                    $v['face'] = 'default/face.png';
                    $v['pei_time'] = K::M('waimai/comment')->timestr($v['pei_time']);;
                    //$v['member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
                    $v['comment_photos'] = array();
                    $comment_list[$k] = $v;
                }
                if($photo_list = K::M('waimai/commentphoto')->items(array('comment_id'=>$comment_ids))){
                    foreach($photo_list as $kk=>$v){
                        $comment_list[$v['comment_id']]['comment_photos'][] = array(
                            'photo'    => $v['photo'],
                            'photo_id' => $v['photo_id']
                        );
                    }
                }
                if($member_list = K::M('member/member')->items_by_ids($uids)){
                    foreach($comment_list as $k=>$v){
                        if($row = $member_list[$v['uid']]){
                            $v['nickname'] = $row['nickname'];
                            $v['face'] = $row['face'];
                            $comment_list[$k] = $v;
                        }
                    }
                }
            }else{
                $comment_list = array();
            }
            //为了兼容旧的APP 依旧这么返回
            $comment['score'] = $shop['score'];
            $comment['count'] = $shop['comments'];
            $this->msgbox->set_data('data', array('items'=>array_values($comment_list),'comment'=>$comment,'total_count'=>$count));
        }
    }

    /*外卖评论提交*/
	public function commit($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单id',213);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除',213);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限评价该订单',213);
        }else if($order['status'] < 0){
            $this->msgbox->add('订单已取消不可评价',213);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单未完成不可评价',213);
        }else if($order['comment_status']){
            $this->msgbox->add('该订单已经评价过了',213);
        }else if(($order['pei_type'] != 3) && !($score_fuwu = (int)$params['score_fuwu'])){
            $this->msgbox->add('服务评分不能为空',213);
        }else if(!$score_kouwei= (int)$params['score_kouwei']){
            $this->msgbox->add('商品评分不能为空',213);
        }else if(!$score = (int)$params['score']){
            $this->msgbox->add('综合评分不能为空',213);
        }else if(!$content = $params['content']){
            $this->msgbox->add('评论内容不能为空',213);
        }else if(($order['pei_type'] != 3) && !($pei_time = $params['pei_time'])){
            $this->msgbox->add('订单配送时间不能为空',213);
        }else{
            if($score_fuwu>5 || $score_fuwu < 1){
                $score_fuwu = 3;
            }
            if($score_kouwei>5 || $score_kouwei < 1){
                $score_kouwei = 3;
            }

            $data = array(
                'shop_id'      => $order['shop_id'],
                'uid'          => $this->uid,
                'order_id'     => $order['order_id'],
                'score'        => $score,
                'score_fuwu'   => $score_fuwu,
                'score_kouwei' => $score_kouwei,
                'content'      => $content,
                'pei_time'     => $pei_time,
            );
            if($comment_id = K::M('waimai/comment')->create($data)){
                if($attachs  = $_FILES){
                    foreach($attachs as $attach){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_id = K::M('waimai/commentphoto')->create(array('comment_id'=>$comment_id, 'photo'=>$a['photo']));
                        }
                    }
                }
                $shop = K::M('shop/shop')->detail($order['shop_id']);
                K::M('shop/shop')->update($order['shop_id'], array('comments'=>$shop['comments']+1));
                K::M('shop/shop')->update_count($order['shop_id'], 'score', $data['score']);
                K::M('order/order')->update($data['order_id'],array('comment_status'=>1, 'pei_time'=>$data['pei_time']));
                $jifen = $this->system->config->get('jifen');
                $jifen_total = (int)(($order['product_price'] + $order['package_price'])*$jifen['jifen_ratio']);
                K::M('member/member')->update_jifen($this->uid,$jifen_total,'订单'.$data['order_id'].'评价完成，获得积分');
                K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>'订单已评价','content'=>'用户('.$order['contact'].')已评价订单(ID:'.$order['order_id'].')','is_read'=>0,'type'=>2,'order_id'=>$order['order_id']));
                $order_items = K::M('order/order')->items(array('shop_id'=>$order['shop_id'],'order_status'=>8,'comment_status'=>1),$orderby,$page,$limit,$count);
                foreach($order_items as $key=>$val) {
                    $pei_times += $val['pei_time'];
                }
                $pei_times = intval($pei_times/$count);
                if($data['score']>3){
                    $update_data = array('comments'=>'`comments`+1','praise_num'=>'`praise_num`+1','score'=>'`score`+'.$data['score'],'score_fuwu'=>'`score_fuwu`+'.$data['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$data['score_kouwei'],'pei_time'=>$pei_times);
                }else{
                    $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$data['score'],'score_fuwu'=>'`score_fuwu`+'.$data['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$data['score_kouwei'],'pei_time'=>$pei_times);
                }
                if($order['from'] == 'waimai') {
                    K::M('waimai/waimai')->update($order['shop_id'],$update_data,true);
                }
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add('评价订单失败!',216);
            }
        }
    }
}
