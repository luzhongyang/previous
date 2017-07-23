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

class Ctl_Cashier_Order extends Ctl_Cashier
{

    public function items($params)
    {
        $filter = array('from'=>'cashier', 'order_status'=>'>=:0');
        // if($this->staff['is_owner']){
        //     $filter['shop_id'] = $shop_id;
        // }else{
        //     $filter['staff_id'] = $this->staff_id;
        // }
        $filter['staff_id'] = $this->staff_id;
        if($params['day'] && in_array($params['day'], array('today', 'week', 'month'))){
            switch($params['day']){
                case 'today' :
                    $filter['dateline'] = $this->system->sdaytime;
                    break;
                case 'week':
                    $stime = $this->system->sdaytime - 86400*7;
                    $filter['dateline'] = $stime.'~'.$this->system->sdaytime;
                    break;
                case 'month' : 
                    $stime = $this->system->sdaytime - 86400*30;
                    $filter['dateline'] = $stime.'~'.$this->system->sdaytime;
                    break;
            }
        }
        if($params['code'] && in_array($params['code'], array('wxpay,alipay,cash,refund'))){
            $filter['pay_code'] = $params['code'];
        }
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $items = array();
        if($order_list = K::M('order/order')->items($filter, null, $page, $limit)){
            $order_ids = array();
            foreach($order_list as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($items = K::M('cashier/order')->items_by_ids($order_ids)){
                $order_ids = $staff_ids = array();
                foreach($items as $k=>$v){
                    $row = array_merge($order_list[$k], $v);
                    $order_ids[$v['order_id']] = $row['order_id'];
                    $staff_ids[$v['staff_id']] = $row['staff_id'];
                    $row['product_list'] = array();
                    $row['staff'] = array('staff_id'=>$row['staff_id'], 'name'=>'', 'mobile'=>'');
                }
                if($staff_ids){
                    if($staff_list = K::M('cashier/staff')->items_by_ids($staff_ids)){
                        foreach($items as $k=>$v){
                            if($row = $staff_list[$v['staff_id']]){
                                $v['staff'] = array('staff_id'=>$row['staff_id'], 'name'=>$row['name'], 'mobile'=>$row['mobile']);
                                $items[$k] = $v;
                            }
                        }
                    }
                }
                if($order_ids){
                    if($product_list = K::M('cashier/order/product')->items(array('order_id'=>$order_ids), null, 1, 500)){
                        foreach($product_list as $v){
                            $items[$v['order_id']]['product_list'][] = $v;
                        }
                    }
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function detail($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限查看该订单', 213);
        }else if(empty($this->staff['is_owner']) && ($order['staff_id'] != $this->staff_id)){
            $this->msgbox->add('您没有权限查看该订单', 214);
        }else{
            $order['staff'] = array('staff_id'=>$this->staff_id, 'name'=>$this->staff['name'], 'mobile'=>$this->staff['mobile']);
            if($order['staff_id'] != $this->staff_id){
                if($staff = K::M('cashier/staff')->detail($order['staff_id'])){
                    if($staff['shop_id'] == $this->shop_id){
                        $order['staff'] = array('staff_id'=>$staff['staff_id'],  'name'=>$staff['name'],  'mobile'=>$staff['mobile']);
                    }
                }   
            }
            if($product_list = K::M('cashier/order/product')->items(array('order_id'=>$order_id), null, 1, 100)){
                $order['product_list'] = array_values($product_list);
            }else{
                $order['product_list'] = array();
            }
            //会员卡
            $order['member_card'] = array('card_id'=>0, 'number'=>'', 'name'=>'', 'mobile'=>'');
            if($order['card_id'] && ($card = K::M('card/card')->detail($order['card_id']))){
                $order['member_card'] = array('card_id'=>$card['card_id'], 'number'=>$card['number'], 'name'=>$card['name'], 'mobile'=>$card['mobile']);
            }
            //是否有退款记录
            if(($refund_id = (int)$order['refund_id']) && ($refund_log = K::M('cashier/log')->detail($refund_id))){
                $order['refund_amount'] = $refund_log['amount'];
            }else{
                $order['refund_amount'] = 0;
                $refund_log = array('log_id'=>0);
            }
            if(!$cashier_log = K::M('cashier/log')->find(array('order_id'=>$order_id, 'type'=>'order'))){
                $cashier_log = array('log_id'=>0);
            }
            $this->msgbox->set_data('data', array('order_detail'=>$order, 'cashier_log'=>$cashier_log, 'refund_log'=>$refund_log));
        }
    }

    public function create($params)
    {
        //card_id,cart,youhui,discount,money
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
            //如果提交来的订单没有有效的商品返回错误
            if(!$order_product_list){
                $this->msgbox->add('没有可结算的商品', 213)->response();
            }
            $card = $coupon = null;
            $coupon_log_id = $coupon_amount = 0;
            $discount = (float)$params['discount'];
            $youhui = (float)$params['youhui'];

            if(($card_id = (int)$params['card_id']) && ($card = K::M('card/card')->detail($card_id))){
                if($card['shop_id'] != $this->shop_id){
                    $card = null;
                }
            }
            // 卡券
            if ($coupon_number = (int)$params['coupon_number']) {
                if ($coupon = K::M('cashier/coupon/log')->find(array('shop_id'=>$this->shop_id,'number'=>$coupon_number))) {
                    if ($coupon['is_used'] != 0 || $coupon['order_id'] != 0 || $coupon['ltime'] <= __TIME) {
                        $this->msgbox->add('卡券已使用或已过期', 214)->response();
                    }
                    if ($coupon['stime'] > __TIME) {
                        $this->msgbox->add('卡券没有到达使用时间', 215)->response();
                    }
                    if (!empty($card)) {
                        if (!empty($coupon['card_id']) && $coupon['card_id'] != $card['card_id']) {
                            $this->msgbox->add('请勿使用他人的卡券', 216)->response();
                        }elseif (!empty($coupon['wx_openid']) && $coupon['wx_openid'] != $card['wx_openid']) {
                            $this->msgbox->add('请勿使用他人的卡券', 216)->response();
                        }
                    }else{// 没有会员卡越权判断
                        if (!empty($coupon['card_id'])) {
                            $this->msgbox->add('请勿使用他人的卡券', 216)->response();
                        }
                    }
                    if ($coupon['shop_id'] != $this->shop_id) {
                        $this->msgbox->add('请勿使用其他店铺的卡券', 216)->response();
                    }
                    if (!empty($coupon['min_price'])) {// 最低消费
                        if ($coupon['min_price'] > $total_price) {
                            $this->msgbox->add('卡券不满足最低消费', 217)->response();
                        }
                    }else{// 消费即抵
                        if ($coupon['amount'] >= $total_price) { // 抵扣金额超过订单总额
                            $coupon['amount'] = $total_price;
                            $card = $discount = $youhui = null;// 其他优惠就不需要了
                        }
                    }
                }else{
                    $this->msgbox->add('没有可使用的卡券', 218)->response();
                }
            }
            $youhui_title = array();

            //=====================优先级顺序: 卡券优惠>>>会员卡打折>>>整单优惠>>>抹零设置=====================
            // 卡券抵扣
            if (!empty($coupon)) {
                $coupon_log_id = $coupon['log_id'];
                $coupon_amount = $coupon['amount'];
                $youhui_amount += $coupon['amount'];
                $youhui_title[] = "卡券抵扣".$coupon['amount'].'元';
            }
            //会员卡折扣
            if($card && $params['is_card_discount']){
                if($grade = K::M('card/grade')->detail($card['grade_id'])){
                    $youhui_amount += ($total_price-$youhui_amount) - bcmul(($total_price-$youhui_amount) , bcdiv($grade['discount'], 10, 2), 2);
                    $youhui_title[] = "会员卡".$grade['discount'].'折';
                }
            }
            // 整单优惠
            if($discount > 0){
                if($discount  < 10){
                    //youhui_amount = $total_price * $discount / 10;
                    $youhui_amount += ($total_price-$youhui_amount) - bcmul(($total_price-$youhui_amount) , bcdiv($discount, 10, 2), 2);
                    $youhui_title[] = "整单".$discount.'折';
                }
            }else if($youhui > 0){
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
                        $this->msgbox->add('会员卡余额不足', 221)->respose();
                        //$money = $card['money'];
                    }
                }                    
            }
            $order_youhui = $moling_amount + $youhui_amount;
            $amount = $total_price - $money - $order_youhui;
            if($amount <= 0){
                $this->msgbox->add('订单应收款项不能为0', 222)->response();
            }
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
                    'moling_amount'=>$moling_amount,
                    'coupon_log_id'=>$coupon_log_id,
                    'coupon_amount'=>$coupon_amount
                );
                K::M('cashier/order')->create($cashier_data);
                if (!empty($coupon)) {
                    K::M('cashier/coupon/log')->update($coupon['log_id'], array('is_used'=>1));
                    K::M('cashier/coupon')->update_count($coupon['coupon_id'], 'used_count', 1);// 原有基础增加已经核销数
                }
                foreach($order_product_list as $v){
                    $a = array('order_id'=>$order_id,'product_id'=>$v['product_id'], 'product_title'=>$v['title'],'product_price'=>$v['price'], 'product_number'=>$v['num'], 'amount'=>$v['amount']);
                    K::M('cashier/order/product')->create($a);
                }
                if($money > 0){
                    K::M('card/card')->update_money($card['card_id'], -$money, '会员卡余额支付订单('.$order_id.')', $order_id);
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
                $this->msgbox->set_data('data', array('order_id'=>$order_id, 'amount'=>$amount));
            }
        }        
    }

