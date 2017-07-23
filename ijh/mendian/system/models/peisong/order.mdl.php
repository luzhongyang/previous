<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Order extends Mdl_Table
{   
  
    protected $_table = 'peisong_order';
    protected $_pk = 'pf_order_id';
    protected $_cols = 'pf_order_id,platform,active_time,remark,pf_payment,pf_status,order_status,order_payment,consignee_name,consignee_phones,consignee_address,o_lng,o_lat,lng,lat,distance,income,package_fee,goods_total,service_rate,service_fee,order_info,dateline';
}