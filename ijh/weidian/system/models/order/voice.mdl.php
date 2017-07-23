<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Order_Voice extends Mdl_Table
{   
  
    protected $_table = 'order_voice';
    protected $_pk = 'voice_id';
    protected $_cols = 'voice_id,order_id,voice,voice_time,dateline';
    
    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        return $this->db->insert($this->_table, $data, true);
    }
    /**
     * 获取语音
     * @param $order_id
     */
    public function getone($order_id)
    {
        return $this->detail_by_order_id($order_id);
    }
    public function detail_by_order_id($order_id)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE `order_id`={$order_id}";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }
    public function items_by_order_ids($order_ids)
    {
        if(is_array($ids)){
            $ids = implode(',', $ids);
        }       
        if(!K::M('verify/check')->ids($ids)){
            return false;
        }
        $where = "order_id IN ($ids)";
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE $where";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $this->_format_row($row);
            }
        }
        return $items;        
    }
}