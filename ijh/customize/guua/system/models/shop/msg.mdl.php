<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Msg extends Mdl_Table
{   
  
    protected $_table = 'shop_msg';
    protected $_pk = 'msg_id';
    protected $_cols = 'msg_id,shop_id,title,content,type,is_read,dateline,clientip,order_id';

    public function create($data, $checked=false)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            return $id;
        } 
    }
}