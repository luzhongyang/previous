<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Paotui_Log extends Mdl_Table
{   
  
    protected $_table = 'paotui_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,paotui_id,log,dateline';

    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
        if ($log_id = $this->db->insert($this->_table, $data, true)) {
            return $log_id;
        }
    }
}