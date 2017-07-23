<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Order extends Ctl_Web {

    // 结算购物车
    public function index($shop_id) {
        $this->check_login();
        if (!$shop_id = (int) $shop_id) {
            $this->msgbox->add(L('商家不存在'), 301);
        } elseif (!$detail = K::M('shop/shop')->detail($shop_id)) {
            $this->msgbox->add(L('商家不存在'), 302);
        } elseif ($detail['closed'] != 0 || $detail['audit'] != 1) {
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        } else {
            $cur_time = (float) date("H.i", __TIME);
            $yy_stime = (float) str_replace(':', '.', $detail['yy_stime']);
            $yy_ltime = (float) str_replace(':', '.', $detail['yy_ltime']);
            if (empty($detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)) {
                $this->msgbox->add(L('商家已经打烊不可下单'), 223);
            }
            $cart = $this->getECart($shop_id);

            if(empty($cart)){
                $this->msgbox->add('你还没有点餐呢', 223)->response();
            }
            $product_number = $package_price = $product_price = 0;
            $products = "";

            foreach($cart as $k => $v){
                if($k != $shop_id){
                    $this->msgbox->add('商品不是同一家商家的', 202)->response();
                }else{
                    foreach($v as $kk => $vv){
                        $pk = $vv['product_id'] . '-' . $vv['spec_id'];
                        $product_ids[$vv['product_id']] = $vv['product_id'];
                        $spec_ids[$vv['spec_id']] = $vv['spec_id'];
                        $product_numbers[$pk] = $vv['number'];
                        $cart_product_list[$pk] = array('product_id' => $vv['product_id'], 'number' => $vv['number'], 'spec_id' => $vv['spec_id']);
                    }
                }
            }
            $product_list = K::M('waimai/product')->items_by_ids($product_ids);
            $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

            foreach($cart_product_list as $pk => $v){
                if(!$p = $product_list[$v['product_id']]){
                    //购物车的商品实际不存在
                }else if($p['is_spec']){
                    $sp = $spec_lists[$v['spec_id']];
                    if(!$v['spec_id'] && $sp){
                        //商品未选规格sku
                        $this->msgbox->add('商品未选规格sku', 231)->response();
                    }else if($sp['product_id'] != $v['product_id']){
                        //选择规格与商品ID关联不符
                        $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                    }else if($sp['sale_sku'] < $product_numbers[$pk]){
                        $this->msgbox->add('商品库存不足', 233)->response();
                    }else{
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['spec_name'] = $sp['spec_name'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $sp['price'];
                        $product_price += $sp['price'] * $product_numbers[$pk];       //商品总价
                        $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $sp['product_id'] . ":" . $product_numbers[$pk];
                        $products .= ":" . $sp['spec_id'] . ',';
                    }
                }else{
                    // 无规格商品
                    if($p['stock'] < $product_numbers[$pk]){
                        $this->msgbox->add('商品库存不足', 211)->response();
                    }else{
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $p['price'];
                        $product_price += $p['price'] * $product_numbers[$pk];       //商品总价
                        $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $v['product_id'] . ":" . $product_numbers[$pk];
                        $products .= ':0,';
                    }
                }
            }

            $products = rtrim($products, ',');

            // 购物车商品列表
            $this->pagedata['products'] = $product_lists;

            $total_money = $product_price + $package_price + $detail['freight'];

            //配送时间
            $res = K::M('order/order')->get_time();
            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'] . ":" . $res['start_quarter'] * 15;
            $rr = explode(':', $detail['yy_ltime']);
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1] / 15;
            $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;
            if ($stime > $detail['yy_ltime']) {
                $set_time = array();
            }
            $this->pagedata['set_time'] = $set_time;
            $this->pagedata['rightnow_time'] = date('H:i', __TIME+1800) . '-' . date('H:i', __TIME+2700);
            
            //红包
            $hongbao_map = array('uid'=>$this->uid,'order_id'=>0);
            $hongbao_map['stime'] = "<=:".__TIME;
            $hongbao_map['ltime'] = ">=:".__TIME;
            $hongbao = K::M('hongbao/hongbao')->items($hongbao_map,array('amount'=>'desc'));
            $this->pagedata['hongbao'] = $hongbao;

            // 配送费
            $lng = $this->system->cookie->get('lng');
            $lat = $this->system->cookie->get('lat');
            if($detail['lng'] && $detail['lat'] && $lng && $lat){
                $juli = K::M('helper/round')->getdistances($detail['lng'], $detail['lat'], $lng, $lat);
                $juli = ceil($juli / 10);
                $juli = $juli/100;//新距离计算方式wu.
                $_freight = array();
                $_max_freight = array('fkm' => 0, 'fm' => 0);
                foreach($detail['freight_stage'] as $k => $v){
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
            }else{
                $freight = 0;
            }
            
            //地址
            $m_addr = K::M('member/addr')->items(array('uid' => $this->uid), array('is_default' => 'desc', 'addr_id' => 'desc'));
            $addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1));
            $this->pagedata['addr_id'] = $addr['addr_id'];
            $this->pagedata['maddr'] = $m_addr;
            $this->pagedata['addr_num'] = count($m_addr);

            $this->pagedata['carts'] = $carts;
            $this->pagedata['total_money'] = $total_money;
            $this->pagedata['package_price'] = $package_price;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['freight_price'] = $freight;
            $this->tmpl = 'web/order.html';
        }
    }

    public function create() {
        //$this->check_login();
        if (empty($this->uid)) {
            $this->msgbox->add(L('请先登陆后操作'), 101)->response();
        }
        
        if (IS_AJAX) {
            if ($params = $this->checksubmit('params')) {
                $pei_time = $pei_time_start = $pei_time_last = 0;
                if (preg_match('/^(\d{2}\:\d{2})\-(\d{2}\:\d{2})$/i', $params['pei_time'], $m)) {
                    $pei_time = $params['pei_time'];
                    $pei_time_start = $m[1];
                    $pei_time_last = $m[2];
                }
                $note = $params['note'];
                if (!$shop_id = (int) $params['shop_id']) {
                    $this->msgbox->add(L('商家不存在'), 221);
                } else if (!$shop_detail = K::M('shop/shop')->detail($shop_id)) {
                    $this->msgbox->add(L('商家不存在'), 222);
                } else if ($shop_detail['audit'] != 1 || $shop_detail['closed'] != 0) {
                    $this->msgbox->add(L('商家不存在或已被删除'), 223);
                } else {
                    $cur_time = (float) date("H.i", __TIME);
                    $yy_stime = (float) str_replace(':', '.', $shop_detail['yy_stime']);
                    $yy_ltime = (float) str_replace(':', '.', $shop_detail['yy_ltime']);
                    $pei_stime = (float) str_replace(':', '.', $pei_time);


                    if (empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)) {
                        $this->msgbox->add(L('商家已经打烊不可下单'), 223);
                    } else if ($pei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)) {
                        $this->msgbox->add(L('配送时间不在商家营业范围'), 223);
                    } else if (!$products = $this->getECart($shop_id)) {
                        $this->msgbox->add(L('您还没有点餐呢'), 201);
                    } else if (!$addr_id = (int) $params['addr_id']) {
                        $this->msgbox->add(L('请输入收货地址'), 206);
                    } else if (!$addr_detail = K::M('member/addr')->detail($addr_id)) {
                        $this->msgbox->add(L('收货地址不存在'), 207);
                    } else if (K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat']) > $shop_detail['pei_distance'] * 1000) {
                        $this->msgbox->add(L('超出配送范围'), 208);
                    } else {
                        $product_numbers = $order_product_list = array();
                        $product_price = $package_price = $product_number = $hongbao_amount = $first_youhui = $youhui_amount = $pei_amount  = $money = $amount = 0;
                        if($shop_detail['lng'] && $shop_detail['lat'] && $addr_detail['lng'] && $addr_detail['lat']){
                            $juli = K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat']);
                            $juli = ceil($juli / 10);
                            $juli = $juli/100;//新距离计算方式wu.
                            $_freight = array();
                            $_max_freight = array('fkm' => 0, 'fm' => 0);
                            foreach($shop_detail['freight_stage'] as $k => $v){
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
                            $freight = $_freight['fkm'] ? $_freight['fm'] : $_max_freight['fm'];
                            $p_amount = $_freight['fkm'] ? $_freight['sm'] : $_max_freight['sm'];
                        }else{
                            $freight = 0;
                            $p_amount = 0;
                        }
                        foreach($products as $k => $v){
                            foreach($v as $kk => $vv){
                                $pk = $vv['product_id'] . '-' . $vv['spec_id'];
                                $product_ids[$vv['product_id']] = $vv['product_id'];
                                $spec_ids[$vv['spec_id']] = $vv['spec_id'];
                                $product_numbers[$pk] = $vv['number'];
                                $cart_product_list[$pk] = array('product_id' => $vv['product_id'], 'number' => $vv['number'], 'spec_id' => $vv['spec_id']);
                            }
                        }
                        $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                        $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);
                    
                        $order_product_list = array();
                        foreach($cart_product_list as $pk => $v){
                            if(!$p = $product_list[$v['product_id']]){
                                //购物车的商品实际不存在
                            }if($p['shop_id'] != $shop_detail['shop_id']){
                                $this->msgbox->add('商品不是同一家商家的', 230)->response();
                            }else if($p['is_spec']){
                                $sp = $spec_lists[$v['spec_id']];
                                if(!$v['spec_id'] && $sp){
                                    //商品未选规格sku
                                    $this->msgbox->add('商品未选规格sku', 231)->response();
                                }else if($sp['product_id'] != $v['product_id']){
                                    //选择规格与商品ID关联不符
                                    $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                                }else if( $sp['sale_sku'] < $product_numbers[$pk]){
                                    $this->msgbox->add('商品库存不足', 233)->response();
                                }else{
                                    $_pamount = ($sp['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id' => $v['product_id'],
                                        'spec_id' => $v['spec_id'],
                                        'sale_type' => $p['sale_type'],
                                        'product_number' => $product_numbers[$pk],
                                        'product_name' => $p['title'],
                                        'product_price' => $sp['price'],
                                        'package_price' => $p['package_price'],
                                        'amount' => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price += $sp['price'] * $product_numbers[$pk];
                                    $package_price += $p['package_price'] * $product_numbers[$pk];
                                }
                            }else{
                                if( $p['stock'] < $product_numbers[$pk]){
                                    $this->msgbox->add('商品库存不足', 211)->response();
                                }else{
                                    $_pamount = ($p['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id' => $v['product_id'],
                                        'spec_id' => 0,
                                        'sale_type' => $p['sale_type'],
                                        'product_number' => $product_numbers[$pk],
                                        'product_name' => $p['title'],
                                        'product_price' => $p['price'],
                                        'package_price' => $p['package_price'],
                                        'amount' => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price += $p['price'] * $product_numbers[$pk];
                                    $package_price += $p['package_price'] * $product_numbers[$pk];
                                }
                                        
                            }
                        }
    
                        if ($product_price < $shop_detail['min_amount']) {
                            $this->msgbox->add(L('没有达到配送要求'), 212)->response();
                        }
                        $data = array(
                            'shop_id' => $shop_id,
                            'city_id' => $shop_detail['city_id'],
                            'uid' => $this->uid,
                            'product_number' => $product_number,
                            'product_price' => $product_price,
                            'package_price' => $package_price,
                            'freight' => $freight,
                            'amount' => $product_price + $package_price + $freight,
                            'contact' => $addr_detail['contact'],
                            'mobile' => $addr_detail['mobile'],
                            'addr' => $addr_detail['addr'],
                            'house' => $addr_detail['house'],
                            'lng' => $addr_detail['lng'],
                            'lat' => $addr_detail['lat'],
                            'online_pay' => 0,
                            'pei_time' => strtotime($pei_time_start),
                            'note' => $note,
                            'from' => 'waimai',
                            'order_from' => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                            'o_lng'=>$shop_detail['lng'],
                            'o_lat'=>$shop_detail['lat'],
                        );

                        $data['pei_type'] = $shop_detail['pei_type'];
                        $data['pei_amount'] = $p_amount>0?$p_amount : $shop_detail['pei_amount'];
                        if ($params['online_pay']) {
                            $data['online_pay'] = 1;
                            /*if ($shop_detail['first_amount'] && !$this->MEMBER['orders']) {
                                $data['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                            }
                            if ($youhui_detail = K::M('shop/youhui')->order_youhui($shop_id, $product_price - $first_youhui)) {
                                $data['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                            }
                            */
                            if ($hongbao_id = (int) $params['hongbao_id']) {
                                if (!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)) {
                                    $this->msgbox->add(L('红包不存在'), 203)->response();
                                } else if ($hongbao_detail['uid'] != $this->uid) {
                                    $this->msgbox->add(L('非法操作'), 204)->response();
                                } else if ($hongbao_detail['order_id']) {
                                    $this->msgbox->add(L('红包已经被使用'), 205)->response();
                                } else if ($hongbao_detail['ltime'] < __TIME) {
                                    $this->msgbox->add(L('红包已过期不能使用'), 244)->response();
                                } else if ($hongbao_detail['min_amount'] > ($product_price - $first_youhui - $youhui_amount)) {
                                    $this->msgbox->add(L('红包不满足使用条件'), 205)->response();
                                } else {
                                    $data['hongbao_id'] = $hongbao_id;
                                    $data['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                                }
                            }
                            $data['amount'] = $amount = $product_price + $package_price + $freight - $youhui_amount - $first_youhui - $hongbao_amount;
                        } else {
                            $data['pei_type'] = 0;
                            $data['pei_amount'] = 0;
                        }

                        if ($data['amount'] == 0) {
                            $data['pay_status'] = 1;
                        }

                        if ($order_id = K::M('order/order')->create($data)) {

                            $waimai_order_data['order_id'] = $order_id;
                            $waimai_order_data['product_number'] = $product_number;
                            $waimai_order_data['product_price'] = $product_price;
                            $waimai_order_data['package_price'] = $package_price;
                            $waimai_order_data['freight'] = $freight;
                            $order = K::M('order/order')->detail($order_id);
                            $waimai_order_id = K::M('waimai/order')->create($waimai_order_data);

                            //写入外卖订单商品表,并更新库存
                            foreach($order_product_list as $k => $val){
                                $val['order_id'] = $order_id;
                                K::M('waimai/orderproduct')->create($val);
                            }

                            if ($hongbao_detail) {
                                K::M('hongbao/hongbao')->update($hongbao_id, array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                            }
                            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => L('订单已提交'), 'type' => 1));
                            K::M('shop/msg')->create(array('shop_id' => $shop_id, 'title' => L('订单已提交'), 'content' => L('订单已提交'), 'is_read' => 0, 'type' => 1, 'order_id' => $order_id));

                            //更新微信模版消息 -- 提交
                            if ($this->MEMBER['wx_openid']) {
                                //获取模版消息配置 --订单已提交
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title' => '您的订单已提交！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('您的订单已提交')), 'remark' => sprintf(L('您的订单于%s提交成功'), date('Y-m-d H:i:s', __TIME)));
                                $url = K::M('helper/link')->mklink('order:detail', array('args' => $order_id), array(), 'www');
                                K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);
                            }

                            K::M('shop/shop')->update_count($shop_id, 'orders', 1);
                            K::M('member/member')->update_count($this->uid, 'orders', 1);
                            $this->msgbox->add(L('恭喜您下单成功'));
                            $this->msgbox->set_data('order_id', $order_id);
                            //$this->msgbox->set_data('pay_status', $data['pay_status']);
                            $this->msgbox->set_data('online_pay', $data['online_pay']);
                        }
                    }
                }
            }
        }
    }

    public function createAddr() {
        //$this->check_login();
        if (empty($this->uid)) {
            $this->msgbox->add(L('请先登陆后操作'), 101);
        } else {
            if (IS_AJAX) {
                if ($params = $this->checksubmit('params')) {
                    if (empty($params['contact'])) {
                        $this->msgbox->add(L('联系人不能为空'), 221);
                    } elseif (!$params['mobile'] = K::M('verify/check')->mobile($params['mobile'])) {
                        $this->msgbox->add(L('手机号码不正确'), 222);
                    } elseif (empty($params['addr'])) {
                        $this->msgbox->add(L('位置不能为空'), 223);
                    } elseif (empty($params['house'])) {
                        $this->msgbox->add(L('详细地址不能为空'), 224);
                    } elseif (!$params['lng'] || !$params['lat']) {
                        $this->msgbox->add(L('地址坐标不正确'), 224);
                    } else {
                        $params['uid'] = $this->uid;
                        if ($addr_id = K::M('member/addr')->create($params)) {
                            $this->msgbox->add(L('添加地址成功'));
                            $addrs = K::M('member/addr')->items(array('uid' => $this->uid), array('addr_id' => 'desc'));
                            //print_r($addrs);die;
                            $this->msgbox->set_data('addrs', array_values($addrs));
                            $this->msgbox->set_data('addr_id', $addr_id);
                        } else {
                            $this->msgbox->add(L('添加失败'), 250);
                        }
                    }
                }
            }
        }
    }

    
    public function pay($order_id)
    {
       $this->check_login();
       $order_id = (int)$order_id;
       if(!$order_id){
           $this->msgbox->add(L('订单不存在'),211);
       }else if(!$detail = K::M('order/order')->detail($order_id)){
           $this->msgbox->add(L('订单不存在'),212);
       }else if($detail['pay_status'] ==1){
           $this->msgbox->add(L('订单已支付'),213);
       }else if($detail['online_pay'] == 0){
           $this->msgbox->add(L('您选择了货到付款'),214);
       }else if($detail['order_status'] !=0){
           $this->msgbox->add(L('订单不能支付'),215);
           $this->msgbox->set_data("forward", $this->mklink('web/menu/index',array($detail['shop_id'])));
       }else{
            if(defined('IN_WEIXIN')){
               $this->pagedata['weixin'] = 1;
            }
            if($detail['online_pay'] ==1){
                if($detail['order_status'] ==0&&$detail['pay_status'] == 0){
                    if(__TIME - $detail['dateline'] <= 1800){
                        $detail['last_second'] = 1800-(__TIME - $detail['dateline']);
                    }
                }
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'web/pay.html';  
        }
    }

    // 解析JS购物车商品信息
    public function getECart($shop_id)
    {
        $this->check_login();
        $cart = json_decode(urldecode($_COOKIE['KT-WEBCart']), true);
        $cart_goods = explode(',', $cart[$shop_id]);
        foreach($cart_goods as $key => $val){
            if(preg_match('/^(\d+)-(\d+):(\d+)$/', $val, $local)){
                $pk = $local[1] . '-' . $local[2];
                $cart_product_list[$pk] = array(
                    'product_id' => $local[1],
                    'number' => $local[3],
                    'spec_id' => $local[2],
                );
            }
        }
        $items[$shop_id] = $cart_product_list;
        return $items;
    }
    
    function ajax_get_freight() 
    {
        $this->check_login();
        $addr_id = (int)$this->GP('addr_id');
        $shop_id = (int)$this->GP('shop_id');
        $detail = K::M('shop/shop')->detail($shop_id);
        $addr = K::M('member/addr')->detail($addr_id);
        $lng = $addr['lng'];
        $lat = $addr['lat'];
        if($detail['lng'] && $detail['lat'] && $lng && $lat){
            $juli = K::M('helper/round')->getdistances($detail['lng'], $detail['lat'], $lng, $lat);
            $juli = ceil($juli / 10);
            $juli = $juli/100;//新距离计算方式wu.
            $_freight = array();
            $_max_freight = array('fkm' => 0, 'fm' => 0);
            foreach($detail['freight_stage'] as $k => $v){
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
        }else{
            $freight = 0;
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',array('freight_price'=>$freight));
    }
}
