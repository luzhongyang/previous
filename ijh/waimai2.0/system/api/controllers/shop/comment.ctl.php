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
        if(!$shop_id = (int) $params['shop_id']){
            $this->msgbox->add(L('商家不存在'), 211);
        }
        else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'), 212);
        }
        else if(empty($shop['audit'])){
            $this->msgbox->add(L('商户审核中'), 213);
        }
        else{
            $filter['shop_id'] = $shop_id;
            $page = max((int) $params['page'], 1);
            $count = K::M('shop/comment')->count($filter);
            if($comment_list = K::M('shop/comment')->items($filter, null, $page, 10, $count)){
                $comment_ids = array();
                foreach($comment_list as $k => $val){
                    $comment_ids[$val['comment_id']] = $val['comment_id'];
                    $uids[] = $val['uid'];
                }
                $photo_list = K::M('shop/photo')->items(array('comment_id' => $comment_ids));
                foreach($photo_list as $kk => $v){
                    $comment_list[$v['comment_id']]['photos'][] = $v;
                }
                foreach($comment_list as $k => $val){
                    $items[] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,reply,reply_time,dateline,photos', $val);
                }
                foreach($items as $k => $v){
                    $detail = K::M('member/member')->detail($v['uid']);
                    $items[$k]['nickname'] = $detail['nickname'];
                    $items[$k]['face'] = $detail['face'];
                    $items[$k]['pei_time'] = K::M('shop/comment')->timestr($v['pei_time']);
                }
            }
            else{
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items' => array_values($items), 'total_count' => $count));
        }
    }

    public function create($params)
    {

        $this->check_login();
        K::M('system/logs')->log('api.http.upload', $_FILES);
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 213);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 214);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 215);
        }
        else if($order['status'] < 0){
            $this->msgbox->add(L('订单已取消不可评价'), 216);
        }
        else if($order['order_status'] != 8){
            $this->msgbox->add(L('订单未完成不可评价'), 217);
        }
        else if($order['comment_status']){
            $this->msgbox->add(L('该订单已经评价过了'), 218);
        }
        else if(!$score_fuwu = (int) $params['score_fuwu']){
            $this->msgbox->add(L('服务评分不能为空'), 219);
        }
        else if(!$score_kouwei = (int) $params['score_kouwei']){
            $this->msgbox->add(L('口味评分不能为空'), 220);
        }
        else if(!$pei_time = (int) $params['pei_time']){
            $this->msgbox->add(L('配送不能为空'), 221);
        }
        else{
            $data = array(
                'uid'          => $this->uid,
                'shop_id'      => $order['shop_id'],
                'order_id'     => $order['order_id'],
                'mark'         => $params['mark'],
                'content'      => $params['content'],
                'score_fuwu'   => $score_fuwu,
                'score_kouwei' => $score_kouwei,
                'pei_time'     => $pei_time
            );
            if($_FILES){
                $data['have_photo'] = 1;
            }
            if($comment_id = K::M('shop/comment')->create($data)){
                if($attachs = $_FILES){
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k => $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'photo')){
                                K::M('shop/photo')->create(array('comment_id' => $comment_id, 'photo' => $a['photo']));
                            }
                        }
                    }
                }
                // 计算商家平均等待时间
                $order_items = K::M('shop/comment')->items(array('shop_id' => $order['shop_id']), array(), 0, 9999999, $count);
                foreach($order_items as $key => $val){
                    $pei_times += $val['pei_time'];
                }
                $pei_times = intval($pei_times / $count);


                //计算平均分
                $filter = array();
                $filter['shop_id'] = $order['shop_id'];
                $count_comment = K::M('shop/comment')->count($filter);
                $comment_list = K::M('shop/comment')->items($filter);
                $score_fuwu = 0;
                $score_kouwei = 0;
                $haoping_count = 0;
                foreach ($comment_list as $k => $v){
                    if( ($v['score_fuwu']+$v['score_kouwei'])/2 >3 ){
                        $haoping_count++;
                    }
                    $score_fuwu += $v['score_fuwu'];
                    $score_kouwei += $v['score_kouwei'];
                }
                $avg_fuwu = round($score_fuwu/$count_comment);
                $avg_kouwei = round($score_kouwei/$count_comment);
                //平均分 结束

                $update_data = array();
                if((($data['score_fuwu']+$data['score_kouwei']/2) > 3 )){
                    $update_data = array('comments' => $count_comment, 'praise_num' => $haoping_count,
                        'score_fuwu' => $avg_fuwu, 'score_kouwei' => $avg_kouwei , 'pei_time' => $pei_times);
                }else{
                    $update_data = array('comments' => $count_comment,
                        'score_fuwu' => $avg_fuwu, 'score_kouwei' => $avg_kouwei , 'pei_time' => $pei_times);
                }
                
                K::M('shop/shop')->update($order['shop_id'], $update_data,true);
                //echo '<pre>';print_r($this->system->db->SQLLOG());die;
                K::M('order/order')->update($data['order_id'], array('comment_status' => 1));
                $jifen = $this->system->config->get('jifen');
                $jifen_total = (int) (($order['amount']) * $jifen['jifen_ratio']);
                K::M('member/member')->update_jifen($this->uid, $jifen_total, sprintf(L('订单%s评价完成，获得积分'), $data['order_id']));
                $shopmsg = array(
                    'shop_id'  => $order['shop_id'],
                    'title'    => sprintf(L('用户已评价订单(%s)'), $order['order_id']),
                    'content'  => $params['content'],
                    'is_read'  => 0,
                    'type'     => 2,
                    'order_id' => $order['order_id'],
                    'dateline' => __TIME
                );
                K::M('shop/msg')->create($shopmsg);
                $this->msgbox->add('success');
            }
            else{
                $this->msgbox->add(L('评价订单失败'), 400);
            }
        }
    }

    public function detail($params)
    {
        if(!$comment_id = (int) $params['comment_id']){
            $this->msgbox->add(L('评论不存在'), 211);
        }
        else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add(L('评论不存在'), 212);
        }
        else if(!$shop = K::M('shop/shop')->detail($detail['shop_id'])){
            $this->msgbox->add(L('商家不存在'), 213);
        }
        else{
            if(!$photos = K::M('shop/photo')->items(array('comment_id' => $comment_id))){
                $photos = array();
            }
            $detail['photos'] = array_values($photos);
            $this->msgbox('success');
            $this->msgbox->set_data('data', $detail);
        }
    }

    public function add($params)
    {  //商家、服务人员同时评价
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 213);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 214);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 215);
        }
        else if($order['status'] < 0){
            $this->msgbox->add(L('订单已取消不可评价'), 216);
        }
        else if($order['order_status'] != 8){
            $this->msgbox->add(L('订单未完成不可评价'), 217);
        }
        else if($order['comment_status']){
            $this->msgbox->add(L('该订单已经评价过了'), 218);
        }
        else if(!$score_fuwu = (int) $params['score_fuwu']){
            $this->msgbox->add(L('服务评分不能为空'), 219);
        }
        else if(!$score_kouwei = (int) $params['score_kouwei']){
            $this->msgbox->add(L('口味评分不能为空'), 220);
        }
        else if(!$pei_time = (int) $params['pei_time']){
            $this->msgbox->add(L('配送时间不能为空'), 221);
        }
        else{
            if($score_fuwu > 5 || $score_fuwu < 1){
                $score_fuwu = 3;
            }
            if($score_kouwei > 5 || $score_kouwei < 1){
                $score_kouwei = 3;
            }

            $data = array(
                'uid'          => $this->uid,
                'shop_id'      => $order['shop_id'],
                'order_id'     => $order['order_id'],
                'mark'         => $params['mark'],
                'content'      => $params['content'],
                'score_fuwu'   => $score_fuwu,
                'score_kouwei' => $score_kouwei,
                'pei_time'     => $pei_time
            );

            if($_FILES){
                $data['have_photo'] = 1;
            }

            if($comment_id = K::M('shop/comment')->create($data)){
                if($attachs = $_FILES){
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k => $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'photo')){
                                K::M('shop/photo')->create(array('comment_id' => $comment_id, 'photo' => $a['photo']));
                            }
                        }
                    }
                }
                // 计算商家平均等待时间
                $order_items = K::M('shop/comment')->items(array('shop_id' => $order['shop_id']), array(), 0, 9999999, $count);
                foreach($order_items as $key => $val){
                    $pei_times += $val['pei_time'];
                }
                $pei_times = intval($pei_times / $count);
                $update_data = array();
                if((($data['score_fuwu']+$data['score_kouwei']/2) > 3 )){
                    $update_data = array('comments' => '`comments`+1', 'praise_num' => '`praise_num`+1', 'score_fuwu' => '`score_fuwu`+' . $data['score_fuwu'], 'score_kouwei' => '`score_kouwei`+' . $data['score_kouwei'], 'pei_time' => $pei_times);
                }else{
                    $update_data = array('comments' => '`comments`+1', 'score_fuwu' => '`score_fuwu`+' . $data['score_fuwu'], 'score_kouwei' => '`score_kouwei`+' . $data['score_kouwei'], 'pei_time' => $pei_times);
                }

                K::M('shop/shop')->update($order['shop_id'], $update_data, true);
                K::M('order/order')->update($data['order_id'], array('comment_status' => 1));
                $jifen = $this->system->config->get('jifen');
                $jifen_total = (int) (($order['amount']) * $jifen['jifen_ratio']);


                K::M('member/member')->update_jifen($this->uid, $jifen_total, sprintf(L('订单%s评价完成，获得积分'), $data['order_id']));
                $shopmsg = array(
                    'shop_id'  => $order['shop_id'],
                    'title'    => sprintf(L('用户已评价订单(%s)'), $order['order_id']),
                    'content'  => $params['content'],
                    'is_read'  => 0,
                    'type'     => 2,
                    'order_id' => $order['order_id'],
                    'dateline' => __TIME
                );
                K::M('shop/msg')->create($shopmsg);

                if($order['staff_id'] > 0 && $params['s_score']){
                    $staff_data = array(
                        'uid'      => $this->uid,
                        'staff_id' => $order['staff_id'],
                        'order_id' => $order['order_id'],
                        'score'    => $params['s_score'],
                        'content'  => $params['s_content'],
                        'mark'     => $params['s_mark']
                    );
                    $create = K::M('staff/comment')->create($staff_data);
                }

                $this->msgbox->add('success');
            }
            else{
                $this->msgbox->add(L('评价订单失败'), 300);
            }
        }
    }

    public function view($params)
    {

        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 213);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 214);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 215);
        }
        else if($order['comment_status'] == 0){
            $this->msgbox->add(L('该订单还没被评价过'), 216);
        }
        else{
            $c['comment'] = K::M('shop/comment')->find(array('order_id' => $order['order_id']));
            if($c['comment']['have_photo'] == 1){
                if($commentphoto = K::M('shop/photo')->items(array('comment_id' => $c['comment']['comment_id']))) {
                    foreach ($commentphoto as $k => $v) {
                        $comment_photos[] = $v['photo'];
                    }
                    $c['commentphoto'] = array_values($comment_photos);
                }else {
                    $c['commentphoto'] = array();
                }
            }
            if($order['staff_id'] > 0){
                if($staff_comment = K::M('staff/comment')->find(array('order_id' => $order['order_id']))){
                    $c['staff_comment']['s_content'] = $staff_comment['content'];
                    $c['staff_comment']['s_score'] = $staff_comment['score'];
                    $c['staff_comment']['s_reply'] = $staff_comment['reply'];
                    $c['staff_comment']['s_reply_time'] = $staff_comment['reply_time'];
                    $c['staff_comment']['s_mark'] = $staff_comment['mark'];
                }
            }
            if($order['staff_id'] > 0){
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $staff = $this->filter_fields('mobile,name,face', $staff);
                $c['staff'] = $staff;
            }
            if($order['shop_id'] > 0){
                $shop = K::M('shop/shop')->detail($order['shop_id']);
                $shop = $this->filter_fields('title,logo', $shop);
                $c['shop'] = $shop;
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', $c);
        }
    }

}
