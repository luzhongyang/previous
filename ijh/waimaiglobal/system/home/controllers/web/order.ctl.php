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

            //$products = K::M('product/product')->items(array('shop_id'=>$shop_id));


            $carts = $this->getcart($shop_id);
            if (empty($carts)) {
                $this->msgbox->add(L('您还没有点餐呢'), 224)->response();
            }
            $total_money = $t_price = $package_price = 0;
            foreach ($carts as $k => $val) {
                if ($val['shop_id'] != $shop_id) {
                    $this->msgbox->add(L('商品不是同一家商家的'), 202)->response();
                } else if ($val['sale_type'] == 1 && (($val['sale_sku'] - $val['sale_count']) < $val['cart_num'])) {
                    $this->msgbox->add(L('商品库存不足'), 211)->response();
                } else {
                    $t_price += $val['total_price'];
                    $total_money += ($val['total_price'] + $val['package_price'] * $val['cart_num']);
                    $package_price += $val['package_price'] * $val['cart_num'];

                    if ($val['sale_type'] == 1) {
                        if ($val['sale_sku'] - $val['sale_count'] > 0) {
                            $carts[$k]['sku'] = $val['sale_sku'] - $val['sale_count'];
                        } else {
                            $carts[$k]['sku'] = 0;
                        }
                    } else {
                        $carts[$k]['sku'] = 999;
                    }
                }
            }
            //print_r($t_price);die;
            $total_money = $total_money + $detail['freight'];

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
            
            //红包
            $hongbao_map = array('uid'=>$this->uid,'order_id'=>0);
            $hongbao_map['stime'] = "<=:".__TIME;
            $hongbao_map['ltime'] = ">=:".__TIME;
            $hongbao = K::M('hongbao/hongbao')->items($hongbao_map,array('amount'=>'desc'));
            $this->pagedata['hongbao'] = $hongbao;
            
            //地址
            $m_addr = K::M('member/addr')->items(array('uid' => $this->uid), array('is_default' => 'desc', 'addr_id' => 'desc'));
            $addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1));
            $this->pagedata['addr_id'] = $addr['addr_id'];
            $this->pagedata['maddr'] = $m_addr;
            $this->pagedata['addr_num'] = count($m_addr);
            //print_r($carts);die;
            $this->pagedata['carts'] = $carts;
            $this->pagedata['total_money'] = $total_money;
            $this->pagedata['package_price'] = $package_price;
            $this->pagedata['detail'] = $detail;
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
                    } else if (!$products = $this->getcart($shop_id)) {
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
                        $freight = $shop_detail['freight'];
                        foreach ($products as $k => $v) {
                            if ($v['shop_id'] != $shop_detail['shop_id']) {
                                $this->msgbox->add(L('商品不是同一家商家的'), 202)->response();
                            } else if ($v['sale_type'] == 1 && (($v['sale_sku'] - $v['sale_count']) < $v['cart_num'])) {
                                $this->msgbox->add(L('商品库存不足'), 211)->response();
                            } else {
                                $_pamount = ($v['price'] + $v['package_price']) * $v['cart_num'];
                                $order_product_list[$k] = array(
                                    'product_id' => $k,
                                    'sale_type' => $v['sale_type'],
                                    'product_number' => $v['cart_num'],
                                    'product_name' => $v['title'],
                                    'product_price' => $v['price'],
                                    'package_price' => $v['package_price'],
                                    'amount' => $_pamount
                                );
                                $product_number += $v['cart_num'];
                                $product_price +=$v['price'] * $v['cart_num'];
                                $package_price +=$v['package_price'] * $v['cart_num'];
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
                            'pei_time' => $params['pei_time'],
                            'note' => $note,
                            'order_from' => (defined('IN_WEIXIN') ? 'weixin' : 'wap')
                        );

                        $data['pei_type'] = $shop_detail['pei_type'];
                        $data['pei_amount'] = $shop_detail['pei_amount'];
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
                            foreach ($order_product_list as $k => $val) {
                                $val['order_id'] = $order_id;
                                K::M('order/product')->create($val);
                                K::M('product/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                                if ($val['sale_type'] == 1) {
                                    K::M('product/product')->update_count($val['product_id'], 'sale_count', $val['product_number']);
                                }
                            }
                            /*if ($youhui_detail) {
                                K::M('shop/youhui')->update_count($youhui_detail['youhui_id'], 'use_count', 1);
                            }*/
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
                            /*if ($data['pay_status'] == 1) {
                                K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => L('订单余额支付成功'), 'type' => 2));
                                K::M('shop/msg')->create(array('shop_id' => $shop_id, 'title' => L('订单余额支付成功'), 'content' => L('订单余额支付成功'), 'is_read' => 0, 'type' => 1, 'order_id' => $order_id));
                                //更新模版消息 -- 订单已支付支付
                                if ($this->MEMBER['wx_openid']) {
                                    //获取模版消息配置
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title' => L('您的订单已支付'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('您的订单已支付')), 'remark' => sprintf(L('您的订单于%s支付成功'), date('Y-m-d H:i:s', __TIME)));
                                    $url = K::M('helper/link')->mklink('order:detail', array('args' => $order_id), array(), 'www');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);
                                }
                            }*/
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
    
}
