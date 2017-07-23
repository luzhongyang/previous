<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Cashier extends Ctl_Biz
{

    public function test()
    {
//        echo 'aa';
//        var_dump(IN_APP);die;
        $code = '微信';
        $order_id = 1001;
        $order['shop_id'] = '10006';
        $order['amount'] = 321;
        $title = sprintf($code."扫码支付成功通知(单号：%s)".time(), $order_id);
        $content = sprintf($code."扫码支付成功(单号：%s)，买单金额￥%s，支付方式".time(), $order_id,  $order['amount']);
        //优惠后支付￥%s
        $name='微信扫码';
        K::M('shop/shop')->send($order['shop_id'], $title, $content, 'qrcodepay', $order_id, 'newMsg.mp3', $order['amount'], $name);
        echo $order['amount'];
        var_dump(IN_APP);
	die('test ok');
    }
    /**
     * 付款列表,已付款的订单
     */
    public function items()
    {
        $limit = 10;
        $page = max((int) $params['page'], 1);
        $filter = array('shop_id' => $this->shop_id);
        $filter['pay_status'] = 1;

        if($items = K::M('cashier/order')->items($filter, array('po_id' => 'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }

        $this->msgbox->set_data('data', array('items' => array_values($items), 'total_count' => $count));
    }

    public function create($params)
    {
        if($this->shop_id){
            $detail = K::M('shop/shop')->detail($this->shop_id);
            $order_data = array(
                'shop_id' => $this->shop_id,
                'order_type' => 0,
                'amount' => $params['amount'],
                'pay_status' => 0,
                'pay_shop' => $detail['title'],
                'title' => $detail['title'],
                'pay_desc' => $detail['title'].'收银'.$params['amount'],
                'trade_no' => ''
            );
        }
        if(!$detail){
            $this->msgbox->add('商家未登录', 210);
        }
        else if(!isset($order_data['amount']) || $order_data['amount'] < 0.01){
            $this->msgbox->add('支付金额不能小于1分钱', 211);
        }else if(!$po_id = K::M('cashier/order')->create($order_data)){
            $this->msgbox->add('写入数据错误,请联系管理员', 212);
        }else{
//error_reporting(E_ALL);
//ini_set("display_errors", 'true');
            $data = array();
            $order_data['po_id'] = $po_id;
            $order = $order_data;
            $order['order_id'] = $po_id;
            $order['uid'] = $this->shop_id;

            $code = 'alipay';
            if($result = K::M('trade/payment')->cashier($code, $order)){
                $data['ali_url'] = $result['qrcode'];
                $data['trade_no'] = $result['trade_no'];
            }

            $code = 'wxpay';
            //cashier 默认是被扫,不用传递参数
            if($result = K::M('trade/payment')->cashier($code, $order, '', $pay_type)){
                $data['wx_url'] = $result['qrcode'];
                $data['trade_no'] = $result['trade_no'];
            }

            //end

            //更新二维码信息等,到order表.
            K::M('cashier/order')->update($po_id, $data);
            $data['po_id'] = $po_id;

            $this->msgbox->set_data('data', array('wx_url' => $data['wx_url'], 'ali_url' => $data['ali_url'], 'trade_no' => $data['trade_no'], 'id' => $po_id, 'pay_desc' => $data['pay_desc']));

            $this->msgbox->add('success');
        }
    }

    public function saoma($params)
    {
        if(!$detail = K::M('shop/shop')->detail($this->shop_id)){
            $this->msgbox->add('店铺不存在', 210);
        }else if(!isset($params['amount']) || $params['amount'] < 0.01){
            $this->msgbox->add('支付金额不能小于1分钱', 211);
        }else if(!isset($params['auth_code'])){
            $this->msgbox->add('用户授权码不能为空', 212);
        }else{
            $order_data = array(
                'shop_id' => $this->shop_id,
                'order_type' => 0,
                'amount' => $params['amount'],
                'pay_status' => 0,
                'pay_shop' => $detail['title'],
                'title' => $detail['title'],
                'pay_desc' => $detail['title'].'收银'.$params['amount'],
                'trade_no' => ''
            );

            $po_id = K::M('cashier/order')->create($order_data);

            $order_data['po_id'] = $po_id;
            $order_data['order_id'] = $po_id;
            $order_data['auth_code'] = $params['auth_code'];


            if('wxpay' == $params['type']){
                //扫用户,传递  'saoma'
                $code = 'wxpay';
                if($res = K::M('trade/payment')->cashier($code, $order_data, 'saoma')){
                    if('SUCCESS' == $res['pay_info']['result_code']){
                        $res['order_id'] = $po_id;
                        $log = K::M('payment/log')->find(array('trade_no'=>$res['trade_no']));
                        $res['log_id'] = $log['log_id'];
                        K::M('cashier/order')->set_payed($res,array(), $code);
                    }
                    //更新订单结束
                    $this->msgbox->set_data('data', array(
                        'result_code' => $res['trade_status'],
                        'transaction_id' => $res['pay_trade_no'],
                        'out_trade_no' => $res['trade_no'],
                        'total_fee' => $res['amount'],
                        'trade_state' => $res['trade_status'],
                    ));
                    $this->msgbox->add('success');
                }
                else{
                    $this->msgbox->add('授权码不正确', 212);
                }

            }else if('alipay' == $params['type']){

                $code = 'alipay';
                if($res = K::M('trade/payment')->cashier($code, $order_data, 'saoma')){
                    if('SUCCESS' == $res['trade_status']){
                        $res['order_id'] = $po_id;
                        $log = K::M('payment/log')->find(array('trade_no'=>$res['trade_no']));
                        $res['log_id'] = $log['log_id'];
                        K::M('cashier/order')->set_payed($res,array(), $code);
                    }

                    //更新订单结束
                    $this->msgbox->set_data('data', array(
                        'result_code' => $res['trade_status'],
                        'transaction_id' => $res['pay_trade_no'],
                        'out_trade_no' => $res['trade_no'],
                        'total_fee' => $res['amount'],
                        'trade_state' => $res['trade_status'],
                    ));
                    $this->msgbox->add('success');
                }
                else{
                    $this->msgbox->add('授权码不正确', 212);
                }

            }else{
                $this->msgbox->add('支付方式类型错误', 220);
            }
        }
    }

}
