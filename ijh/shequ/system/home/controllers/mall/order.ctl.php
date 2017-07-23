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
            $data_order = $data_mall_order = $data_mall_order_product = $product_ids = array();
            foreach($mallcart as $k => $v){
                if($v){
                    $product = K::M('mall/product')->detail($k);
                    if($product['sku'] < $v){
                        $nosku = $product['title'];
                        break;
                    }
                    $data_mall_order['product_number'] += $v; //所有商品总数量
                    $data_mall_order['product_price'] += $product['price'] * $v; //所有商品总价格
                    $data_mall_order['product_jifen'] += $product['jifen'] * $v; //所有商品总积分
                    $product_ids[$k] = $k;
                    $freight[] = $product['freight']; //运费数组
                    $data_mall_order_product[$k] = array(
                        'product_id' => $product['product_id'],
                        'product_name' => $product['title'],
                        'product_jifen' => $product['jifen'],
                        'product_number' => $v,
                        'product_price' => $product['price']
                    );
                }else{
                    unset($mallcart[$k]);//否则删除该商品
                }
            }
            $data_mall_order['freight'] = max($freight); //根据运费数组得出总运费，取运费中的最大一条
            
            if(!$mallcart){
                $this->msgbox->add('购物车无商品，请重新下单', 220);
                $this->msgbox->set_data('forward', $this->mklink('mall'));
            }elseif(isset($nosku)){
                $this->msgbox->add('商品' . $nosku . '库存不足，请重新下单', 217);
            }elseif($this->MEMBER['jifen'] < $total['jifen']){
                $this->msgbox->add('您的积分不足', 218);
            }else{
                $data_order = array(
                    'city_id' => 1,
                    'shop_id' => 0,
                    'staff_id' => 0,
                    'uid' => $this->uid,
                    'from' => 'mall',
                    'order_status' => 0,
                    'online_pay' => 1,
                    'pay_status' => 0,
                    'total_price' => $data_mall_order['product_price'],
                    'amount' => $data_mall_order['product_price'] + max($freight),
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
                if(0 == $data_order['amount']){
                    $data_order['pay_status'] = 1;
                }

                if($order_id = K::M('order/order')->create($data_order)){
                    $data_mall_order['order_id'] = $order_id;
                    //mall_order创建记录
                    K::M('mall/order')->create($data_mall_order,true);
                    //遍历在mall_order_product表创建记录
                    foreach($data_mall_order_product as $key => $val){
                        $val['order_id'] = $order_id;
                        K::M('mall/order/product')->create($val);//遍历插入
                        K::M('mall/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        K::M('mall/product')->update_count($val['product_id'], 'sku', -$val['product_number']);
                    }
                    K::M('member/member')->update_count($this->uid, 'orders', 1);//增加用户订单量
                    K::M('member/member')->update_jifen($this->uid, -$data_mall_order['product_jifen'], '商城订单(ID:' . $order_id . ')下单花费积分', 'member');
                    $this->cookie->set('mallcart', '');
                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'pay_status' => $data_order['pay_status']));
                }else{
                    $this->msgbox->add('下单失败', 219);
                }

            }
        }
    }

    public function index($type=1)
    {
        $this->items($type);
    }

    // 订单列表
    public function items($type=1, $page=1)
    {
        $this->check_login();
        $filter = $order_ids = $order_items = $mall_order_list = $order_list = array();
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = 'mall';
        if($type == 1){
            $filter['order_status'] = array(1,2,3,4,5,6,7);
        }else if($type == 2){
            $filter['order_status'] = array(-1,8);
        }
        $page = max((int)$page, 1);
        $limit = 10;
        if($order_list = K::M('order/order')->items($filter, null, $page, $limit, $count)){
            foreach($order_list as $k => $v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($mall_order_list = K::M('mall/order')->items_by_ids($order_ids)){
                $order_ids = array();
                foreach($mall_order_list as $k => $v){
                    $order_ids[$v['order_id']] = $v['order_id'];
                    $row = array_merge($order_list[$k], $v);
                    $row['product_list'] = array();
                    $order_items[$k] = $row;
                    $pids[] = $v['product_id'];
                }
                if($product_list = K::M('mall/order/product')->items_by_ids($order_ids)){
                    foreach($product_list as $k=>$v){
                        $order_items[$v['order_id']][$k] = $v;
                    }
                }
            }
        }
        $this->pagedata['items'] = $order_items;
        $this->tmpl = 'mall/order/items.html';
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
        $this->tmpl = 'mall/order/detail.html';
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
