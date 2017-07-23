<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Mall_Order extends Mdl_Table
{   
  
    protected $_table = 'mall_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,product_jifen,product_price,product_number,freight';


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
        }else if($order['order_status'] !=0){
            return false;
        }else if($order['pay_status'] == 1){
            $amount = $order['product_price'] + $order['freight'];
        }
        return $amount;
    }

    public function return_sku($order_id, $order=null)
    {
        if(empty($order) && !($order = $this->detail($order_id))){
            return false;
        }
        if($produt_list = K::M('mall/order/product')->items(array('order_id'=>$order_id))){
            foreach($produt_list as $v){
                $data = array('sales'=>'`sales`-'.$v['product_number'], 'sku'=>'`sku`+'.$v['product_number']);
                K::M('mall/product')->update($v['product_id'], $data, true);
            }
        }
        return true;
    }
    
}
