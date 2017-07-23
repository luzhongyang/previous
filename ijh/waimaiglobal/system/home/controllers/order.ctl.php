<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Order extends Ctl
{
    // 待处理订单列表
    public function index()
    {
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['order_status'] = array(0,1,3,4);  // 0：未处理，1：已接单，3：配送开始，4：配送完成
        $orders = K::M('order/order')->items($filter,array('order_id'=>'desc'));
        $shop_ids = $order_ids = array();
        foreach ($orders as $k=>$val){
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        if($shop_ids){
            $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        }
        $products = K::M('order/product')->items(array('order_id'=>$order_ids),array('pid'=>'desc'));
        foreach ($products as $k=>$val){
            foreach($orders as $kk=>$v){
                if($v['order_id'] == $val['order_id']){
                    $orders[$kk]['count'] +=$val['product_number'];
                }
            }
        }
        $this->pagedata['orders'] = $orders;
        $this->tmpl = 'order/index.html';  
    }

    // 已完成订单列表
    public function orderwell()
    {   
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['order_status'] = array(-1,8); //-1:已取消 8：订单完成

        $orders = K::M('order/order')->items($filter,array('order_id'=>'desc'));
        $shop_ids = $order_ids = array();
        foreach ($orders as $k=>$val){
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        if($shop_ids){
            $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        }
        $products = K::M('order/product')->items(array('order_id'=>$order_ids),array('pid'=>'desc'));
        foreach ($products as $k=>$val){
            foreach($orders as $kk=>$v){
                if($v['order_id'] == $val['order_id']){
                    $orders[$kk]['count'] +=$val['product_number'];
                }
            }
        }
        $this->pagedata['orders'] = $orders;
        $this->tmpl = 'order/orderwell.html';
    }

    public function order($shop_id)
    {   
        $this->check_login();
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add(L('商家不存在'), 221)->response();
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
             $this->msgbox->add(L('商家不存在'), 222)->response();
        }
        $cur_time = (float)date("H.i", __TIME);
        $yy_stime = (float)str_replace(':', '.', $detail['yy_stime']);
        $yy_ltime = (float)str_replace(':', '.', $detail['yy_ltime']);
        if(empty($detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
            $this->msgbox->add(L('商家已经打烊不可下单'), 223);
        }
        $product_list = $this->getcart($shop_id);
        if(empty($product_list)){
            $this->msgbox->add(L('您还没有点餐呢'),223)->response();
        }
        $product_number = $package_price = $product_price = 0;
        $products = "";
        foreach($product_list as $k=>$v){
            if($v['shop_id'] != $shop_id){
                $this->msgbox->add(L('商品不是同一家商家的'),202)->response();
            }else if($v['sale_type'] == 1 && (($v['sale_sku']-$v['sale_count']) < $v['cart_num'])){
                $this->msgbox->add(L('商品库存不足'),211)->response();
            }else{
                $product_list[$k]['amount'] = ($v['price'] + $v['package_price']) * $v['cart_num'];
                $product_number += $v['cart_num'];
                $product_price += $v['price']  * $v['cart_num'];
                $package_price += $v['package_price'] * $v['cart_num'];
                $products .= $v['product_id'].":".$v['cart_num'].',';
            }
        }
        $this->pagedata['products'] = substr($products, 0, -1);
        if($product_price < $shop_detail['min_amount']){
               $this->msgbox->add(L('没有达到配送要求'), 212)->response();
            }
        
        if(!K::M('order/order')->count(array('uid'=>$this->uid))){
            $first_youhui = $detail['first_amount'];
        }else{
            $first_youhui = 0;
        }
        
        $first_price = $yh_price = $product_price - $first_youhui;
        if($youhui = K::M('shop/youhui')->order_youhui($shop_id,$first_price)){
            $yh_price = $first_price - $youhui['youhui_amount'];
        } 
        if($hongbao = K::M('hongbao/hongbao')->get_hongbao($this->uid,$yh_price)){
            $hongbao_price = $yh_price - $hongbao['amount'];
        }else{
            $hongbao_price = $yh_price;
        }
        $total_price = $hongbao_price + $package_price + $detail['freight'];
        $total_youhui = $first_youhui + $youhui['youhui_amount'] + $hongbao['amount'];
        
        $res = K::M('order/order')->get_time();
        $set_time['start'] = $res['start'];
        $set_time['start_quarter'] = $res['start_quarter'];
        $stime = $res['start'].":".$res['start_quarter']*15;
        $rr = explode(':',$detail['yy_ltime']);
        $set_time['end'] = $rr[0];
        $set_time['end_quarter'] = $rr[1]/15;
        $ltime = $res['start'].":".$res['start_quarter']*15;
        if($stime > $detail['yy_ltime']){
           $set_time = array();
        }
        $this->pagedata['set_time'] = $set_time;
        if(!$m_addr = K::M('member/addr')->find(array('uid'=>$this->uid,'is_default'=>1))){
            $m_addr = K::M('member/addr')->find(array('uid'=>$this->uid));
        }
        if($member = K::M('member/member')->detail($this->uid)) {
            $this->pagedata['mymoney'] = $member['money'];
        }
        $this->pagedata['total'] = $total_price + $total_youhui;
        $this->pagedata['total_price'] = $total_price;
        $this->pagedata['total_youhui'] = $total_youhui;
        $this->pagedata['hongbao'] = $hongbao;
        $this->pagedata['youhui'] = $youhui;
        $this->pagedata['yh_price'] = $yh_price;
        $this->pagedata['first_youhui'] = $first_youhui;
        $this->pagedata['package_price'] = $package_price;
        $this->pagedata['product_list'] = $product_list;
        $this->pagedata['detail'] = $detail;
        $this->pagedata['maddr'] = $m_addr;
        $this->tmpl = 'order/order.html';  
    }

    public function create()
    {
        $this->check_login();
        if(IS_AJAX){
            if($params = $this->checksubmit('params')){
                $pei_time = $pei_time_start =  $pei_time_last = 0;
                if(preg_match('/^(\d{2}\:\d{2})\-(\d{2}\:\d{2})$/i', $params['pei_time'], $m)){
                    $pei_time = $params['pei_time'];
                    $pei_time_start = $m[1];
                    $pei_time_last = $m[2];
                }
                $note = $params['note'];
                if(!$shop_id = (int) $params['shop_id']){
                    $this->msgbox->add(L('商家不存在'), 221);
                }else if(!$shop_detail = K::M('shop/shop')->detail($shop_id)){
                    $this->msgbox->add(L('商家不存在'), 222);
                }else if($shop_detail['audit']!=1||$shop_detail['closed']!=0){
                    $this->msgbox->add(L('商家不存在或已被删除'), 223);
                }else{
                    $cur_time = (float)date("H.i", __TIME);
                    $yy_stime = (float)str_replace(':', '.', $shop_detail['yy_stime']);
                    $yy_ltime = (float)str_replace(':', '.', $shop_detail['yy_ltime']);
                    $pei_stime = (float)str_replace(':', '.', $pei_time);
                    if(empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                        $this->msgbox->add(L('商家已经打烊不可下单'),223);
                    }else if($pei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                        $this->msgbox->add(L('配送时间不在商家营业范围'),223);
                    }else if(!$products = $params['products']){
                        $this->msgbox->add(L('您还没有点餐呢'),201);
                    }else if(!$addr_id = (int)$params['addr_id']){
                        $this->msgbox->add(L('请输入收货地址'),206);
                    }else if(!$addr_detail = K::M('member/addr')->detail($addr_id)){
                        $this->msgbox->add(L('收货地址不存在'),207);
                    }else if(K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat'])>$shop_detail['pei_distance']*1000){                        
                        $this->msgbox->add(L('超出配送范围'),208);
                    }else{
                        $products = explode(',',$products);
                        $product_ids = $product_numbers = $order_product_list = array();
                        foreach ($products as $key => $val) {
                            $local = explode(':',$val);
                            $local[0] = (int) $local[0];
                            $local[1] = (int) $local[1];
                            if (!empty($local[0]) && !empty($local[1]) && $local[1] > 0) {
                                $product_ids[$local[0]] = $local[0];
                                $product_numbers[$local[0]] = $local[1];
                            }
                        }
                        $product_price = $package_price = $product_number = $hongbao_amount = $first_youhui = $youhui_amount = $pei_amount  = $money = $amount = 0;
                        $freight = $shop_detail['freight'];
                        $product_list = K::M('product/product')->items_by_ids($product_ids);
                        foreach($product_list as $k=>$v){
                            if($v['shop_id'] != $shop_detail['shop_id']){
                                $this->msgbox->add(L('商品不是同一家商家的'),202)->response();
                            }else if($v['sale_type'] == 1 && (($v['sale_sku']-$v['sale_count']) < $product_numbers[$k])){
                                $this->msgbox->add(L('商品库存不足'),211)->response();
                            }else{
                                $_pamount = ($v['price'] + $v['package_price']) * $product_numbers[$k];
                                $order_product_list[$k] = array(
                                    'product_id'=>$k,
                                    'sale_type'=>$v['sale_type'],
                                    'product_number'=>$product_numbers[$k],
                                    'product_name'=>$v['title'],
                                    'product_price'=>$v['price'],
                                    'package_price'=>$v['package_price'],
                                    'amount'=> $_pamount
                                );
                                $product_number += $product_numbers[$k];
                                $product_price +=$v['price'] * $product_numbers[$k];
                                $package_price +=$v['package_price'] * $product_numbers[$k];

                            }
                        }
                        if($product_price < $shop_detail['min_amount']){
                           $this->msgbox->add(L('没有达到配送要求'),212)->response();
                        }
                        $data = array(
                            'shop_id' => $shop_id,
                            'city_id' => $shop_detail['city_id'],
                            'uid' => $this->uid,
                            'product_number' => $product_number,
                            'product_price' => $product_price,
                            'package_price' => $package_price,
                            'freight'=>$freight,
                            'amount' => $product_price+$package_price+$freight,
                            'contact' => $addr_detail['contact'],
                            'mobile' => $addr_detail['mobile'],
                            'addr' => $addr_detail['addr'],
                            'house' => $addr_detail['house'],
                            'lng' => $addr_detail['lng'],
                            'lat' => $addr_detail['lat'],
                            'online_pay' => 0,
                            'pei_time' => $params['pei_time'],
                            'note' => $note,
                            'order_from'=> (defined('IN_WEIXIN') ? 'weixin' : 'wap')
                        );

                        $data['pei_type'] = $shop_detail['pei_type'];
                        $data['pei_amount'] = $shop_detail['pei_amount'];
                        if($params['online_pay']){
                            $data['online_pay'] = 1;
                            if($shop_detail['first_amount'] && !$this->MEMBER['orders']){
                                $data['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                            }
                            if($youhui_detail = K::M('shop/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                                $data['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                            }

                            if($hongbao_id = (int)$params['hongbao_id']){
                                if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                                    $this->msgbox->add(L('红包不存在'),203)->response();
                                }else if($hongbao_detail['uid'] != $this->uid){
                                    $this->msgbox->add(L('非法操作'),204)->response();
                                }else if($hongbao_detail['order_id']){
                                    $this->msgbox->add(L('红包已经被使用'),205)->response();
                                }else if($hongbao_detail['ltime'] < __TIME){
                                    $this->msgbox->add(L('红包已过期不能使用'),244)->response();
                                }else if($hongbao_detail['min_amount'] > ($product_price-$first_youhui-$youhui_amount)){
                                    $this->msgbox->add(L('红包不满足使用条件'),205)->response();
                                }else{
                                    $data['hongbao_id'] = $hongbao_id;
                                    $data['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                                }
                            }
                            $data['amount'] = $amount = $product_price + $package_price + $freight - $youhui_amount - $first_youhui - $hongbao_amount;
                            if($this->MEMBER['money']>0 && ($passwd = $params['passwd'])){
                                if(md5($passwd) == $this->MEMBER['passwd']){
                                    if($this->MEMBER['money'] >= $amount){
                                        K::M('member/member')->update_money($this->uid, -$amount, L('订单抵扣金额'));
                                        $data['money'] = $money = $amount;
                                        $data['amount'] = $amount = 0;
                                        $data['pay_status'] = 1;
                                        $data['pay_code'] = 'money';
                                        $data['pay_time'] = __TIME;
                                        $data['pay_ip'] = __IP;
                                     }else{
                                        $data['money'] = $money = $this->MEMBER['money'];
                                        $data['amount'] = $amount = $amount - $money;
                                        K::M('member/member')->update_money($this->uid, -$money, L('订单抵扣金额'));
                                     }
                                }else{
                                    $this->msgbox->add(L('密码不正确'),255)->response();
                                }
                            }
                        }else{
                            $data['pei_type'] = 0;
                            $data['pei_amount'] = 0;
                        }

                        if($data['amount'] == 0) {
                            $data['pay_status'] = 1;
                        }

                        if($order_id = K::M('order/order')->create($data)){
                            foreach ($order_product_list as $k=>$val){
                                $val['order_id'] = $order_id;
                                K::M('order/product')->create($val);
                                K::M('product/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                                if($val['sale_type'] ==1){
                                     K::M('product/product')->update_count($val['product_id'],'sale_count', $val['product_number']);
                                }
                            }
                            if($youhui_detail){
                                K::M('shop/youhui')->update_count($youhui_detail['youhui_id'],'use_count',1);
                            }
                            if($hongbao_detail){
                                K::M('hongbao/hongbao')->update($hongbao_id, array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                            }
                            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>L('订单已提交'),'type'=>1));
                            K::M('shop/msg')->create(array('shop_id'=>$shop_id,'title'=>L('订单已提交'),'content'=>L('订单已提交'),'is_read'=>0,'type'=>1,'order_id'=>$order_id));

                            //更新微信模版消息 -- 提交
                            if ($this->MEMBER['wx_openid']) {
                                //获取模版消息配置 --订单已提交
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title'=>'您的订单已提交！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('您的订单已提交')), 'remark' =>sprintf(L('您的订单于%s提交成功'), date('Y-m-d H:i:s',__TIME)));
                                $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                                K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);    
                            }
                            if($data['pay_status']==1){
                                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>L('订单余额支付成功'),'type'=>2));
                                K::M('shop/msg')->create(array('shop_id'=>$shop_id,'title'=>L('订单余额支付成功'),'content'=>L('订单余额支付成功'),'is_read'=>0,'type'=>1,'order_id'=>$order_id));
                                //更新模版消息 -- 订单已支付支付
                                if ($this->MEMBER['wx_openid']) {
                                    //获取模版消息配置
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title'=>L('您的订单已支付'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' =>L('您的订单已支付')), 'remark' =>sprintf(L('您的订单于%s支付成功'), date('Y-m-d H:i:s',__TIME)));
                                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);    
                                }
                            }
                            K::M('shop/shop')->update_count($shop_id, 'orders', 1);
                            K::M('member/member')->update_count($this->uid, 'orders', 1);
                            $this->msgbox->add(L('SUCCESS'));
                            $this->msgbox->set_data('order_id',$order_id);
                            $this->msgbox->set_data('pay_status',$data['pay_status']);
                            $this->msgbox->set_data('online_pay',$data['online_pay']);
                            
                        }
                    }
                }
            } 
        }
    }

    
    public function pay($order_id)
    {
       $order_id = (int)$order_id;
       if(!$order_id){
           $this->msgbox->add(L('订单不存在'),211);
       }else if(!$detail = K::M('order/order')->detail($order_id)){
           $this->msgbox->add(L('订单不存在'),212);
       }else if($detail['pay_status'] ==1){
           $this->msgbox->add(L('订单已支付'),213);
       }else if($detail['online_pay'] == 0){
           $this->msgbox->add(L('您选择了货到付款'),214);
       }else if($detail['order_status'] >0){
           $this->msgbox->add(L('订单不能支付'),215);
       }
       
       if(defined('IN_WEIXIN')){
           $this->pagedata['weixin'] = 1;
       }
       
        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'order/pay.html';  
    }

    public function remark()
    {   
        $this->check_login();
        $notes = K::M('order/order')->get_note();
        $this->pagedata['notes'] = $notes;
        $this->tmpl = 'order/remark.html';  
    }
    
    public function cpmplaint($order_id)
    {
        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
            $this->msgbox->response();
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
            $this->msgbox->response();
        }else if($order['order_status'] < 1){
            $this->msgbox->add(L('该订单暂时不可投诉'),213);
            $this->msgbox->response();
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),214);
            $this->msgbox->response();
        }
        $this->pagedata['order_id'] = $order_id;
        $this->tmpl = 'order/cpmplaint.html';
    }
    
    public function cpmplaint_handle($order_id){
        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),222);
        }else if($order['order_status'] < 1){
            $this->msgbox->add(L('该订单暂时不可投诉'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!$title = $this->GP('title')){
            $this->msgbox->add(L('请选择投诉类型'),214);
        }else if(!$content = $this->GP('content')){
            $this->msgbox->add(L('请填写投诉内容'),215);
        }else if($check = K::M('order/complaint')->find(array('uid'=>$this->uid,'order_id'=>$order_id))){
            $this->msgbox->add(L('该订单已经投诉过了'),216);
        }else{
            
            $data = array(
                'order_id'=>$order_id,
                'uid'=>$this->uid,
                'shop_id'=>$order['shop_id'],
                'staff_id'=>$order['staff_id'],
                'title'=>$title,
                'content'=>$content
            );
            $data2 = array(
                'shop_id'=>$order['shop_id'],
                'title'=>$title,
                'content'=>$content,
                'is_read'=>0,
                'type'=>3,
                'order_id'=>$order_id
            );
            if(!$add = K::M('order/complaint')->create($data)){
                $this->msgbox->add(L('FAIL'),217);
            }else{
                K::M('shop/msg')->create($data2);
                if($staff = $order['staff_id']) {
                    $data3 = array(
                        'staff_id'  => $staff,
                        'title'     => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order['contact'], $order['order_id']),
                        'content'   => $content,
                        'is_read'   => 0,
                        );
                    K::M('staff/msg')->create($data3);
                }
                $this->msgbox->add(L('SUCCESS'));
            }
        }
    }
    
    public function comment($order_id)
    {

        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
            $this->msgbox->response();
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),221);
            $this->msgbox->response();
        }else if($order['order_status'] != 8){
            $this->msgbox->add(L('订单不可评价'),212);
            $this->msgbox->response();
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
            $this->msgbox->response();
        }else if($order['comment_status'] != 0){
            $this->msgbox->add(L('订单已经评价过了'),214);
            $this->msgbox->response();
        }else{
            $shop = K::M('shop/shop')->detail($order['shop_id']);
        }
        if($res = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$order['shop_id']))){
            $shop['collect'] = 1;
        }else{
            $shop['collect'] = 0;
        }
        
        $peitime = K::M('shop/comment')->peitime();
        $jifen = K::M('system/config')->get('jifen');
        
        $this->pagedata['peitime'] = $peitime;
        $this->pagedata['jifen'] = intval($order['amount']*$jifen['jifen_ratio']);
        $this->pagedata['shop'] = $shop;
        $this->pagedata['order'] = $order;
        $this->tmpl = 'order/comment.html';  
    }
    
    
    public function comment_handle()
    {
        $this->check_login();
        if($this->checksubmit()){
            
            $data = array('post'=>$this->GP('data'), 'file'=>$_FILES);
            $datas = $data['post'];
            $datas['uid'] = $this->uid;

            if(!$this->uid){
                $this->msgbox->add(L('NOLOGIN'),101);
            }else if(!$datas['score_fuwu'] || $datas['score_fuwu'] < 1 || $datas['score_fuwu'] > 5){
                $this->msgbox->add(L('请给服务态度打分'),211);
            }else if(!$datas['pei_time']){
                $this->msgbox->add(L('请选择配送速度'),212);
            }else if(!$datas['score_kouwei'] || $datas['score_kouwei'] < 1 || $datas['score_kouwei'] > 5){
                $this->msgbox->add(L('请给菜品口味打分'),213);
            }else if(!$datas['score'] || $datas['score'] < 1 || $datas['score'] > 5){
                $this->msgbox->add(L('请给综合评分打分'),214);
            }else if(!$datas['content']){
                $this->msgbox->add(L('请填写评价内容'),215);
            }else if(!$datas['order_id']){
                $this->msgbox->add(L('订单不存在'),216);
            }else if(!$order = K::M('order/order')->detail($datas['order_id'])){
                $this->msgbox->add(L('订单不存在'),216);
            }else{
                    $datas['shop_id'] = $order['shop_id'];
                    if($data['file']){
                        $datas['have_photo'] = 1;
                    }
                    if($create = K::M('shop/comment')->create($datas)){
                        if($data['file']){
                            //插入评价
                            foreach($data['file'] as $k => $v){
                                if($a = K::M('magic/upload')->upload($v,'photo')){
                                    $photo_data = array(
                                        'comment_id' => $create,
                                        'photo' => $a['photo']
                                    );
                                    $create_photo = K::M('shop/photo') -> create($photo_data);
                                }
                            }
                        }
                        $shop = K::M('shop/shop') -> detail($order['shop_id']);
                        
                        $pei_time = intval(($datas['pei_time'] + $shop['pei_time']*$shop['comments'])/($shop['comments']+1));
                        
                        if($datas['score']>3){
                            $update_data = array('comments'=>'`comments`+1','praise_num'=>'`praise_num`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_time);
                        }else{
                           $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_time);
                        }
                        K::M('shop/shop')->update($order['shop_id'],$update_data,true);
                        K::M('order/order')->update($datas['order_id'],array('comment_status'=>1));
                        $jifen = $this->system->config->get('jifen');
                        $jifen_total = (int)(($order['product_price'] + $order['package_price'])*$jifen['jifen_ratio']);
                        K::M('member/member')->update_jifen($this->uid,$jifen_total, sprintf(L('订单%s评价完成，获得积分'), $data['order_id']));
                        K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>L('订单已评价'),'content'=>sprintf(L('用户(%s)已评价订单(ID:%s)'), $order['contact'], $order['order_id']),'is_read'=>0,'type'=>2,'order_id'=>$order['order_id']));
                        $this->msgbox->add(L('SUCCESS'));
                    }else{
                        $this->msgbox->add(L('FAIL'),217);
                    }  
            }
            
        }
        
    }
    
    // 订单进度
    public function work($order_id) 
    { 
        $this->check_login();
        $log_type = NULL;
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else {
            $time = time();
            if($order['dateline']+1800 < $time){
                if($order['order_status'] != (-1)){
                  $this->pagedata['reload'] = 1;
                  $this->chargeback($order['order_id']);  
                }
            }

            $filter = array();
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])) {
                $this->msgbox->add(L('商家不存在'),214);
            }else{
                $shop = $this->filter_fields('shop_id,phone',$shop);
            }
              
            if(!$staff = K::M('staff/staff')->detail($order['staff_id'])) {
                $this->msgbox->add(L('配送员不存在'),215);
            }else{
                $staff = $this->filter_fields('staff_id,name,mobile',$staff);
            }
            // 订单日志
            if($order['order_status']==0 && $order['pay_status']==0) {
                $log_type = 1;   
            }else if($order['order_status']==1 && $order['pay_status']==0) {
                $log_type = array(1,3); 
            }else if($order['order_status']==2 && $order['pay_status']==0 && $order['staff_id']>0) {
                $log_type = array(1,2,3);
            }else if($order['order_status']==3 && $order['pay_status']==0 && $order['staff_id']>0) {
                $log_type = array(1,2,3,4);
            }else if($order['order_status']==4 && $order['pay_status']==0 && $order['staff_id']>0) {
                $log_type = array(1,2,3,4,5);
            }else if($order['order_status']==3 && $order['pay_status']==0) {
                $log_type = array(1,3,4);
            }else if($order['order_status']==8 && $order['pay_status']==0) {
                $log_type = array(1,3,4,6);
            }else if($order['order_status']==-1 && $order['pay_status']==0) {
                $log_type = array(-1,1);
            }else if($order['order_status']==0 && $order['pay_status']==1) {
                $log_type = array(1,2); 
            }else if($order['order_status']==1 && $order['pay_status']==1) {
                $log_type = array(1,2,3); 
            }else if($order['order_status']==2 && $order['pay_status']==1 && $order['staff_id']>0) {
                $log_type = array(1,2,3);
            }else if($order['order_status']==3 && $order['pay_status']==1 && $order['staff_id']>0) {
                $log_type = array(1,2,3,4);
            }else if($order['order_status']==4 && $order['pay_status']==1 && $order['staff_id']>0) {
                $log_type = array(1,2,3,4,5);
            }else if($order['order_status']==3 && $order['pay_status']==1) {
                $log_type = array(1,2,3,4); 
            }else if($order['order_status']==8 && $order['pay_status']==1) {
                $log_type = array(1,2,3,4,6); 
            }else if($order['order_status']==-1 && $order['pay_status']==1) {
                $log_type = array(-1,1);
            }

            $filter['order_id'] = $order_id;
            $filter['type'] = $log_type;
            if(!$log_list = K::M('order/log')->items($filter,array('log_id'=>'desc'))){
                $this->msgbox->add(L('订单日志不存在'),215);
            }
            $log_list = array_values($log_list);
            $last_time = $order['dateline'] + 1800;
        }
        $this->pagedata['log_type'] = $log_type;
        $this->pagedata['last_time'] = $last_time;
        $this->pagedata['order'] = $order;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['staff'] = $staff;
        $this->pagedata['logs'] = $log_list;
        $this->tmpl = 'order/work.html';
    }
    
    // 订单详情
    public function detail($order_id) 
    {
        $this->check_login();
        $proids = $filter = array();
        if(!$order_id = (int)$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else{
            $time = time();
            if($order['dateline']+1800 < $time && $order['online_pay'] == 1 && $order['pay_status'] == 0){
                if($order['order_status'] != (-1)){
                  $this->pagedata['reload'] = 1;
                    $this->chargeback($order['order_id']);  
                }
            }
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array();
            }else{
                $shop = $this->filter_fields('shop_id,title,phone,logo',$shop);
            }
            if($order['order_status']==0 && $order['pay_status']==0) {
                $log_type = 1;  
            }else if($order['order_status']==1 && $order['pay_status']==1) {
                $log_type = array(1,2,3); 
            }else if($order['order_status']==3 && $order['pay_status']==1) {
                $log_type = array(1,2,3,4); 
            }else if($order['order_status']==8 && $order['pay_status']==1) {
                $log_type = array(1,2,3,4,5); 
            }else if($order['order_status']==-1 && $order['pay_status']==0) {
                $log_type = array(-1,1);
            }
            $filter['order_id'] = $order_id;
            $filter['type'] = $log_type;
            if(!$log_list = K::M('order/log')->items($filter,array('log_id'=>'desc'))){
                $this->msgbox->add(L('订单日志不存在'),214);
            }
            $logs = array_values($log_list);

            if($order_product = K::M('order/product')->items(array('order_id'=>$order_id))) {
                foreach($order_product as $k => $v){
                    $product = K::M('product/product')->find(array('product_id'=>$v['product_id']));
                    $product['numbers'] = $v['product_number'];
                    $items[] = $product; 
                }
            }
            $last_time = $order['dateline'] + 1800;

        }
        $this->pagedata['last_time'] = $last_time;
        $this->pagedata['pro'] = $items;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['order'] = $order;
        $this->pagedata['logs'] = $logs;
        $this->tmpl = 'order/detail.html';
    } 

    // 申请退单
    public function chargeback($order_id) 
    {
        $this->check_login();
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'),214);
        }else if($order['order_status'] != 0){
             $this->msgbox->add(L('当前订单是不可取消的状态'),215);
        }else{
            if(K::M('order/order')->cancel($order_id, $order, 'member')) {
                $data = array(
                    'shop_id'=>$order['shop_id'],
                    'title'=>L('订单已取消'),
                    'content'=>sprintf(L('用户(%s)已取消订单(ID:%s)'), $order['contact'], $order_id),
                    'is_read'=>0,
                    'type'=>1,
                    'order_id'=>$order_id
                    );
                K::M('shop/msg')->create($data);
                $this->msgbox->add(L('SUCCESS'));
            }else {
                $this->msgbox->add(L('FAIL'),216);
            }
        }
    } 

    // 催单
    public function remind()
    {
        $this->check_login();
        $order_id = $this->GP('order_id');
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else if((__TIME - $order['cui_time'])<600){
            $this->msgbox->add(L('已经催过，请稍后再试'),216);
        }else if(K::M('order/order')->update($order_id, array('cui_time'=>__TIME))) {
            $data = array(
                'shop_id'=>$order['shop_id'],
                'title'=> L('用户正在催单'),
                'content'=> sprintf(L('用户(%s)正在催促订单(ID:%s)'), $order['contact'], $order_id),
                'is_read'=>0,
                'type'=>1,
                'order_id'=>$order_id
                );
            K::M('shop/msg')->create($data);
            if($staff = $order['staff_id']) {
                $data2 = array(
                    'staff_id'  => $staff,
                    'title'    => L('用户正在催单'),
                    'content'  => sprintf(L('用户(%s)正在催促订单(ID:%s)'), $order['contact'], $order_id),
                    'is_read'  => 0,
                    );
                K::M('staff/msg')->create($data2);
            }
            $this->msgbox->add(L('SUCCESS'));
        }else {
            $this->msgbox->add(L('FAIL'),214);
        }
    }

    // 确认送达
    public function getwell() 
    {
        $this->check_login();
        $inviteCfg = $this->system->config->get('invite');
        $order_id = $this->GP('order_id');
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status']==8){
            $this->msgbox->add(L('订单已经确认,无需重复确认'),214);
        }else if(!in_array($order['order_status'], array(1,3,4))){
            $this->msgbox->add(L('商家还未配送完成不可确认'),215);
        }else if(K::M('order/order')->confirm($order_id, null, 'member')){
            $this->msgbox->add(L('SUCCESS')); 
        }else {
            $this->msgbox->add(L('FAIL'),222);
        }
    }

    // 再来一份
    public function onemore()
    {
        $this->check_login();
        $ele = array();
        $order_id = $this->GP('order_id');
        if(!$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else {
            if($order_product = K::M('order/product')->items(array('order_id'=>$order_id))) {
                $ele = array();
                foreach($order_product as $k => $v){
                    $product = K::M('product/product')->find(array('product_id'=>$v['product_id']));
                    $order_product[$k]['cate_id'] = $product['cate_id'];
                    $product['num'] = $v['product_number'];
                    $product['price'] = $v['product_price'];
                    if($product['sale_type']== 1){
                        $product['sku'] = $product['sale_sku'] - $product['sale_count'];
                        if($product['sku'] == 0) {
                            unset($product['product_id']);
                        }
                    }else {
                        $product['sku'] = 999;
                    }
                    unset($product['photo'],$product['sales'],$product['shop_id'],$product['sale_sku'],$product['sale_type'],$product['sale_count']);
                    unset($product['intro'],$product['orderby'],$product['closed'],$product['clientip'],$product['dateline']);
                    $ele[$v['product_id']] = $product;
                }
                $cart = (array) json_decode($_COOKIE['ele']);
                foreach ($cart as $kk => $vv) {
                    foreach ($vv as $key => $v) {
                        $v = (array) $v;
                        $carts[$kk][$key] = $v;
                        if ($v['num'] == 0) {
                            unset($carts[$kk][$key]);
                        }
                    }
                }  
                $cart[$order['shop_id']] = $ele;
                setcookie("ele",json_encode($cart),time()+86400*30,'/');
            }
        }
    }  
       
    // 删除订单
    public function delorder($order_id) {
        if($order_id = (int)$order_id){
            if(!$order = K::M('order/order')->detail($order_id)){
                $this->msgbox->add(L('订单不存在或已被删除'), 211);
            }else if($order['comment_status']==0 && $order['order_status']==8) {
                $this->msgbox->add(L('订单还未评价'),212);
            }else{
                if(K::M('order/order')->delete($order_id)){
                    $this->msgbox->add(L('SUCCESS'));
                }
            }
        }
    }   
}