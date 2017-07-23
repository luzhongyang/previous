<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Tuan_Order extends Mdl_Table
{   
  
    protected $_table = 'tuan_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,tuan_id,tuan_title,tuan_price,tuan_number,use_time,tuan_photo,type,ltime';
    public function detail($pk, $closed=false)
    {
        if(!$pk = (int)$pk){
            return false;
        }
        $this->_checkpk();
        $where ="o.order_id=ext.order_id AND o.order_id=".$pk;
        if(empty($closed) && $this->field_exists('closed')){
            $where .= " AND o.closed='0'";
        }
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($detail = $this->db->GetRow($sql)){
            $detail = K::M('order/order')->order_format_row($detail);
        }
        return $detail;
    }
    public function create($data, $checked=false)
    {
        if ($order_id = $this->db->insert($this->_table, $data, true)) {
            $this->flush();
        }
        return $order_id;
    }
    
    //返回订单还需要支付的金额
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
        }else if($order['order_status'] < 0 || $order['order_status']==8){
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
        if($order) {
            $tuan_order = K::M('tuan/order')->detail($order['order_id']); 
        }
        $data = array('sales'=>'`sales`-'.$tuan_order['tuan_number'],'sale_count'=>'`sale_count`-'.$tuan_order['tuan_number'], 'stock_num'=>'`stock_num`+'.$tuan_order['tuan_number']);
        $data['orders'] = '`orders`-1';
        return K::M('tuan/tuan')->update($tuan_order['tuan_id'], $data, true);
    }
}