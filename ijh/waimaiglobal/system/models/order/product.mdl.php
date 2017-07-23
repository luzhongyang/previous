<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Product extends Mdl_Table
{   
  
    protected $_table = 'order_product';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_name,product_price,package_price,product_number,amount';

    public function count_by_product($filter, $page=1, $limit=7)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `product_id`,`product_name`, SUM(`product_number`) as sales_count FROM ".$this->table($this->_table)." WHERE $where GROUP BY product_id LIMIT $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['product_id']] = $row;
            }
        }
        return $items;
    }
}