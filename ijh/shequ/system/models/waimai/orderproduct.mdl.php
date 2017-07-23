<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_OrderProduct extends Mdl_Table
{   
  
    protected $_table = 'waimai_order_product';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_name,product_price,package_price,product_number,amount,spec_id';

    public function count_sales($shop_id, $between)
    {
    	$sql_order = "SELECT `order_id` FROM {$this->table('order')} WHERE `shop_id`={$shop_id} AND `order_status`=8 AND (dateline {$between})";
    	$order_items = array();
    	if($rs_order = $this->db->Execute($sql_order)){
            while($row_order = $rs_order->fetch()){
                $order_items[] = $row_order;
            }
            foreach($order_items as $k=>$v) {
            	$orderids[$v['order_id']] = $v['order_id'];
            }
            $orderids = implode(',' , $orderids);
        }

        $sql = "SELECT `product_id`,SUM(`product_number`) as product_number FROM {$this->table($this->_table)} WHERE `order_id` IN ({$orderids}) GROUP BY `product_id`";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }
}