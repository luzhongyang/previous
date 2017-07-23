<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Order_Cuilog extends Mdl_Table
{
    protected $_table = 'order_cuilog';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,uid,shop_id,staff_id,order_id,cui_time,reply,reply_time';
    public function create($data)
    {
    	$data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
        if ($log_id = $this->db->insert($this->_table, $data, true)) {
            return $log_id;
        }
    }

    public function count_by_order($filter)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `order_id`, COUNT(1) as cui_count FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `order_id`";      
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        return $items;
    }
  
}
