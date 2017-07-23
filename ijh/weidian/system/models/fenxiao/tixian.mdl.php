<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Fenxiao_Tixian extends Mdl_Table
{   
  
    protected $_table = 'fenxiao_tixian';
    protected $_pk = 'id';
    protected $_cols = 'id,sid,money,intro,account_info,status,reason,updatetime,clientip,dateline';
 
    public function create($data, $checked = false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        $data['status'] = 0;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }        
        return $id;
    }

}