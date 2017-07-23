<?php
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Waimai_Orderproduct extends Mdl_Table
{  
	protected $_table = 'waimai_order_product';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_name,product_price,package_price,product_number,amount,spec_id,sale_type';
    protected $_orderby = array('pid'=>'DESC');

    // 根据order_id 查询一条价格最大的商品记录和订单商品总条数
    public function get_standard($id)
    {
    	$id = (int)$id;
        $sql = "SELECT SUM(`product_number`) as total_count,MAX(`product_price`) as max_price,`product_id`,`order_id` FROM " . $this->table($this->_table). " WHERE `order_id`='{$id}'";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
            	//$items[$row['order_id']] = $row;
                $items = $this->_format_row($row);
            }
        }
        return $items;
    }
}