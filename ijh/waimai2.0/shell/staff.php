<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: index.php 7284 2014-11-24 10:42:02Z maoge $
 */
if (strtolower(php_sapi_name()) != 'cli') {
    exit('only run cli');
}
@ini_set("display_errors", "On");
@error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING);;
@set_time_limit(0);
@ini_set('memory_limit', '128M');
@ini_set('allow_url_fopen', 'On');
@date_default_timezone_set('Asia/Shanghai');
require(dirname(dirname(__FILE__)) . '/system/home/index.php');
$system = new Index('magic-shell');


//新订单消息推送给商家
$filter_neworder['order_status'] = 0;
$filter_neworder['pei_type'] = array(0, 1, 2, 3);
//$filter_neworder[':OR'] = array('pay_status' => 1, 'online_pay' => 0);//取消货到付款推送
$filter_neworder['pay_status'] = 1;

$filter = array();
$filter['status'] = 1;
$filter['audit'] = 1;
if ($list = K::M('staff/staff')->items($filter)) {
    foreach ($list as $k => $v) {

        $filter = array('staff_id' => 0, 'closed' => 0, 'pay_status' => 1);

        $lng = $v['lng'];
        $lat = $v['lat'];

        //使用此函数计算得到结果后，带入sql查询。
        $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 5); //5KM以内的新订单

//        $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
//        $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];

        $a = array($squares['left-bottom']['lat'], $squares['right-top']['lat']);
        sort($a);
        $filter['o_lat'] = $a[0] . '~' . $a[1];
        $b = array($squares['left-bottom']['lng'], $squares['right-top']['lng']);
        sort($b);
        $filter['o_lng'] = $b[0] . '~' . $b[1];


        $filter[':SQL'] = "((`from`='waimai' AND ((`pei_type`=1 AND `order_status` IN(1,2)) OR (`order_status`=0 AND `pei_type`=2))) OR (`from`='paotui' && `order_status`=0 ))";
        if ($new_order_count = (int)K::M('order/order')->count($filter)) {

            if($new_order_count > 0){

                K::M('staff/staff')->send($v['staff_id'], '您有新的订单啦', '您有新的配送订单', 'newOrder');

                $sql = K::$system->db->SQLLOG();
                K::M('system/logs')->log('__ssssssql_staff', array($filter, $sql, $new_order_count));
            }


            // $sql = $this->system->db->SQLLOG();
            // K::M('system/logs')->log('__sql_staff', array($sql));
        }
        if(3 == $v['staff_id']){
            // $sql = K::$system->db->SQLLOG();
            // K::M('system/logs')->log('__ssssssql_staff', array($filter, $sql, $new_order_count));
        }

        // $sql = K::$system->db->SQLLOG();
        // K::M('system/logs')->log('__sql_staff', array($sql));
        // echo 'aaaa';

    }

}

if ($new_order_items = K::M('order/order')->neworders_by_shopid($filter_neworder, 1, 10000)) {
    foreach ($new_order_items as $k => $v) {
        if ($v['shop_id']) {
            $send_rlt = K::M('shop/shop')->send($v['shop_id'], '您有' . $v['neworders'] . '个新订单待处理', '请注意查看', 'newOrder');
            echo "shop:" . $v['shop_id'] . ',newOrder:' . $v['neworders'] . "\n";
            //echo $v['shop_id'], '您有'.$v['neworders'].'个新订单待处理' , '请注意查看' , 'newOrder';
        }
    }
}
error_log("!!start!!--" . date('Y-m-d H:i:s') . "----\r\n", 3, "d:/cron_log.txt");
echo 'finish';