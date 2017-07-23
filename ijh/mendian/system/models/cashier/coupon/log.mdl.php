<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Coupon_Log extends Mdl_Table
{   
  
    protected $_table = 'cashier_coupon_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,shop_id,coupon_id,number,wx_openid,card_id,is_used,use_time,order_id,dateline,title,amount,min_price,stime,ltime,intro';
    protected $_orderby = array('log_id'=>'DESC');

    public function count_by_wx_openid($wx_openid,$coupon_id){
        if(!$wx_openid){
            return false;
        }
        $where = " wx_openid = '$wx_openid ' and coupon_id = $coupon_id";
        $sql = "SELECT  COUNT(*) as count   from ".$this->table($this->_table)." WHERE $where";
      if($res = $this->db->Execute($sql)){
          $arr = array();
          while($num = $res->fetch()){
              $arr []=$num;
          }
          return (int)$arr[0]['count'];
      }
        return false;

    }
     //总额度
    public function  count_by_openid($wx_openid){
        if(!$wx_openid){
            return false;
        }
        $sql = "SELECT SUM(amount) as count FROM ".$this->table($this->_table)." WHERE wx_openid = '$wx_openid' and ltime < now()";
        if($row = $this->db->Execute($sql)){
        return $row->fetch();
        }
        return false;


    }
    //获取个人领取列表
    public function items_by_openid($openid,$time = false){
        $sql = "SELECT  *  FROM  ".$this->table($this->_table." WHERE wx_openid = '$openid' and ");
        if($time){
            $where = ' ltime < '.time()." and is_used = '0'";
        } else {
            $where = ' ltime >= '.time()." and is_used = '0'";
        }
         $sql = $sql.$where.' order by dateline DESC';
        if($row = $this->db->Execute($sql)){
            $arr= array();
            while($str = $row->fetch()){
                $arr[] = $str;
            }
            return $arr;
        }
        return false;
        
    }

    public function create_number()
    {    
        do{
            $no = '2'.date('ymd',__TIME).rand(10000000, 99999999);
            $number = $this->db->GetOne("SELECT number FROM ".$this->table($this->_table)." WHERE number='{$no}'");
        } while ($number);
        return $no;
    }

    public function send_coupon($data=array(),$items=array())
    {
    	if (!empty($data) && !empty($data['coupon_id']) && !empty($data['shop_id'])) {
    		$send_data = array();
    		if (!empty($items)) {
    			$card_ids = $new_card_ids = $logs = array();
    			// 发券之前先查一遍该店铺的发券信息。
    			if ($logs = K::M('cashier/coupon/log')->items(array('shop_id'=>$data['shop_id'], 'coupon_id'=>$data['coupon_id']))) {
	            	foreach ($logs as $k => $v) {
	            		$card_ids[$v['card_id']] = $v['card_id']; // 已经发放过卡券的会员卡ID集合
	            	}
	            }else{
	            	$logs = array(); // 首次发放。
	            }
				foreach ((array)$items as $k => $v) {
					if ($v['shop_id'] == $data['shop_id']) { // 越权判断
						$new_card_ids[$v['card_id']] = $v['card_id']; //获取所有会员卡ID
	                	$data['card_id'] = $v['card_id'];
	                	$data['number'] = $this->create_number();
		                if (!empty($v['wx_openid'])) {
		                    $data['wx_openid'] = $v['wx_openid'];
		                }
		                K::M('cashier/coupon/log')->create($data); //批量发券
	                }else{
	                	unset($items[$k]);
	                }
	            }
	            $send_count = count($items);
	            if (!empty($send_count)) {

	            	if (!empty($logs) && !empty($card_ids)) {
		            	if (!empty($new_card_ids)) {
		            		if ($array_diff = array_diff($new_card_ids, $card_ids)) { //新增将发券会员卡与已有会员卡集合取差集
		            			$send_data['receive_count'] = count($array_diff);
		            			K::M('cashier/coupon')->update_count($data['coupon_id'], 'receive_count', $send_data['receive_count']);// 原有基础增加总领取人数
		            		}
		            	}
		            }else{ // 首次发放。
		            	$send_data['receive_count'] = $send_count;
						K::M('cashier/coupon')->update_count($data['coupon_id'], 'receive_count', $send_count);// 原有基础增加总领取人数
		            }
		            $send_data['send_count'] = $send_count;
		            K::M('cashier/coupon')->update_count($data['coupon_id'], 'send_count', $send_count);// 增加总发放数量
		            return $send_data;
	            }
	    	}else{
	    		if (!K::M('cashier/coupon/log')->find(array('shop_id'=>$data['shop_id'], 'coupon_id'=>$data['coupon_id'], 'card_id'=>$data['card_id'])) ) {// 如果不存在该会员就计算领取数
					$send_data['receive_count'] = 1;
					K::M('cashier/coupon')->update_count($data['coupon_id'], 'receive_count', 1);// 原有基础增加总领取人数
				}else{
					$send_data['receive_count'] = 0;
				}
				if($log_id = K::M('cashier/coupon/log')->create($data)){
					$send_data['send_count'] = 1;
					K::M('cashier/coupon')->update_count($data['coupon_id'], 'send_count', 1);// 增加总发放数量
					return $send_data;
				}
	    	}

    	}
    	return false;
    }

}