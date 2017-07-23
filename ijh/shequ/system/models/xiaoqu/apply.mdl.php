<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Apply extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_apply';
    protected $_pk = 'apply_id';
    protected $_cols = 'apply_id,city_id,title,contact,mobile,clientip,dateline';
    protected $_orderby = array('apply_id'=>'DESC');
    
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data);
    }
}