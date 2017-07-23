<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Yuyue_Dingzuo extends Mdl_Table
{   
  
    protected $_table = 'yuyue_dingzuo';
    protected $_pk = 'dingzuo_id';
    protected $_cols = 'dingzuo_id,city_id,shop_id,uid,order_status,contact,mobile,zhuohao_id,yuyue_time,yuyue_number,is_baoxiang,order_from,wx_openid,jd_time,lasttime,cui_time,reason,closed,clientip,dateline,notice';
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