<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Mall_Order extends Ctl
{
	// 下单
	public function create($params){
        $this->check_login();
        if(!$addr_id = $params['addr_id']){
            $this->msgbox->add('收货地址不存在',213);
        }else if(!$addr = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('收货地址不存在',215);
        }else if($addr['uid'] != $this->uid){
            $this->msgbox->add('非法操作',216);
        }else if(!$params['cart_str']){
            $this->msgbox->add('没有选择商品',216);
        }else{
            $cart_str = explode(',',$params['cart_str']);
            $mallcart = array();  //封装购物车数组
            foreach($cart_str as $csk => $csv){
                $csv = explode(':',$csv);
                $mallcart[$csv[0]] = $csv[1];
            }
            K::M('system/logs')->log('mall',$mallcart);
            foreach($mallcart as $k=>$v){
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
                    'product_id'        => $product['product_id'],
                    'product_name'      => $product['title'],
                    'product_jifen'     => $product['jifen'],
                    'product_number'    => $v,
                    'product_price'     => $product['price']
                );
            }
            if(isset($nosku)){
                $this->msgbox->add('商品'.$nosku.'库存不足，请重新下单',217);
            }elseif($this->MEMBER['jifen'] < $total['jifen']){
                $this->msgbox->add('您的积分不足',218);
            }else{
                $order_data = array(
                    'city_id'       => 1,
                    'shop_id'       => 0,
                    'staff_id'      => 0,
                    'uid'           => $this->uid,
                    'from'          => 'mall',
                    'order_status'  => 0,
                    'online_pay'    => 1,
                    'pay_status'    => 0,
                    'total_price'   => $total['price'],
                    'amount'        => $total['price'] + max($freight),
                    'contact'       => $addr['contact'],
                    'mobile'        => $addr['mobile'],
                    'lng'           => $addr['lng'],
                    'lat'           => $addr['lat'],
                    'house'         => $addr['house'],
                    'addr'          => $addr['addr'],
                    'pei_amount'    => max($freight),
                    'order_from'    => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                );
 
                if($order_id = K::M('order/order')->create($order_data)) {
                    foreach($mall_order_data as $key => $val) {
                        $val['order_id'] = $order_id;
                        K::M('mall/order')->create($val);     
                    }
                    K::M('member/member')->update_jifen($this->uid, -$total['jifen'], '商城订单(ID:'.$order_id.')下单花费积分', 'member');
                    K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'商城订单已提交成功','type'=>1,'kind'=>'mall'));
                    $this->cookie->set('mallcart', '');
                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('data', array('order_id'=>$order_id,'dateline'=>time()));
                }else {
                    $this->msgbox->add('下单失败',219);
                }     
            }
        }
    }

    // 积分商城订单列表
	public function items($params)
	{
		$this->check_login();
		$filter = array();
        $filter['uid'] = $this->uid;
        $filter['from'] = 'mall';
        $filter['closed'] = 0;
        $page = max((int)$params['page'], 1);
        if($items = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, 10, $count)) {
            foreach($items as $k => $v){
                $items[$k] = $this->filter_fields('order_id,city_id,uid,from,order_status,pay_status,total_price,amount,contact,mobile,addr,house,lat,lng,pei_amount,day,dateline,pay_code',$v);
                $items[$k]['product'] = array_values(K::M('mall/order')->items(array('order_id'=>$v['order_id'])));
                foreach($items[$k]['product'] as $kk => $vv){
                    $d = K::M('mall/product')->detail($vv['product_id']);
                    $items[$k]['product'][$kk]['photo'] = $d['photo'];
                }
            }
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
	}
    
    
    public function detail($params){
        $this->check_login();
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单ID不存在！');
        }elseif(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单错误！');
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add('非法操作！');
        }else{
            $detail = $this->filter_fields('order_id,city_id,uid,from,order_status,pay_status,total_price,amount,contact,mobile,addr,house,lat,lng,pei_amount,day,dateline,pay_code',$detail);
            $detail['product'] = array_values(K::M('mall/order')->items(array('order_id'=>$order_id),array('pid'=>'desc'),1,1000));
            foreach($detail['product'] as $k => $v){
                $p = K::M('mall/product')->detail($v['product_id']);
                $detail['product'][$k]['photo'] = $p['photo'];
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }
    
    public function complete($params){
        $this->check_login();
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单ID不存在！');
        }elseif(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单错误！');
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作！');
        }elseif(!$complete = K::M('order/order')->update($order_id,array('order_status'=>8))){
            $this->msgbox->add('收货失败！');
        }else{
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已完成','type'=>6));
            $this->msgbox->add('收货成功！');
        }
    }
    
    public function cancel($params){
        $this->check_login();
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单ID不存在！');
        }elseif(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单错误！');
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作！');
        }elseif($order['order_status'] == 3){
            $this->msgbox->add('订单已发货，不能取消！');
        }else{
            if($params['remark']){
                $remark = '订单由于：“'.$params['remark'].'”，被用户取消';
            }else{
                $remark = '订单已取消';
            }
            if(K::M('order/order')->cancel($order_id, $order, 'member', $remark)) {
                $this->msgbox->add('取消成功！');
            }
        }
    }
    
    public function delete($params){
        $this->check_login();
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单ID不存在！');
        }elseif(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单错误！');
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作！');
        }else{
            K::M('order/order')->delete($order_id);
            $this->msgbox->add('删除成功！');
        }
    }
    

}