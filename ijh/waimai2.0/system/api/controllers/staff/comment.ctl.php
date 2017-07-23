<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Comment extends Ctl_Staff
{
    /**
     * 评论列表
     * @param $this->staff_id
     * @param $page
     */
    public function items($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',200);
        }
        $orderby['dateline'] = 'desc';
        $filter['staff_id']  = $this->staff_id;
        $page = isset($params['page']) ? $params['page'] : 1;
        $items = K::M('staff/comment')->items($filter, $orderby, $page, 20, $count);
        $comment_id_arr = array();
        $uids  =  array();
        foreach($items as $item){
            $comment_id_arr[$item['comment_id']] =  $item['comment_id'];
            $uids[] = $item['uid'];
        }
        $comment_id_arr = implode(',', $comment_id_arr);
        $members = K::M('member/member')->items(array('uid'=>$uids));
        $photos  = K::M('staff/commentphoto')->photos_by_comment($comment_id_arr);

        
        $good_star = 0;
        foreach($items as $k=>$item){
            $good_star+=$item['score'];
            foreach($members as $m){
                if($m['uid'] == $item['uid']){
                    $items[$k]['member_name'] = $m['nickname'];
                    $items[$k]['member_face'] = $m['face'];
                }
            }
            foreach($photos as $photo){
              
                if($item['comment_id'] == $photo['comment_id']){
                    $items[$k]['photos'][] = $photo['photo'];
                }
            }
            
            if(!$items[$k]['photos']){
                $items[$k]['photos'] = array();
            }
                
        }

        $well_counts = K::M('staff/comment')->count(array('staff_id'=>$this->staff_id,'score'=>'>:3'));
        $all_counts  = K::M('staff/comment')->count(array('staff_id'=>$this->staff_id));
        //好评率
        $total_precent = round($well_counts/$all_counts, 2);
        //好评星星
        $total_score = floor($total_precent * 5);

        $this->msgbox->set_data('data', array('total_score'=>$total_score,'total_precent'=>$total_precent,'count'=>$count,'items' => array_values($items)));
    }

    public function detail($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$comment = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('参数不正确',212);
        }else if($comment['reply_time']){
            $this->msgbox->add('评论已经回复',213);
        }else{
            $comment_info = $this->filter_fields('comment_id,order_id,staff_id,uid,score,content,reply,reply_time,dateline', $comment);
            $photo_list  = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']));
            $comment_info['photos'] = array();
            $comment_info['member_face'] = 'default/face.png';
            $comment_info['member_name'] = '';
            if($photos = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                foreach($photos as $v){
                    $comment_info['photos'][] = $v['photo'];
                }
            }
            if($member = K::M('member/member')->member($comment['uid'])){
                $comment_info['member_face'] = $member['face'];
                $comment_info['member_name'] = $member['nickname'];
            } 
            $this->msgbox->set_data('data', $comment_info);
        }
    }

    /**
     * 回复评论
     * @param $comment_id,评论ID
     * @param $reply,回复内容
     */
    public function reply($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$comment = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('参数不正确',212);
        }else if($comment['reply_time']){
            $this->msgbox->add('评论已经回复',213);
        }else if(!$reply = $params['reply']){
            $this->msgbox->add('回复内容不能为空',200);
        }else{
            $data = array(
                'reply'      => $reply,
                'reply_time' => time(),
                'clientip'   => __IP
            );
            if(K::M('staff/comment')->update($comment_id, $data)){
                $staff = K::M('staff/staff')->detail($comment['staff_id']);
                $order = K::M('order/order')->detail($comment['order_id']);
                K::M('order/order')->send_member('骑手('.$staff['name'].')已回复', '订单(' . $order['order_id'] . ')骑手回复内容：(' . $reply . ')', $order, null);
                $this->msgbox->add('回复成功');
            }else{
                $this->msgbox->add('位置错误',100);
            }
        }
    }


    //已经废除不用了
    /**
     * 订单列表回复
     * @param $comment_id,评论ID
     * @param $reply
     */
    public function order_reply($params)
    {
        if(!$comment_id = (int)$params['comment_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$comment = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('参数不正确',212);
        }else if($comment['reply_time']){
            $this->msgbox->add('评论已经回复',213);
        }else if(empty($params['reply'])){
            $staff   = K::M('staff/staff')->detail($this->staff_id);
            $comment = K::M('staff/comment')->detail($params['comment_id']);
            $photos  = K::M('staff/commentphoto')->items(array('comment_id'=>$params['comment_id']));
            $_photos = array();
            foreach($photos as $key=>$photo){
                $_photos[] = $photo['photo'];
            }
            $data = array(
                'member_name'    => $staff['name'],
                'member_face'    => $staff['face'],
                'content'        => $comment['content'],
                'reply'          => $comment['reply'],
                'dateline'       => $comment['dateline'],
                'reply_time'     => $comment['reply_time'],
                'photos'         => $_photos,
                'score'          => $comment['score']      
            ); 
            $this->msgbox->set_data('data', $data);
        }else{
            $data = array(
                'reply'      => $params['reply'],
                'reply_ip'   => __IP,
                'reply_time' => time()
            );
            if(K::M('staff/comment')->update($params['comment_id'],$data)){
                $this->msgbox->add('回复成功');
            }else{
                $this->msgbox->add('回复失败',101);
            }
        }
    }
}