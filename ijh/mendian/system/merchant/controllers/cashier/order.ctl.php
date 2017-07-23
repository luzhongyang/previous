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

/*收银收款、开单控制器*/
Import::C('cashier');
class Ctl_Cashier_Order extends Ctl_Cashier 
{
    
    public function items()
    {
    	//echo '<pre>';print_r('11');die;
    	//$this->tmpl = 'biz/cashier/order/items.html';
    }

    // 收款index
    public function payee()
    {
    	$gradeids = array();
    	$cashier = K::M('cashier/cashier')->detail($this->shop_id);
    	$this->pagedata['youhui_data'] = $cashier['youhui_data'];
    	$this->pagedata['discount_data'] = $cashier['discount_data'];
    	if($member_items = K::M('card/card')->items(array('shop_id'=>$this->shop_id,'closed'=>0))) {
    		foreach ($member_items as $k => $v) {
    			$gradeids[] = $v['grade_id'];
    		}
    		$card_grade_items = K::M('card/grade')->items_by_ids($gradeids);
    		foreach ($card_grade_items as $k => $v) {
    			foreach ($member_items as $k2 => $v2) {
    				if($v['grade_id'] == $v2['grade_id']) {
    					$member_items[$k2]['discount'] = $v['discount'];
    				}
    			}
    		}
    	}
    	$this->pagedata['member_items'] = $member_items;
    	$this->tmpl = 'merchant:cashier/order/payee.html';
    }

