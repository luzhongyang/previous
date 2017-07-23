<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Tuan_Tuan extends Mdl_Table
{
    protected $_table = 'tuan';
    protected $_pk = 'tuan_id';
    protected $_cols = 'tuan_id,shop_id,city_id,type,title,desc,price,market_price,photo,views,stime,ltime,sale_count,virtual_sales,info,orderby,audit,closed,clientip,notice,detail,sales,orders,ticket_merge,min_buy,max_buy,stock_type,stock_num,dateline,is_onsale';

    
    // public function create($data, $checked=false)
    // {
    //     if(!$checked && !$data = $this->_check_schema($data)){
    //         return false;
    //     }
    //     $data['views'] = 0;
    //     $data['virtual_sales'] = 0;
    //     $data['audit'] = 1;
    //     $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
    //     $data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
    //     if($tuan_id = $this->db->insert($this->_table, $data, true)){
    //         $this->flush();
    //     }        
    //     return $tuan_id;        
    // }

    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !$data = $this->_check_schema($data,  $pk)){
            return false;
        }
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }
    public function update_count($ids, $from='views', $num=1)
    {
        $this->_checkpk();
        if($ids = K::M('verify/check')->ids($ids)){
            if(($num = (int)$num) && $this->field_exists($from)){
                $sql = "UPDATE ".$this->table($this->_table)." SET `{$from}`=`{$from}`+$num WHERE ".self::field($this->_pk, $ids);
                return $this->db->Execute($sql);
            }
        }
        return false;
    }
    /**
     * 订单求和
     */
    public function sales($where)
    {
        return $this->total_sales($where);
    }
    public function total_sales($where)
    {
        $where = $this->where($where);
        $sql = "SELECT SUM(`sale_count`+`virtual_sales`) FROM ".$this->table($this->_table)." WHERE {$where}";
        return $this->db->GetOne($sql);        
    }
    protected function _format_row($row)
    {
        $row['stock_type'] = 1;
        $row['audit'] = 1;
        return $row;
    }
    protected function _check($row, $tuan_id=null)
    {
        if(empty($tuan_id) || (isset($row['stock_type']) && empty($row['stock_type']))){
            $row['stock_type'] = 1;
        }
        if(isset($row['min_buy']) && isset($row['max_buy']) && $row['min_buy'] >= $row['max_buy']) {
            $this->msgbox->add('最小购买数 必需小于 最大购买数',213);
            return false;
        }
        if(isset($row['stime'])){
            if(is_numeric($row['stime'])){
                $row['stime'] = strtotime(date("Y-m-d", $row['stime'])." 00:00:00");
            }else if(preg_match('/^(\d{4}-\d{1,2}-\d{1,2})$/i', $row['stime'])){
                $row['stime'] = $row['stime'].' 00:00:00';
            }
        }  
        if(isset($row['ltime'])){
            if(is_numeric($row['ltime'])){
                $row['ltime'] = strtotime(date("Y-m-d", $row['ltime'])." 23:59:59");
            }else if(preg_match('/^(\d{4}-\d{1,2}-\d{1,2})/', $row['ltime'])){
                $row['ltime'] = $row['ltime'].' 23:59:59';
            }
        }        
        return parent::_check($row, $tuan_id);
    }
}
