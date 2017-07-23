<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Pintuangroup extends Ctl_Biz
{

    public $status = 1000;

    public function index($page)
    {
        if($this->shop['pintuan'] != 1){
            //$this->msgbox->add('拼团功能尚未开启',210);
            header('Location:/biz/shop/opened');
        }
        else{
            $filter = $pager = array();
            $filter['shop_id'] = $this->shop_id;
            if(1000 != $this->status){
                $filter['status'] = $this->status;
            }
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 20;
            if($SO = $this->GP('SO')){
                $pager['SO'] = $SO;
                if($SO['pintuan_product_id']){
                    $filter['pintuan_product_id'] = $SO['pintuan_product_id'];
                }
                if($SO['group_id']){
                    $filter['pintuan_group_id'] = $SO['group_id'];
                }
                if($SO['title']){
                    $filter['title'] = "LIKE:%" . $SO['title'] . "%";
                }
                if($SO['master_id']){
                    $filter['master_id'] = $SO['master_id'];
                }
                if($SO['user_num']){
                    $filter['user_num'] = $SO['user_num'];
                }
                if($SO['tuan_price']){
                    $filter['tuan_price'] = ">=:" . $SO['tuan_price'];
                }
                if($SO['tuan_limit']){
                    $filter['tuan_limit'] = $SO['tuan_limit'];
                }
            }
            $SO = $filter;
            if($items = K::M('pintuan/group')->items($filter, array('pintuan_group_id' => 'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
                $arr_product_id = array();
                $arr_master_id = array();
                foreach($items as $k => $v){
                    $arr_product_id[] = $v['pintuan_product_id'];
                    $arr_master_id[] = $v['master_id'];
                }
                $arr_product_id = array_unique($arr_product_id);
                $arr_product_title = K::M('pintuan/product')->select(" pintuan_product_id in (" . implode(',', $arr_product_id) . ")");

                $arr_master_id = array_unique($arr_master_id);
                $arr_master_nickname = K::M('member/member')->select(" uid in (" . implode(',', $arr_master_id) . ")");

                $view_params = K::M('pintuan/group')->view_params;
                foreach($items as $k => $v){
                    $v['jiedan_time'] = $v['end_time'] + 0; // 即时接单,不需要过1天 86400
                    $v['start_time'] = date('Y-m-d H:i', $v['start_time']);
                    $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
                    $v['status_cn'] = $view_params['status']['select'][$v['status']];
                    $v['pintuan_product_id_cn'] = $arr_product_title[$v['pintuan_product_id']]['title'];
                    $v['master_id_cn'] = $arr_master_nickname[$v['master_id']]['nickname'];
                    $v['money_pre'] = $arr_product_title[$v['pintuan_product_id']]['money_pre'];
                    
                    $items[$k] = $v;
                }
            }
            $this->pagedata['now'] = time();
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['status'] = $this->status;
            $this->tmpl = 'biz/pintuan/group/index.html';
        }
    }

    /**
     * 进行中,组团中
     */
    public function start($page)
    {
        $this->status = 0;
        $this->index($page);
    }

    /**
     * 组团成功
     */
    public function process($page)
    {
        $this->status = 1;
        $this->index($page);
    }

    /**
     * 组团失败
     */
    public function complete($page)
    {
        $this->status = 2;
        $this->index($page);
    }

    /**
     * 商家已确认
     */
    public function ok($page)
    {
        $this->status = 3;
        $this->index($page);
    }

    /**
     * 组团成功, 商家接单发货,   
     * 此按钮出现的时间, 为 付款倒计时之后 30分钟(默认),之后,
     */
    public function status_ok($group_id)
    {

        $return = array(
            'error'   => 0,
            'message' => '接单成功.',
        );

        $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));

        //组团成功后,24消失,才可以接单,
        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $arr_group['pintuan_product_id']));
        //到期时间, 预付款模式, + 0 // 即时接单,不需要过1天 86400
        if($arr_product['money_pre'] > 0){
            $jiedan_time = $arr_group['end_time'] + 0;
        }
        else{
            $jiedan_time = time() - 10;
        }

        //防止误操作,退多次
        if(1 == $arr_group['status'] && time() > $jiedan_time){

            //多人团,单人购买,处理异议
            //佣金按照人数来计算,不计算在订单总额内
            $update = array(
                'status' => '3',
            );
            K::M('pintuan/group')->update($group_id, $update);

            //减少产品库存,   0902库存处理方式要修改,付款/付尾款处理库存
            $stock = $arr_product['stock'] - $arr_group['order_yongjin_count']; //成功人数  order_success_count 取消
            $stock_update = array('stock' => $stock);
            K::M('pintuan/product')->update($arr_product['pintuan_product_id'], $stock_update);

            //订单确认操作,将订单钱打入商家账户
            $pintuan_order = K::M('pintuan/order')->select(array('pintuan_group_id' => $group_id, 'shop_id' => $this->shop_id));

            foreach($pintuan_order as $k => $v){

                $order_id = $v['order_id'];
                /*
                 * 先判断订单,是否付款, 已经是否付尾款, 
                 * 未付款,取消订单, 0902不取消订单
                 * 未付尾款,将预付款,打入商家账户
                 */
                $arr_order = K::M('order/order')->find(array('order_id' => $order_id));
                if(0 == $arr_order['pay_status']){
                    //未付款的,取消订单
                    $content = "操作时间" . date('Y-m-d: H:i');
                    K::M('member/member')->send($v['uid'], '商家取消接单(ID:' . $order_id . ')', $content, 'order', $order_id);
                    K::M('order/order')->cancel($order_id, null, $from = 'pintuan', $reason = '拼团订单未付款,订单自动取消');
                }
                else if(1 == $arr_order['pay_status'] && 1 == $v['is_money_pre'] && $arr_order['amount'] > $v['money_paid']){
                    //没付尾款的, 7天内可以付款, 否则钱打给商家
                    //计划任务内执行了
                }
                else{
                    if(K::M('order/order')->update($order_id, array('order_status' => 1, 'jd_time' => __TIME, 'lasttime' => __TIME))){
                        //自动打印订单判断 todo...
                        $log = array('order_id' => $order_id, 'from' => 'shop', 'log' => '拼团商家已接单', 'type' => 3);
                        K::M('order/log')->create($log);
                        //通知用户,APP推送 weixin模板消息
                        K::M('order/order')->send_member('拼团商家已经接单', sprintf("订单(%s)拼团商家已经接单", $order_id), $order, 'jiedan');
                        $overdue = K::M('weidian/pintuan/group')->group_auto_check($group_id);
                        $this->msgbox->add('接单成功');
                    }
                    else{
                        $this->msgbox->add('接单失败', 215);
                    }
                }
            }

            //佣金单个处理
        }
        else{
            if(time() < $jiedan_time){
                $return['message'] = "更新失败, 团编号: $group_id 接单时间未到,<br />组团成功后24小时可以接单.";
            }
            if(1 != $arr_group['status']){
                $return['message'] = "更新失败, 团编号: $group_id 不是组团成功状态.";
            }
        }

        print_r(json_encode($return));
        exit;
    }

    /**
     * ,商家取消发货,执行此. 组团成功将变为组团失败
     */
    public function status_complete($group_id)
    {
        //退回余额
        $return = array(
            'error'   => 0,
            'message' => '已经退单, 钱已经退回到用户账号余额.',
        );
        $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));

        //防止误操作,退多次
        if(1 == $arr_group['status']){
            $update = array(
                'status' => '2',
            );
            K::M('pintuan/group')->update($group_id, $update);
            //逐个退,每个成功支付定的钱
            $pintuan_order = K::M('pintuan/order')->select(array('pintuan_group_id' => $group_id, 'shop_id' => $this->shop_id));
            $order_ids = array();
            //退款,并更新订单状态
            foreach($pintuan_order as $k => $v){
                $content = "操作时间" . date('Y-m-d: H:i');
                $arr_group = K::M('member/member')->send($v['uid'], '商家取消接单(ID:' . $v['order_id'] . ')', $content, 'order', $v['order_id']);
                $is_cancel = K::M('order/order')->cancel($v['order_id'], null, $from = 'pintuan', $reason = '拼团商家取消接单');
            }
        }
        else{
            $return['message'] = "更新失败, 团编号: $group_id 不是组团成功状态.";
        }
        print_r(json_encode($return));
        exit;
    }

}
