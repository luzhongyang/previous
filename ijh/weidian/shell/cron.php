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

//15分钟未支付的自动取消
$filter = array('online_pay'=>1, 'order_status'=>0, 'pay_status'=>0, 'dateline'=>'<:'.(__TIME-900));
if($items = K::M('order/order')->items($filter, null, 1, 30, $unpay_cancel_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->cancel($v['order_id'], $v, 'system');
        K::M('order/order')->send_member("超时未支付订单取消", sprintf('您的订单(编号:%s)超时未支付，订单自动取消', $v['order_id']), $v, 'cancel');
    }
}

//外卖3小时过期自动结算
$filter = array('pay_status'=>1, 'pei_type'=>array(0, 1, 2), 'order_status'=>array(4,5), 'from'=>'waimai', 'lasttime'=>'<:'.(__TIME-10800));
if($items = K::M('order/order')->items($filter, null, 1, 30, $waimai_confirm_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->confirm($v['order_id'], $v, 'system');
    }
}

//外卖15分钟商户费接单自动取消
$filter = array('pay_status'=>1, 'order_status'=>'0', 'from'=>'waimai', 'pay_time'=>'<:'.(__TIME-900));
if($items = K::M('order/order')->items($filter, null, 1, 30, $waimai_unjiedan_cancel_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->cancel($v['order_id'], $v, 'system');
        K::M('order/order')->send_member("商家未接单自动取消", sprintf('您的外卖订单(编号:%s)超过15分钟商家未接单，订单自动取消', $v['order_id']), $v, 'cancel');
    }
}

//家政/维修/跑腿订单超过3小时未接单自动取消
$filter = array('pay_status'=>1, 'staff_id'=>0, 'order_status'=>0, 'lasttime'=>'<:'.(__TIME-10800));
$filter[':SQL'] = "(`from` IN('house','weixiu' ,'paotui'))";
if($items = K::M('order/order')->items($filter, null, 1, 30, $house_weixiu_paotui_unjiedan_cancel_count)){
    foreach($items as $k=>$v){
        K::M('order/order')->cancel($v['order_id'], $v, 'system');
        K::M('order/order')->send_member("超时未接单自动取消", sprintf('您的%s订单(编号:%s)超过3小时未接单，订单自动取消', $v['from_name'], $v['order_id']), $v, 'cancel');
    }
}

//团购订单超时自动退款
$filter = array('status'=>0,'ltime'=>'<:'.__TIME);
if($ticket_list = K::M('tuan/ticket')->items($filter, null, 1, 30, $ticket_count)){
	$order_ids = array();
	foreach($ticket_list as $k=>$v){
		$order_ids[$v['order_id']] = $v['order_id'];
	}
	if($items = K::M('order/order')->items_by_ids($order_ids)){
	    foreach($items as $k=>$v){
	        K::M('order/order')->cancel($v['order_id'], $v, 'system');
	        K::M('order/order')->send_member("团购订单过期退款", sprintf('您的团购订单(编号:%s)已经过期，系统自动退款到您的帐户。', $v['order_id']), $v, 'cancel');
	    }
	}
}
echo '<?php exit("Access denied");?>\n';
echo "+----------------------------------------------------------------------------------------+\n";
echo "time:".date("Y-m-d H:i:s")."\n";
echo "订单超时未支付:{$unpay_cancel_count}\n";
echo "外卖商家未接单:{$waimai_unjiedan_confirm_count}\n";
echo "家政维修跑腿未接单:{$house_weixiu_paotui_unjiedan_cancel_count}\n";
echo "团购过期未使用:{$ticket_count}\n";
echo "+----------------------------------------------------------------------------------------+\n";
