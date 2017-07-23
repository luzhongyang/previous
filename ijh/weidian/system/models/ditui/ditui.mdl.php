<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Ditui_Ditui extends Mdl_Table
{   
  
    protected $_table = 'ditui';
    protected $_pk = 'ditui_id';
    protected $_cols = 'ditui_id,city_id,mobile,passwd,money,pmid,reg_count,total_money,order_count,name,id_number,id_photo,account_type,account_name,account_number,audit,clientip,dateline';
    
    public function update_money($ditui_id, $money)
    {
        if($money > 0){
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE ditui_id='$ditui_id'";
        }else{
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE ditui_id='$ditui_id'";
        }
        if($this->db->Execute($sql)){
            return true;
        }
    }
    public function ditui($u, $l='ditui_id')
    {
        $l = strtolower($l);
        switch ($l) {
            case 'ditui_id':
                $field = 'ditui_id';
                break;
            case 'mobile':
                $field = 'mobile';
                break;
            default:
                return false;
        }
        $sql = "SELECT * FROM " . $this->table($this->_table) . " WHERE " . $this->field($field, $u);
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }
        return $row;
    }
    protected function _format_row($row)
    {
        if($city = K::M('data/city')->city($row['city_id'])){
            $row['city_name'] = $city['city_name'];
        }
        if(empty($row['face'])){
            $row['face'] = 'face/default.png';
        }
        $row['pid'] = sprintf("D%05d", $row['ditui_id']);
        return $row;
    }
    public function update_regcount($ditui_id)
    {
        $sql = "UPDATE ".$this->table($this->_table)." SET `reg_count`=`reg_count`+1 WHERE ditui_id='$ditui_id'";
        if($this->db->Execute($sql)){
            return true;
        }
    }
}
