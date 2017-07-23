<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Staff_Comment extends Ctl
{

    public function comment($params)
    {
        $this->check_login();
        $data = array();
        if(!$data['score'] = (int)$params['score']){
            $this->msgbox->add('没有选择评分!',211);
        }else if(!$data['content'] = $params['content']){
            $this->msgbox->add('没有填写评价内容!',212);
        }else if(!$data['order_id'] = (int)$params['order_id']){
            $this->msgbox->add('订单不存在或已经删除!',213);
        }else if(!$order = K::M('order/order')->detail($data['order_id'])){
            $this->msgbox->add('订单不存在或已经删除!',214);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限评价该订单',217);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单未完成不可评价!',215);
        }else if($order['commment_status']){
            $this->msgbox->add('订单已经评价过了不可重复评价!',215);
        }else{
            $data['staff_id'] = $order['staff_id'];
            $data['uid'] = $this->uid;
            if($comment_id = K::M('staff/comment')->create($data)){
                if($_FILES){
                   foreach($_FILES as $k => $v){
                       if($a = K::M('magic/upload')->upload($v,'photo')){
                           $photo_data = array(
                               'order_id' => $add,
                               'photo' => $a['photo']
                           );
                           $create_photo = K::M('staff/commentphoto')->create($photo_data);
                       }
                   }
                }
                //更新评分
                K::M('staff/staff')->update($order['staff_id'], array('score'=>'`score`+'.$data['score'], 'comments'=>'`comments`+1'));
                K::M('order/order')->update($order['order_id'], array('comment_status'=>1));
                //通知服务人员
                $title = sprintf("用户[%s]对您进行了评价(单号：%s)", $order['contact'], $order['order_id']);
                $content = sprintf("用户[%s]对您进行了评价：%s", $order['contact'], $data['content'], $order['order_id']);
                K::M('staff/staff')->send($order['staff_id'], $title, $content, 'comment', $order['order_id']);
                $this->msgbox->add('success');
            }
        }       
    }
}