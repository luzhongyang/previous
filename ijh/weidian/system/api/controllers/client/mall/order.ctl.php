<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Mall_Order extends Ctl
{

    protected $_allow_fields = '';
	/* 插入兑换记录
     * @param product_id
     * @param product_number
     * @param addr_id
     */
	public function create($params)
	{
        $this->check_login();
        if(!$addr_id = (int)$params['addr_id']){
            $this->msgbox->add('未指定收获地址', 211);
        }else if(!$addr = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('未指定收获地址', 212);
        }else if($addr['uid'] != $this->uid){
            $this->msgbox->add('未指定收获地址', 213);
        }else if(!$mcart = explode(',', $params['mcart'])){
            $this->msgbox->add('您还没有选择商品', 214);
        }else{
            $plist = $pids = array();
            foreach($mcart as $v){
                list($pid, $num) = explode(':', $v);
                $pid = (int)$pid; $num = (int)$num;
                if($pid && $num){
                    $pids[$pid] = $pid;
                    $plist[$pid] = $num;
                }
            }
            if($pids && ($product_list = K::M('mall/product')->items_by_ids($pids))){
                $product_price = $product_jifen = $product_number = $freight;
                foreach($product_list as $k=>$v){
                    if($v['sku'] < $plist[$k]){
                        $this->msgbox->add("[{$v['product']}]库存不足", 221)->response();
                    }
                    if($v['freight'] > $freight){
                        $freight = $v['freight'];
                    }
                    $product_number += $plist[$k];
                    $product_price += $v['price'] * $plist[$k];
                    $product_jifen += $v['jifen'] * $plist[$k];
                }
                if($product_jifen && $product_jifen > $this->MEMBER['jifen']){
                    $this->msgbox->add("您的积分不足", 221)->response();
                }
                $total_price = $product_price + $freight;
                $order_data = array(
                    'uid'           =>$this->uid,
                    'total_price'   => $total_price,
                    'contact'       => $addr['contact'],
                    'mobile'        => $addr['mobile'],
                    'addr'          => $addr['addr'],
                    'house'         => $addr['house'],
                    'lng'           => $addr['lng'],
                    'lat'           => $addr['lat'],
					'from'          => 'mall',
                    'amount'        => $total_price,
                    'online_pay'    => 1,
                    'order_from'    =>strtolower(CLIENT_OS)
                );
                //不需要支付时直接设置订单状态为已支付
                if(empty($total_price)){
                    $order_data['pay_status'] = 1;
                }
                if($order_id = K::M('order/order')->create($order_data)){
                    $mall_order_data = array('order_id'=>$order_id, 'product_price'=>$product_price, 'product_jifen'=>$product_jifen, 'product_number'=>$product_number, 'freight'=>$freight);
                    K::M('mall/order')->create($mall_order_data, true);
                    foreach($product_list as $k=>$v){
                        $a = array(
                            'order_id'=>$order_id,
                            'product_id'=>$v['product_id'],
                            'product_price'=>$v['price'],
                            'product_jifen'=>$v['jifen'],
                            'product_name'=>$v['title'],
                            'product_number' => $plist[$k]
                        );
                        //创建订单商品表，并更新商品表库存销量
                        if($pid = K::M('mall/order/product')->create($a)){
                            K::M('mall/product')->update($pid, array('sales'=>'`sales`+'.$plist[$k], 'sku'=>'`sku`-'.$plist[$k]), true);
                        }
                    }
                    K::M('member/member')->update_account($this->uid, 'jifen', -$product_jifen, $intro='积分商城订单('.$order_id.')，扣除积分');
                    $this->msgbox->set_data('data', array('order_id'=>$order_id));
                }
            }else{
                $this->msgbox->add('您还没有选择商品', 214);
            }
        }
	}


    /* 产品列表
     * @param page
     */
    public function items($params)
    {
        $this->check_login();
        $filter = array('uid'=>$this->uid, 'closed'=>0, 'from'=>'mall');
        $orderby = array('order_id'=>'DESC');
        $type = $params['type'];
        if($params['type']){
            $filter['order_status'] = array(-1, -2, 8);
        }else{
            $filter['order_status'] = array(0, 1, 2, 3, 4, 5);
        }            
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $items = array();
        if($order_items = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)) {
            foreach($order_items as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($mall_order_items = K::M('mall/order')->items_by_ids($order_ids)){
                $order_ids = array();
                foreach($mall_order_items as $k=>$v){
                    $order_ids[$v['order_id']] = $v['order_id'];
                    $v['product_list'] = array();
                    $items[$k] = array_merge($order_items[$k], $v);
                }
                if($order_product_list = K::M('mall/order/product')->items(array('order_id'=>$order_ids), null, 1, 500)){
                    $product_ids = array();
                    foreach($order_product_list as $k=>$v){
                        $product_ids[$v['product_id']] = $v['product_id'];
                        $v['product_photo'] = 'default/mall_product.png';
                        $order_product_list[$k] = $v;
                    }
                    if($product_list = K::M('mall/product')->items_by_ids($product_ids)){
                        foreach($order_product_list as $k=>$v){
                            if($row = $product_list[$v['product_id']]){
                                $v['product_photo'] = $row['photo'];
                            }
                            $items[$v['order_id']]['product_list'][] = $v;
                        }
                    }
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查看该订单', 212);
        }else{
            $order['product_list'] = array();
            if($order_product_list = K::M('mall/order/product')->items(array('order_id'=>$order_id), null, 1, 500)){
                $product_ids = array();
                foreach($order_product_list as $k=>$v){
                    $product_ids[$v['product_id']] = $v['product_id'];
                    $v['product_photo'] = 'default/mall_product.png';
                    $order_product_list[$k] = $v;
                }
                if($product_list = K::M('mall/product')->items_by_ids($product_ids)){
                    foreach($order_product_list as $k=>$v){
                        if($row = $product_list[$v['product_id']]){
                            $v['product_photo'] = $row['photo'];
                        }
                        $order['product_list'][] = $v;
                    }
                }
            }
            $this->msgbox->set_data('data', array('order'=>$order));
        }
    }

    public function confirm($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该该订单', 212);
        }else if($order['order_status'] != 3){
            $this->msgbox->add('该订单状态不能确定', 449);
        }else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该该订单', 212);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('订单不能取消', 449);
            return false;
        }else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }
}
