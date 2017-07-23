<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Order extends Mdl_Table
{   
  
    protected $_table = 'card_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,card_id,type,chongzhi_money,give_money,give_jifen';

    public function detail($order_id, $closed=false)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        $where ="o.order_id=ext.order_id AND o.order_id=".$order_id;
        if(empty($closed)){
            $where .= " AND o.closed='0'";
        }
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($row = $this->db->GetRow($sql)){
            $row = K::M('order/order')->order_format_row($row);
            $row = $this->_format_row($row);
        }        
        return $row;
    }


    //确认订单 ，结算订单
    public function confirm($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if(in_array($order['order_status'], array(1,2,3,4,5))){ //-1:已取消，0：未处理，1：已接单，2：已配货，3：开始工作，4：完成工作，5：待完成/补差价，8：订单完成
            $order_id = $order['order_id'];
            if($this->db->update('order', array('order_status'=>8), "order_id='{$order_id}'", true)){ //防止并发
                return true;
            }
        }
        return false;
    }

    public function set_payed($log, $trade=array())
    {        
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($res = $this->db->update('order', array('pay_status' => 1), "order_id='{$order_id}'", true)){
            $order_data = array('online_pay'=>1, 'pay_time'=>__TIME,'lasttime'=>__TIME,'pay_code'=>$trade['code'], 'order_status'=>8, 'trade_no'=>$trade['trade_no'],'payee'=>$log['payee']);
            if($trade['code'] == 'cash'){
                $order_data['online_pay'] = 0;
            }
            K::M('order/order')->update($order_id, $order_data, true);
            if($order['type'] == 'chongzhi'){ //会员卡充值
                $give_money = $give_jifen = 0;
                $give_money = $order['give_money'];
                $give_jifen = $order['give_jifen'];
//                if($shop = K::M('cashier/cashier')->detail($order['shop_id'])){
//                    $_total_price = (int)$order['total_price'];
//                    foreach($shop['package_data'] as $v){
//                        if((int)$v['money'] == $_total_price){
//                            $give_money = $v['give'];
//                            $give_jifen = $v['jifen'];
//                            break;
//                        }
//                    }
//                }
//                $this->update($order_id, array('give_money'=>$give_money, 'give_jifen'=>$give_jifen), true);
                //增加会员卡余额
                if($card = K::M('card/card')->detail($order['card_id'])){
                    $intro = '会员卡充值￥'.$order['total_price'];
                    if($give_money){
                        $intro .= "，赠送￥{$give_money}";
                    }
                    $intro .= "(单号:{$order_id})"; 
                    K::M('card/card')->update_chongzhi($card['card_id'], $order['total_price'] + $give_money, $intro, $order_id);
                    if($give_jifen){
                        K::M('card/card')->update_jifen($card['card_id'], $give_jifen, '会员卡充值赠送积分(单号:'.$order_id.')', $order_id);
                    }
                }
            }else if($card = K::M('card/card')->detail($order['card_id'])){
                $order_amount = $order['money'] + $order['amount'];
                K::M('card/card')->update_order($card['card_id'], $order_amount, '会员卡优惠买单('.$order_id.')', $order_id);
            }
            //在线付款增加可以提现余额
            if(in_array($trade['code'], array('wxpay', 'alipay'))){
                $log_intro = $order['type'] == 'chongzhi' ? '会员卡充值订单('.$order_id.')' : '会员卡优惠买单('.$order_id.')';
                if($order['payee']){ //商户自己帐户收款
                    K::M('shop/shop')->update_total_money($order['shop_id'], $order['amount'], $log_intro);
                }else{
                    K::M('shop/shop')->update_money($order['shop_id'], $order['amount'], $log_intro);
                }
            }
            $a = array('order_id'=>$order_id, 'shop_id'=>$order['shop_id'], 'staff_id'=>$order['staff_id'], 'amount'=>$order['amount'] + $order['money']);
            $a['pay_code'] = $trade['code'];
            $a['type'] = $order['type'];
            K::M('cashier/log')->create($a);
            if($order['staff_id']){
                $type = $trade['code'];
                if(!in_array($type, array('cash', 'money', 'wxpay', 'alipay', 'refund'))){
                    $type = 'cash';
                }
                $staff_day = array("day_{$type}"=>"`day_{$type}`+{$trade['amount']}", 'day_chongzhi'=>"`day_chongzhi`+{$trade['amount']}", 'day_orders'=>'`day_orders`+1');
                if($order['money']){
                    $staff_day['day_money'] = "`day_money`+".$order['money'];
                }
                K::M('cashier/staff')->update($order['staff_id'], $staff_day, true);                
            }
            //更新商户收银统计
            if($order['shop_id']){
                $cashier_data = array("total_{$type}"=>"`total_{$type}`+{$trade['amount']}", "orders"=>"`orders`+1");
                //$cashier_data['total_chongzhi'] = "`total_chongzhi`+{$trade['amount']}";
                if($order['type'] == 'chongzhi'){
                    $cashier_data['total_chongzhi'] = "`total_chongzhi`+{$trade['amount']}";
                }
                if($order['money']){
                    $cashier_data['total_money'] = "`total_money`+".$order['money'];
                }
                K::M('cashier/cashier')->update($order['shop_id'], $cashier_data, true);
            }
            //在线收款推送付款成功推送
            if(in_array($trade['code'], array('wxpay', 'alipay'))) {
                $title = ($trade['code'] == 'wxpay' ? '微信' : '支付宝').'收款到帐通知(￥'.$trade['amount'].')';
                $content = "您有笔".($trade['code'] == 'wxpay' ? '微信' : '支付宝')."收款到帐(单号:{$trade['trade_no']}, ￥:{$trade['amount']})";
                $extras = array('from'=>'payment', 'trade'=>$trade['trade_no'], 'order_id'=>$order_id, 'sound'=>'newMsg.mp3');
                if($order['type'] == 'chongzhi'){
                    $extras['type'] = 'chongzhi';
                }else{
                    $extras['type'] = 'order';
                }
                if($order['staff_id']){
                    K::M('cashier/staff')->send($order['staff_id'], $title, $content, $extras);
                }else{
                    K::M('cashier/staff')->send($order['shop_id'], $title, $content, $extras);
                }
            }
            return true;
        }
        return $res;
    }
}