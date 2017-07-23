<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Orderproduct extends Mdl_Table
{

    protected $_table = 'pintuan_order_product';

    protected $_pk = 'pid';

    protected $_cols = 'pid,order_id,product_id,product_name,product_price,package_price,product_number,amount';

    /**
     * 根据pintuan_grou_id 获取订单和订单产品
     */
    public function order_from_group_id($group_id)
    {
        $sql = "SELECT a.*, b.uid, c.product_id, d.nickname, d.face FROM " . $this->table('order') . " a 
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on b.order_id = c.order_id
            left join " . $this->table('member') . "   d on b.uid = d.uid
            WHERE b.pintuan_group_id = '{$group_id}'  ORDER BY a.order_id asc ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }

}
