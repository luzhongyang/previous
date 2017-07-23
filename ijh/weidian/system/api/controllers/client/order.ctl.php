<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Order extends Ctl
{

    public function index($params)
    {
        $this->items($params);
    }

    public function items($params)
    {
        $this->check_login();
        $filter = array();
        if(in_array($params['status'], array(0,1,2))){
            switch ($params['status']){
            case 2:
                $filter['order_status'] = array(-1,5,6,7,8);
                if(in_array($params['comment_status'], array(0,1))){
                   $filter['comment_status'] = $params['comment_status'];
                }
              break;
            case 1:
                $filter['order_status'] = array(0,1,2,3,4);
                break;
            }
        }
        if(in_array($params['pay_status'], array(0,1))){
            $filter['pay_status'] = $params['pay_status'];
        }
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($order_list = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $shop_ids = $staff_ids = array();
            foreach($order_list as $k=>$val){
                $staff_ids[$val['staff_id']] = $val['staff_id'];
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            if($shop_list = K::M('shop/shop')->items_by_ids($shop_ids)){
                $shop_ids = array();
                foreach($shop_list as $k=>$v){
                    $v = $this->filter_fields('shop_id,title,phone,logo',$v);
                    $v['collect'] = 0;
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                    $shop_list[$k] = $v;
                }
            }
            $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);
            if($this->uid){
                if($collects = K::M('shop/collect')->items(array('uid'=>$this->uid,'shop_id'=>$shop_ids))){
                    foreach($collects as $k=>$v){
                        $shop_list[$v['shop_id']]['collect'] = 1;
                    }
                }
            }
            foreach($staff_list as $k=>$val){
                $staff_list[$k] = $this->filter_fields('staff_id,name,mobile,lng,lat',$val);
            }
            $items = array();
            $jifen = K::M('system/config')->get('jifen');
            foreach($order_list as $k=>$val){
                $items[$k] = $this->filter_fields('order_id,city_id,shop_id,uid,product_price,package_price,comment_status,product_number,freight,money,amount,order_youhui,first_youhui,hongbao,hongbao_id,contact,mobile,addr,house,lat,lng,note,order_status,pay_status,pay_code,pay_time,staff_id,pei_type,dateline,order_status_label,total_order_price', $val);
                $items[$k]['jifen'] = (int)(($val['product_price'] + $val['package_price'])*$jifen['jifen_ratio']);
                if($shop_list[$val['shop_id']]){
                    $items[$k]['shop'] = array($shop_list[$val['shop_id']]);
                }else{
                    $items[$k]['shop'] = array('shop_id'=>0,'title'=>'','phone'=>'','logo'=>'');
                }
                if($staff_list[$val['staff_id']]){
                    $items[$k]['staff'] = $staff_list[$val['staff_id']];
                }else{
                    $items[$k]['staff'] = array('staff_id'=>0,'name'=>'','mobile'=>'','lng'=>'','lat'=>'');
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'page'=>$page));
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('不存在的订单',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法订单',213);
        }else{
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array(
                    'shop_id'=>0,
                    'title'=>'',
                    'phone'=>'',
                    'logo'=>'',
                    'comments'=>0,
                    'yy_stime'=>0,
                    'yy_ltime'=>0,
                    'praise_num'=>0,
                    'score_fuwu'=>0,
                    'score_kouwei'=>0,
                    'info'=>''
                );
            }else{
                $shop = $this->filter_fields('shop_id,title,phone,logo,comments,yy_stime,yy_ltime,praise_num,score_fuwu,score_kouwei,info',$shop);
                $order['shop'] = $shop;
            }
            if(!$staff = K::M('staff/staff')->detail($order['staff_id'])){
               $order['staff'] = array('staff_id'=>0,'name'=>'','mobile'=>'','lng'=>'','lat'=>'');
            }else{
                $staff = $this->filter_fields('staff_id,name,mobile,lng,lat',$staff);
                $order['staff'] = $staff;
            }
            if(!$log_list = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'DESC'))){
                $log_list = array();
            }
            if(!$product_list = K::M('order/product')->items(array('order_id'=>$order_id))){
                $product_list = array();
            }
            if($complaint = K::M('order/complaint')->find(array('uid'=>$this->uid,'order_id'=>$order_id))){
               $order['complaint'] = 1;
            }else{
               $order['complaint'] = 0;
            }
            $logs = array();
            foreach($log_list as $k=>$val){
                $logs[$val['type']] = $val;
            }

            if($order['order_status'] >=1){
                $order['receive_time'] = $logs[3]['dateline'];
            }
            if($order['order_status'] >= 3){
                $order['pks_time'] = $logs[4]['dateline'];
            }
            if($order['order_status'] >= 4){
                $order['pwc_time'] = $logs[5]['dateline'];
            }
            if($order['order_status'] >= 8){
                $order['wc_time'] = $logs[6]['dateline'];
                $order['pwc_from'] = $logs[6]['from'];
            }
            if($order['order_status'] == -1){
                if($logs[3]){
                    $order['receive_time'] = $logs[3]['dateline'];
                }
                if($logs[4]){
                    $order['pks_time'] = $logs[4]['dateline'];
                }
                if($logs[5]){
                    $order['pwc_time'] = $logs[5]['dateline'];
                }
                $order['pcancel_time'] = $logs[-1]['dateline'];
                $order['pcancel_from'] = $logs[-1]['from'];
            }
            $order['order_status_tips'] = '';
            if($order['pay_status'] == 0){
                if($order['order_status'] == 0 || $order['order_status'] == 1){
                    $order['order_status_tips'] = '订单逾期未支付半小时自动取消';
                }else if($order['order_status'] == -1){
                    $order['order_status_tips'] = '订单已取消';
                }
            }else if($order['pay_status'] == 1){
                if($order['order_status'] == 0){
                    $order['order_status_tips'] = '等待商家接单';
                }else if($order['order_status'] == 1 || $order['order_status'] == 3){
                    $order['order_status_tips'] = '预计送达：尽快送达';
                }else if($order['order_status'] == 4 || $order['order_status'] == 8){
                    $order['order_status_tips'] = '订单超过3小时自动完成';
                }else if($order['order_status'] == -1){
                    $order['order_status_tips'] = '订单逾期未支付半小时自动取消';
                }
            }
            //订单进度 jindu
            $jindu = array('xiadan'=>array(), 'zhifu'=>array());

            $order['products'] = array_values($product_list);
            $order['logs'] = array_values($log_list);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('order'=>$order));
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('不存在的订单',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消',214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态',215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add('取消订单失败', 216);
        }
    }

    public function confirm($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('不存在的订单',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经确认,无需重复确认',214);
        }else if(!in_array($order['order_status'], array(3, 4,5))){
            $this->msgbox->add('商家还未配送完成不可确认',215);
        }else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add('订单确认完成失败',216);
        }
    }

    // 订单投诉
    // public function complaint($params)
    // {
    //     $this->check_login();
    //     if(!$order_id = (int)$params['order_id']){
    //         $this->msgbox->add('订单不存在',211);
    //     }else if(!$order_detail = K::M('order/order')->detail($order_id)){
    //         $this->msgbox->add('订单不存在',212);
    //     }else if($order_detail['uid'] !=$this->uid){
    //         $this->msgbox->add('订单不正确',213);
    //     }else if(!$title = $params['title']){
    //         $this->msgbox->add('投诉类型不能为空',214);
    //     }else if(!$content = $params['content']){
    //         $this->msgbox->add('投诉内容不能为空',214);
    //     }else{
    //         $a = array(
    //             'order_id' => $order_detail['order_id'],
    //             'uid'      => $this->uid,
    //             'shop_id'  => $order_detail['shop_id'],
    //             'staff_id' => $order_detail['staff_id'],
    //             'title'    => $title,
    //             'content'  => $content
    //         );
    //         if($complaint_id = K::M('order/complaint')->create($a)){
    //             if($order_detail['shop_id']){
    //                 K::M('shop/shop')->send($order_detail['shop_id'], $a['title'], $a['title'].$content, 'complaint', $order_id);
    //             }
    //             if($staff_id = $order_detail['staff_id']) {
    //                 K::M('staff/staff')->send($order_detail['staff_id'], $a['title'], $a['title'].$content, 'complaint', $order_id);
    //             }
    //             $this->msgbox->add('success');
    //             $this->msgbox->set_data('data', array('complaint_id'=>$complaint_id));
    //         }
    //     }
    // }

    
    //用户申请退单，需要商家/管理员同意后才能取消订单
    // public function tuidan($params)
    // {

    // }

    public function cuidan($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('不存在的订单',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已完成可催单',214);
        }else if(!in_array($order['order_status'], array(1, 2, 3, 4))){
            $this->msgbox->add('未接单不可催单',214);
        }else if($order['cui_time']>(__TIME-900)){
            $this->msgbox->add('您已经催单了,请再耐心等等',214);
        }else if(K::M('order/order')->update($order_id, array('cui_time'=>__TIME), true)){
            $a = array('uid'=>$order['uid'], 'order_id'=>$order_id, 'shop_id'=>$order['shop_id'], 'staff_id'=>$order['staff_id'], 'cui_time'=>__TIME);
            $log_id = K::M('order/cuilog')->create($a);
            if($order['pei_type'] < 2 && $order['shop_id']) {
                K::M('order/order')->send_shop('用户正在催单', sprintf("订单(%s)用户正在催单", $order_id), $order);
            }
            if($order['staff_id']) {
                K::M('order/order')->send_staff('用户正在催单', sprintf("订单(%s)用户正在催单", $order_id), $order);
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',array('log_id'=>$log_id, 'order_id'=>$order_id));
        }
    }

    // public function preinfo($params)
    // {
    //     $this->check_login();
    //     if(!$shop_id = (int)$params['shop_id']){
    //         $this->msgbox->add('商家不存在或已删除', 211);
    //     }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
    //         $this->msgbox->add('商家不存在或已删除', 212);
    //     }else if(empty($shop['audit'])){
    //         $this->msgbox->add('商户审核中不可下单!',212);
    //     }else{
    //         $hongbao_id = $addr_id = $hongbao_count = 0;
    //         $hongbao = $addr = array();
    //         if($amount = (float)$params['amount']){
    //             $filter = array('uid'=>$this->uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0);
    //             if($hb_list = K::M('hongbao/hongbao')->items($filter, array('amount'=>'DESC'), 1, 1, $count)){
    //                 $hongbao = array_shift($hb_list);
    //                 $hongbao_id = $hongbao['hongbao_id'];
    //                 $hongbao_count = $count;
    //             }else{
    //                 $hongbao = array('hongbao_id'=>0, 'title'=>'', 'min_amount'=>'', 'amount'=>'','type'=>'', 'uid'=>'0', 'stime'=>'0', 'ltime'=>'','order_id'=>'0','used_time'=>'0','dateline'=>'');
    //             }
    //         }
    //         if($addr_id = (int)$params['addr_id']){
    //             if($addr = K::M('member/addr')->detail($addr_id)){
    //                 if($addr['uid'] != $this->uid){
    //                     $addr = array();
    //                 }
    //             }
    //         }
    //         if(!$addr){
    //             if($addr_list = K::M('member/addr')->items(array('uid'=>$this->uid), null, 1, 10)){
    //                 $pei_distance = $shop['pei_distance'] ? $shop['pei_distance'] : 5;
    //                 $point = K::M('helper/round')->returnSquarePoint($shop['lng'], $shop['lat'], $pei_distance);
    //                 foreach($addr_list as $v){
    //                     if(($v['lng']>$point['left-bottom']['lng']) && ($v['lng'] < $point['right-top']['lng'])){
    //                         if(($v['lat']>$point['left-bottom']['lat']) && ($v['lat']<$point['right-top']['lat'])){
    //                             $addr = $v;
    //                             $addr_id = $v['addr_id'];
    //                             break;
    //                         }
    //                     }
    //                 }
    //             }
    //         }else{
    //             $addr = array('addr_id'=>0, 'uid'=>'', 'contact'=>'', 'mobile'=>'', 'addr'=>'','house'=>'', 'is_default'=>'0', 'lat'=>'0', 'lng'=>'');
    //         }
    //         $first_amount = 0;
    //         if(!$this->MEMBER['orders']){
    //             $first_amount = $shop['first_amount'];
    //         }
    //         $addr = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng', $addr);
    //         $data = array('hongbao_id'=>$hongbao_id, 'hongbao_count'=>$hongbao_count, 'hongbao'=>$hongbao,'first_amount'=>$first_amount, 'addr_id'=>$addr_id, 'addr'=>$addr);
    //         $this->msgbox->set_data('data', $data);
    //     }
    // }

    // public function delete($params)
    // {
    //     $this->check_login();
    //     if(!$order_id = (int)$params['order_id']){
    //         $this->msgbox->add('错误的订单ID',211);
    //     }else if(!$order = K::M('order/order')->detail($order_id)){
    //         $this->msgbox->add('不存在的订单',212);
    //     }else if($order['uid'] != $this->uid){
    //         $this->msgbox->add('你没有权限操作',213);
    //     }else if($order['order_status'] != (-1) || $order['order_status'] != 8){
    //         $this->msgbox->add('订单为不可删除状态',214);
    //     }else if(K::M('order/order')->delete($order_id)){
    //         $this->msgbox->add('success');
    //     }else{
    //         $this->msgbox->add('取消订单失败', 216);
    //     }
    // }
    
}
