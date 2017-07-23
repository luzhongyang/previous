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
    protected $_cols = 'log_id,uid,money,jifen,number,intro,admin,day,clientip,dateline';
    protected $_orderby = array('log_id'=>'DESC');
    
    public function create($data, $checked=false)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        $data['day'] = date('Ymd', $data['dateline']);
        return $this->db->insert($this->_table, $data, true);
    }

    public function log($uid, $money=0, $jifen=0, $intro='', $admin='')
    {
        $a = array();
        if(!$uid = (int)$uid){
            return false;
        }else if($money){
            $money = floatval($money);
        }else if($jifen){
            $jifen = intval($jifen);
        }else{
            return false;
        }
        $a = array('uid'=>$uid, 'money'=>$money,'jifen'=>$jifen, 'intro'=>$intro);
        if(defined('IN_ADMIN')){
            $admin = K::$system->admin->admin;
            $a['admin'] = "{$admin['admin_id']}:{$admin['admin_name']}";
        }
        $a['clientip'] = __IP;
        $a['dateline'] = __CFG::TIME;
        $a['day'] = date('Ymd', __TIME);
        return $this->db->insert($this->_table, $a, true);
    }

    public function update($pk, $data, $checked=false)
    {
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }    
}