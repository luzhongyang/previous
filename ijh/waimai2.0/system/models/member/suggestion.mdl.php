<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Mdl_Member_Suggestion extends Mdl_Table {

    protected $_table = 'member_suggestion';
    protected $_pk = 'id';
    protected $_cols = 'id,uid,content,pic,create_time,client_ip,shop_id';
    protected $_orderby = array('create_time'=>'DESC', 'id'=>'DESC');

    public function create($data, $checked = false)
    {
        if (!$checked && !($data = $this->_check($data))) {
            return false;
        }
        $data['client_ip'] = __IP;
        $data['create_time'] = time();
        return $this->db->insert($this->_table, $data, true);

    }

}
