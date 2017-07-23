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
class Ctl_Client_House_Order extends Ctl
{
   // 家政下单
   public function create($params)
   {
        $this->check_login();
        $data = $data2 = $data3 = array();
        if(!$data['city_id'] = $params['city_id']){
           $this->msgbox->add('城市没有选择!',210);
        }else if(!$data2['fuwu_time'] = $params['fuwu_time']){
            $this->msgbox->add('服务时间没有选择!',211);
        }else if(!$addr_id = $params['addr_id']){
            $this->msgbox->add('没有地址ID!',217);
        }else if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写需求!',217);
        }else if(!$data2['danbao_amount'] = $params['danbao_amount']){
            $this->msgbox->add('订金错误!',218);
        }else if(!$data2['cate_id'] = $params['cate_id']){
            $this->msgbox->add('没有服务分类!',219);
        }else if(!$cate = K::M('house/cate') -> detail($params['cate_id'])){
            $this->msgbox->add('没有服务分类!',220);
        }else{
            $data['from'] = 'house';
            $data['uid'] = $this->uid;
            $data['amount'] = $data['total_price'] = $data2['danbao_amount'];
            $data['order_from'] = strtolower(CLIENT_OS);
            if($addr_id){
                if($addr = K::M('member/addr')->detail($addr_id)){
                    $data['lat'] = $data['o_lat'] = $addr['lat'];
                    $data['lng'] = $data['o_lng'] = $addr['lng'];
                    $data['addr'] = $addr['addr'];
                    $data['house'] = $addr['house'];
                    $data['contact'] = $addr['contact'];
                    $data['mobile'] = $addr['mobile'];
                    $data['order_from'] = strtolower(CLIENT_OS);
                }
            }
            if($staff_id = (int)$params['staff_id']){
                if($staff = K::M('staff/staff')->detail($staff_id)){
                    $data['staff_id'] = $staff_id;
                    // order_status 放在订单支付回调中处理
                    // $data['order_status'] = 1;
                }
            }
            if($order_id = K::M('order/order')->create($data)){
                $data2['cate_title'] = $cate['title'];
                $data2['order_id'] = $order_id;
                K::M('house/order')->create($data2);
                foreach($_FILES as $k=>$attach){
                    if($k == 'voice'){
                        if($b = K::M('magic/upload')->file($_FILES['voice'])){
                            $voice = $b['photo'];
                            K::M('order/voice')->create(array('order_id'=>$order_id, 'voice'=>$voice, 'voice_time'=>(int)$params['voice_time']));
                        }
                    }else if($a = K::M('magic/upload')->upload($attach)){
                        K::M('order/photo')->create(array('order_id'=>$order_id, 'photo'=>$a['photo']));
                    }
                }
                // 下单成功
                K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                K::M('member/member')->update_count($this->uid, 'orders', 1);                
                $this->msgbox->set_data('data',array('order_id'=>$order_id));
            }else{
                $this->msgbox->add('创建订单失败!', 311);
            }
        }
    }

    public function commenthandle($params)
    {
        $this->check_login();
        $data = $data2 = array();
        if(!$data['score'] = $params['score']){
            $this->msgbox->add('没有选择评分!',211);
        }else if(!$data['content'] = $params['content']){
            $this->msgbox->add('没有填写评价内容!',212);
        }else if(!$data['order_id'] = $params['order_id']){
            $this->msgbox->add('订单错误!',213);
        }else if(!$order = K::M('order/order')->detail($params['order_id'])){
            $this->msgbox->add('订单错误!',214);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单状态不可评价!',215);
        }else if($order['from'] != 'house'){
            $this->msgbox->add('该订单不是家政订单！',216);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('不可操作别人的订单！',217);
        }else{
            $data['staff_id'] = $order['staff_id'];
            $data['uid'] = $this->uid;
            if(!$add = K::M('staff/comment')->create($data)){
                $this->msgbox->add('评价失败!',230);
            }else{
                if($_FILES){
                   foreach($_FILES as $k => $v){
                       if($a = K::M('magic/upload')->upload($v,'photo')){
                           $photo_data = array(
                               'order_id' => $add,
                               'photo' => $a['photo']
                           );
                           $create_photo = K::M('staff/commentphoto') -> create($photo_data);
                       }
                   }
                }
                K::M('order/order')->update($order['order_id'], array('commment_status'=>1));
                $this->msgbox->add('success');
            }
        }
    }

}
