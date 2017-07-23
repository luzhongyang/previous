<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Complaint extends Mdl_Table
{   
  
    protected $_table = 'order_complaint';
    protected $_pk = 'complaint_id';
    protected $_cols = 'complaint_id,order_id,uid,shop_id,staff_id,title,content,reply,reply_time,clientip,dateline';

    public function create($data, $checked=false)
    {
        /*if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }*/
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }
}