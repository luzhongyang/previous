<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Pintuangroup extends Ctl_Weidian
{

    public $status = 1000;

    public function index($page)
    {
        $this->check_weidian();
        if($this->shop['pintuan'] == 1){
            //$this->msgbox->add('拼团功能尚未开启',210);
           // $this->msgbox->set_data('forward', $this->mklink('merchant/shop/opened'));
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
                if($SO['product_id']){
                    $filter['product_id'] = $SO['product_id'];
                }
                if($SO['group_id']){
                    $filter['group_id'] = $SO['group_id'];
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
            if($items = K::M('weidian/pintuan/group')->items($filter, array('group_id' => 'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
                $arr_product_id = array();
                $arr_master_id = array();
                foreach($items as $k => $v){
                    $arr_product_id[] = $v['product_id'];
                    $arr_master_id[] = $v['master_id'];
                }
                $arr_product_id = array_unique($arr_product_id);
                $arr_product_title = K::M('weidian/product')->select(" product_id in (" . implode(',', $arr_product_id) . ")");

                $arr_master_id = array_unique($arr_master_id);
                $arr_master_nickname = K::M('member/member')->select(" uid in (" . implode(',', $arr_master_id) . ")");

                $view_params = K::M('weidian/pintuan/group')->view_params;

                foreach($items as $k => $v){
                    $v['start_time'] = date('Y-m-d H:i', $v['start_time']);
                    $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
                    $v['status_cn'] = $view_params['status']['select'][$v['status']];
                    $v['pintuan_product_id_cn'] = $arr_product_title[$v['product_id']]['title'];
                    $v['master_id_cn'] = $arr_master_nickname[$v['master_id']]['nickname'];

                    $items[$k] = $v;
                }
            }

            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['status'] = $this->status;
            $this->pagedata['statuss'] = $this->status +1;
            $this->tmpl = 'merchant:weidian/group/index.html';
        }
    }

    /**
     * 进行中,组团中
     */
    public function start()
    {
        $this->check_weidian();
        $this->status = 0;
        $this->index();
    }

    /**
     * 组团成功
     */
    public function process()
    {
        $this->check_weidian();
        $this->status = 1;
        $this->index();
    }

    /**
     * 组团失败
     */
    public function complete()
    {
        $this->check_weidian();
        $this->status = 2;
        $this->index();
    }

    /**
     * 商家已确认
     */
    public function ok()
    {
        $this->check_weidian();
        $this->status = 3;
        $this->index();
    }

    /**
     * 组团成功, 商家接单发货,   
     * 此按钮出现的时间, 为 付款倒计时之后 30分钟(默认),之后,
     */
    public function status_ok($group_id)
    {
        $this->check_weidian();
        $return = array(
            'error'   => 0,
            'message' => '接单成功.',
        );

        $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $group_id));

        //防止误操作,退多次
        if(1 == $arr_group['status']){

            //多人团,单人购买,处理异议
            $arr_product = K::M('weidian/pintuan/product')->find(array('product_id' => $arr_group['product_id']));
            //佣金按照人数来计算,不计算在订单总额内
            $update = array(
                'status' => '3',
            );
            K::M('weidian/pintuan/group')->update($group_id, $update);

            //减少产品库存
            $stock = $arr_product['stock'] - $arr_group['order_yongjin_count']; //成功人数  order_success_count 取消
            $stock_update = array('stock' => $stock);
            $update_product = K::M('weidian/pintuan/product')->update($arr_product['product_id'], $stock_update);

            //订单确认操作,将订单钱打入商家账户
            $pintuan_order = K::M('weidian/pintuan/order')->select(array('group_id' => $group_id, 'shop_id' => $this->shop_id));
            $order_ids = array();
            foreach($pintuan_order as $k => $v){
                $order_id = $v['order_id'];
                if(K::M('order/order')->update($order_id, array('order_status' => 1, 'jd_time' => __TIME, 'lasttime' => __TIME))){
                    //自动打印订单判断 todo...
                    $log = array('order_id' => $order_id, 'from' => 'shop', 'log' => '拼团商家已接单', 'type' => 3);
                    K::M('order/log')->create($log);
                    //通知用户,APP推送 weixin模板消息
                    K::M('order/order')->send_member('拼团商家已经接单', sprintf("订单(%s)拼团商家已经接单", $order_id), $order, 'jiedan');
                    $this->msgbox->add('接单成功');
                }
                else{
                    $this->msgbox->add('接单失败', 215);
                }
            }

            //佣金单个处理
        }
        else{
            $return['message'] = "更新失败, 团编号: $group_id 不是组团成功状态.";
        }

        print_r(json_encode($return));
        exit;
    }

    /**
     * ,商家取消发货,执行此. 组团成功将变为组团失败
     */
    public function status_complete($group_id)
    {
        $this->check_weidian();
        //退回余额
        $return = array(
            'error'   => 0,
            'message' => '已经退单, 钱已经退回到用户账号余额.',
        );
        $arr_group = K::M('weidian/pintuan/group')->find(array('pintuan_group_id' => $group_id));

        //防止误操作,退多次
        if(1 == $arr_group['status']){
            $update = array(
                'status' => '2',
            );
            K::M('weidian/pintuan/group')->update($group_id, $update);
            //逐个退,每个成功支付定的钱
            $pintuan_order = K::M('weidian/pintuan/order')->select(array('pintuan_group_id' => $group_id, 'shop_id' => $this->shop_id));
            $order_ids = array();
            //退款,并更新订单状态
            foreach($pintuan_order as $k => $v){
                $content = "操作时间" . date('Y-m-d: H:i');
                $arr_group = K::M('member/member')->send($v['uid'], '商家取消接单', $content, 'order', $v['order_id']);
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
