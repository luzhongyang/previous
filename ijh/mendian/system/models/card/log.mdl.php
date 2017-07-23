<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Log extends Mdl_Table
{   
  
    protected $_table = 'card_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,card_id,order_id,type,number,intro,day,clientip,dateline';
    protected $_orderby = array('log_id'=>'DESC');
    protected $types = array('money'=>"余额",'jifen'=>"积分",'order'=>"订单付款",'chongzhi'=>"充值");

    // public function create($data, $checked=false)
    // {
    //     if(!$checked && !$data = $this->_check_schema($data)){
    //         return false;
    //     }
    //     $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
    //     $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
    //     $data['day'] = date('Ymd', $data['dateline']);
    //     return $this->db->insert($this->_table, $data, true);
    // }
    protected function _format_row($row)
    {
        $row['type_title'] = $this->types[$row['type']];
        $row['number'] = $row['type'] == 'jifen' ? (int)$row['number'] : $row['number'];
        return $row;
    }
    public function log($card_id, $order_id=0, $type='money', $num=0, $intro='')
    {
        $a = array();
        if(!$card_id = (int)$card_id){
            return false;
        }else if($type == 'money' || $type == 'chongzhi' || $type == 'order'){
            $num = floatval($num);
        }else if($type == 'jifen'){
            $num = intval($num);
        }else{
            return false;
        }
        $order_id = (int)$order_id;
        $a = array('card_id'=>$card_id, 'order_id'=>$order_id, 'type'=>$type,'number'=>$num, 'intro'=>$intro);
        $a['day'] = date('Ymd', __TIME);
        $a['clientip'] = __IP;
        $a['dateline'] = __CFG::TIME;
        return $this->db->insert($this->_table, $a, true);
    }

    protected function _check($data, $log_id=null)
    {
    	if($log_id && !isset($data['day'])){
    		$data = date('Ymd', __TIME);
    	}
    	return parent::_check($data, $log_id);
    }
}