<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Jifen_Order extends Ctl_Cashier
{

    public function items($params)
    {
        $filter = array('shop_id'=>$this->shop_id);
        if($card_id = (int)$params['card_id']){
            $filter['card_id'] = $card_id;
        }else if($mobile = K::M('verify/check')->mobile($params['mobile'])){
            if($card = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'mobile'=>$mobile))){
                $filter['card_id'] = $card['card_id'];
            }
        }

        $page = max((int)$params['page'], 1);
        $limit = 10;
        $count = 0;
        if($items = K::M('jifen/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $product_ids = $card_ids = array();
            foreach($items as $k=>$v){
                $card_ids[$v['card_id']] = $v['card_id'];
                $product_ids[$v['product_id']] = $v['product_id'];
                $v['product_photo'] = 'default/jifen/product.png';
                $v['card'] = array('card_id'=>0, 'name'=>'游客', 'mobile'=>'');
                $items[$k] = $v;
            }
            if($product_ids){
                $card_list = K::M('card/card')->items(array('shop_id'=>$this->shop_id, 'card_id'=>$card_ids));
                if($product_list = K::M('jifen/product')->items(array('shop_id'=>$this->shop_id, 'product_ids'=>$product_ids))){
                    foreach($items as $k=>$v){
                        if($row = $product_list[$v['product_id']]){
                            $v['product_photo'] = $row['photo'];
                            foreach($card_list as $vv){
                                if($vv['card_id'] == $v['card_id']){
                                    $v['card'] = array('card_id'=>$vv['card_id'], 'name'=>$vv['name'], 'mobile'=>$vv['mobile']);
                                }
                            }
                            $items[$k] = $v;
                        }
                    }
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function create($params)
    {
        if(!$card_id = (int)$params['card_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('请求参数错误', 212);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员不存在', 213);
        }else if($card['shop_id'] != $this->shop_id){
            $this->msgbox->add('会员不存在', 213);
        }else if(!$product = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('兑换的商品不存在', 214);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('兑换的商品不存在', 214);
        }else{
            $num = max((int)$params['num'], 1);
            $total_jifen = $product['jifen'] * $num;
            if($product['stock'] < $num){
                $this->msgbox->add('商品库存不足', 216);
            }else if($card['jifen'] < $total_jifen){
                $this->msgbox->add('积分余额不足', 216);
            }else{
                $data = array('shop_id'=>$this->shop_id, 'card_id'=>$card_id, 'product_id'=>$product_id, 'product_title'=>$product['title'], 'product_jifen'=>$product['jifen']);
                $data['total_jifen'] = $total_jifen;
                $data['order_status'] = 1; //收银员直接替会员兑换订单状态直接设置为已经领取状态
                if($order_id = K::M('jifen/order')->create($data)){
                    K::M('card/card')->update_jifen($card['card_id'], -$total_jifen, '兑换商品('.$product['title'].')', $order_id);
                    K::M('jifen/product')->update($product_id, array('stock'=>"`stock`-{$num}", 'sales'=>"`sales`+$num"), true);
                    $this->msgbox->set_data('data', array('order_id'=>$order_id));
                }
            }
        }
    }

    //确认领取
    public function confirm($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数错误', 211);
        }elseif(!$order = K::M('jifen/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }elseif($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('订单不存在', 213);
        }elseif(!$card = K::M('card/card')->detail($order['card_id'])){
            $this->msgbox->add('订单错误，会员卡不存在', 213);
        }elseif($card['shop_id'] != $this->shop_id){
            $this->msgbox->add('订单错误，会员卡不存在', 213);
        }elseif(K::M('jifen/order')->confirm($order_id, $order)){
            $order = K::M('jifen/order')->detail($order_id);
            $order['card'] = $card;
            $this->msgbox->set_data('data', array('order_detail'=>$order));
        }else{
            $this->msgbox->set_data('兑换失败', 215);
        }
    }

    //取消订单
    public function cancel($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$order = K::M('jifen/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('订单不存在', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消', 213);
        }else if($order['order_status'] > 0){
            $this->msgbox->add('订单已经完成不可取消', 213);
        }else if(K::M('jifen/order')->cancel($order_id, $order)){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }else{
            $this->msgbox->add('取消订单失败');
        }
    }

}
