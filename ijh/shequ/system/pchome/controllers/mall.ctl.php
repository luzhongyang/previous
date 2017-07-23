<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Mall extends Ctl
{

    //积分商城
    public function index($page, $cate_id = 0, $type_num = 1, $type)
    {
        //查询分类
        $cate = K::M('mall/cate')->items(array('parent_id' => 0));
        $filter = $pager = array();
        $filter['closed'] = 0;
        $pager['page'] = $page = max((int) $page, 1);
        $pager['limit'] = $limit = 12;
        $cate_id = (int) $cate_id;
        if($cate_id != 0){
            $filter['cate_id'] = $cate_id;
        }
        $this->pagedata['cate_id'] = $cate_id;

        if(!in_array($type_num, array('d', 'a'))){
            $type_num = 'a';
        }
        if($type_num == 'd'){
            $type_num = 'desc';
        }else{
            $type_num = 'asc';
        }
        $this->pagedata['type_num'] = $type_num;
        if(!in_array($type, array('s', 'j'))){
            $type = 's';
        }
        if($type == 's'){
            $type = 'sales';
        }else{
            $type = 'jifen';
        }
        $this->pagedata['type'] = $type;
        $orderby[$type] = $type_num;

        $count = K::M('mall/product')->count($filter);
        if($items = K::M('mall/product')->items($filter, $orderby, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('mall/index', array('{page}'), null, 'base'));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['sales'] = $sales;
        $this->pagedata['jifen'] = $jifen;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cate'] = $cate;
        $this->tmpl = 'pchome/mall/index.html';
    }

    public function detail($product_id)
    {
        $product_id = (int) $product_id;
        $product = K::M('mall/product')->detail($product_id);
        if(!$product = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add('商品不存在', 211)->response();
        }else{
            //查询5个其它商品
            $other = K::M('mall/product')->items(array('product_id'=>'<>:'.$product_id),null,1,5);

            $mallcart = unserialize($this->cookie->get('mallcart'));

            foreach($mallcart as $k => $v){
                $ids[$k] = $k;
                $total['count'] += $v;
                if($product_id == $k){
                    $this->pagedata['this_count'] = $v;
                }
            }
            $this->pagedata['total'] = $total;
            $this->pagedata['other'] = $other;
            $product['info'] = htmlspecialchars_decode($product['info']);
            $this->pagedata['detail'] = $product;
            $this->tmpl = 'pchome/mall/detail.html';
        }
    }

    // 购物车
    public function addcart()
    {
        $this->check_login();
        if(!$pid = (int) $this->GP('pid')){
            $this->msgbox->add(L('商品不存在'), 211)->response();
        }else{
            $mallcart = unserialize($this->cookie->get('mallcart'));
            if($this->GP('reduce')){
                if($this->GP('reduce') == -1){
                    unset($mallcart[$pid]); //如果reduce传0，则执行删除操作
                }else{
                    if($mallcart[$pid] > 1){
                        $mallcart[$pid] = $mallcart[$pid] - 1;
                    }else{
                        unset($mallcart[$pid]);
                        //$this->msgbox->add(L('该商品已从购物车清除'),212);
                    }
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
                $this->msgbox->add('商品' . $nosku . '库存不足，请重新下单', 212)->response();
                return false;
            }else if($this->MEMBER['jifen'] < $total['jifen']){
                $mallcart[$pid] --;
                $this->msgbox->add('您的积分不足', 213)->response();
                return false;
            }else if(count($mallcart) == 0){
                $this->cookie->delete('mallcart');
                $this->msgbox->add('购物车已清空，请继续选择', 244)->response();
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

    //购物车
    public function cart()
    {
        $this->cart_init();
        $this->pagedata['checked_product'] = $cart;
        $this->tmpl = 'pchome/mall/cart.html';
    }

    //下单
    public function order()
    {
        $this->cart_init();
        $addr = K::M('member/addr')->items(array('uid' => $this->uid));
        $this->pagedata['my_addr'] = $addr;
        $this->tmpl = 'pchome/mall/order.html';
    }

    // 创建订单
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

            $check_arr = (array) json_decode(str_replace('\"', '"', $this->cookie->get('check_arr')), true); //获取用户从购物车中选择的商品列表
            //下单成功后的剩余购物车
            $ordered_mallcart = array();

            //对比后的所选择商品
            foreach($mallcart as $k => $v){
                if(!$check_arr[$k]){
                    $ordered_mallcart[$k] = $v;
                    unset($mallcart[$k]);
                }
            }

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
                        'product_id'     => $product['product_id'],
                        'product_name'   => $product['title'],
                        'product_jifen'  => $product['jifen'],
                        'product_number' => $v,
                        'product_price'  => $product['price']
                    );
                }else{
                    unset($mallcart[$k]); //否则删除该商品
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
                    'city_id'      => 1,
                    'shop_id'      => 0,
                    'staff_id'     => 0,
                    'uid'          => $this->uid,
                    'from'         => 'mall',
                    'order_status' => 0,
                    'online_pay'   => 1,
                    'pay_status'   => 0,
                    'total_price'  => $data_mall_order['product_price'],
                    'amount'       => $data_mall_order['product_price'] + max($freight),
                    'contact'      => $addr['contact'],
                    'mobile'       => $addr['mobile'],
                    'lng'          => $addr['lng'],
                    'lat'          => $addr['lat'],
                    'house'        => $addr['house'],
                    'addr'         => $addr['addr'],
                    'pei_amount'   => max($freight),
                    'order_from'   => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                );

                //判断金额如果是0,订单状态已支付
                if(0 == $data_order['amount']){
                    $data_order['pay_status'] = 1;
                }

                if($order_id = K::M('order/order')->create($data_order)){
                    $data_mall_order['order_id'] = $order_id;
                    //mall_order创建记录
                    K::M('mall/order')->create($data_mall_order, true);
                    //遍历在mall_order_product表创建记录
                    foreach($data_mall_order_product as $key => $val){
                        $val['order_id'] = $order_id;
                        K::M('mall/order/product')->create($val); //遍历插入
                        K::M('mall/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        K::M('mall/product')->update_count($val['product_id'], 'sku', -$val['product_number']);
                    }
                    K::M('member/member')->update_count($this->uid, 'orders', 1); //增加用户订单量
                    K::M('member/member')->update_jifen($this->uid, -$data_mall_order['product_jifen'], '商城订单(ID:' . $order_id . ')下单花费积分', 'member');

                    //清除购物车中已选的商品,设置剩余商品为新购物车
                    //$this->cookie->set('mallcart', '');
                    $this->cookie->set('mallcart', serialize($ordered_mallcart));

                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'pay_status' => $data_order['pay_status']));
                }else{
                    $this->msgbox->add('下单失败', 219);
                }

            }
        }
    }

    private function cart_init()
    {
        $this->check_login();
        $mallcart = unserialize($this->cookie->get('mallcart'));
        $check_arr = (array) json_decode(str_replace('\"', '"', $this->cookie->get('check_arr')), true); //获取用户从购物车中选择的商品列表
        //通过$check_arr给数组写入选择状态
        foreach($mallcart as $k => $v){
            if(!$check_arr[$k]){
                $new_mallcart[$k]['check'] = 0;
            }else{
                $new_mallcart[$k]['check'] = 1;
            }
            $new_mallcart[$k]['num'] = $v;
        }

        foreach($mallcart as $k => $v){
            if($v){
                if($new_mallcart[$k]['check'] == 1){
                    $total['checked_count'] += $v;
                }
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

            //查询已选的
            if($new_mallcart[$k]['check'] == 1){
                $total['checked_price'] += $product['price'] * $mallcart[$k];
                $total['checked_jifen'] += $product['jifen'] * $mallcart[$k];
                $checked_freight[] = $product['freight'];
            }
        }

        $this->pagedata['freight'] = max($freight);
        $this->pagedata['checked_freight'] = max($checked_freight);
        $this->pagedata['total'] = $total;
        $this->pagedata['mallcart'] = $new_mallcart;
        $this->pagedata['products'] = $products;
    }

}
