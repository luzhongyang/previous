<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Payment extends Ctl
{

    public function order($params)
    {
        $this->check_login();
        if(!($order_id = (int) $params['order_id'])){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已取消不可支付'), 214);
        }
        else if($order['from'] == 'waimai' && !$order['online_pay']){
            $this->msgbox->add(L('货到付款订单不可支付'), 215);
        }
        else if($order['pay_status'] == 1){
            $this->msgbox->add(L('该订单已经支付过了'), 216);
        }
        else if($order['amount'] <= 0){
            $this->msgbox->add(L('该订单不需要支付'), 217);
        }
        else if(!$code = $params['code']){
            $this->msgbox->add(L('未指定支付方式'), 218);
        }
        else if($code == 'money' && $this->MEMBER['money'] < $order['amount']){
            $this->msgbox->add(L('余额不足，请更换支付方式'), 219);
        }
        else if($order['from'] == 'waimai' && !$data = K::M('trade/payment')->order($code, $order, 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 220);
        }
        else if($order['from'] == 'paotui' && !$data = K::M('trade/payment')->paotui($code, $order, 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 221);
        }
        else if($order['from'] == 'mall' && !$data = K::M('trade/payment')->mall($code, $order, 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 222);
        }
        else if($order['from'] == 'pintuan' && !$data = K::M('trade/payment')->pintuan($code, $order, 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 223);
        }
        else{
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR . 'default/trade/payment/paypal.html';
                $data['html'] = $this->output(true);
                $this->tmpl = null;
            }
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }
    }

    public function addreward($params)
    {
        $this->check_login();
        if(!($order_id = (int) $params['order_id'])){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if(!in_array($order['order_status'], array(0, 8))){
            $this->msgbox->add(L('该订单不可以追加小费或打赏' . $order['order_id']), 214);
        }
        else if(!$code = $params['code']){
            $this->msgbox->add(L('未指定支付方式'), 221);
        }
        else if($code == 'money' && $this->MEMBER['money'] < $params['amount']){
            $this->msgbox->add(L('余额不足，请更换支付方式'), 221);
        }
        else if($r = K::M('paotui/reward')->find(array('type' => 1, 'order_id' => $order['order_id'], 'order_status' => 8))){
            $this->msgbox->add(L('已经打赏过了！'), 221);
        }
        else if(!$data = K::M('trade/payment')->reward($code, $order, $params['amount'], 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 223);
        }
        else{
            K::M('system/logs')->log('try', $this->system->db->SQLLOG());
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR . 'default/trade/payment/paypal.html';
                $data['html'] = $this->output(true);
                $this->tmpl = null;
            }
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }
    }

    public function money($params)
    {
        $this->check_login();
        if(!$code = $params['code']){
            $this->msgbox->add(L('未指定支付方式'), 211);
        }
        else if(!$amount = $params['amount']){
            $this->msgbox->add(L('未选择充值金额'), 212);
        }
        else if($data = K::M('trade/payment')->money($this->uid, $code, $amount, 'APP')){
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }
        else{
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR . 'default/trade/payment/paypal.html';
                $data['html'] = $this->output(true);
                $this->tmpl = null;
            }
            $this->msgbox->add(L('创建支付请求失败'), 213);
        }
    }

    public function payment_return($params)
    {
        $this->check_login();
        if(!($code = $params['code'])){
            $this->msgbox->add(L('未指定支付方式'), 211);
        }
        else if(!$return_data = $params['return_data']){
            $this->msgbox->add(L('支付返回参数不正确'), 212);
        }
        else if($obj = K::M('trade/payment')->loadPayment($code)){
            $_GET = array_merge($_GET, json_decode($return_data, true));
            if($trade = $obj->return_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add(L('支付的订单不存在'), 211);
                }
                else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'order' || $log['from'] == 'paotui'){ //订单支付
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('trade/order')->detail_by_no($trade['trade_no']);
                        $this->msgbox->add('success'); //订单支付成功                      
                    }
                    else if($log['from'] == 'reward'){
                        K::M('trade/payment')->payed_reward($log, $trade);
                        $this->pagedata['order'] = K::M('trade/order')->detail_by_no($trade['trade_no']);
                        $this->msgbox->add('success'); //增加小费支付成功                        
                    }
                    else if($log['from'] == 'money'){ //余额充值
                        K::M('trade/payment')->payed_money($log, $trade);
                        $this->msgbox->add('success'); //充值余额成功
                    }
                }
                else{
                    if($log['from'] == 'order'){
                        $this->msgbox->add(L('该订单已经支付过了'), 213);
                    }
                    else if($log['from'] == 'reward'){
                        $this->msgbox->add(L('该笔小费已经支付过'), 214);
                    }
                    else if($log['from'] == 'money'){
                        $this->msgbox->add(L('已经充值成功，请不要重复提交'), 215);
                    }
                }
            }
            else{
                $this->msgbox->add(L('支付验证签名失败'), 215);
            }
        }
    }

    public function package($params)
    {
        $data = array();
        if($package = K::M('member/money')->package()){
            foreach($package as $k => $v){
                $data[] = array('chong' => $k, 'song' => $v);
            }
        }
        $this->msgbox->set_data('data', array('items' => $data));
    }

    /**
     * 余额支付确认
     * trade_no 支付订单号
     * passwd 支付密码同用户登录密码
     */
    public function paymoney($params)
    {
        $this->check_login();
        $passwd = $params['passwd'];
        if(!$trade_no = $params['trade_no']){
            $this->msgbox->add(L('要支付订单号错误'), 211);
        }
        else if(md5($passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add(L('支付密码不正确'), 212);
        }
        else if(!$log = K::M('payment/log')->log_by_no($trade_no)){
            $this->msgbox->add(L('支付订单不存在'), 213);
        }
        else{
            if($log['from'] == 'order' || $log['from'] == 'paotui'){
                if(!$order = K::M('order/order')->detail($log['order_id'])){
                    $this->msgbox->add(sprintf(L('订单不存在或已被删除ww%s'), $trand_no), 214);
                }
                else if($this->uid != $order['uid']){
                    $this->msgbox->add(L('非法操作'), 215);
                }
                else if($order['order_status'] < 0){
                    $this->msgbox->add(L('订单已取消不可支付'), 216);
                }
                else if($order['pay_status']){
                    $this->msgbox->add(L('该订单已经支付过了'), 217);
                }
                else if($order['order_status'] == 8){
                    $this->msgbox->add(L('该订单已经完成'), 218);
                }
                else if($this->MEMBER['money'] < $order['amount']){
                    $this->msgbox->add(L('余额不足，请更换支付方式'), 219);
                }
                else{

                    $trade = array('trade_no' => $trade_no, 'pay_trade_no' => $trade_no, 'order_id' => $log['order_id'], 'amount' => $log['amount'], 'code' => 'money');
                    if(K::M('member/member')->update_money($this->uid, -$log['amount'], '余额支付订单(ID:' . $order['order_id'] . ')')){
                        $this->MEMBER['money'] = $this->MEMBER['money'] - $log['amount'];
                        if(K::M('payment/log')->set_payed($trade_no)){
                            K::M('trade/payment')->payed_order($log, $trade);
                            $this->msgbox->set_data('data', $trade);
                        }
                        else{
                            $this->msgbox->add('订单支付失败', 218);
                        }
                    }
                }
            }
        }
    }

    /**
     * 小费追加,余额支付确认
     * trade_no 支付订单号
     * passwd 支付密码同用户登录密码
     */
    public function reward_paymoney($params)
    {
        $this->check_login();
        $passwd = $params['passwd'];
        if(!$trade_no = $params['trade_no']){
            $this->msgbox->add(L('要支付订单号错误'), 211);
        }
        else if(md5($passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add(L('支付密码不正确'), 212);
        }
        else if(!$log = K::M('payment/log')->log_by_no($trade_no)){
            $this->msgbox->add(L('支付订单不存在'), 213);
        }
        else{

            if(!$paotui = K::M('order/order')->detail($log['order_id'])){
                $this->msgbox->add(sprintf(L('订单不存在或已被删除%s'), $trand_no), 214);
            }
            else if($this->uid != $paotui['uid']){
                $this->msgbox->add(L('非法操作'), 215);
            }
            else if(!in_array($paotui['order_status'], array(0, 8))){
                $this->msgbox->add(L('订单不可追加小费或打赏！'), 216);
            }
            else if($this->MEMBER['money'] <= $log['amount']){
                $this->msgbox->add(L('余额不足，请更换支付方式'), 219);
            }
            else if($over = K::M('paotui/reward')->find(array('type' => 1, 'order_id' => $paotui['order_id'], 'order_status' => 8))){
                $this->msgbox->add(L('该单已经打赏过了！'), 220);
            }
            else{

                $trade = array('trade_no' => $trade_no, 'pay_trade_no' => $trade_no, 'paotui_id' => $log['order_id'], 'amount' => $log['amount'], 'code' => 'money');
                if($paotui['order_status'] == 8){
                    $money_name = '打赏';
                }
                else{
                    $money_name = '小费';
                }
                $do = K::M('member/member')->update_money($this->uid, -($log['amount']), sprintf(L('追加' . $money_name . '订单(ID:%s)'), $paotui['order_id']));
                if($do){
                    $this->MEMBER['money'] = $this->MEMBER['money'] - ($paotui['paotui_amount'] + $paotui['danbao_amount']);
                    K::M('payment/log')->set_payed($trade_no);
                    K::M('trade/payment')->payed_reward($log, $trade);
                    $this->msgbox->set_data('data', $trade);
                }
            }
        }
    }

}
