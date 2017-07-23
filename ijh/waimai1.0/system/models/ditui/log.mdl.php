<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Ditui_Log extends Mdl_Table
{   
  
    protected $_table = 'ditui_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,ditui_id,money,intro,admin,clientip,dateline';

    public function create($data, $checked=false)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        return $this->db->insert($this->_table, $data, true);
    }
}