    public function refund($params)
    {
        
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 213);
        }else if(empty($this->staff['is_owner']) && $this->staff_id != $order['staff_id']){
            $this->msgbox->add('您没有权限操作', 213);
        }else if(empty($order['pay_status'])){
            $this->msgbox->add('订单未支付无需退款', 213);
        }else if($order['refund_id'] > 0){
            $this->msgbox->add('订单已经退款过了', 214);
        }else if(($money = (float)$params['money']) <= 0){
            $this->msgbox->add('退款金额不合法', 215);
        }else if($money > bcadd($order['amount'], $order['money'], 2)){
            $this->msgbox->add('退款金额不合法', 215);
        }else if($order['type'] == 'chongzhi'){
            $this->msgbox->add('充值订单不可退款', 216);
        }else if($order['pay_time'] < $this->system->sdaytime){
            $this->msgbox->add('只有当班订单才能退款', 217);
        }else{
            $is_refund_card = 0;
            if($order['card_id'] && $params['is_refund_card']){ //全部退还到余额
                $is_refund_card = 1;
                $refund_amount = 0;
                $refund_card_money = $order['amount'] + $order['money'];
            }else if($money > $order['amount']){ //如果使用了余额，优先退其他支付方式(cash,wxpay,alipay)
                $refund_amount = $order['amount'];
                $refund_card_money = $money - $order['amount'];
            }else{
                $refund_amount = $money;
                $refund_card_money = 0;
            }
            $refund_res = false;
            if(($refund_amount > 0) && in_array($order['pay_code'], array('alipay', 'wxpay'))){ //原支付通道返回
                $order['refund_amount'] = $refund_amount;
                $order['refund_reason'] = $params['refund_reason'] ? $params['refund_reason'] : '订单正常退款';
                if($trade = K::M('trade/payment')->refund($order['pay_code'], $order)){
                    if($shop_id = $order['shop_id']){
                        K::M('cashier/cashier')->update_money($shop_id, -$refund_amount, $order['refund_reason']."(ID:{$order_id})");
                    }
                    $refund_res = true;
                }
            }else{ //cash退款
                $refund_res = true;
            }
            if($refund_res){
                //退回会员卡余额
                if($order['card_id'] && $refund_card_money){
                    K::M('card/card')->update_money($order['card_id'], $refund_card_money, $order['refund_reason']."({$order_id})", $order_id);
                }
                $data = array(
                        'shop_id'   => $this->shop_id, 
                        'staff_id'  => $this->staff_id, 
                        'order_id'  => $order_id, 
                        'amount'    => $money, 
                        'type'  => 'refund',
                        'dateline'  => __TIME
                    );
                $pay_code = $is_refund_card ? 'money' : $order['pay_code'];
                if(!in_array($pay_code, array('money', 'cash', 'wxpay', 'alipay'))){
                    $pay_code = 'cash';
                }
                $data['refund_info'] = array(
                        'refund_type' => $pay_code,
                        'refund_amount'=>$refund_amount,
                        'refund_card_money'=>$refund_card_money,
                        'refund_reason'=>$order['refund_reason']
                    ); 
                $data['pay_code'] = $pay_code;
                if($log_id = K::M('cashier/log')->create($data)){
                    K::M('cashier/order')->update($order_id, array('refund_id'=>$log_id));
                    if($staff_id = $order['staff_id']){
                        $refund_data = array(
                                'day_refund_count'  => "`day_refund_count`+1",
                                'day_refund'        => "`day_refund`+{$money}",
                                'day_refund_'.$pay_code => "`day_refund_{$pay_code}`+{$refund_amount}", 
                                'day_refund_money' => "`day_refund_money`+{$refund_card_money}"
                            );
                        K::M('cashier/staff')->update($staff_id, $refund_data, true);
                    }
                    $data = array(
                            'order_id'  => $order['order_id'],
                            'log_id'    => $log_id,
                            'refund_amount' => $refund_amount,
                            'refund_card_money' => $refund_card_money
                        );
                    $this->msgbox->set_data('data', $data);
                }                
            }else{
                $this->msgbox->add('退款失败', 221);
            }
        }
    }

    public function cancel($params)
    {
        if(!$order_id = (int)$params['order_id']){
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

    public function query($params)
    {
        
    }

    public function log($params)
    {
        if($this->staff['is_owner']){
            $filter = array('shop_id'=>$this->shop_id);
        }else{
            $filter = array('staff_id'=>$this->staff_id);
        }
        if(in_array($params['code'], array('cash','money','wxpay','alipay','refund','qrcode'))){
            $filter['pay_code'] = $params['code'];
        }
        if(in_array($params['type'], array('order', 'chongzhi', 'refund'))){
            $filter['type'] = $params['type'];
        }
        if($oid = (int)$params['order_id']){
            $filter['order_id'] = "LIKE:%{$oid}%";
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('cashier/log')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function tongji($params)
    {
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('shop_id'=>$this->shop_id, 'day'=>$lday.'~'.$sday);
        $today_count = $week_count = $month_count = $total_count = 0;
        $today_amount = $week_amount = $month_amount = $total_amount = 0;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('day'=>$day, 'date'=>$date, 'count'=>0, 'amount'=>0);
        }

        if($count_list = K::M('cashier/log')->count_by_day($filter, 1, 31)){
            foreach($count_list as $k=>$v){
                if($sday == $v['day']){
                    $today_count  = $v['day_order'];
                    $today_amount = $v['day_amount'] - $v['day_refund'];
                }else{
                    if($week_day <= $v['day']){
                        $week_count += $v['day_order'];
                        $week_amount += $v['day_amount'] - $v['day_refund'];
                    }
                    $month_count += $v['day_order'];
                    $month_amount += $v['day_amount'] - $v['day_refund'];
                    $items[$k]['count'] = $v['day_order'];
                    $items[$k]['amount'] = $v['day_amount'] - $v['day_refund'];
                }
            }
        }
        foreach($items as $k=>$v) {
            if(!$v['day'] && !$v['date']) {
                unset($items[$k]);
            }
        }
        if($total_order = K::M('cashier/log')->total_order(array('shop_id'=>$this->shop_id))){
            $total_count = $total_order['total_order'];
            $total_amount = $total_order['total_amount'];
        }
        $this->msgbox->set_data('data', 
            array(
                'items'         => array_values($items), 
                'total_count'   => $total_count, 
                'today_count'   => $today_count, 
                'week_count'    => $week_count,
                'month_count'   => $month_count,
                'total_amount'  => $total_amount,
                'today_amount'  => $today_amount,
                'week_amount'   => $week_amount,
                'month_amount'  => $month_amount,
                'money'         => $this->shop['money'] //可提现金额
            )
        );
    }

    public function printer($params)
    {
        if(!$printer_id = (int)$params['printer_id']){
            $this->msgbox->add('参数错误', 211);
        }else if($order_id = (int)$params['order_id']){
            $this->msgbox->add('参数错误', 212);
        }else if($printer = K::M('shop/printer')->detail($printer_id)){
            $this->msgbox->add('打印机不存在', 213);
        }else if($printer['shop_id'] != $this->shop_id){
            $this->msgbox->add('打印机不存在', 214);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('打印人订单不存', 215);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('订单不存在或已经删除', 215);
        }else{
            $printerObj = K::M('printer/printer');
            $printerObj->init($printer);
            $num = max((int)$params['num'], 1); 
            $printerObj->send('cashier_order', $order, $num);
        }
    }
}