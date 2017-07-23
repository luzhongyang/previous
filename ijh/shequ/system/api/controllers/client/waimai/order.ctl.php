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
class Ctl_Client_Waimai_Order extends Ctl
{
    /*外卖创建订单
     * pei_time,配送时间
     * shop_id,商铺ID
     * products,
     * addr_id
     */
    public function create($params)
    {
        $this->check_login();
        // 验证并拆分用户要求送达时间
        $pei_time = $pei_time_start =  $pei_time_last = 0;
        if($opei_time = $params['pei_time']){
            $pei_time = explode('-',$params['pei_time']);
            $pei_time_start = $pei_time[0];
            $pei_time_last = $pei_time[1];
            $pei_time = strtotime(date('Y-m-d').' '.$pei_time_start);
        }else {
            $pei_time = 0;
        }
        // 订单备注
        if(!$shop_id = (int) $params['shop_id']){
            $this->msgbox->add('商家不能为空',221);
        }else if(!$shop_detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商家不存在或已删除',222);
        }else if(empty($shop_detail['audit'])){
            $this->msgbox->add('商户审核中不可下单',223);
        }else{
            $cur_time = (float)date("H.i", __TIME);
            $yy_stime = (float)str_replace(':', '.', $shop_detail['yy_stime']);
            $yy_ltime = (float)str_replace(':', '.', $shop_detail['yy_ltime']);
            $pei_stime = (float)str_replace(':', '.', $opei_time);
            if(empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                $this->msgbox->add('商家已经打烊不可下单',224);
            }else if($opei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                $this->msgbox->add('配送时间不在商家营业范围',225);
            }else if(!$products = $params['products']){
                $this->msgbox->add('您还没有订餐呢',226);
            }else if($params['pei_type'] == 3 && !$shop_detail['is_ziti']){
                $this->msgbox->add('该商户不支持自提',226);
            }else if($params['online_pay'] && !$shop_detail['online_pay']){
                $this->msgbox->add('该商户不支持在线支付',226);
            }else if(!$params['online_pay'] && !$shop_detail['is_daofu']){
                $this->msgbox->add('该商户不支持货到付款',226);
            }else if($params['pei_type'] != 3 && !($addr_id = (int)$params['addr_id'])){
                $this->msgbox->add('请选择地址',227);
            }else if($params['pei_type'] != 3 && !($addr_detail = K::M('member/addr')->detail($addr_id))){
                $this->msgbox->add('地址不存在',228);
            }else if($params['pei_type'] != 3 && K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat']) > ($shop_detail['pei_distance']*1000)){
               $this->msgbox->add('超出配送范围',229);
            }else{
                $data_order = $data_waimai = array();
                // 验证订单商品信息
                //1:2:1,2:2
                //商品ID:规格ID:数量
                $products = explode(',',$products);
                foreach($products as $key=>$pro){
                    $products[$key] = explode(':', $pro);
                }
                $product_ids = $spec_ids = $product_numbers = $product_specids = $order_product_list = array();
                foreach($products as $key=>$value){
                    $len  =  count($value);
                    if($len > 2){
                        $pk = $value[0] .'-'. $value[1];
                        $product_ids[$value[0]] = $value[0];
                        $spec_ids[$value[1]] = $value[1];
                        $product_numbers[$pk] = $value[2];
                        $cart_product_list[$pk] = array('product_id'=>$value[0], 'number'=>$value[2], 'spec_id'=>$value[1]);
                    }else{
                        $pk = $value[0];
                        $product_ids[$value[0]] = $value[0];
                        $product_numbers[$pk]   = $value[1];
                        $cart_product_list[$pk] = array('product_id'=>$value[0], 'number'=>$value[2], 'spec_id'=>$value[1]);
                    }
                }
                // foreach ($products as $key => $val) {
                //
                //     if(preg_match('/^(\d+):(\d+):(\d+)$/', $val, $local)){
                //         $pk = $local[1].'-'.$local[3];
                //         $product_ids[$local[1]] = $local[1];
                //         $spec_ids[$local[3]] = $local[3];
                //         $product_numbers[$pk] = $local[2];
                //         $cart_product_list[$pk] = array('product_id'=>$local[1], 'number'=>$local[2], 'spec_id'=>$local[3]);
                //     }
                // }
                $product_price = $package_price = $product_number = $hongbao_amount = $first_youhui = $youhui_amount = $pei_amount  = $money = $amount = 0;
                $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($cart_product_list as $pk=>$v){
                    if(!$p = $product_list[$v['product_id']]){
                        //购物车的商品实际不存在
                    }if($p['shop_id'] != $shop_detail['shop_id']){
                        $this->msgbox->add('商品不是同一家商家的',230)->response();
                    }else if($p['is_spec']){
                        $sp = $spec_lists[$v['spec_id']];
                        if(!$v['spec_id'] && $sp){
                            //商品未选规格sku
                            $this->msgbox->add('商品未选规格',231)->response();
                        }else if($sp['product_id'] != $v['product_id']){
                            //选择规格与商品ID关联不符
                            $this->msgbox->add('选择规格与商品ID关联不符',232)->response();
                        }else if($p['sale_type'] == 1 && ($sp['sale_sku'] < $product_numbers[$pk])){
                            $this->msgbox->add('商品库存不足',233)->response();
                        }else{
                            $_pamount = ($sp['price'] + $p['package_price']) * $product_numbers[$pk];
                            $order_product_list[$pk] = array(
                                'product_id'      => $v['product_id'],
                                'spec_id'         => $v['spec_id'],
                                'sale_type'       => $p['sale_type'],
                                'product_number'  => $product_numbers[$pk],
                                'product_name'    => $p['title']."({$sp['spec_name']})",
                                'product_price'   => $sp['price'],
                                'package_price'   => $p['package_price'],
                                'amount'          => $_pamount
                            );
                            $product_number += $product_numbers[$pk];
                            $product_price +=$sp['price'] * $product_numbers[$pk];
                            $package_price +=$p['package_price'] * $product_numbers[$pk];
                        }
                    }else{
                        if($p['sale_type'] == 1 && ($p['sale_sku'] < $product_numbers[$pk])){
                            $this->msgbox->add('商品库存不足',211)->response();
                        }else{
                            $_pamount = ($p['price'] + $p['package_price']) * $product_numbers[$pk];
                            $order_product_list[$pk] = array(
                                'product_id'       => $v['product_id'],
                                'spec_id'          => 0,
                                'sale_type'        => $p['sale_type'],
                                'product_number'   => $product_numbers[$pk],
                                'product_name'     => $p['title'],
                                'product_price'    => $p['price'],
                                'package_price'    => $p['package_price'],
                                'amount'           => $_pamount
                            );
                            $product_number += $product_numbers[$pk];
                            $product_price +=$p['price'] * $product_numbers[$pk];
                            $package_price +=$p['package_price'] * $product_numbers[$pk];
                        }
                    }
                }                
                if($product_price < $shop_detail['min_amount']){
                   $this->msgbox->add('没有达到配送要求',212)->response();
                }
                $data_order = array(
                    'city_id'            => $shop_detail['city_id'],
                    'shop_id'            => $shop_id,
                    'staff_id'           => 0,
                    'uid'                => $this->uid,
                    'from'               => 'waimai',
                    'order_status'       => 0,
                    'product_number'     => $product_number,
                    'product_price'      => $product_price,
                    'package_price'      => $package_price,
                    'o_lat'              => $shop_detail['lat'],
                    'o_lng'              => $shop_detail['lng'],
                    'intro'              => (isset($params['intro']) ? $params['intro'] : $params['note']),
                    'pay_status'         => 0,
                    'pei_time'           => $pei_time,
                    'order_from'         => strtolower(CLIENT_OS)
                );
                if($params['pei_type'] == 3){
                    $data_order['amount'] = $product_price+$package_price;
                    $data_order['freight'] = 0;
                    $data_order['contact'] = $this->MEMBER['nickname'];
                    $data_order['mobile'] = $this->MEMBER['mobile'];
                    $data_order['pei_type'] = 3;
                    $data_order['pei_amount'] = 0;
                    $data_order['total_price'] = $product_price+$package_price;
                }else{
                    $juli = K::M('helper/round')->juli($shop_detail['lng'], $shop_detail['lat'], $addr_detail['lng'], $addr_detail['lat']);
                    $juli = ceil($juli/1000);
                    $_freight = array();
                    $_max_freight = array('fkm'=>0, 'fm'=>0);
                    foreach($shop_detail['freight_stage'] as $k=>$v){
                        if($juli <= $v['fkm']){
                            if($_freight && $_freight['fkm'] > $v['fkm']){
                                $_freight = $v;
                            }else if(empty($_freight)){
                                $_freight = $v;
                            }
                        }
                        if($v['fkm'] > $_max_freight['fkm']){
                            $_max_freight = $v;
                        }
                    }
                    $freight = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                    $p_amount = $_freight['sm'] ? $_freight['sm'] : $_max_freight['sm'];
                    
                    $data_order['amount'] = $product_price+$package_price + $freight;
                    $data_order['contact'] = $addr_detail['contact'];
                    $data_order['mobile'] = $addr_detail['mobile'];
                    $data_order['addr'] = $addr_detail['addr'];
                    $data_order['house'] = $addr_detail['house'];
                    $data_order['lng'] = $addr_detail['lng'];
                    $data_order['lat'] = $addr_detail['lat'];
                    $data_order['pei_type'] = $shop_detail['pei_type'];
                    $data_order['pei_amount'] = $p_amount;
                    $data_order['total_price'] = $product_price+$package_price+$freight;
                }
                if($params['online_pay'] == 1){
                    // 在线支付方式支付
                    $data_order['online_pay'] = 1;
                    if($shop_detail['first_amount'] && (K::M('order/order')->count(array('shop'=>$shop_id, 'uid'=>$this->uid, 'from'=>'waimai', 'order_status'=>'>=:0'))==0)){
                        $data_order['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                    }
                    if($youhui_detail = K::M('waimai/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                        $data_order['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                    }
                    if($hongbao_id = (int)$params['hongbao_id']){
                        if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                            $this->msgbox->add('红包不存在',203)->response();
                        }else if($hongbao_detail['uid'] != $this->uid){
                            $this->msgbox->add('红包信息不正确',204)->response();
                        }else if($hongbao_detail['order_id']){
                            $this->msgbox->add('该红包已经使用',205)->response();
                        }else if($hongbao_detail['ltime'] < __TIME){
                            $this->msgbox->add('红包已过期不能使用',244)->response();
                        }else if($hongbao_detail['min_amount'] > ($product_price-$first_youhui-$youhui_amount)){
                            $this->msgbox->add('该红包不能使用',205)->response();
                        }else{
                            $data_order['hongbao_id'] = $hongbao_id;
                            $data_order['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                        }
                    }
                    $amount = $product_price - $youhui_amount - $first_youhui - $hongbao_amount;
                    if($amount < 0){
                        $amount = 0;
                    }
                    //打包费用和配送费用不参与优惠(首单、满减、红包)
                    $amount = $amount + $package_price + $freight ;
                    $data_order['amount'] = $amount;
                }else{
                    // 货到付款方式支付
                    $data_order['online_pay'] = 0;
                }

                $data_order['wx_openid'] = $this->MEMBER['wx_openid'];
                // 创建主订单记录
                if($order_id = K::M('order/order')->create($data_order)) {
                    $data_waimai = array(
                        'order_id'         => $order_id,
                        'product_number'   => $product_number,
                        'product_price'    => $product_price,
                        'package_price'    => $package_price,
                        'freight'          => $freight,
                        );
                    // 创建附属表订单记录
                    $waimai_order_id = K::M('waimai/order')->create($data_waimai);
                    $order = K::M('waimai/order')->detail($order_id);
                    if($params['is_daofu']==1 && $order['pei_type']==3) { 
                        //如果是自提单且选择了到付，直接生成消费码
                        K::M('waimai/order')->create_number($order_id);
                    }else if($order['online_pay']==1 && $order['pay_status']==0 && $order['pei_type']==3) { 
                        //如果自提单选择了在线支付且未支付，支付成功之后生成消费码
                        K::M('waimai/order')->update($order_id, array('spend_number'=>0,'spend_status'=>0));
                    }
                    //写入waimai_order_product表
                    foreach ($order_product_list as $k=>$val){
                        $val['order_id'] = $order_id;
                        K::M('waimai/orderproduct')->create($val);
                        // 更新外卖商品库、销量
                       $_num = $val['product_number'];
                        if($val['spec_id']){
                            $up_sale_count = array('sale_sku'=>'`sale_sku`-'.$_num, 'sale_count'=>'`sale_count`+'.$_num);
                            K::M('waimai/productspec')->update($val['spec_id'], $up_sale_count, true);
                        }else{
                            $up_sale_count = array('sales'=>'`sales`+'.$_num,'sale_sku'=>'`sale_sku`-'.$_num, 'sale_count'=>'`sale_count`+'.$_num);
                            K::M('waimai/product')->update($val['product_id'], $up_sale_count, true);
                        }
                        // K::M('waimai/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        // if($val['sale_type'] ==1){
                        //     $_num = $val['product_number'];
                        //     if($val['spec_id']){
                        //         $up_spec_count = array('sale_sku'=>'`sale_sku`-'.$_num, 'sale_count'=>'`sale_count`+'.$_num);
                        //         K::M('waimai/productspec')->update($val['spec_id'], $up_spec_count, true);
                        //     }else{
                        //         K::M('waimai/product')->update_count($val['product_id'],'sale_count', $val['product_number']);
                        //         K::M('waimai/product')->update_count($val['product_id'],'sale_sku', -$val['product_number']);
                        //     }
                        // }
                    }
                    if($youhui_detail){
                        K::M('waimai/youhui')->update_count($youhui_detail['youhui_id'],'use_count',1);
                    }
                    if($hongbao_detail){
                        K::M('hongbao/hongbao')->update($hongbao_id, array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                    }
                    // 写入订单日志
                    K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                    // 货到付款的给商户发送订单消息
                    if(empty($order['online_pay'])){
                        if($order['pei_type'] == 3) { // 自提订单 创建消费码
                            K::M('waimai/order')->create_number($order_id);
                            $addr = '客户自提';
                        }else{
                            $addr = $order['addr'].$order['house'];
                        }
                        $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                        $content = sprintf("您有新的外卖订单(单号：%s)，货到付款，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                        K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newWaimaiOrder', $order_id);
                    }else if($data_order['pay_status']==1){                        
                        K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单支付成功','status'=>2));
                        if($order['pei_type'] == 3) { // 自提订单 创建消费码
                            K::M('waimai/order')->create_number($order_id);
                            $addr = '客户自提';
                        }else{
                            $addr = $order['addr'].$order['house'];
                        }
                        $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                        $content = sprintf("您有新的外卖订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                        K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newWaimaiOrder', $order_id);
                    }
                    // 更新商户订单量
                    K::M('waimai/waimai')->update_count($shop_id, 'orders', 1);
                    //更新库存
                    K::M('waimai/product')->updatesku_by_ids($product_ids);
                    // 更新用户订单量
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id'=>$order_id, 'amount'=>$data_order['amount']));
                }else{
                    if($money){ //下单失败退回余额
                        K::M('member/member')->update_money($this->uid, $money, '订单创建失败退回余额');
                    }
                    $this->msgbox->add('创建订单失败', 411);
                }
                
            }
        }
    }
    /*
     * @param shop_id
     * @param addr_id
     * @param amount
     */
    public function preinfo($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add('商家不存在', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在或已被删除', 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可下单',212);
        }else{
            $shop = $waimai = K::M('waimai/waimai')->detail($shop_id);
            if($shop['first_amount'] && (K::M('order/order')->count(array('shop'=>$shop_id, 'uid'=>$this->uid, 'from'=>'waimai', 'order_status'=>'>=:0'))==0)){
                $first_youhui = $shop['first_amount'];
            }else{
                $first_youhui = 0;
            }
            $youhui_info = array();
            $youhui_label = '';
            if($youhui_list = K::M('waimai/youhui')->items(array('shop_id'=>$shop['shop_id']))){
                $youhui_info = array();
                foreach($youhui_list as $v){
                    $youhui_info[] = $v['order_amount'].":".$v['youhui_amount'];
                }
                $youhui_label = implode(",", $youhui_info);
            }
            $hongbao_id = $addr_id = $hongbao_count = 0;
            $addr = array();
            $hongbao = array('hongbao_id'=>0, 'title'=>'', 'min_amount'=>'', 'amount'=>'','type'=>'', 'uid'=>'0', 'stime'=>'0', 'ltime'=>'','order_id'=>'0','used_time'=>'0','dateline'=>'');

            if($amount = (float)$params['amount']){
                $filter = array('uid'=>$this->uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0);
                if($hb_list = K::M('hongbao/hongbao')->items($filter, array('amount'=>'DESC'), 1, 1, $count)){
                    $hongbao = array_shift($hb_list);
                    $hongbao_id = $hongbao['hongbao_id'];
                    $hongbao_count = $count;
                }else{
                    $hongbao = array('hongbao_id'=>0, 'title'=>'', 'min_amount'=>'', 'amount'=>'','type'=>'', 'uid'=>'0', 'stime'=>'0', 'ltime'=>'','order_id'=>'0','used_time'=>'0','dateline'=>'');
                }
            }
            if($addr_id = (int)$params['addr_id']){
                if($addr = K::M('member/addr')->detail($addr_id)){
                    if($addr['uid'] != $this->uid){
                        $addr = array();
                    }else{
                        $addr['juli'] = K::M('helper/round')->juli($shop['lng'], $shop['lat'], $addr['lng'], $addr['lat']);
                    }
                }
            }

            if(empty($addr)){
                if($addr_list = K::M('member/addr')->items(array('uid'=>$this->uid), null, 1, 10)){
                    $pei_distance = $shop['pei_distance'] ? $shop['pei_distance'] : 5;
                    $_a = array();
                    foreach($addr_list as $k=>$v){
                        $v['juli'] = K::M('helper/round')->juli($shop['lng'], $shop['lat'], $v['lng'], $v['lat']);
                        if($v['juli'] <= $pei_distance*1000){
                            if(empty($addr) || ($addr['juli'] > $v['juli'])){
                                $addr = $v;
                                $addr_id = $v['addr_id'];
                            }
                        }
                        $addr_list[$k] = $v;
                    }
                }
            }            
            if(empty($addr)){
                $addr = array('addr_id'=>0, 'uid'=>'', 'contact'=>'', 'mobile'=>'', 'addr'=>'','house'=>'', 'is_default'=>'0', 'lat'=>'0', 'lng'=>'');
            }
            if($addr){
                //计算出对应的配送费
                $juli = ceil($addr['juli']/1000);
                $_freight = array();
                $_max_freight = array('fkm'=>0, 'fm'=>0);
                foreach($shop['freight_stage'] as $k=>$v){
                    if($juli <= $v['fkm']){
                        if($_freight && $_freight['fkm'] > $v['fkm']){
                            $_freight = $v;
                        }else if(empty($_freight)){
                            $_freight = $v;
                        }
                    }
                    if($v['fkm'] > $_max_freight['fkm']){
                        $_max_freight = $v;
                    }
                }
                $freight_stage = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                //计算出对应的配送费结束
            }else{
                $addr = array('addr_id'=>0, 'uid'=>'', 'contact'=>'', 'mobile'=>'', 'addr'=>'','house'=>'', 'is_default'=>'0', 'lat'=>'0', 'lng'=>'');
                $freight_stage = 0;
            }
            $addr = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng,juli', $addr);
            $data = array('hongbao_id'=>$hongbao_id, 'hongbao_count'=>$hongbao_count, 'hongbao'=>$hongbao, 'addr_id'=>$addr_id, 'addr'=>$addr, 'freight'=>$shop['freight'], 'first_amount'=>$first_youhui, 'youhui'=>$youhui_label,'youhui_info'=>$youhui_info);
            $data['freight_stage'] = $freight_stage;
            $shop = array(
                'yy_stime'=>$shop['yy_stime'],
                'yy_ltime'=>$shop['yy_ltime'], 
                'yy_status'=>$shop['yy_status'], 
                'addr'=>$shop['addr'],
                'house'=>$shop['house'],
                'lat'=>$shop['lat'],
                'lng'=>$shop['lng'],
                'titleString'=>$shop['title'],
                'is_ziti' =>$waimai['is_ziti'],
                'is_daofu'=>$waimai['is_daofu'],
                'online_pay'=>$waimai['online_pay']
            );
            $data['shopinfo'] = $shop;            
            $this->msgbox->set_data('data',$data);
        }
    }
}
