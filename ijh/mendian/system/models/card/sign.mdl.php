<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Sign extends Mdl_Table
{

    protected $_table = 'card_sign';
    protected $_pk = 'sign_id';
    protected $_cols = 'sign_id,uid,jifen,card_id,dateline';

    public function create($data)
    {
        if(!$data = $this->_check_schema($data)){
            return false;
        }
        $data['dateline'] = __CFG::TIME;
        if($city_id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $city_id;
    }
  
}
