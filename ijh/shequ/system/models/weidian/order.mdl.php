<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Order extends Mdl_Table
{
    protected $_table = 'weidian_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,product_price,product_number,freight,spend_number,spend_status,type,sid,invite1,invite2,invite3,shop_amount,amount_1,amount_2,amount_3';
    
    
    public function items_by_status($filter, $orderby, $page=1, $limit=10, &$count=0)
    {
        
        $where = '1';
        $ext_sql = '';
        if(is_array($filter)){
            if(isset($filter['weidian'])){
                $where = $this->where($filter['weidian'], 'ext.');
                $ext_sql = " LEFT JOIN ".$this->table($this->_table)." ext ON o.`order_id`=ext.`order_id` ";
            }
        }
        $where = $where ." AND ". K::M('order/order')->where($filter, 'o.');
        $orderby = $this->order($orderby);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT COUNT(*) FROM ".$this->table('order') . " o " . $ext_sql . " WHERE $where";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT o.*,ext.product_price,ext.product_number,ext.freight,ext.type,ext.spend_number,ext.spend_status,ext.sid,ext.invite1,ext.invite2,ext.invite3,ext.shop_amount,ext.amount_1,ext.amount_2,ext.amount_3 FROM ". $this->table('order')." o $ext_sql WHERE $where $orderby $limit";
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $row = $this->_format_row($row);
                    if($row[$this->_pk]){
                        $items[$row[$this->_pk]] = $row;
                    }else{
                        $items[] = $row;
                    }
                }
            }
        }
        return $items;
    }
    
    public function order_by_sid($filter, $page=1, $limit=50, &$count=0)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $items = array();
        $sql = "SELECT COUNT(1) FROM ".$this->table($this->_table)." WHERE $where GROUP BY `uid`";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT uid, SUM(`amount`+`money`) as total_amount, COUNT(1) total_order FROM ".$this->table($this->_table)." WHERE $where GROUP BY `uid` ORDER BY `uid` $limit";
            if($rs = $this->db->Execute($sql)){
                $count = $this->db->GetOne("SELECT FOUND_ROWS()");
                while($row = $rs->fetch()){
                    $items[$row['uid']] = $row;
                }
            }
        }
        return $items;    
    }
    public function detail($order_id, $closed=false)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        if(empty($closed)){
            $where .= " AND o.closed='0'";
        }
        $where ="o.order_id=ext.order_id AND o.order_id=".$order_id;
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($row = $this->db->GetRow($sql)){
            $row = K::M('order/order')->order_format_row($row);
        }   
        return $row;
    }
    
    public function get_payment_amount($order_id, &$level=0)
    {
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($order['pay_status']){
            return false;
        }else if($order['order_status']<0 || $order['order_status']==8){
            return false;
        }else{
            $level = 0;
            //拼团,多次支付
            if( 'pintuan' == $order['type'] ){
                $arr_p_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order['order_id']));
                if(1 == $arr_p_order['is_money_pre']){
                    if(0 == $arr_p_order['money_paid']){
                        //1.预付款
                        $order['amount'] = $arr_p_order['money_need_pay'];
                    }
                    elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                        //2.付尾款
                        $level = 1;
                        $order['amount'] = abs(($arr_p_order['product_price']*$arr_p_order['product_number']) - $arr_p_order['money_paid']);
                    }
                }
            }
            $amount = $order['amount'];
        }
        return $amount;
    }
    //返回订单需要退回的金额
    public function get_return_amount($order_id, $order=null)
    {
        $amount = 0;
        if($order === null && !($order = $this->detail($order_id))){
            return false;
        }else if($order['order_status'] < 0 || $order['order_status'] == 8){
            return false;
        }else if($order['pay_status']){
            $amount = $order['amount'];
        }else{
            $amount = 0;
        }
        return $amount;
    } 
    public function return_sku($order_id, $order=null)
    {
        if(empty($order) && !($order = $this->detail($order_id))){
            return false;
        }
        if($produt_list = K::M('weidian/orderproduct')->items(array('order_id'=>$order_id))){
            foreach($produt_list as $v){
                if($v['stock_name']){
                    $stock = K::M('weidian/product/attrstock')->find(array('stock_name'=>$v['stock_name']));
                    $a = array('sales'=>'`sales`-'.$v['product_number'], 'stock'=>'`stock`+'.$v['product_number']);
                    K::M('weidian/product/attrstock')->update($stock['attr_stock_id'],  $a, true);
                }
                $b = array('sales'=>'`sales`-'.$v['product_number'], 'stock'=>'`stock`+'.$v['product_number']);
                K::M('weidian/product')->update($v['product_id'], $b, true);
            }
        }
        return true;
    }
    // 自提订单创建消费码
    public function create_number($order_id)
    {    
        do{
            $no = '2'.date('ym').rand(1000000000, 9999999999);
            $number = $this->db->GetRow("SELECT spend_number FROM ".$this->table($this->_table)." WHERE spend_number='{$no}'");
        } while ($number);
        if(isset($no)) {
            $this->update($order_id,array('spend_number'=>$no, 'spend_status'=>0));
            return $no;
        }
    }
    
    
    public function cancel($order_id,$order,$from='member'){ //取消订单
        if(!$order_id = (int)$order_id){
            return false;
        }elseif(!$order && !($order = $this->detail($order_id))){
            return false;
        }else{
            if(K::M('order/order')->update($order_id,array('order_status'=>-1),true)){
                if($order['pay_status'] == 1){ //如果已支付需退款
                    $fan_amount = $this->get_return_amount($order_id, $order);
                    K::M('member/member')->update_money($order['uid'], $fan_amount, '微店商城订单(ID:'.$order_id.')取消退回到余额');
                }
                if($order['coupon_id']){ //退还优惠券
                    $coupon = K::M('member/coupon')->find(array('uid'=>$order['uid'],'coupon_id'=>$order['coupon_id']));
                    K::M('member/coupon')->update($coupon['cid'], array('order_id'=>0, 'use_time'=>0, 'status'=>0));
                }
                //下面更新库存销量等数据
                $this->return_sku($order_id, $order); //退回库存
                
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>$from,'log'=>'订单已取消','status'=>-1));
                return true;
            }
            return false; 
        }
    }
    
    public function complete($order_id, $order=null, $from='member'){
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else{
            $order_id = $order['order_id'];
            if(K::M('order/order')->update($order_id, array('order_status'=>8), true)){
                $shop_amount = 0;
                if($order['online_pay']){
                    $log = '订单完成结算(ID:'.$order_id.')';
                    if($order['from'] == 'weidian'){
                        if($order['type'] == 'default'){
                            $shop_amount = $order['amount'];
                            if($shop_amount){
                                K::M('shop/shop')->update_money($order['shop_id'], $shop_amount, '订单完成结算(ID:'.$order_id.')');
                            }
                        }elseif($order['type'] == 'fenxiao'){  //分销情况
                            if($order['shop_amount']){
                                 K::M('shop/shop')->update_money($order['shop_id'], ($order['shop_amount']+$order['freight']), '订单完成结算(ID:'.$order_id.')');
                            }
                            if($order['invite1'] && $order['amount_1']){
                                K::M('fenxiao/fenxiao')->update_money_by_invite($order['invite1'],$order['shop_id'],$order['amount_1'],'分销订单完成获取佣金(ID:'.$order_id.')' );
                                K::M('member/member')->update_money($order['invite1'],$order['amount_1'], '订单完成获取佣金(ID:'.$order_id.')');
                            }
                            if($order['invite2'] && $order['amount_2']){
                                K::M('fenxiao/fenxiao')->update_money_by_invite($order['invite2'],$order['shop_id'],$order['amount_2'],'分销订单完成获取佣金(ID:'.$order_id.')' );
                                K::M('member/member')->update_money($order['invite2'],$order['amount_2'], '订单完成获取佣金(ID:'.$order_id.')');
                            }
                            if($order['invite3'] && $order['amount_3']){
                                K::M('fenxiao/fenxiao')->update_money_by_invite($order['invite3'],$order['shop_id'],$order['amount_3'],'分销订单完成获取佣金(ID:'.$order_id.')' );
                                K::M('member/member')->update_money($order['invite3'],$order['amount_3'], '订单完成获取佣金(ID:'.$order_id.')');
                            }
                            if($order['pei_type'] == 2){
                                K::M('weidian/order')->update($order['order_id'], array('spend_status'=>1));
                            }
                        }
                    }
                    
                }
                if($from == 'admin'){
                    $log = '管理员确认订单完成';
                }else if($from == 'system'){
                    $log = '超过3小时系统自动确认订单完成';
                }else if($from == 'shop'){
                    $log = '商家确认订单完成';
                }else{
                    $log = '用户确认订单完成';
                }
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>$from,'log'=>$log,'status'=>8));
                
                return true;
            }
            
        }
        return false;
        
    }
    
}