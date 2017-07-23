<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Shop_Log extends Mdl_Table
{   
  
    protected $_table = 'shop_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,shop_id,money,intro,admin,day,clientip,dateline';
    protected $_orderby = array('log_id'=>'DESC');

    public function create($data)
    {
    	$data['dateline'] = $data['dateline'] ? $data['dateline']: __CFG::TIME;
    	$data['clientip'] = __IP;
    	$data['day'] = date('Ymd');
    	if ($log_id = $this->db->insert($this->_table, $data, true)) {
            return $log_id;
        }
    }
    
    public function count_money($filter=null)
    {
        $where = $this->where($filter);
        $sql = "SELECT SUM(`money`) FROM ".$this->table($this->_table)." WHERE {$where}";
        return $this->db->GetOne($sql);
    }
    
    /*
     * 根据天统计金额
     * param $filter 查询条件
     * param $limit 开始 
     */
    public function count_by_day($filter=null, $page=1, $limit=30)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `day`, SUM(`money`) as day_money FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `day` ORDER BY day ASC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['day']] = $row;
            }
        }
        return $items;
    }

    public function count_by_shopid($filter=null, $page=1, $limit=30)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `shop_id`, SUM(`money`) as day_money FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `shop_id` ORDER BY shop_id ASC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['shop_id']] = $row;
            }
        }
        return $items;
    }
    
}