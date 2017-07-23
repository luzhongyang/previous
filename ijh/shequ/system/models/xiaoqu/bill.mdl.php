<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Bill extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_bill';
    protected $_pk = 'bill_id';
    protected $_cols = 'bill_id,xiaoqu_id,yezhu_id,uid,bill_sn,total_price,wuye_price,chewei_price,shui_price,dian_price,ranqi_price,pay_status,pay_code,pay_time,closed,dateline';
    protected $_orderby = array('bill_id'=>'DESC');
    public function set_payed($log, $trade=array())
    {        
        $bill_id = $log['order_id'];
        if(!$bill = $this->detail($bill_id)){
            return false;
        }else if($res = $this->db->update($this->_table, array('pay_status'=>1), "bill_id='{$bill_id}'", true)){
            $a = array('pay_time'=>__TIME,'lasttime'=>__TIME,'pay_code'=>$trade['code']);
            $this->update($order_id, $a, true);
            //发消息通知 todo
            
            //把此缴费单的金额返给物业
            $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($bill['xiaoqu_id']);
            K::M('xiaoqu/wuye')->update_money($xiaoqu['wuye_id'],$bill['total_price'],'业主['.$bill['uid'].']缴费帐单'.$bill['bill_sn'].'成功');
        }
        return $res;
    }
}