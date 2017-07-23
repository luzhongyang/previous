<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Biz_Order extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array();
        $orderby = array('order_id' => 'DESC');
        if (in_array($params['status'], array(1, 2, 3))) {
            switch ($params['status']) {
                case 1 : //待接单的
                    $filter['order_status'] = 0;
                    $filter['pei_type'] = array(0, 1, 3);
                    $filter[':OR'] = array('pay_status' => 1, 'online_pay' => 0);
                    $orderby = array('order_id' => 'ASC');
                    break;
                case 2 : //进行中的
                    $filter['pei_type'] = array(0, 1, 3);
                    $filter['order_status'] = array(1, 2, 3);
                    //$filter['staff_id'] = 0;
                    break;
                case 3 : //已完成的
                    $filter['pei_type'] = array(0, 1, 3);
                    $filter['order_status'] = array(4, 5, 6, 7, 8);
                    //$filter['order_status'] = array(4,5,6,7,8);                    
                    break;
            }
        }
        $filter['closed'] = 0;
        $filter['shop_id'] = $this->shop_id;
        $page = max((int)$params['page'], 1);
        
        if (($page<=100) && $items = K::M('order/order')->items($filter, $orderby, 1, $limit, $count)) {
            $staff_ids = $order_ids = $staff_list = array();
            foreach ($items as $k => $v) {
                $order_ids[$v['order_id']] = $v['order_id'];
                if ($v['staff_id']) {
                    $staff_ids[$v['staff_id']] = $v['staff_id'];
                }
                if ($v['pei_time'] == 0) {
                    $items[$k]['pei_time'] = L('尽快送达');
                }
                $items[$k]['comment_info'] = array('comment_id' => 0, 'shop_id' => 0, 'uid' => 0, 'order_id' => 0, 'content' => '', 'reply' => '', 'reply_time' => 0, 'dateline' => 0);
                // 管理员取消超时未付款的订单
                if (__TIME - $v['dateline'] > 1800 && $v['pay_status'] == 0) {
                    K::M('order/order')->cancel($v['order_id'], null, 'admin');
                }
            }
            if ($order_ids) {
                if ($comment_list = K::M('shop/comment')->items(array('order_id' => $order_ids), null, 1, $limit)) {
                    foreach ($comment_list as $k => $v) {
                        $items[$v['order_id']]['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,content,reply,reply_time,dateline', $v);
                    }
                }
            }
            if ($staff_ids) {
                $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);
            }
            foreach ($items as $k => $v) {
                if ($v['staff_id']) {
                    $v['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', $staff_list[$v['staff_id']]);
                } else {
                    $v['staff'] = array('staff_id' => '0', 'name' => '', 'mobile' => '', 'lng' => '', 'lat' => '');
                }
                $items[$k] = $v;
            }
            $items = array_slice($items,($page-1)*10,10,true);
        }
        $this->msgbox->set_data('data', array('items' => array_values($items), 'total_count' => $count));
    }

    public function detail($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('waimai/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else {
            if ($order['staff_id'] && ($staff = K::M('staff/staff')->detail($order['staff_id']))) {
                $order['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', $staff);
            } else {
                $order['staff'] = array('staff_id' => '0', 'name' => '', 'mobile' => '', 'lng' => '', 'lat' => '');
            }
            if ($member = K::M('member/member')->detail($order['uid'])) {
                $order['member'] = array('uid' => $member['uid'], 'nickname' => $member['nickname'], 'face' => $member['face']);
            } else {
                $order['member'] = array('uid' => 0, 'nickname' => '匿名', 'face' => 'default/face.png');
            }

            if (!$logs = K::M('order/log')->items(array('order_id' => $order_id), array('log_id' => 'ASC'))) {
                $logs = array();
            }
            $order['logs'] = array_values($logs);
            if (!$products = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))) {
                $products = array();
            }
            //增加spec_name在products内
            $arr_spec_id = array();
            foreach ($products as $k => $v) {
                if ($v['spec_id'] > 0) {
                    $arr_spec_id[] = $v['spec_id'];
                }
            }
            $arr_spec_val = K::M('waimai/productspec')->items(array('spec_id' => $arr_spec_id));
            foreach ($products as $k => $v) {
                if ($v['spec_id'] > 0) {
                    $products[$k]['spec_name'] = $arr_spec_val[$v['spec_id']]['spec_name'];
                }
            }

            $order['products'] = array_values($products);
            if ($complaint = K::M('order/complaint')->find(array('uid' => $this->uid, 'order_id' => $order_id))) {
                $order['complaint'] = 1;
            } else {
                $order['complaint'] = 0;
            }
            //有 spend_number  会返回自提码 已经 spend_status 字体状态
