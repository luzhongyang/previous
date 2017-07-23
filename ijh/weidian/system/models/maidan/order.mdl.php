<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Maidan_Order extends Mdl_Table
{   
  
    protected $_table = 'maidan_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,maidan_amount,unyouhui';
    
    
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
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        return $this->db->insert($this->_table, $data);
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
            $amount = $$oroder['amount'] + $order['money'];
        }else{
            $amount = $order['money'];
        }
        return $amount;
    }  
}