    public function cancel()
    {
        if(!$order_id = (int)$this->GP('order_id')) {
            $this->msgbox->add('无效的订单号', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('无效的订单号', 212);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成不可作废', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经作废过了', 214);
        }else if(K::M('order/order')->cancel($order_id, $order)){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    public function create()
    {
        //card_id,cart,youhui,discount,is_money,is_card_discount
        $params = $_POST;
        if(!$params = $this->check_fields($params,'card_id,cart,youhui,discount,is_money,is_card_discount')) {
        	$this->msgbox->add('非法的数据提交',210)->response();
        }
        if(!$cart = $params['cart']){
            $this->msgbox->add('没有可结算的商品', 211);
        }else{
            // 验证订单商品信息
            //1:200:2,N1:980:2'
            //商品ID:价格:数量,无码商品1
            $products = explode(',',$cart);
            $cart_pids = $order_product_list = $product_ids = array();
            $total_price = $money = $youhui_amount = $moling_amount = $product_number = $card_youhui = 0;
            foreach($products as $k=>$v){
                list($pid, $price, $num) = explode(':', $v);
                if(($num = (int)$num) > 0){
                    if(is_numeric($pid)){
                        $product_ids[$pid] = $pid;
                        $cart_pids[$pid] = $num;
                    }else{
                        $pamount = $price * $num;
                        $total_price += $pamount;
                        $product_number += $num;
                        $order_product_list[$pid] = array('product_id'=>0, 'title'=>$pid, 'price'=>$price, 'num'=>$num, 'amount'=>$pamount); 
                    }  
                }
            }
            if($product_ids){
                if($product_list = K::M('cashier/product')->items(array('product_id'=>$product_ids, 'shop_id'=>$this->shop_id))){
                    foreach($product_list as $k=>$v){
                        $product_number += $cart_pids[$v['product_id']];
                        $pamount = $v['price'] * $cart_pids[$v['product_id']];
                        $total_price += $pamount;
                        $order_product_list[$k] = array('product_id'=>$v['product_id'], 'title'=>$v['title'], 'price'=>$v['price'], 'num'=>$cart_pids[$v['product_id']], 'amount'=>$pamount);
                    }
                }
            }
            $card = null;
            if(($card_id = (int)$params['card_id']) && ($card = K::M('card/card')->detail($card_id))){
                if($card['shop_id'] != $this->shop_id){
                    $card = null;
                }
            }
            //如果提交来的订单没有有效的商品返回错误
            if(!$order_product_list){
                $this->msgbox->add('没有可结算的商品', 213)->response();
            }
            $youhui_title = array();
            //会员卡折扣
            if($card && $params['is_card_discount']){
                if($grade = K::M('card/grade')->detail($card['grade_id'])){
                    $youhui_amount =  $total_price - bcmul($total_price , bcdiv($grade['discount'], 10, 2));
                    $youhui_title[] = "会员卡".$grade['discount'].'折';
                }
            }
            if(($discount = (float)$params['discount']) > 0){
                if($discount  < 10){
                    //youhui_amount = $total_price * $discount / 10;
                    $youhui_amount += ($total_price-$youhui_amount) - bcmul(($total_price-$youhui_amount) , bcdiv($discount, 10, 2));
                    $youhui_title[] = "整单".$discount.'折';
                }
            }else if(($youhui = (float)$params['youhui']) > 0){
                if(($total_price-$youhui_amount) > $youhui){
                    $youhui_amount += $youhui;
                    $youhui_title[] = "整单减".$youhui.'元';
                }
            }
            //结算金额抹零
            $moling_amount = K::M('cashier/cashier')->moling_amount($total_price-$youhui_amount, $this->shop);
            $order_data = array('shop_id'=>$this->shop_id, 'staff_id'=>$this->staff_id);
            if($params['pay_code']){
                $order_data['pay_code'] = $params['pay_code'];
            }
            $order_card_id = 0;
            if($card){
                $order_card_id = $card['card_id'];
                $order_data['uid'] = $card['uid'];
                //先择了会员卡余额抵扣,如果可以抵扣完刚全部抵扣
                if($params['is_money']){
                    if($card['money'] >= ($total_price - $moling_amount - $youhui_amount)){
                        $money = ($total_price - $moling_amount - $youhui_amount);
                        $order_data['pay_code'] = 'money';
                        $order_data['pay_time'] = __TIME;
                        $order_data['order_status'] = 0; //订单完成
                    }else{
                        $money = $card['money'];
                    }
                }                    
            }
            $order_youhui = $moling_amount + $youhui_amount;
            $amount = $total_price - $money - $order_youhui;
            $order_data['money'] = $money;
            $order_data['amount'] = $amount;
            $order_data['order_youhui'] = $order_youhui;
            $order_data['total_price'] = $total_price;
            $order_data['day'] = date('Ymd', __TIME);
            $order_data['lasttime'] = __TIME;
            $order_data['from'] = 'cashier';
            if($order_id = K::M('order/order')->create($order_data)){
                $cashier_data = array(
                    'order_id'=>$order_id,
                    'card_id'=>$order_card_id, 
                    'type'=>'cashier',
                    'product_number'=>$product_number, 
                    'product_price'=>$total_price, 
                    'youhui_title'=>implode(',', $youhui_title), 
                    'youhui_amount'=>$youhui_amount, 
                    'moling_amount'=>$moling_amount
                );
                K::M('cashier/order')->create($cashier_data);
                foreach($order_product_list as $v){
                    $a = array('order_id'=>$order_id,'product_id'=>$v['product_id'], 'product_title'=>$v['title'],'product_price'=>$v['price'], 'product_number'=>$v['num'], 'amount'=>$v['amount']);
                    K::M('cashier/order/product')->create($a);
                }
                if($money){
                    K::M('card/card')->update_money($card['card_id'], -$money, '会员卡支付订单('.$order_id.')', $order_id);
                    if($order_data['amount'] == 0){
                        $order = K::M('cashier/order')->detail($order_id);
                        if($trade = K::M('trade/payment')->order('money', $order)){
                            if(K::M('payment/log')->set_payed($trade['trade_no'], $trade['trade_no'])){
                                $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                                K::M('order/order')->set_payed($log, $trade);
                            }
                        }
                    }
                }
                $card = K::M('card/card')->detail($order_card_id);
                $card_detail['mobile'] = $card['mobile'];
                $card_detail['name'] = $card['name'];
                $card_detail['money'] = $card['money'];
                $card_detail['jifen'] = $card['jifen'];
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('order_id'=>$order_id, 'amount'=>$amount, 'card'=>$card_detail));
            }
        }        
    }

    // 生成订单之后现金入账
    public function cashpay()
    {
        if(!$order_id = (int)$this->GP('order_id')){
            $this->msgbox->add('无效的订单号', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单已经完成不可作废', 212);
        }else if($order['order_status'] < 0 || $order['order_status'] == 8){
            $this->msgbox->add('订单状态不可支付', 213);
        }else if($order['pay_status']){
            $this->msgbox->add('订单已经支付过了', 214);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 215);
        }else if(($shishou_amount = (float)$this->GP('shishou_amount') < $order['amount'])){
            $this->msgbox->add('实收金额不能小于订单金额', 215);
        }else if($trade = K::M('trade/payment')->cashpay($order)){
            $log = K::M('payment/log')->log_by_no($trade['trade_no']);
            if(K::M('cashier/order')->set_payed($log, $trade)){
                $zhaoling_amount = $shishou_amount - $order['amount'];
                if($zhaoling_amount || $shishou_amount){
                    K::M('cashier/order')->update($order_id, array('shishou_amount'=>$shishou_amount, 'zhaoling_amount'=>$zhaoling_amount));
                }
                $this->msgbox->add('success');
                $card = K::M('card/card')->detail($order['card_id']);
                $card_detail['mobile'] = $card['mobile'];
                $card_detail['name'] = $card['name'];
                $card_detail['money'] = $card['money'];
                $card_detail['jifen'] = $card['jifen'];
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('trade_detail'=>$trade,'card'=>$card_detail));
            }
        }
    }
}