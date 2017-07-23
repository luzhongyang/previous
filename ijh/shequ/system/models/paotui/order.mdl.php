<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Paotui_Order extends Mdl_Table
{
    protected $_table = 'paotui_order';
    protected $_pk    = 'order_id';
    protected $_cols  = 'order_id,type,o_addr,o_house,o_contact,o_mobile,o_time,time,paotui_amount,danbao_amount,jiesuan_amount';
    
    
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        return $this->db->insert($this->_table, $data);
    }
    
    public function detail($pk, $closed=false)
    {
        if(!$pk = (int)$pk){
            return false;
        }
        $this->_checkpk();
        $where ="o.order_id=ext.order_id AND o.order_id=".$pk;
        if(empty($closed)){
            $where .= " AND o.closed='0'";
        }
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($detail = $this->db->GetRow($sql)){
            $detail = K::M('order/order')->order_format_row($detail);
            $detail = $this->_format_row($detail);
        }
        return $detail;
    }

    public function set_price($order_id, $price, $from='staff')
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        if(($price = (float)$price) <=0){
            return false;
        }
        if(K::M('order/order')->update($order_id, array('order_status'=>5, 'pay_status'=>0, 'total_price'=>$price))){
            $this->update($order_id, array('jiesuan_amount'=>$price));
            $log = array('order_id'=>$order_id, 'status'=>5, 'log'=>sprintf('骑手设置了订单价格:￥%s', $price), 'from'=>$from);
            K::M('order/log')->create($log);
            return true;            
        }
        return false;
    }
    public function get_payment_amount($order_id, &$level=0)
    {
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($order['pay_status']){
            return false;
        }else if($order['order_status']<0 || $order['order_status']==8){
            return false;
        }else if($order['order_status'] == 5){
            $level = 1;
            $amount = $order['jiesuan_amount'] - $order['danbao_amount'] - $order['hongbao'];
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
        }else if($order['pay_status'] || $order['order_status'] == 5){ //二次支付时pay_status为0
            //$amount = $$oroder['danbao_amount'] + $order['paotui_amount'] - $order['hongbao'];
            $amount = $order['amount'] + $order['money'];
        }else{
            $amount = $order['money'];
        }
        return $amount;
    }
    public function return_sku($order_id, $order=null)
    {
        return true;
    }
    protected function _format_row($row)
    {
        static $cate_list = null;
        if($cate_list === null){
            $cate_list = K::M('paotui/cate')->fetch_all();
        }
        $row['type_title'] = $cate_list[$row['type']]['title'];
        return $row;
    }
}
