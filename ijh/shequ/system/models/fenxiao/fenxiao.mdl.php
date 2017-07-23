<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Fenxiao_Fenxiao extends Mdl_Table
{
    protected $_table = 'fenxiao';
    protected $_pk = 'sid';
    protected $_cols = 'sid,p_sid,shop_id,uid,shop_name,title,photo,status,dateline,clientip,money,orders,orders_amount';
    
    public function detail($sid, $closed=false)
    {
        if(!$sid = (int)$sid){
            return false;
        }
        $where ="s.shop_id=f.shop_id AND f.sid=".$sid;
        if(empty($closed)){
            $where .= " AND s.closed='0'";
        }
        $sql = "SELECT s.*, f.*,s.title as shop_name FROM ".$this->table('shop').' s, '.$this->table($this->_table)." f WHERE {$where}";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }
    
    protected function _format_row($row)
    {
        static $_cfg = null;
        if($_cfg === null){
            $_cfg = K::$system->config->get('fenxiao');
            //$_cfg = array('domain'=>'weizx.cn');
        }
        $row['have_fenxiao'] = min($_cfg['level'], $row['have_fenxiao']);
        if($app = __CFG::$APPS['fenxiao']){
            $row['url'] = sprintf($app['url'], $row['sid']);
        }else{
            $row['url'] = 'http://fx'.$row['sid'].'.'.$_cfg['domain'];
        }
        return $row;
    }
   
    public function get_url($sid)
    {
        static $_cfg = null;
        if($_cfg === null){
            $_cfg = K::$system->config->get('fenxiao');
            //$_cfg = array('domain'=>'weizx.cn');
        }
        $url = 'http://fx'.$sid.'.'.$_cfg['domain'];
        return $url;
    }
    
    
    public function update_money($sid, $money, $intro, $admin='')
    {
        if(($sid = (int)$sid) && ($money = (float)$money)){
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE sid='$sid'";
            if($this->db->Execute($sql)){
                return K::M('fenxiao/log')->create(array('sid'=>$sid, 'money'=>$money, 'intro'=>$intro));
            }
        }
        return false;
    }
    
    
    public function update_money_by_invite($uid,$shop_id,$money,$intro,$admin=''){
        if(!$uid){
            return false;
        }elseif(!$fenxiao = K::M('fenxiao/fenxiao')->find(array('uid'=>$uid,'shop_id'=>$shop_id))){
            return false;
        }elseif(!$money = (float)$money){
            return false;
        }else{
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE sid={$fenxiao['sid']}";
            if($this->db->Execute($sql)){
                K::M('fenxiao/log')->create(array('sid'=>$fenxiao['sid'], 'money'=>$money, 'intro'=>$intro));
            }
            return true;
        }
        return false;
    }


}