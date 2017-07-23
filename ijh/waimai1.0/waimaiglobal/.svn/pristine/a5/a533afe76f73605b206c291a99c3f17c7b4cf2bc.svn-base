<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: payment.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Trade_Payment extends Model
{

    public function order($code, $order, $from=false)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if(!$log = K::M('payment/log')->log_by_order_id($order['order_id'])){
            $log = array('uid'=>$order['uid'], 'from'=>'order', 'order_id'=>$order['order_id'], 'trade_no'=>$order['order_id'], 'payment'=>$code, 'amount'=>$order['amount']); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }
        if($log['payed'] == 1){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $order['amount']){
            $a['amount'] = $order['amount'];
        }
        if($log['from'] != 'order'){
            $a['from'] = 'order';
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $order['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $order['addr'].'('.$order['contact'].','.$order['mobile'].')';
        // 欧元 = 人民币 * 汇率
        if($ex_rate = K::M('payment/payment')->payment($code)) {
            $order['amount'] = (float)$order['amount'] * (float)$ex_rate['config']['ex_rate'] ;
        }
        $params['amount'] = $order['amount'];
        $params['contact'] = $order['contact'];
        $params['mobile'] = $order['mobile'];
        $params['addr'] = $order['addr'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            return $oPayApi->build_url($params);
        }
    }

    public function payed_order($log, $trade)
    {
        if($log['order_id']){
            if(K::M('order/order')->set_payed($log['order_id'], $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }

    public function paotui($code, $paotui_id, $from=false, $level=null)
    {
         //$level 支付次数，
        $paotui = K::M('paotui/paotui')->detail($paotui_id);
        if($paotui['pay_status']){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
        }else if($paotui['order_status']==8){
            $this->msgbox->add(L('该订单已经完成'), 212);
        }else{
            $amount = $paotui['paotui_amount'] + $paotui['danbao_amount'];
            if($paotui['order_status'] == 5){ //二次支付
                $level = ($level === null) ? 1 : 0;
                $amount = $paotui['jiesuan_amount'] - $paotui['danbao_amount'];
            }
        }
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $level = (int)$level;
        if(!$log = K::M('payment/log')->log_by_paotui_id($paotui['paotui_id'], $level)){
            $log = array('uid'=>$paotui['uid'], 'from'=>'paotui', 'order_id'=>$paotui['paotui_id'], 'pay_level'=>$level, 'trade_no'=>$paotui['paotui_id'], 'payment'=>$code, 'amount'=>$amount); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }
        if($log['payed']){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $amount){
            $a['amount'] = $amount;
        }
        if($log['from'] != 'paotui'){
            $a['from'] = 'paotui';
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $order['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $order['addr'].'('.$order['contact'].','.$order['mobile'].')';
        // 欧元 = 人民币 * 汇率
        if($ex_rate = K::M('payment/payment')->payment($code)) {
            $order['amount'] = (float)$order['amount'] * (float)$ex_rate['config']['ex_rate'] ;
        }
        $params['amount'] = $order['amount'];
        $params['contact'] = $order['contact'];
        $params['mobile'] = $order['mobile'];
        $params['addr'] = $order['addr'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            return $oPayApi->build_url($params);
        }

    }

    public function payed_paotui($log, $trade)
    {
        if($log['order_id']){
            if(K::M('paotui/paotui')->set_payed($log['order_id'], $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }
    
    public function money($uid, $code, $amount, $from=false)
    {
        if(!$uid = (int)$uid){
            return false;
        }else if(!$member = K::M('member/member')->detail($uid)){
            return false;
        }else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $log = array('uid'=>$uid,'amount'=>$amount,'payment'=>$code,'from'=>'money');
        if(!$log_id = K::M('payment/log')->create($log, true)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);
        $site = K::$system->config->get('site');
        $params = array();
        $params['title'] = sprintf(L('%s-充值余额'), $site['title']);
        $params['body'] = sprintf(L('会员:%s(%s)'), $member['nickname'], $uid);
        // 欧元 = 人民币 * 汇率
        if($ex_rate = K::M('payment/payment')->payment($code)) {
            $amount = (int)$amount * (float)$ex_rate['config']['ex_rate'] ;
        }
        $params['amount'] = $amount;
        $params['trade_no'] = $log['trade_no'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else{
            //return $oPayApi->build_url($params);
            return array('url'=>$oPayApi->build_url($params),'trade_no'=>$log['trade_no']);
        }
    }

    public function payed_money($log, $trade)
    {
        $package = K::M('member/money')->package();
        if($smoney = $package[$log['amount']]){
            $money = (float)$log['amount'] + (float)$smoney;
            $intro = sprintf(L('在线充值￥%s,送￥%s'), $log['amount'], $smoney);
        }else{
            $money = (float)$log['amount'];
            $intro = sprintf(L('在线充值￥%s'), $log['amount']);
        }
        return K::M('member/money')->update($log['uid'], $money, $intro);
    }

    public function loadPayment($code)
    {

        static $_PayApiObj = array();
        if(!is_object($_PayApiObj[$code])){
            $file = __CFG::DIR."plugins/payments/{$code}/{$code}.php";
            if(!file_exists($file)){
                $this->msgbox->add(L('您选择的支付接口不存在'), 311);
                return false;
            }else if(!$payment = K::M('payment/payment')->payment($code)){
                $this->msgbox->add(L('您选择的支付接口不存在'), 312);
                return false;
            }else if(empty($payment['status'])){
                $this->msgbox->add(L('您选择的支付接口不可用'), 313);
                return false;
            }
            if (defined('IN_WEIXIN') && $code == 'wxpay') {
                $file = __CFG::DIR."plugins/payments/{$code}/jsapi.php";
                include($file);
                $clsName = "Weixin_".ucfirst('jsapi');
            }else{
                include($file);
                $clsName = "Payment_".ucfirst($code);
            }
            $config = $payment['config'];
            $site = K::$system->config->get('site');
            if(/*$code == 'wxpay' && */defined('IN_APP')){
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
            }else{
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
            }
            $config['show_url'] = $site['siteurl'];
            $_PayApiObj[$code] = new $clsName($config);
        }
        return $_PayApiObj[$code];
    }
}
