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
        $filter = array('staff_id'=>$this->staff_id);
        $limit = 10;
        $page = max((int)$params['page'], 1);
        if($items = K::M('staff/comment')->items($filter, array('comment_id'=>'DESC'), $page, $limit, $count)){
            $uids = $comment_ids  =  array();
            foreach($items as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $comment_ids[$v['comment_id']] =  $v['comment_id'];
                $v['member_name'] = '匿名';
                $v['member_face'] = 'default/face.png';
                $v['photos'] = array();
                $items[$k] = $v;
            }
            if($photo_list = K::M('staff/commentphoto')->items(array('comment_id'=>$comment_ids), null, 1, 50)){
                foreach($photo_list as $v){
                    $items[$v['comment_id']]['photos'][] = $v['photo'];
                }
            }
            if($member_list = K::M('member/member')->items_by_ids($uids)){
                foreach($items as $k=>$v){
                    if($row = $member_list[$v['uid']]){
                        $v['member_name'] = $row['nickname'];
                        $v['member_face'] = $row['face'];
                        $items[$k] = $v;
                    }
                }
            }
        }
        $total_precent = 0;
        if($count){
            if($hao_comments = K::M('staff/comment')->count(array('staff_id'=>$this->staff_id,'score'=>'>:3'))){
                $total_precent = round($hao_comments/$count, 2);
            }
        }
        $total_score = $this->staff['score'];
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
                'reply_time' => __TIME,
                'clientip'   => __IP
            );
            if(K::M('staff/comment')->update($comment_id, $data)){
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
                'reply_time' => __TIME
            );
            if(K::M('staff/comment')->update($params['comment_id'],$data)){
                $this->msgbox->add('回复成功');
            }else{
                $this->msgbox->add('回复失败',101);
            }
        }
    }
}