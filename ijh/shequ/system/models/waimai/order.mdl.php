<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_Order extends Mdl_Table
{   
  
    protected $_table = 'waimai_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,product_number,product_price,package_price,freight,spend_number,spend_status';
    public function get_order_status(){
        return array(
            '-1' => '已取消',
            '0' => '未处理',
            '1' => '已接单',
            '3' => '配送开始',
            '4' => '配送完成',
            '8' => '订单完成',
        );
    }
    public function  get_payments(){
        return array(
            'wxpay' => '微信支付',
            'alipay' => '支付宝支付',
            'money' => '余额支付',
        );
    }

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
            
        }        
        return $row;
    }
    public function detail_by_number($number, $closed=false)
    {
        if(!preg_match('/^(\d+)$/i', $number)){
            return false;
        }
        if(empty($closed)){
            $where .= " AND o.closed='0'";
        }
        $where ="o.order_id=ext.order_id AND ext.spend_number=".$number;
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
            $amount = $order['amount'] + $order['money'];
        }else{
            $amount = $order['money'];
        }
        return $amount;
    }
    
    public function return_sku($order_id, $order=null)
    {
        if(empty($order) && !($order = $this->detail($order_id))){
            return false;
        }
        if($produt_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id))){
            foreach($produt_list as $v){
                if($v['spec_id']){
                    $a = array('sale_count'=>'`sale_count`-'.$v['product_number'], 'sale_sku'=>'`sale_sku`+'.$v['product_number']);
                    K::M('waimai/productspec')->update($v['spec_id'],  $a, true);
                }
                $b = array('sales'=>'`sales`-'.$v['product_number'], 'sale_count'=>'`sale_count`-'.$v['product_number'], 'sale_sku'=>'`sale_sku`+'.$v['product_number']);
                K::M('waimai/product')->update($v['product_id'], $b, true);
            }
        }
        return true;
    }
    // 自提订单创建消费码 15位
    public function create_number($order_id)
    {    
        do{
            $no = '1'.date('ymd',__TIME) . rand(10000000, 99999999);
            $number = $this->db->GetRow("SELECT spend_number FROM ".$this->table($this->_table)." WHERE spend_number='{$no}'");
        } while ($number);
        if(isset($no)) {
            $this->update($order_id,array('spend_number'=>$no, 'spend_status'=>0));
        }
    }
}