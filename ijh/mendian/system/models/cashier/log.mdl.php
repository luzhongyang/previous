<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Log extends Mdl_Table
{   
  
    protected $_table = 'cashier_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,shop_id,staff_id,order_id,amount,pay_code,type,day,refund_info,dateline';
    protected $_orderby = array('log_id'=>'DESC');
    protected $pay_type = array('cash'=>'现金','money'=>'余额','wxpay'=>'微信','alipay'=>'支付宝','cash'=>'现金','refund'=>'退款','qrcode'=>'台卡',);

    /**
     * 根据天统计订单
     * param $filter 订单条件
     * param $limit 开始 
     */
    public function count_by_day($filter=null, $page=1,$limit=30)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `day`, COUNT(1) as day_order, SUM(`amount`) as day_amount FROM ".$this->table($this->_table)." WHERE {$where} AND `type`<>'refund' GROUP BY `day` ORDER BY day ASC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['day']] = $row;
            }
        }
        $sql = "SELECT `day`, SUM(`amount`) as day_refund FROM ".$this->table($this->_table)." WHERE {$where} AND `type`='refund' GROUP BY `day` ORDER BY day ASC $limit";
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                if($items[$row['day']]){
                    $items[$row['day']]['day_refund'] = $row['day_refund'];
                }else{
                    $row['day_count'] = 0;
                    $row['day_amount'] = 0;
                    $items[$row['day']] = $row;
                }
            }
        }
        return $items;
    }

    public function total_order($filter)
    {
		$where = $this->where($filter);
		$sql = "SELECT COUNT(1) as total_order, SUM(`amount`) as total_amount FROM ".$this->table($this->_table)." WHERE {$where} AND 'pay_code'<>'reound'";
		return $this->db->GetRow($sql);
    }

    protected function _format_row($row)
    {
        $row['pay_code_title'] = $this->pay_type[$row['pay_code']];
        return $row;
    }

    protected function _check($row, $log_id=null)
    {
    	if($log_id === null){
            $row['dateline'] = $row['dateline'] ? $row['dateline'] : __TIME;
    		$row['day'] = $row['day'] ? $row['day'] : date('Ymd', __TIME);
    	}
        if(isset($row['refund_info']) && is_array($row['refund_info'])){
            $row['refund_info'] = json_encode($row['refund_info']);
        }
    	return parent::_check($row, $log_id);
    }
}