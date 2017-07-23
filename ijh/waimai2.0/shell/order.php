<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: index.php 7284 2014-11-24 10:42:02Z maoge $
 */
if(strtolower(php_sapi_name()) != 'cli'){
    exit('only run cli');
}
@ini_set("display_errors","On");
@error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING);;
@set_time_limit(0);
@ini_set('memory_limit','128M');
@ini_set('allow_url_fopen', 'On');
@date_default_timezone_set('Asia/Shanghai');
require(dirname(dirname(__FILE__)).'/system/home/index.php');
$system = new Index('magic-shell');



//新订单消息推送给商家
$filter_neworder['order_status'] = 0;
$filter_neworder['pei_type'] = array(0, 1, 2, 3);
$filter_neworder[':OR'] = array('pay_status' => 1, 'online_pay' => 0);
if($new_order_items = K::M('order/order')->neworders_by_shopid($filter_neworder, 1, 10000)){
    foreach($new_order_items as $k=>$v){
        if($v['shop_id']) {
            $send_rlt = K::M('shop/shop')->send($v['shop_id'], '您有'.$v['neworders'].'个新订单待处理' , '请注意查看' , 'newOrder');
            echo "shop:" . $v['shop_id'] . ',newOrder:'.$v['neworders']."\n";
            //echo $v['shop_id'], '您有'.$v['neworders'].'个新订单待处理' , '请注意查看' , 'newOrder';
        }
    }
}
error_log("!!start!!--".date('Y-m-d H:i:s')."----\r\n", 3, "d:/cron_log.txt");
echo 'finish';