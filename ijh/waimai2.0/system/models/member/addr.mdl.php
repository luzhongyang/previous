<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Member_Addr extends Mdl_Table
{

    protected $_table = 'member_addr';
    protected $_pk = 'addr_id';
    protected $_cols = 'addr_id,uid,contact,mobile,addr,house,is_default,dateline,lat,lng,tag';
    protected $tags = array(0=>'无',1=>'公司',2=>'家',3=>'学校');
    
    public function get_tags(){
        return $this->tags;
    }

    public function create($data, $checked=false)
    {
        if (!$checked && !($data = $this->_check($data))) {
            return false;
        }
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        if ($addr_id = $this->db->insert($this->_table, $data, true)) {
            return $addr_id;
        }
    }

    public function update($val, $data, $checked=false)
    {
    	$data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        if(isset($val) && !empty($data) && is_array($data)) {
            if($ret = $this->db->update($this->_table, $data, self::field($this->_pk, $val))){
                $this->clear_cache($val);
            }
            return $ret;
        }
        return false;
    }

    public function set_default($uid, $addr_id)
    {
        if(!($uid = (int)$uid) || !($addr_id = (int)$addr_id)){
            return false;
        }
        $this->db->update($this->_table, array('is_default'=>0), "uid={$uid}");
        $this->db->update($this->_table, array('is_default'=>1), "uid={$uid} AND addr_id={$addr_id}");
        return true;
    }

    public function check_contact($contact) {
        $length = strlen($contact);
        if($length>5 && $length<16) {
            return $contact;
        }else {
            return false;
        }
    }

    public function check_mobile($mobile) {
        K::M('verify/check')->mobile($mobile);
    }

}
