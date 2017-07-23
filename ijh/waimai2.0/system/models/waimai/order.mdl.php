<?php
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Waimai_Order extends Mdl_Table
{   
    protected $_table = 'waimai_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,product_number,product_price,package_price,freight,spend_number,spend_status';
    protected $_orderby = array('order_id'=>'DESC');

    public function create($data, $checked=false)
    {
        /*if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }*/
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }

    // 自提订单创建消费码
    public function create_number($order_id)
    {    
        do{
            $no = '2'.substr(date('Ymd'),1,7) . rand(10000000, 99999999);
            $number = $this->db->GetRow("SELECT spend_number FROM ".$this->table($this->_table)." WHERE spend_number='{$no}'");
        } while ($number);
        if(isset($no)) {
            $this->update($order_id,array('spend_number'=>$no, 'spend_status'=>0));
        }
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
}