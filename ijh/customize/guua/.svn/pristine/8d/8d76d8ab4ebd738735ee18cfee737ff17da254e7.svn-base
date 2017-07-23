<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: logs.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Member_Log extends Mdl_Table
{   
  
    protected $_table = 'member_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,uid,type,number,intro,admin,day,clientip,dateline';
    protected $_orderby = array('log_id'=>'DESC');
    
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        $data['day'] = date('Ymd', $data['dateline']);
        return $this->db->insert($this->_table, $data, true);
    }

    public function log($uid, $type='money', $num=0, $intro='')
    {
        $a = array();
        if(!$uid = (int)$uid){
            return false;
        }else if($type == 'money'){
            $num = floatval($num);
        }else if($type == 'jifen'){
            $num = intval($num);
        }else{
            return false;
        }
        $a = array('uid'=>$uid, 'type'=>$type,'number'=>$num, 'intro'=>$intro);
        if(defined('IN_ADMIN')){
            $admin = K::$system->admin->admin;
            $a['admin'] = "{$admin['admin_id']}:{$admin['admin_name']}";
        }
        $a['clientip'] = __IP;
        $a['dateline'] = __CFG::TIME;
        return $this->db->insert($this->_table, $a, true);
    }

    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !$data = $this->_check_schema($data,  $pk)){
            return false;
        }
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }    
}