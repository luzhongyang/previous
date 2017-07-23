#!/www/wdlinux/php/bin/php -q
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

//30分钟未支付的自动取消
$filter = array('online_pay'=>1, 'order_status'=>0, 'pay_status'=>0, 'dateline'=>'<:'.(__TIME-900));
if($items = K::M('order/order')->items($filter, null, 1, 30, $cancel_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->cancel($v['order_id'], $v, 'system');
    }
}
//3小时过期自动结算
$filter = array('order_status'=>4, 'lasttime'=>'<:'.(__TIME-10800));
if($items = K::M('order/order')->items($filter, null, 1, 30, $confirm_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->confirm($v['order_id'], $v, 'system');
    }
}
//邀请商户返现地推用户


echo '{"cancelOrder":"'.$cancel_count.'", "confirmOrder":"'.$confirm_count.'"}';