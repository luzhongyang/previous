<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_House_order extends Ctl
{
    
    public function index($cate_id){
        if(!$cate_id){
            $this->msgbox->set_data('forward', $this->mklink('house/index'));
            $this->msgbox->add('错误！',211);         
        }else if(!$cate = K::M('house/cate') -> detail($cate_id)){
            $this->msgbox->set_data('forward', $this->mklink('house/index'));
            $this->msgbox->add('错误',221);
        }else{
            $unit = K::M('data/unit')->unit_list();
            $this->pagedata['unit'] = $unit;
            //var_dump($cate);die;
            $this->pagedata['cate'] = $cate;
            if($this->uid > 0){
                $addr = K::M('member/addr')->items(array('uid'=>$this->uid),array('addr_id'=>'desc'));
                if(count($addr) > 0){
                    $this->pagedata['addrs'] = $addr;
                };
            }
            $today = strtotime(date('Y-m-d'));
            $now_time = date('H');
            $this->pagedata['cate_id'] = $cate_id;
            $this->pagedata['now_time'] = $now_time;
            $this->tmpl = 'house/order.html';
        }      
        
    }
    
    //提交订单
    public function handle()
    { 
        $this->check_login();
        $file = $_FILES;
        $data = $_POST['data'];
        $data2 = $_POST['data2'];

        if(!$this->checksubmit()){
            $this->msgbox->add('非法操作!',210);
        }
        if(!$data['city_id']){
            $this->msgbox->add('城市没有选择!',210); 
        }else if(!$this->GP('sday_val') || !$this->GP('stime_val')){
            $this->msgbox->add('服务时间没有选择!',211);
        }else if(!$addr_id = $this->GP('sd_val')){
            $this->msgbox->add('服务地址不正确!',216);
        }else if(!$addr = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('服务地址不正确!',216);
        }else if($addr['uid'] != $this->uid){
            $this->msgbox->add('服务地址不正确!',216);
        }else if(!$data['addr']){
            $this->msgbox->add('服务地址不正确!',212);
        }
        // else if(!$data['house']){
        //     $this->msgbox->add('门牌号没有选择!',213);
        // }else if(!$data['contact']){
        //     $this->msgbox->add('联系人没有选择!',214);
        // }else if(!$data['mobile']){
        //     $this->msgbox->add('联系人手机没有选择!',215);
        // }else if(!$addr_id = $this->GP('sd_val')){
        //     $this->msgbox->add('地址信息有误!',216);
        // }
        else if(!$data['intro']){
            $this->msgbox->add('没有填写需求!',217);
        }else if(!$data2['danbao_amount']){
            $this->msgbox->add('订金错误!',218);
        }else{ 
            $data['from'] = 'house';
            $data['uid'] = $this->uid;
            //{{{#################
            $data['addr'] = $addr['addr'];
            $data['house'] = $addr['house'];
            $data['contact'] = $addr['contact'];
            $data['mobile'] = $addr['mobile'];
            $data['lat'] = $data['o_lat'] = $addr['lat'];
            $data['lng'] = $data['o_lng'] = $addr['lng'];
            //##############}}}}           
            $data['amount'] = $data2['danbao_amount'];
            $data['total_price'] = $data2['danbao_amount'];
            $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
            $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');
            
            $d = intval($this->GP('sday_val'));
            $t = intval($this->GP('stime_val'));
            $today = strtotime(date('Y-m-d'));
            if($d > 1){
                $now = $today+intval($d-1)*(86400);
            }else{
                $now = $today;
            }
            $t = intval($t) * intval(3600);
            $data2['fuwu_time'] = intval($now + $t);            
            if($add = K::M('order/order')->create($data)){             
                if($file){
                    foreach($file as $k => $v){
                        if($a = K::M('magic/upload')->upload($v,'photo')){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }
                }
                $data2['order_id'] = $add;

                if($add2 = K::M('house/order')->create($data2)){
                     // 写入订单日志
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    // 更新用户订单量
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    
                    $this->msgbox->add('下单成功!');
                    $this->msgbox->set_data('order_id', $add);
                }else{
                    $this->msgbox->add('下单失败!',312);
                }
            }else{
                $this->msgbox->add('下单失败!',311);
            }
       }

    }
    
    
    public function comment($order_id){  //评价
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('错误的订单!',211);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单状态不可评价!',212);
        }else if($order['from'] != 'house'){
            $this->msgbox->add('该订单不是家政订单!',213);
        }else{
            $this->pagedata['order']= $order;
        }
        $this->tmpl = 'house/comment.html';
    }

    public function comment_handle(){
        $this->check_login();
        $data = $data2 = array();
        $file = $_FILES;
        
        if(!$data['score'] = $this->GP('star')){
            $this->msgbox->add('没有选择评分!',211);
        }else if(!$data['content'] = $this->GP('content')){
            $this->msgbox->add('没有填写评价内容!',212);
        }else if(!$data['order_id'] = $this->GP('order_id')){
            $this->msgbox->add('订单错误!',213);
        }else if(!$order = K::M('order/order')->detail($this->GP('order_id'))){
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
                if($file){
                   foreach($file as $k => $v){
                       if($a = K::M('magic/upload')->upload($v,'photo')){
                           $photo_data = array(
                               'order_id' => $add,
                               'photo' => $a['photo']
                           );
                           $create_photo = K::M('staff/commentphoto') -> create($photo_data);
                       }
                   }
                }
                $this->msgbox->add('评价成功!');
            }
        }
    }
}