//            if(!$order['spend_status']){
//                $order['spend_number'] = '';
//            }
            $order['spend_number'] = ''; //始终不显示自提码

            if ($order['pei_time'] == 0) {
                $order['pei_time_label'] = L('尽快送达');
            } else {
                $order['pei_time_label'] = date("H:i", $order['pei_time']);
            }
            $order['shop_title'] = $order['waimai_title'] = $this->shop['title'];
            if ($waimai = K::M('shop/shop')->detail($this->shop_id)) {
                $order['waimai_title'] = $waimai['title'];
            }

            if ($reply = K::M('shop/comment')->find(array('order_id' => $order['order_id']))) {
                $order['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo', $reply);
                $reply['pei_time_label'] = $reply['pei_time'] . '分钟送达';
                $reply['have_photo'] = 0;
                $reply['photo_list'] = array();
                if ($photo_list = K::M('shop/photo')->items(array('comment_id' => $reply['comment_id']), null, 1, 5)) {
                    foreach ($photo_list as $k => $v) {
                        $reply['have_photo'] = 1;
                        $reply['photo_list'][] = $v['photo'];
                    }
                }
                $reply['member'] = $order['member'];
                // if($order['pei_time'] == 0) {
                //     $reply['pei_time_label'] = date("H:i", $order['dateline']+$reply['pei_time']*60);
                // }else{
                //     $reply['pei_time_label'] = date("H:i", $order['pei_time']+$reply['pei_time']*60);
                // }
                $order['comment_info'] = $reply;
            } else {
                $order['comment_info'] = array('comment_id' => 0, 'member' => $order['member']);
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('success');
        }
    }

    //扫自提码获取订单信息
    public function ziti_get($params)
    {
        if (!$params['spend_number']) {
            $this->msgbox->add(L('参数错误'), 213);
        } else {
            $number = $params['spend_number'];
            if (strlen($number) > 10) {
                if (!$waimai_order = K::M('waimai/order')->find(array('spend_number' => $number))) {
                    $this->msgbox->add(L('无效的自提码'), 217);
                } else if (!$order = K::M('order/order')->find(array('order_id' => $waimai_order['order_id']))) {
                    $this->msgbox->add(L('无效的自提码'), 218);
                } else if ($order['shop_id'] != $this->shop_id) {
                    $this->msgbox->add(L('无效的自提码'), 219);
                } else if ($order['order_status'] < 0) {
                    $this->msgbox->add(L('订单已取消'), 220);
                } else if ($waimai_order['spend_status'] > 0) {
                    $this->msgbox->add(L('自提码已使用'), 221);
                } else {
                    $order = $this->filter_fields('order_id,hongbao_id,first_youhui,order_youhui,contact,mobile,intro,total_price,hongbao,amount,spend_number,spend_status,dateline', $order);
                    $product_list = K::M('waimai/orderproduct')->items(array('order_id' => $order['order_id']));
                    $data = array('product_list' => array_values($product_list), 'waimai' => array('order' => $order, 'spend_number' => $waimai_order['spend_number'], 'order_id' => $order['order_id']));

                    if (CLIENT_OS == 'ANDROID') {
                        $this->msgbox->set_data('data', $data);
                    } else {
                        $data['result'] = $data['product_list'];
                        $this->msgbox->set_data('data', $data);
                    }
                }
            } else {
                $this->msgbox->add('无效的券', 212);
            }
        }
    }

    //自提订单核销
    public function ziti_set($params)
    {
        if (!$params['spend_number']) {
            $this->msgbox->add('参数错误', 212);
        } else if (!$order = K::M('waimai/order')->find(array('spend_number' => $params['spend_number']))) {

        }elseif(!$order = K::M('waimai/order')->detail($order['order_id'])){
            $this->msgbox->add('订单不存在', 212);
        } else if ($order['closed'] != 0) {
            $this->msgbox->add('订单不存在或已被删除', 214);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作', 215);
        } else if ( !($order['order_status'] == 1 && $order['pay_status'] == 1)
                        &&  !($order['order_status'] == 1 &&  0 == $order['online_pay']  && 0 == $order['pay_status'] )   ) {
            $this->msgbox->add('订单状态不可核销', 217);
        } else if ($order['spend_status'] == 1 && $order['order_status'] == 8) {
            $this->msgbox->add('订单已核销，请勿重复操作', 218);
        } else {
            if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                $this->msgbox->add('订单核销成功');
            }
        }
    }

    //设置订单配送类型
    public function pei_type_set($params)
    {
        if (!$params['order_id'] || !isset($params['pei_type'])) {
            $this->msgbox->add('参数错误', 212);
        } else if (!$order = K::M('order/order')->detail($params['order_id'])) {
            $this->msgbox->add('订单不存在', 212);
        } else if ($order['closed'] != 0) {
            $this->msgbox->add('订单不存在或已被删除', 214);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作', 215);
        } else {
            if (!in_array($params['pei_type'], array(0, 1))) {
                $params['pei_type'] = 1;
            }
            if ($cc = K::M('order/order')->update($order['order_id'], array('pei_type' => $params['pei_type']))) {
                $this->msgbox->add('success');
            }
        }
    }

    /**
     * 外卖1.0的方法,留着做参考
     * @param $params
     */
    public function detail_old($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else {
            if ($order['pei_type'] > 0 && $order['staff_id']) {
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $order['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', (array)$staff);
            } else {
                $order['staff'] = array('staff_id' => '0', 'name' => '', 'mobile' => '', 'lng' => '', 'lat' => '');
            }
            if (!$logs = K::M('order/log')->items(array('order_id' => $order_id), array('log_id' => 'ASC'))) {
                $logs = array();
            }
            $order['logs'] = array_values($logs);
            if (!$products = K::M('order/product')->items(array('order_id' => $order_id))) {
                $products = array();
            }
            $order['products'] = array_values($products);
            if ($complaint = K::M('order/complaint')->find(array('uid' => $this->uid, 'order_id' => $order_id))) {
                $order['complaint'] = 1;
            } else {
                $order['complaint'] = 0;
            }
            if ($reply = K::M('shop/comment')->detail_by_order($order['order_id'])) {
                $order['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo', $reply);
                $reply['have_photo'] = 0;
                $reply['photo_list'] = array();
                if ($photo_list = K::M('shop/photo')->items(array('comment_id' => $reply['comment_id']), null, 1, 5)) {
                    foreach ($photo_list as $k => $v) {
                        $reply['have_photo'] = 1;
                        $reply['photo_list'][] = $v['photo'];
                    }
                }
                $order['comment_info'] = $reply;
            } else {
                $order['comment_info'] = array('comment_id' => 0);
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('success');
        }
    }

    public function jiedan($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else if ($this->biz['verify_name'] != 1) {
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'), 212);
        } else if ($order['pei_type'] == 2) {
            $this->msgbox->add(L('代购订单不可接单'), 214);
        } else if ($order['online_pay'] && !$order['pay_status']) {
            $this->msgbox->add(L('订单未支付不可接单'), 215);
        } else if ((int)$order['order_status'] !== 0) {
            $this->msgbox->add(L('订单状态不可接单'), 216);
        } else if (K::M('order/order')->update($order_id, array('order_status' => 1, 'lasttime' => time()))) {
            //订单日志
            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'shop', 'log' => L('商家已接单'), 'type' => '3'));
            $this->msgbox->add('success');
        }
    }

    //抢单
    public function qiang($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else if ($this->biz['verify_name'] != 1) {
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'), 212);
        } else if ($order['pei_type'] == 2) {
            $this->msgbox->add(L('代购订单不可抢送'), 214);
        } else if ($order['staff_id'] > 0) {
            $this->msgbox->add(L('配送员已经接单不可抢送'), 215);
        } else if ($order['online_pay'] && !$order['pay_status']) {
            $this->msgbox->add(L('订单未支付不可抢送'), 216);
        } else if (!in_array($order['order_status'], array(0, 1, 2))) {
            $this->msgbox->add(L('订单状态不可抢送'), 217);
        } else if (K::M('order/order')->update($order_id, array('order_status' => 3, 'pei_type' => 0))) {
            //订单日志
            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'shop', 'log' => L('商家自己开始配送'), 'type' => 4));
            $this->msgbox->add('success');
            $orderdetail = K::M('order/order')->detail($order_id);
            $this->msgbox->set_data('data', array('order' => $orderdetail));
        }
    }

    public function cancel($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else if ($order['pei_type'] == 2) {
            $this->msgbox->add(L('代购订单不可取消'), 214);
        } else if ($order['order_status'] != 0) {
            $this->msgbox->add(L('订单状态不可取消'), 215);
        } else if (K::M('order/order')->cancel($order_id, $order, 'shop')) {
            $this->msgbox->add('success');
        }
    }

    public function pei($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else if ($order['pei_type'] == 2) {
            $this->msgbox->add(L('代购订单不可抢送'), 214);
        } else if ($order['staff_id'] > 0) {
            $this->msgbox->add(L('配送员已经接单不可操作'), 214);
        } else if (!in_array($order['order_status'], array(1, 2))) {
            $this->msgbox->add(L('订单状态不可发货'), 215);
        } else if (K::M('order/order')->update($order_id, array('order_status' => 3, 'pei_type' => 0, 'lasttime' => __TIME))) {
            //订单日志 v-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成
            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'shop', 'log' => L('商家开始配送'), 'type' => 4));
            $this->msgbox->add('success');
            $orderdetail = K::M('order/order')->detail($order_id);
            $this->msgbox->set_data('data', array('order' => $orderdetail));
        }
    }

    public function delivered($params)
    {
        if (!$order_id = (int)$params['order_id']) {
            $this->msgbox->add(L('订单不存在'), 211);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        } else if ($order['shop_id'] != $this->shop_id) {
            $this->msgbox->add(L('非法操作'), 213);
        } else if ($order['staff_id'] > 0) {
            $this->msgbox->add(L('订单由配送员配送不可操作'), 214);
        } else if ((int)$order['order_status'] !== 3) {
            $this->msgbox->add(L('订单状态不可设置为已送达'), 215);
        } else if (K::M('order/order')->update($order_id, array('order_status' => 4, 'lasttime' => __TIME))) {
            //订单日志 v-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成
            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'shop', 'log' => L('订单已送达'), 'type' => 5));
            $this->msgbox->add('success');
        }
    }

    public function batch($params)
    {

    }

    //订单提醒
    public function tixing($params)
    {
        $this->check_login();
        if (!$dateline = (int)$params['dateline']) {
            //如果没有传时间戳设置为15分钟前
            $dateline = __TIME - 900;
        }
        //$lasttime = K::M('order/order')->get_last_dateline();
        $filter = array('shop_id' => $this->shop_id, 'order_status' => 0, 'lasttime' => ">:" . $dateline);
        $filter[':OR'] = array('pay_status' => 1, 'online_pay' => 0);
        $filter['pei_type'] = array(0, 1);
        $filter['closed'] = 0;
        $new_order = (int)K::M('order/order')->count($filter);
        $cui_order = (int)K::M('order/order')->count(array('shop_id' => $this->shop_id, 'pei_type' => array(0, 1), 'cui_time' => ">:" . $dateline, 'order_status' => array(1, 2, 3, 4), 'closed' => 0));

        $new_msg = (int)K::M('shop/msg')->items(array('shop_id' => $this->shop_id, 'dateline' => ">:" . $dateline, 'is_read' => 0));

        $this->msgbox->set_data('data', array('new_order' => $new_order, 'cui_order' => $cui_order, 'new_msg' => $new_msg, 'dateline' => __TIME));
        $this->msgbox->add('success');
    }

}
