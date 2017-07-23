<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
class Ctl_Trade_Payment extends Ctl
{

    public function __construct(&$system)
    {
        parent::__construct($system);
        $uri = $this->request['uri'];
        if(preg_match('/(return|notify)-(\w+)(-(app))?\.html/i', $uri, $match)){
            $system->request['act'] = $match[1] . '_verify';
            $system->request['args'] = array($match[2], $match[4]);
        }
    }

    public function return_verify($code, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        $forward = $this->mklink('ucenter/money:index');
        if($obj = K::M('trade/payment')->loadPayment($code)){

            if($trade = $obj->return_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add(L('支付的订单不存在'), 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'],$trade['pay_trade_no'])){
                    if($log['from'] == 'money'){ //余额充值
                        K::M('trade/payment')->payed_money($log, $trade);
                        $this->msgbox->add(L('充值余额成功'));
                    }else if($log['from'] == 'order'){
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('order/order')->detail($log['order_id']);
                        $this->msgbox->add(L('订单支付成功'));
                        $forward = $this->mklink('waimai/order:detail', array($log['order_id']));
                    }else if($log['from'] == 'reward'){
                        K::M('trade/payment')->payed_reward($log, $trade);
                        $this->pagedata['order'] = K::M('trade/order')->detail_by_no($trade['trade_no']);
                        $this->msgbox->add('success'); //增加小费支付成功
                    }else if($log['from'] == 'paotui'){
                        if(K::M('trade/payment')->payed_paotui($log, $trade)){
                            //$this->pagedata['paotui'] = K::M('paotui/paotui')->detail($log['order_id']);
                            $this->msgbox->add(L('订单支付成功'));
                            $forward = $this->mklink('paotui:detail', array($log['order_id']));
                        }
                    }
                }else{
                    if( 1 == $log['payed'] ){
                        $this->msgbox->add('订单支付成功');
                    }else if($log['from'] == 'money'){
                        $this->msgbox->add(L('已经充值成功，请不要重复提交'), 214);
                    }else{
                        $this->msgbox->add(L('该订单已经支付过了'), 213);
                    }
                }
            }else{
                $this->msgbox->add(L('支付验证签名失败'), 215);
            }
            if(defined('IN_WEIXIN') && $code == 'alipay'){
                $this->msgbox->set_js('window.top.location.href="' . $forward . '";');
            }else{
                //为stripe准备的支付成功跳转
                $order_id = $this->GP('order_id');
                if($order = K::M('order/order')->detail($order_id)){
                    if($order['from'] == 'waimai'){
                        if(defined('IS_MOBILE')){
                            $this->msgbox->set_data('forward', $this->mklink('waimai/order:detail', array($order_id)));
                        }else{
                            $this->msgbox->set_data('forward', $this->mklink('web/ucenter/order/detail', array($order_id)));
                        }
                    }else if($order['from'] == 'pintuan'){
                        $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                        $this->msgbox->set_data('forward', $this->mklink('pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));
//                                    }
                    }else if($order['from'] == 'weidian_pintuan'){
                        //查出团id
                        $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                        $this->msgbox->set_data('forward', $this->mklink('weidian/pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));
                    }else if($order['from'] == 'mall'){
                        $this->msgbox->set_data('forward', $this->mklink('mall/order:detail', array($order_id)));
                    }else if($order['from'] == 'paotui'){
                        $this->msgbox->set_data('forward', $this->mklink('paotui:order_detail', array($order_id)));
                    }else if($order['from'] == 'weidian_waimai'){
                        $this->msgbox->set_data('forward', $this->mklink('weidian_'.$order['shop_id'].'/ucenter/order/waimai_order_detail', array($order_id)));
                    }else{
                        $this->msgbox->set_data('forward', $this->mklink('ucenter/order/detail', array($order_id)));
                    }
                    $this->msgbox->add('订单支付成功');

                }else{
                    $this->msgbox->set_data('forward', $forward);
                }


            }
        }
    }

    public function notify_verify($code, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        $success = false;
        if($obj = K::M('trade/payment')->loadPayment($code)){
            if($trade = $obj->notify_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add(L('支付的订单不存在'), 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'money'){ //金币充值
                        if(K::M('trade/payment')->payed_money($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'order'){
                        if(K::M('trade/payment')->payed_order($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'paotui'){
                        if(K::M('trade/payment')->payed_order($log, $trade)){
                            $success = true;
                        }
                    }
                }
            }
            $obj->notify_success($success);
        }
    }

    public function order($code = null, $order_id = null, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        if(!($order_id = (int) $order_id) && !($order_id = (int) $this->GP('order_id'))){
            $this->error(404);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->error(404);
        }else if($this->check_login()){
            $order = K::M('order/order')->detail($order_id);
            if($order['from'] == 'pintuan' || $order['from'] == 'weidian_pintuan'){
                $arr_p_order = K::M('pintuan/order')->find(array('order_id' => $order['order_id']));
                if(1 == $arr_p_order['is_money_pre']){
                    if(0 == $arr_p_order['money_paid']){
                        //1.预付款
                        //无需更新状态
                    }elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){

                        //2.付尾款 //如果商家已经接单,状态更新为1
                        $arr_pintuan_order = K::M('pintuan/order')->detail($order_id);
                        $arr_pintuan_group = K::M('pintuan/group')->detail($arr_pintuan_order['pintuan_group_id']);
                        $_pintuan_update = array();
                        if( 3 == $arr_pintuan_group['status'] ){
                            $_pintuan_update['order_status'] = 1;
                            $_pintuan_update['pay_status'] = 0;
                        }
                        K::M('order/order')->update($order_id, $_pintuan_update);
                    }else{
                        //3.付尾款,多次付款兼容  //如果商家已经接单,状态更新为1
                        $arr_pintuan_order = K::M('pintuan/order')->detail($order_id);
                        $arr_pintuan_group = K::M('pintuan/group')->detail($arr_pintuan_order['pintuan_group_id']);
                        $_pintuan_update = array();
                        if( 3 == $arr_pintuan_group['status'] ){
                            $_pintuan_update['order_status'] = 1;
                            $_pintuan_update['pay_status'] = 0;
                        }
                        K::M('order/order')->update($order_id, $_pintuan_update);
                    }

                }
            }

            if(!$order = K::M('order/order')->detail($order_id)){
                $this->msgbox->add(L('您的订单不存在或已被删除'), 211);
            }else if($order['order_status'] < 0){
                $this->msgbox->add(L('订单已经取消不可支付'), 212);
            }else if($order['order_status'] == 8){
                $this->msgbox->add(L('订单已经完成不可支付'), 212);
            }else if($order['pay_status'] == 1){
                $this->msgbox->add(L('该订单已经支付过了,不需要重复支付'), 213);
            }else if((float) $order['amount'] == 0){
                $this->msgbox->add(L('订单无需在线支付'), 215);
            }else{

                $amount = $order['amount'];
                if($code == 'money'){
                    if($this->MEMBER['money'] < $order['amount']){
                        $this->msgbox->add('账户余额不足！', 217);
                    }else if(!$trade = K::M('trade/payment')->order('money', $order)){
                        $this->msgbox->add('余额支付失败！', 216);
                    }else if(K::M('member/member')->update_money($this->uid, -$trade['amount'], '支付订单(ID:' . $order_id . ')')){
                        $amount = $trade['amount'];
                        $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                        $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                        if($log['payed']){
                            $this->msgbox->add('单号已经支付过了', 218);
                        }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                            if($res = K::M('trade/payment')->payed_order($log, $trade)){

                                if($this->MEMBER['wx_openid']){
                                    K::M('order/order')->payed_wxmsg($this->MEMBER['wx_openid'], $order);  //发送微信模板消息
                                    $this->msgbox->set_data('forward', $this->mklink('ucenter/order/detail', array($order_id)));
                                }

                                if($order['from'] == 'waimai'){
                                    if(defined('IS_MOBILE')){
                                        $this->msgbox->set_data('forward', $this->mklink('waimai/order:detail', array($order_id)));
                                    }else{
                                        $this->msgbox->set_data('forward', $this->mklink('web/ucenter/order/detail', array($order_id)));
                                    }
                                }else if($order['from'] == 'pintuan'){
                                    K::M('system/logs')->log('user_agent', $_SERVER['HTTP_USER_AGENT']);
                                    //如果是APP调WEBVIEW
//                                    if(strpos($_SERVER['HTTP_USER_AGENT'], "WaiMai2.0")){
//                                        echo "<script>function app_reback();app_reback(1);</script>";
//                                        die;
//                                    }else{
                                        //查出团id
                                        $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                                        $this->msgbox->set_data('forward', $this->mklink('pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));
//                                    }
                                }else if($order['from'] == 'weidian_pintuan'){
                                        //查出团id
                                        $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                                        $this->msgbox->set_data('forward', $this->mklink('weidian/pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));
                                }else if($order['from'] == 'mall'){
                                    $this->msgbox->set_data('forward', $this->mklink('mall/order:detail', array($order_id)));
                                }else if($order['from'] == 'paotui'){
                                    $this->msgbox->set_data('forward', $this->mklink('paotui:order_detail', array($order_id)));
                                }else if($order['from'] == 'weidian_waimai'){
                                    $this->msgbox->set_data('forward', $this->mklink('weidian_'.$order['shop_id'].'/ucenter/order/waimai_order_detail', array($order_id)));
                                }else{
                                    $this->msgbox->set_data('forward', $this->mklink('ucenter/order/detail', array($order_id)));
                                }
                                $this->msgbox->add('订单支付成功');
                                //没有web版,先都跳到ucenter下
//                                if(defined('IS_MOBILE')){
//
//                                }
//                                else{
//                                    $this->msgbox->set_data('forward', $this->mklink('ucenter/order/detail', array($order_id)));
//                                }
                            }
                        }else{
                            //如果失败了并且是APP_WEBVIEW。
                            if($app_webview == 1){
                                echo "<script>function app_reback();app_reback(0);</script>";
                                die;
                            }
                        }
                    }
                }else{
                    if(defined('IN_WEIXIN') && $code == 'wxpay'){
                        $this->_init_wxopenid();
                        $order['wx_openid'] = $this->wx_openid;
                    }

                    if($url = K::M('trade/payment')->order($code, $order)){

                        if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                            $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'order_id' => $order['order_id']));
                            header("Location:{$qrurl}");
                        }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                            $this->pagedata['payurl'] = $url;
                            $this->tmpl = 'trade/payment/wxalipay.html';
                        }else if($code == 'paypal'){
                            $this->pagedata['paypal_form_html'] = $url;
                            $this->tmpl = 'trade/payment/paypal.html';
                        }else if($code == 'stripe'){
                            //stripe 流程不同于支付宝,微信,这里传参走自己的流程
                            $payment_stripe = K::M('payment/payment')->payment($code);
                            $obj_stripe = K::M('trade/payment')->loadPayment($code);
                            $pay_button = $obj_stripe->load_web_pay_button($url,$payment_stripe);
                            $payment_stripe['pay_button'] = $pay_button;
                            $this->pagedata['payment'] = $payment_stripe;
                            $this->pagedata['input'] = $url;
                            $this->tmpl = 'trade/payment/stripe.html';

                        }else{
                            header("Location:{$url}");
                        }
                    }
                }
            }
            //增加各种错误,跳转到订单页面,
            if($order['from'] == 'waimai'){
                if(defined('IS_MOBILE')){
                    $this->msgbox->set_data('forward', $this->mklink('waimai/order:detail', array($order_id)));
                }else{
                    $this->msgbox->set_data('forward', $this->mklink('web/ucenter/order/detail', array($order_id)));
                }

            }else if($order['from'] == 'pintuan'){
                K::M('system/logs')->log('user_agent', $_SERVER['HTTP_USER_AGENT']);
                //如果是APP调WEBVIEW
//                if(strpos($_SERVER['HTTP_USER_AGENT'], "WaiMai2.0")){
//                    echo "<script>function app_reback();app_reback(1);</script>";
//                    die;
//                }else{
                    //查出团id
                    $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                    $this->msgbox->set_data('forward', $this->mklink('pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));

//                    $this->msgbox->set_data('forward', $this->mklink('pintuan/tuan_order_detail', array($order_id)));
//                }
            }else if($order['from'] == 'weidian_pintuan'){
                    $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                    $this->msgbox->set_data('forward', $this->mklink('weidian/pintuan/tuan_detail', array($arr_group['pintuan_group_id'])));
            }else if($order['from'] == 'mall'){
                $this->msgbox->set_data('forward', $this->mklink('mall/order:detail', array($order_id)));
            }else if($order['from'] == 'paotui'){
                $this->msgbox->set_data('forward', $this->mklink('paotui:order_detail', array($order_id)));
            }else if($order['from'] == 'weidian_waimai'){
                $this->msgbox->set_data('forward', $this->mklink('weidian_'.$order['shop_id'].'/ucenter/order/waimai_order_detail', array($order_id)));
            }else{
                $this->msgbox->set_data('forward', $this->mklink('ucenter/order/detail', array($order_id)));
            }
        }
    }

    // 跑腿订单追加小费支付
    public function addreward($order_id = null, $code = null, $amount = null)
    {
        $this->check_login();
        if(!($order_id = (int) $order_id)){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else if(!in_array($order['order_status'], array(0, 8))){
            $this->msgbox->add(L('该订单不可以追加小费或打赏' . $order['order_id']), 214);
        }else if(!$code){
            $this->msgbox->add(L('未指定支付方式'), 221);
        }else if($code == 'money' && $this->MEMBER['money'] < $amount){
            $this->msgbox->add(L('余额不足，请更换支付方式'), 221);
        }else if($r = K::M('paotui/reward')->find(array('type' => 1, 'order_id' => $order['order_id'], 'order_status' => 8))){
            $this->msgbox->add(L('已经打赏过了！'), 221);
        }else{
            if($code == 'money'){
                if(!$trade = K::M('trade/payment')->reward($code, $order, $amount, 'APP')){
                    $this->msgbox->add('余额支付失败！', 216);
                }else{
                    // 追加或小费支付成功 jh_paotui_order_reward 插入一条记录
                    $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                    K::M('trade/payment')->payed_reward($log, $trade);
                }
            }else{
                if(defined('IN_WEIXIN') && $code == 'wxpay'){
                    $this->_init_wxopenid();
                    $order['wx_openid'] = $this->wx_openid;
                }
                if($url = K::M('trade/payment')->order($code, $order)){
                    if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                        $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'order_id' => $order['order_id']));
                        header("Location:{$qrurl}");
                    }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                        $this->pagedata['payurl'] = $url;
                        $this->tmpl = 'trade/payment/wxalipay.html';
                    }else if($code == 'paypal'){
                        $this->pagedata['paypal_form_html'] = $url;
                        $this->tmpl = 'trade/payment/paypal.html';
                    }else{
                        header("Location:{$url}");
                    }
                }
            }
        }
    }

    public function paotui($code = null, $paotui_id = null, $from = null)
    {

        $this->check_login();
        if(!($paotui_id = (int) $paotui_id) && !($paotui_id = (int) $this->GP('paotui_id'))){
            $this->error(404);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->error(404);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('您的订单不存在或已被删除'), 211);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 211);
        }else if($paotui['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消不可支付'), 212);
        }else if($paotui['order_status'] == 8){
            $this->msgbox->add(L('订单已经完成不可支付'), 212);
        }else if($paotui['pay_status'] == 1){
            $this->msgbox->add(L('该订单已经支付过了,不需要重复支付'), 213);
        }else if((float) ($paotui['paotui_amount'] + $paotui['danbao_amount']) == 0){
            $this->msgbox->add(L('订单无需在线支付'), 215);
        }else{
            $amount = $paotui['paotui_amount'] + $paotui['danbao_amount'];
            if($code == 'money'){
                if($paotui['order_status'] == 5){ //二次支付
                    $amount = $chajia = $paotui['jiesuan_amount'] - $paotui['danbao_amount'];
                    $staff_amount = $paotui['jiesuan_amount'] + $paotui['paotui_amount'];
                    if($amount >= 0){
                        if($this->MEMBER['money'] < $amount){
                            $this->msgbox->add(L('账户余额不足'), 555);
                        }else if(K::M('member/member')->update_money($this->uid, -$amount, sprintf(L('支付订单(ID:%s)'), $order_id))){
                            $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                            if($res = K::M('paotui/paotui')->update($paotui['paotui_id'], array('order_status' => 8, 'pay_status' => 1, 'pay_time' => __TIME, 'pay_code' => 'money'))){
                                K::M('payment/log')->update($paylog['log_id'], array('payment' => 'money', 'payedip' => __IP, 'payedtime' => __TIME));
                                K::M('staff/staff')->update_money($paotui['staff_id'], $staff_amount, sprintf(L('订单补价结算(ID:%s)'), $paotui['paotui_id']));
                                $this->msgbox->add(L('订单补差价支付成功'));
                                $this->msgbox->set_data('forward', $this->mklink('paotui:detail', array($paotui['paotui_id'])));
                            }
                        }
                    }else{
                        K::M('member/member')->update_money($this->uid, $amount, sprintf(L('退回托管差额(ID:%s)'), $order_id));
                        K::M('staff/staff')->update_money($paotui['staff_id'], $staff_amount, sprintf(L('订单补价结算(ID:%s)'), $paotui['paotui_id']));
                        $this->msgbox->set_data('forward', $this->mklink('paotui:detail', array($paotui['paotui_id'])));
                    }
                }else{
                    //正常余额支付
                    if($this->MEMBER['money'] < $amount){
                        $this->msgbox->add(L('账户余额不足'), 555);
                    }else if(K::M('member/member')->update_money($this->uid, -$amount, sprintf(L('支付订单(ID:%s)'), $order_id))){
                        $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                        if($res = K::M('paotui/paotui')->update($paotui['paotui_id'], array('pay_status' => 1, 'pay_time' => __TIME, 'pay_code' => 'money'))){
                            if($this->MEMBER['wx_openid']){
                                //获取模版消息配置
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title' => L('恭喜您！订单支付成功！订单完成！'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => '订单支付成功'), 'remark' => sprintf(L('恭喜,您的订单于%s支付成功，订单交易完成！'), date('Y-m-d H:i:s', time())));
                                $url = K::M('helper/link')->mklink('paotui:detail', array($paotui['paotui_id']), array(), 'www');
                                K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_order_status'], $url, $a);
                                $b = array('title' => sprintf(L('编号：#%s订单支付成功！余额减少%s'), $order['order_id'], $amount), 'items' => array('keyword1' => L('普通会员'), 'keyword2' => L('订单支付'), 'keyword3' => sprintf(L('余额减少%s'), $oprice), 'keyword4' => $oprice, 'keyword5' => $money), 'remark' => sprintf(L('恭喜,您的账户于%s支付订单成功！'), date('Y-m-d H:i:s', time())));
                                K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_member_money'], $url, $b);
                            }
                            $this->msgbox->add(L('订单支付成功'));
                            $this->msgbox->set_data('forward', $this->mklink('paotui:detail', array($paotui['paotui_id'])));
                        }
                    }
                }
            }else{
                if(defined('IN_WEIXIN') && $code == 'wxpay'){
                    $this->_init_wxopenid();
                    $order['wx_openid'] = $this->wx_openid;
                }
                if($url = K::M('trade/payment')->paotui($code, $paotui)){
                    if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                        $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'paotui_id' => $paotui['paotui_id']));
                        header("Location:{$qrurl}");
                    }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                        $this->pagedata['payurl'] = $url;
                        $this->tmpl = 'trade/payment/wxalipay.html';
                    }else if($code == 'paypal'){
                        $this->pagedata['paypal_form_html'] = $url;
                        $this->tmpl = 'trade/payment/paypal.html';
                    }else{
                        header("Location:{$url}");
                    }
                }
            }
        }
    }
 
    public function money($code = null, $amount = null, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        $code = $this->GP('code');
        $amount = (int)$this->GP('amount');

        if(!$code){
            $this->msgbox->add(L('请选择支付方式'), 212);
        }else if(!isset($amount)){
            $this->msgbox->add(L('付款金额不合法'), 211);
        }else if($this->check_login()){
            if(defined('IN_WEIXIN') && $code == 'wxpay'){
                $this->_init_wxopenid();
                $order['wx_openid'] = $this->wx_openid;
            }
            if($ret = K::M('trade/payment')->money($this->uid, $code, $amount)){
                $url = $ret['url'];
                $trade_no = $ret['trade_no'];
                if(!defined('IN_WEIXIN') && strpos($url, 'wxpay')){
                    $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'order_no' => $trade_no));
                    header("Location:{$qrurl}");
                }else if(defined('IN_WEIXIN') && ($code == 'alipay')){ //解决支付宝在微信内支付给屏蔽的问题
                    $this->pagedata['payurl'] = $url;
                    $this->tmpl = 'trade/payment/wxalipay.html';
                }else if($code == 'paypal'){
                    $this->pagedata['paypal_form_html'] = $url;
                    $this->tmpl = 'trade/payment/paypal.html';
                }else{
                    header("Location:{$url}");
                }
            }
        }
    }

    public function get_payed($from = null, $order_id = null)
    {
        $from = $this->GP('from');
        $order_id = $this->GP('order_id');
        if(!$from || !$order_id){
            $this->ajaxReturn(array('status' => 'error'));
        }else if($from != 'order' && $from != 'money'){
            $this->ajaxReturn(array('status' => 'error'));
        }

        $uid = $this->MEMBER['uid'];
        $r = K::M('payment/log')->find(array('uid' => $uid, 'payment' => 'wxpay', 'from' => $from, 'trade_no' => $order_id), array('log_id' => 'desc'));

        if($r){
            if($r['payed'] == 1){
                $this->ajaxReturn(array('status' => 'success', 'payed' => 1));
            }else{
                $this->ajaxReturn(array('status' => 'error'));
            }
        }else{
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

    public function wxqrcode()
    {
        if(!$codeurl = $this->GP('codeurl')){
            exit('params error');
        }
        if(!$amount = $this->GP('amount')){
            exit('params error');
        }
        if(!$order_no = $this->GP('order_no')){
            exit('params error');
        }
        $amount = sprintf("%.2f", $amount);
        $this->pagedata['codeurl'] = $codeurl;
        $this->pagedata['amount'] = $amount;
        $this->pagedata['order_id'] = $order_id;
        $this->tmpl = 'trade/payment/wxqrcode.html';
    }

    public function redirect($trade_no, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        $url = K::M('helper/link')->mklink('ucenter/money:index', null, null, 'www');
        if($log = K::M('payment/log')->log_by_no($trade_no)){
            if($log['from'] == 'order'){
                $url = K::M('helper/link')->mklink('waimai/order:detail', array($log['order_id']), array(), 'www');
            }
        }
        if(defined('IN_APP')){
            $this->pagedata['redirect_url'] = $url;
            $this->pagedata['paymentlog'] = $log;
            $this->tmpl = 'trade/payment/redirect.html';
        }else{
            header("Location:{$url}");
            exit;
        }
    }

}
