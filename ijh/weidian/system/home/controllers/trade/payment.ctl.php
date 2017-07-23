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
                    $this->msgbox->add('支付的订单不存在', 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'money'){ //余额充值
                        K::M('trade/payment')->payed_money($log, $trade);
                        $this->msgbox->add('充值余额成功');
                    }else if($log['from'] == 'coin'){
                        K::M('trade/payment')->payed_coin($log, $trade);
                        $this->msgbox->add('充值成功');
                    }else if('yzbill' == $log['from']){
                        K::M('trade/payment')->payed_yzbill($log, $trade);
                        $this->msgbox->add('余额缴费成功');
                    }else if($log['from'] == 'cloud'){
                        K::M('trade/payment')->payed_cloud($log, $trade);
                        $this->msgbox->add('云购支付成功');
                    }else{ //订单支付
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('order/order')->detail($log['order_id']);
                        $this->msgbox->add('支付订单成功');
                        $forward = $this->mklink('ucenter/order:detail', array($log['order_id']));
                    }
                }else{
                    if($log['from'] == 'money'){
                        $this->msgbox->add('已经充值成功，请不要重复提交', 214);
                    }else if($log['from'] == 'coin'){
                        K::M('trade/payment')->payed_coin($log, $trade);
                        $this->msgbox->add('已经充值成功，请不要重复提交');
                    }else if('yzbill' == $log['from']){
                        K::M('trade/payment')->payed_yzbill($log, $trade);
                        $this->msgbox->add('已经缴费成功，请不要重复提交');
                    }else if($log['from'] == 'cloud'){
                        K::M('trade/payment')->payed_cloud($log, $trade);
                        $this->msgbox->add('已经支付成功，请不要重复提交');
                    }else{
                        $this->msgbox->add('该订单已经支付过了', 213);
                    }
                }
            }else{
                $this->msgbox->add('支付验证签名失败', 215);
            }
            if(defined('IN_WEIXIN') && $code == 'alipay'){
                $this->msgbox->set_js('window.top.location.href="' . $forward . '";');
            }else{
                $this->msgbox->set_data('forward', $forward);
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
                    $this->msgbox->add('支付的订单不存在', 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'money'){ //金币充值
                        if(K::M('trade/payment')->payed_money($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'coin'){
                        if(K::M('trade/payment')->payed_coin($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'cloud'){
                        if(K::M('trade/payment')->payed_cloud($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'yzbill'){
                        if(K::M('trade/payment')->payed_yzbill($log, $trade)){
                            $success = true;
                        }
                    }else if($log['from'] == 'cashier'){
                        if(K::M('trade/payment')->payed_cashier($log, $trade, $code)){
                            $success = true;
                        }
                    }else{
                        if(K::M('trade/payment')->payed_order($log, $trade)){
                            $success = true;
                        }
                    }
                }
            }
            $obj->notify_success($success);
        }
    }

    public function order($code = null, $order_id = null)
    {
        $this->check_login();
        if(!($order_id = (int) $order_id) && !($order_id = (int) $this->GP('order_id'))){
            $this->error(404);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->error(404);
        }else if($order = K::M('order/order')->detail($order_id)){
            //阶梯团,重制支付状态
            if($order['from'] == 'weidian') {
                K::M('weidian/pintuan/order')->pay_status_reset($order);
            }

            if($order['order_status'] < 0){
                $this->msgbox->add('订单已经取消不可支付', 212);
            }else if($order['order_status'] == 8){
                $this->msgbox->add('订单已经完成不可支付', 212);
            }else if($order['pay_status'] == 1){
                $this->msgbox->add(L('该订单已经支付过了,不需要重复支付'), 213);
            }else if((float) $order['amount'] == 0){
                $this->msgbox->add('订单无需在线支付', 215);
            }else{
                if($code == 'money'){//使用余额支付
                    if(!$trade = K::M('trade/payment')->order('money', $order)){
                        $this->msgbox->add('余额支付失败！', 216);
                    }else if($this->MEMBER['money'] < $trade['amount']){
                        $this->msgbox->add('账户余额不足！', 217);
                    }else if(K::M('member/member')->update_money($this->uid, -$trade['amount'], '支付订单(ID:' . $order_id . ')')){
                        $amount = $trade['amount'];
                        $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                        $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                        if($log['payed']){
                            $this->msgbox->add('单号已经支付过了', 218);
                        }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                            if($res = K::M('trade/payment')->payed_order($log, $trade)){
                                if($this->MEMBER['wx_openid']){
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title' => '恭喜您！订单支付成功！！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '订单支付成功'), 'remark' => '您的订单于 ' . date('Y-m-d H:i:s', __TIME) . ' 支付成功');
                                    $url = K::M('helper/link')->mklink('ucenter/order:detail', array('args' => $order_id), array(), 'www');
                                    //K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);
                                }
                                $this->msgbox->add('订单支付成功');
                            }
                        }
                    }
                }else{
                    if($url = K::M('trade/payment')->order($code, $order)){
                        if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                            $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $order['amount'], 'order_id' => $order['order_id']));
                            header("Location:{$qrurl}");
                        }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                            $this->pagedata['payurl'] = $url;
                            $this->tmpl = 'trade/payment/wxalipay.html';
                        }else{
                            header("Location:{$url}");
                        }
                    }
                }
            }
            //set auto location url
            $this->url_auto_location($order,$order_id);
        }
    }

    //set weidian auto location url
    public function url_auto_location($order,$order_id)
    {
        if($order['from'] == 'weidian'){
            $weidian = K::M('weidian/weidian')->detail($order['shop_id']);
            $detail = K::M('weidian/order')->detail($order_id);
            $url = K::M('fenxiao/fenxiao')->get_url($detail['sid']);
            $group = K::M('weidian/pintuan/group')->find(array('order_id'=>$order_id),array('group_id'=>'desc'));
            if($detail['type'] == 'default'){
                $link = $this->mklink('ucenter/order:detail', array($order_id), null, $weidian['url']);
	    }elseif($detail['type'] == 'fenxiao'){
                $link = $this->mklink('ucenter/order:detail', array($order_id), null, $url);
            }else{
                $link = $this->mklink('pintuan:open_detail', array($group['group_id']), null, $weidian['url']);
            }
        }else{
            //other type order
            $link = $this->mklink('ucenter/order:detail', array($order_id));
        }
        $this->msgbox->set_data("forward", $link);
    }

    public function money($code = null, $amount = null)
    {
        $code = $this->GP('code');
        $amount = $this->GP('amount');
        if(!$code){
            $this->msgbox->add('没有选择支付方式', 212);
        }else if(empty($amount)){
            $this->msgbox->add('付款金额不合法', 211);
        }else if($this->check_login()){
            if($ret = K::M('trade/payment')->money($this->uid, $code, $amount)){
                $url = $ret['url'];
                $trade_no = $ret['trade_no'];
                if(!defined('IN_WEIXIN') && strpos($url, 'wxpay')){
                    $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'order_no' => $trade_no));
                    header("Location:{$qrurl}");
                }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                    $this->pagedata['payurl'] = $url;
                    $this->tmpl = 'trade/payment/wxalipay.html';
                }else{
                    header("Location:{$url}");
                }
            }
        }
    }
    
    
    public function coin($code = null, $amount = null)
    { //夺宝币充值
        $code = $this->GP('code');
        $amount = $this->GP('amount');
        if(!$code){
            $this->msgbox->add('没有选择支付方式', 212);
        }else if(empty($amount)){
            $this->msgbox->add('充值金额不合法', 211);
        }else if($this->check_login()){
            if($code == "money"){
                if($this->MEMBER['money'] < $amount){
                    $this->msgbox->add('账户余额不足！', 217);
                }else if(K::M('member/member')->update_money($this->uid, -$amount, "在线充值{$amount}夺宝币")){
                    $package = K::M('member/member')->getRecharge();
                    if($smoney = $package[$amount]){
                        $money = (float)$amount + (float)$smoney;
                        $intro = "在线充值{$amount}夺宝币,送{$smoney}夺宝币";
                    }else{
                        $money = (float)$amount;
                        $intro = "在线充值{$amount}夺宝币";
                    }
                    K::M('member/member')->update_coin($this->uid, $money, $intro);
                     $this->msgbox->add('充值成功！');
                }
            }else{
                if($ret = K::M('trade/payment')->coin($this->uid, $code, $amount)){
                    $url = $ret['url'];
                    $trade_no = $ret['trade_no'];
                    if(!defined('IN_WEIXIN') && strpos($url, 'wxpay')){
                        $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $amount, 'order_no' => $trade_no));
                        header("Location:{$qrurl}");
                    }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                        $this->pagedata['payurl'] = $url;
                        $this->tmpl = 'trade/payment/wxalipay.html';
                    }else{
                        header("Location:{$url}");
                    }
                }
            }
        }
    }

    //业主账单
    public function yzbill($code = null, $bill_id = null)
    {
        if(!($bill_id = (int) $bill_id) && !($bill_id = (int) $this->GP('bill_id'))){
            $this->msgbox->add('账单不存在1', 210);
        }else if(empty($code) && !($code = $this->GP('pay_code'))){
            $this->msgbox->add('账单不存在2', 211);
        }else if(!$bill = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('账单不存在3', 212);
        }else if($bill['uid'] != $this->uid){
            $this->msgbox->add('非法的数据操作', 213);
        }else if($bill['pay_status'] == 1){
            $this->msgbox->add('账单已经支付成功', 216);
        }else if($bill['total_price'] <= 0){
            $this->msgbox->add('账单无需需要支付', 217);
        }else{

            if($code == 'money'){//使用余额支付

               if(!$trade = K::M('trade/payment')->yzbill('money', $bill)){
                    $this->msgbox->add('余额支付失败！', 216);
                }else if($this->MEMBER['money'] < $trade['amount']){
                    $this->msgbox->add('账户余额不足！', 217);
                }else if(K::M('member/member')->update_money($this->uid, -$trade['amount'], '支付订单(ID:' . $bill_id . ')')){
                    $amount = $trade['amount'];
                    $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                    $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                    if($log['payed']){
                        $this->msgbox->add('单号已经支付过了', 218);
                    }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                        if($res = K::M('trade/payment')->payed_yzbill($log, $trade)){
                            if($this->MEMBER['wx_openid']){
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title' => '恭喜您！订单支付成功！！', 'items' => array('OrderSn' => $bill_id, 'OrderStatus' => '订单支付成功'), 'remark' => '您的订单于 ' . date('Y-m-d H:i:s', __TIME) . ' 支付成功');
                                $url = K::M('helper/link')->mklink('xiaoqu/bill', array('args' => $bill_id), array(), 'www');
                                K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['bill_id'], $url, $a);
                            }
                            $this->msgbox->add('订单支付成功');
                            $link = $this->mklink('xiaoqu/bill',array());
                            header("location:{$link}");
                        }
                    }
                }
            }else{
                if($url = K::M('trade/payment')->yzbill($code, $bill, 'weixin')){
                    if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                        $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $bill['amount'], 'order_id' => $bill['bill_id']));
                        header("Location:{$qrurl}");
                    }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                        $this->pagedata['payurl'] = $url;
                        $this->tmpl = 'trade/payment/wxalipay.html';
                    }else{
                        echo ($url);
                        die;
                        header("Location:{$url}");
                    }
                }
            }
        }
    }
    
    
    //云购支付
    public function cloud($code = null, $order_id = null)
    {
        if(!($order_id = (int)$order_id) && !($order_id = (int) $this->GP('order_id'))){
            $this->msgbox->add('该订单不存在', 210);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->msgbox->add('该订单不存在', 211);
        }else if(!$order = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add('该订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法的数据操作', 213);
        }else if($order['order_status'] == 1){
            $this->msgbox->add('订单已经支付成功', 216);
        }else if($order['num'] - $order['use_coin'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }else{
            if($code == 'money'){//使用余额支付
               if(!$trade = K::M('trade/payment')->cloud('money', $order)){
                    $this->msgbox->add('余额支付失败！', 216);
                }else if($this->MEMBER['money'] < $trade['amount']){
                    $this->msgbox->add('账户余额不足！', 217);
                }else if(K::M('member/member')->update_money($this->uid, -$trade['amount'], '支付云购订单(ID:' . $order_id . ')')){
                    $amount = $trade['amount'];
                    $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                    $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;
                    if($log['payed']){
                        $this->msgbox->add('单号已经支付过了', 218);
                    }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                        if($res = K::M('trade/payment')->payed_cloud($log, $trade)){
                            if($this->MEMBER['wx_openid']){
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title' => '恭喜您！云购订单支付成功！！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '云购订单支付成功'), 'remark' => '您的订单于 ' . date('Y-m-d H:i:s', __TIME) . ' 支付成功');
                                $url = K::M('helper/link')->mklink('cloud/ucenter/order', array('args' => $order_id), array(), 'www');
                                //K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['bill_id'], $url, $a);
                            }
                            $this->msgbox->add('订单支付成功');
                            $link = $this->mklink('cloud/ucenter/order/detail',array('args'=>$order_id));
                            header("location:{$link}");
                        }
                    }
                }
            }else{
                if($url = K::M('trade/payment')->cloud($code, $order, 'weixin')){
                    if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                        $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => ($order['num'] - $order['use_coin']), 'order_id' => $order['order_id']));
                        header("Location:{$qrurl}");
                    }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                        $this->pagedata['payurl'] = $url;
                        $this->tmpl = 'trade/payment/wxalipay.html';
                    }else{
                        echo ($url);
                        die;
                        header("Location:{$url}");
                    }
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
        if(!$order_id = $this->GP('order_id')){
            exit('params error');
        }
        $amount = sprintf("%.2f", $amount);
        $this->pagedata['codeurl'] = $codeurl;
        $this->pagedata['amount'] = $amount;
        $this->pagedata['order_id'] = $order_id;
        $this->tmpl = 'trade/payment/wxqrcode.html';
    }

    public function redirect($trade_no)
    {
        $url = K::M('helper/link')->mklink('ucenter/money:index', null, null, 'base');
        if($log = K::M('payment/log')->log_by_no($trade_no)){
            if($log['from'] == 'order'){
                $url = K::M('helper/link')->mklink('ucenter/order:detail', array($log['order_id']), array(), 'base');
            }
        }
        header("Location:{$url}");
        exit;
    }

}
