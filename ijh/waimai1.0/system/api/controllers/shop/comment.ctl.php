<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Comment extends Ctl
{

    public function index($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add(L('商家不存在'),211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'),212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add(L('商户审核中'),213);
        }else{
            $filter['shop_id'] = $shop_id;
            $page = max((int)$params['page'], 1);
            $count = K::M('shop/comment')->count($filter);
            if($comment_list = K::M('shop/comment')->items($filter, null, $page, 10, $count)){
                $comment_ids = array();
                foreach ($comment_list as $k=>$val){
                    $comment_ids[$val['comment_id']] = $val['comment_id'];
                    $uids[] = $val['uid'];
                }
                $photo_list = K::M('shop/photo')->items(array('comment_id'=>$comment_ids));
                foreach($photo_list as $kk=>$v){
                    $comment_list[$v['comment_id']]['photos'][] = $v;
                }
                foreach ($comment_list as $k=>$val){
                    $items[] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,reply,reply_time,dateline,photos', $val);
                }                
                foreach($items as $k => $v){
                    $detail = K::M('member/member')->detail($v['uid']);
                    $items[$k]['nickname'] = $detail['nickname'];
                    $items[$k]['face'] = $detail['face'];
                    $items[$k]['pei_time'] = K::M('shop/comment')->timestr($v['pei_time']);
                }               
            }else{
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items),'total_count'=>$count));
        }
    }

    public function create($params)
    {
        $this->check_login();
        K::M('system/logs')->log('api.http.upload', $_FILES);
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),213);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),213);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['status'] < 0){
            $this->msgbox->add(L('订单已取消不可评价'),213);
        }else if($order['order_status'] != 8){
            $this->msgbox->add(L('订单未完成不可评价'),213);
        }else if($order['comment_status']){
            $this->msgbox->add(L('该订单已经评价过了'),213);
        }else if(!$score_fuwu = (int)$params['score_fuwu']){
            $this->msgbox->add(L('服务评分不能为空'),213);
        }else if(!$score_kouwei= (int)$params['score_kouwei']){
            $this->msgbox->add(L('口味评分不能为空'),213);
        }else if(!$pei_time = (int)$params['pei_time']){
            $this->msgbox->add(L('配送不能为空'),213);
        }else if(!$content = $params['content']){
            $this->msgbox->add(L('评论内容不能为空'),213);
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
				'score'=> $score,
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
                    K::M('member/member')->update_jifen($this->uid,$jifen_total,sprintf(L('订单%s评价完成，获得积分'), $data['order_id']));
                    $shopmsg = array(
                        'shop_id'=>$order['shop_id'],
                        'title'=>sprintf(L('用户已评价订单(%s)'), $order['order_id']),
                        'content'=>$content,
                        'is_read'=>0,
                        'type'=>2,
                        'order_id'=>$order['order_id'],
                        'dateline'=>__TIME
                        );
                    K::M('shop/msg')->create($shopmsg);
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add(L('评价订单失败'),216);
            }
        }
    }

    public function detail($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add(L('评论不存在'),211);
        }else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add(L('评论不存在'), 212);
        }else if(!$shop = K::M('shop/shop')->detail($detail['shop_id'])){
            $this->msgbox->add(L('商家不存在'), 213);
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
