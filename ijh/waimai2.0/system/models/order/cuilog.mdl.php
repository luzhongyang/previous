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
    protected $_cols = 'log_id,uid,shop_id,staff_id,order_id,cui_time,reply,reply_time,dateline';

    public function create($data, $checked=null)
    {
    	$data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
    	if ($log_id = $this->db->insert($this->_table, $data, true)) {
            return $log_id;
        }
    }
}