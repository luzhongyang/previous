<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Yuyue_Paidui extends Mdl_Table
{   
  
    protected $_table = 'yuyue_paidui';
    protected $_pk = 'paidui_id';
    protected $_cols = 'paidui_id,city_id,shop_id,uid,zhuohao_id,order_status,contact,mobile,paidui_number,wait_time,order_from,wx_openid,reason,jd_time,cui_time,lasttime,closed,clientip,dateline';
    protected function _format_row($row)
    {
        if($row['order_status'] < 0){
            $row['order_status_label'] = '已取消';
        }else if($row['order_status'] > 1){
            $row['order_status_label'] = '已完成';
        }else if($row['order_status'] == 1){
            $row['order_status_label'] = '排队中';
        }else{
            $row['order_status_label'] = '待接单';
        }
        return $row;
    }
    public function cancel_reason_list()
    {
        return array('改时间了', '不需要了', '订错了', '临时有事', '任性取消');
    }
    
}