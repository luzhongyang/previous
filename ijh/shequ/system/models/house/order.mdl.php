<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_House_Order extends Mdl_Table
{   
  
    protected $_table = 'house_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,cate_id,cate_title,jiesuan_price,fuwu_time,danbao_amount';
    
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
        if(empty($closed) && $this->field_exists('closed')){
            $where .= " AND o.closed='0'";
        }
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($detail = $this->db->GetRow($sql)){
            $detail = K::M('order/order')->order_format_row($detail);
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
            $this->update($order_id, array('jiesuan_price'=>$price));
            // $log = array('order_id'=>$order_id, 'status'=>5, 'log'=>sprintf('师傅设置了订单价格:￥%s', $price), 'from'=>$from);
            // K::M('order/log')->create($log);
            return true;            
        }
        return false;
    }
    
    //返回订单需要支付的金额
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
            $amount = $order['jiesuan_price'] - $order['danbao_amount'] - $order['hongbao'];
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
        }else if($order['pay_status'] || $order['order_status']==5){
            //$amount = $$oroder['danbao_amount'] - $order['hongbao'];
            $amount = $$oroder['amount'] + $order['money'];
        }else{
            $amount = $order['money'];
        }
        return $amount;
    }
    public function return_sku($order_id, $order=null)
    {
        return true;
    } 
    // 根据条件查询订单数量
    public function order_count($filter)
    {
        $where = '1';
        if(is_array($filter)){
            if(isset($filter['house'])){
                $where = $this->where($filter['house'], 'ext.');
                $ext_sql = " LEFT JOIN ".$this->table($this->_table)." ext ON o.`order_id`=ext.`order_id` ";
                unset($filter['house']);
            }
        }
        $where = $where ." AND ". K::M('order/order')->where($filter, 'o.');
        $sql = "SELECT COUNT(1) FROM ".$this->table('order') . " o " . $ext_sql . " WHERE $where";
        return $this->db->GetOne($sql);
    }

    //家政订单列表，新订单用，支持技能ID条件
    public function order_items($filter=array(), $orderby=null, $p=1, $l=50, &$count=0)
    {
        $where = '1';
        if(is_array($filter['house'])){
            $where = $this->where($filter['house'], 'ext.');
        }
        unset($filter['house']);
        $where = $where." AND ".K::M('order/order')->where($filter);
        $orderby = K::M('order/order')->order($orderby);
        $limit = $this->limit($p, $l);
        $items = array();
        if($count = $this->order_count($filter)){
            $sql = "SELECT o.*,ext.* FROM ".$this->table('order') . " o LEFT JOIN ".$this->table($this->_table). " ext ON o.`order_id`=ext.`order_id` WHERE $where $orderby $limit";
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
    protected function _format_row($row)
    {
        return K::M('order/order')->order_format_row($row);
    }
}