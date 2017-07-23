<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Mall_Order extends Mdl_Table
{   
  
    protected $_table = 'mall_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,uid,product_name,product_jifen,product_number,status,contact,mobile,addr,clientip,dateline';

    public function create($data)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        return $this->db->insert($this->_table, $data, true);
    }
}
