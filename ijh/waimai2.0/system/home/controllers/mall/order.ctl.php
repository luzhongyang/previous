<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Mall_Order extends Ctl
{

    // 购物车
    public function addcart()
    {
        $this->check_login();
        if(!$pid = (int) $this->GP('pid')){
            $this->msgbox->add(L('商品不存在'), 211);
        }else{
            $mallcart = unserialize($this->cookie->get('mallcart'));
            if($this->GP('reduce')){
                if($mallcart[$pid] > 1){
                    $mallcart[$pid] = $mallcart[$pid] - 1;
                }else{
                    unset($mallcart[$pid]);
                    //$this->msgbox->add(L('该商品已从购物车清除'),212);
                }
            }else{
                $mallcart[$pid] ++;
            }
            $total = array('count' => 0, 'price' => 0, 'jifen' => 0);
            foreach($mallcart as $k => $v){
                $product_ids[$k] = $k;
                /* $product = K::M('mall/product')->detail($k);
                  if($product['sku'] < $v){
                  $nosku = $product['title'];
                  break;
                  }
                  $total['count'] += $v;
                  $total['price'] += $product['price'] * $v;
                  $total['jifen'] += $product['jifen'] * $v;
                  if($product['freight'] == null) {$product['freight']==0;}
                  $freight[] = $product['freight']; */
            }
            $products = K::M('mall/product')->items_by_ids($product_ids);
            foreach($products as $k => $product){
                if($product['sku'] < $mallcart[$k]){
                    $nosku = $product['title'];
                    break;
                }
                $total['count'] += $mallcart[$k];
                $total['price'] += $product['price'] * $mallcart[$k];
                $total['jifen'] += $product['jifen'] * $mallcart[$k];
                if($product['freight'] == null){
                    $product['freight'] == 0;
                }
                $freight[] = $product['freight'];
            }

            if(isset($nosku)){
                $mallcart[$pid] --;
                $this->msgbox->add('商品' . $nosku . '库存不足，请重新下单', 212);
            }else if($this->MEMBER['jifen'] < $total['jifen']){
                $mallcart[$pid] --;
                $this->msgbox->add('您的积分不足', 213);
            }else if(count($mallcart) == 0){
                $this->msgbox->add('购物车已清空，请继续选择', 244);
                $total['freight'] = max($freight);
                $this->msgbox->set_data('data', $total);
            }else{
                $total['freight'] = max($freight);
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', $total);
            }
            $this->cookie->set('mallcart', serialize($mallcart));
        }
    }

    // 确认订单
    public function cart()
    {
        $this->check_login();
        if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
            $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
        }
        $mallcart = unserialize($this->cookie->get('mallcart'));
        foreach($mallcart as $k => $v){
            if($v){
                $total['count'] += $v;
                $product_ids[$k] = $k;
            }else{
                unset($mallcart[$k]);
            }
        }
        $products = K::M('mall/product')->items_by_ids($product_ids);
        foreach($products as $k => $product){
            $total['price'] += $product['price'] * $mallcart[$k];
            $total['jifen'] += $product['jifen'] * $mallcart[$k];
            $freight[] = $product['freight'];
        }

        $this->pagedata['freight'] = max($freight);
        $this->pagedata['total'] = $total;
        $this->pagedata['mallcart'] = $mallcart;
        $this->pagedata['products'] = $products;
        $addr_count = K::M('member/addr')->count(array('uid' => $this->uid));
        $this->pagedata['addr_count'] = $addr_count;
        $this->pagedata['my_addr'] = $m_addr;
        $this->tmpl = 'mall/cart.html';
    }

    // 下单
    public function create()
    {
        $this->check_login();
        if(!$addr_id = $this->GP('addr_id')){
            $this->msgbox->add('收货地址不存在', 213);
        }else if(!$addr = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('收货地址不存在', 215);
        }else if($addr['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 216);
        }else{
            $mallcart = unserialize($this->cookie->get('mallcart'));

            foreach($mallcart as $k => $v){
                if($v){
                    $product = K::M('mall/product')->detail($k);
                    if($product['sku'] < $v){
                        $nosku = $product['title'];
                        break;
                    }
                    $total['count'] += $v;
                    $total['price'] += $product['price'] * $v;
                    $total['jifen'] += $product['jifen'] * $v;
                    $product_ids[$k] = $k;
                    $freight[] = $product['freight'];
                    $mall_order_data[$k] = array(
                        'product_id' => $product['product_id'],
                        'product_name' => $product['title'],
                        'product_jifen' => $product['jifen'],
                        'product_number' => $v,
                        'product_price' => $product['price']
                    );
                }else{
                    unset($mallcart[$k]);
                }
            }

            if(!$mallcart){
                $this->msgbox->add('购物车无商品，请重新下单', 220);
                $this->msgbox->set_data('forward', $this->mklink('mall/product'));
            }elseif(isset($nosku)){
                $this->msgbox->add('商品' . $nosku . '库存不足，请重新下单', 217);
            }elseif($this->MEMBER['jifen'] < $total['jifen']){
                $this->msgbox->add('您的积分不足', 218);
            }else{
                $order_data = array(
                    'city_id' => 1,
                    'shop_id' => 0,
                    'staff_id' => 0,
                    'uid' => $this->uid,
                    'from' => 'mall',
                    'order_status' => 0,
                    'online_pay' => 1,
                    'pay_status' => 0,
                    'total_price' => $total['price'],
                    'amount' => $total['price'] + max($freight),
                    'contact' => $addr['contact'],
                    'mobile' => $addr['mobile'],
                    'lng' => $addr['lng'],
                    'lat' => $addr['lat'],
                    'house' => $addr['house'],
                    'addr' => $addr['addr'],
                    'pei_amount' => max($freight),
                    'order_from' => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                );

                //判断金额如果是0,订单状态已支付
                if(0 == $order_data['amount']){
                    $order_data['pay_status'] = 1;
                }

                if($order_id = K::M('order/order')->create($order_data)){
                    foreach($mall_order_data as $key => $val){
                        $val['order_id'] = $order_id;
                        K::M('mall/order')->create($val);
                        K::M('mall/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        K::M('mall/product')->update_count($val['product_id'], 'sku', -$val['product_number']);
                    }
                    K::M('member/member')->update_jifen($this->uid, -$total['jifen'], '商城订单(ID:' . $order_id . ')下单花费积分', 'member');
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '商城订单已提交成功', 'type' => 1, 'kind' => 'mall'));
                    $this->cookie->set('mallcart', '');
                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'pay_status' => $order_data['pay_status']));
                }else{
                    $this->msgbox->add('下单失败', 219);
                }
            }
        }
    }

    public function index()
    {
        $this->check_login();
        $this->tmpl = 'ucenter/order/mall/items.html';
    }

    // 订单列表
    public function items()
    {
        $this->check_login();
        $filter = $orderids = $order_items = $mall_order_items = array();
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = 'mall';
        //$filter['day'] = date('Ymd', __TIME - 31 * 86400) . '~' . date('Ymd', __TIME);      //只查询近一个月订单
        $page = max((int) $this->GP('page'), 1);
        if(($page <= 10) && $order_items = K::M('order/order')->items($filter, array('order_id' => 'desc'), 1, $limit, $count)){
            foreach($order_items as $k => $v){
                $orderids[$v['order_id']] = $v['order_id'];
                $order_items[$k]['dateline'] = date('Y-m-d H:i', $v['dateline']);
                $order_items[$k]['link'] = $this->mklink('mall/order:detail', array('args' => $v['order_id']));
            }
            if($order_child = K::M('mall/order')->items(array('order_id' => $orderids), array('pid' => 'desc'), 1, 2000, $count2)){
                foreach($order_child as $k => $v){
                    $pids[] = $v['product_id'];
                }
                $p = K::M('mall/product')->items(array('product_id' => $pids));
                foreach($order_child as $kc => $vc){
                    $order_child[$kc]['photo'] = $p[$vc['product_id']]['photo'];
                }
            }
            foreach($order_items as $ko => $vo){
                foreach($order_child as $kc => $vc){
                    if($ko == $vc['order_id']){
                        $order_items[$ko]['child'][] = $vc;
                    }
                }
            }
            $items = array_slice($order_items, ($page - 1) * 10, 10, true);
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => array_values($items)));
    }

    // 订单详情
    public function detail($order_id = null)
    {
        $this->check_login();
        $order_child = array();
        if($order_id = (int) $order_id){
            if($order = K::M('order/order')->detail($order_id)){
                if(empty($order['pay_status'])){
                    $order['pay_label'] = '未支付';
                }else if($order['pay_status'] == 1 && $order['pay_code'] == 'alipay'){
                    $order['pay_label'] = '支付宝支付';
                }else if($order['pay_status'] == 1 && $order['pay_code'] == 'wxpay'){
                    $order['pay_label'] = '微信支付';
                }else if($order['pay_status'] == 1 && $order['pay_code'] == 'money'){
                    $order['pay_label'] = '余额支付';
                }
                if($order['uid'] = $this->uid && $order['from'] == 'mall'){
                    if($order_child = K::M('mall/order')->items(array('order_id' => $order_id), array('pid' => 'desc'), 1, 50, $count)){
                        foreach($order_child as $k => $v){
                            $p = K::M('mall/product')->detail($v['product_id']);
                            $order_child[$k]['photo'] = $p['photo'];
                        }
                    }
                    $order['child'] = $order_child;
                    $this->pagedata['order'] = $order;
                }
            }
        }
        $this->tmpl = 'ucenter/order/mall/detail.html';
    }

    // 用户取消订单
    public function cancel()
    {
        $this->check_login();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在11', 210);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else if($order['from'] != 'mall'){
            $this->msgbox->add('非法操作', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消', 214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态', 215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $mall_orders = k::M('mall/order')->items(array('order_id' => $order['order_id']));
            foreach($mall_orders as $k => $v){
                $jifen += $v['product_jifen'] * $v['product_number'];
            }
            K::M('member/member')->update_jifen($this->uid, $jifen, '商城订单(ID:' . $order['order_id'] . ')取消返还积分', 'member');

            $this->msgbox->add('订单取消成功');
        }else{
            $this->msgbox->add('订单取消失败', 216);
        }
    }

    // 用户删除订单
    public function delete()
    {
        $this->check_login();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 211);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 212);
        }else if($order['from'] != 'mall'){
            $this->msgbox->add('非法操作', 213);
        }else if(($order['order_status'] == -1) || ($order['order_status'] == 8)){
            if(K::M('order/order')->delete($order_id, false)){
                $this->msgbox->add('删除订单成功');
            }else{
                $this->msgbox->add('删除订单失败', 213);
            }
        }else{
            $this->msgbox->add('当前状态不可删除', 214);
        }
    }

    // 用户确认收货
    public function setreceipt()
    {
        $this->check_login();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 211);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 212);
        }else if($order['from'] != 'mall'){
            $this->msgbox->add('非法操作', 213);
        }else if(in_array($order['order_status'], array(2, 3, 4))){
            if(K::M('order/order')->update($order_id, array('order_status' => 8))){
                $this->msgbox->add('确认收货成功');
            }else{
                $this->msgbox->add('确认收货失败', 213);
            }
        }else{
            $this->msgbox->add('当前状态不可确认收货', 214);
        }
    }

}
