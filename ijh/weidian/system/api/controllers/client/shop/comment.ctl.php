<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Shop_Comment extends Ctl
{

    public function items($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add('请选择商户！',211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在',212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中',213);
        }else{
            $limit = 10;
            $page = max((int)$params['page'], 1);
            if($comment_list = K::M('shop/comment')->items(array('shop_id'=>$shop_id),array('comment_id'=>'desc'), $page, $limit, $count)){
                $comment_ids = array();
                foreach($comment_list as $k=>$v){
                    $comment_ids[$v['comment_id']] = $v['comment_id'];
                    $uids[$v['uid']] = $v['uid'];
                    $row = $this->filter_fields('comment_id,score,score_fuwu,score_kouwei,uid,content,reply,reply_time,dateline',$v);
                    $row['nickname'] = '匿名';
                    $row['face'] = 'default/face.png';
                    $row['photos'] = array();
                    $comment_list[$k] = $row;
                }
                if($photo_list = K::M('shop/commentphoto')->items(array('comment_id'=>$ids))) {
                    foreach($photo_list as $k=>$v){
                        if($row = $comment_list[$v['comment_id']]){
                            $row['photos'][] = $this->filter_fields('photo_id,photo', $v);
                        }
                    }
                } 
                if($member_list = K::M('member/member')->items(array('uid'=>$uids))) {
                    foreach($comment_list as $k=>$v){
                        if($m = $member_list[$v['uid']]){
                            $v['nickname'] = $m['nickname'];
                            $v['face'] = $m['face'];
                        }
                        $comment_list[$k] = $v;
                    }
                } 
            }else {
                $comment_items = array();
            } 
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($comment_list),'total_count'=>$count, 'shop'=>$this->filter_fields('comments,score,avg_score', $shop)));
        }
    }

    public function commit($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单id',213);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除',213);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限评价该订单',213);
        }else if($order['status'] < 0){
            $this->msgbox->add('订单已取消不可评价',213);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单未完成不可评价',213);
        }else if($order['comment_status']){
            $this->msgbox->add('该订单已经评价过了',213);
        }else if(!$score_fuwu = (int)$params['score_fuwu']){
            $this->msgbox->add('服务评分不能为空',213);
        }else if(!$score_kouwei= (int)$params['score_kouwei']){
            $this->msgbox->add('口味评分不能为空',213);
        }else if(!$pei_time = (int)$params['pei_time']){
            $this->msgbox->add('配送不能为空',213);
        }else if(!$content = $params['content']){
            $this->msgbox->add('评论内容不能为空',213);
        }else{
            if($score_fuwu>5 || $score_fuwu < 1){
                $score_fuwu = 3;
            }
            if($score_kouwei>5 || $score_kouwei < 1){
                $score_kouwei = 3;
            }
            if($pei_time<10){
                $pei_time = 10;
            }else if($pei_time>190){
                $pei_time = 190;
            }
            $data = array(
                'uid'=>$this->uid,
                'shop_id'=>$order['shop_id'],
                'order_id'=>$order['order_id'],
                'content'=>$content,
                'score_fuwu'=> $score_fuwu,
                'score_kouwei' => $score_kouwei,
                'pei_time'=>$pei_time
            );
            if($comment_id = K::M('shop/comment')->create($data)){
                if($attachs = $_FILES){
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'photo')){
                                K::M('shop/photo')->create(array('comment_id'=>$comment_id, 'photo'=>$a['photo']));
                            }
                        }
                    }
                }
                if($data['score']>3){
                        $update_data = array('comments'=>'`comments`+1','praise_num'=>'`praise_num`+1','score'=>'`score`+'.$data['score'],'score_fuwu'=>'`score_fuwu`+'.$data['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$data['score_kouwei']);
                    }else{
                       $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$data['score'],'score_fuwu'=>'`score_fuwu`+'.$data['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$data['score_kouwei']); 
                    }
                    K::M('shop/shop')->update($order['shop_id'],$update_data,true);
                    K::M('order/order')->update($data['order_id'],array('comment_status'=>1));
                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int)(($order['product_price'] + $order['package_price'])*$jifen['jifen_ratio']);
                    K::M('member/member')->update_jifen($this->uid,$jifen_total,'订单'.$data['order_id'].'评价完成，获得积分');
                    $shopmsg = array(
                        'shop_id'=>$order['shop_id'],
                        'title'=>"用户已评价订单(".$order['order_id'].")",
                        'content'=>$content,
                        'is_read'=>0,
                        'type'=>2,
                        'order_id'=>$order['order_id'],
                        'dateline'=>__TIME
                        );
                    K::M('shop/msg')->create($shopmsg);
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add('评价订单失败!',216);
            }
        }
    }

    public function detail($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('未指定评论ID',211);
        }else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在', 212);
        }else if(!$shop = K::M('shop/shop')->detail($detail['shop_id'])){
            $this->msgbox->add('商铺不存在', 213);
        }else{
            if(!$photos = K::M('shop/photo')->items(array('comment_id'=>$comment_id))){
                $photos = array();
            }
            $detail['photos'] = array_values($photos);
            $this->msgbox('success');
            $this->msgbox->set_data('data', $detail);
        }
    }
}
