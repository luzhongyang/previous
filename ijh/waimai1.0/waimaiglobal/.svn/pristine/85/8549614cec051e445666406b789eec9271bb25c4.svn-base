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
        if(!($order_id = (int)$params['order_id'])){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已取消不可支付'), 214);
        }else if(!$order['online_pay']){
            $this->msgbox->add(L('货到付款订单不可支付'), 215);
        }else if($order['pay_status'] == 1){
            $this->msgbox->add(L('该订单已经支付过了'), 216);
        }else if($order['amount'] <= 0){
            $this->msgbox->add(L('该订单不需要支付'), 217);
        }else if(!$code = $params['code']){
            $this->msgbox->add(L('未指定支付方式'), 221);
        }else if($code == 'money' && $this->MEMBER['money'] < $order['amount']){
            $this->msgbox->add(L('余额不足，请更换支付方式'), 221);
        }else if(!$data = K::M('trade/payment')->order($code, $order, 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 223);
        }else{
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR.'default/trade/payment/paypal.html';
                $data['html'] = $this->output(true);
                $this->tmpl = null;
            }         
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }
    }

    public function paotui($params)
    {
        $this->check_login();
        if(!($paotui_id = (int)$params['paotui_id'])){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($paotui['order_status'] < 0){
            $this->msgbox->add(L('订单已取消不可支付'), 214);
        }else if($paotui['pay_status'] == 1){
            $this->msgbox->add(L('该订单已经支付过了'), 216);
        }else if($paotui['paotui_amount']+$paotui['danbao_amount'] <= 0){
            $this->msgbox->add(L('该订单不需要支付'), 217);
        }else if(!$code = $params['code']){
            $this->msgbox->add(L('未指定支付方式'), 221);
        }else if($code == 'money' && $this->MEMBER['money'] < $paotui['paotui_amount']+$paotui['danbao_amount']){
            $this->msgbox->add(L('余额不足，请更换支付方式'), 221);
        }else if(!$data = K::M('trade/payment')->paotui($code, $paotui['paotui_id'], 'APP')){
            $this->msgbox->add(L('创建支付请求失败'), 223);
        }else{
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR.'default/trade/payment/paypal.html';
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
        }else if(!$amount = $params['amount']){
            $this->msgbox->add(L('未选择充值金额'), 212);
        }else if($data = K::M('trade/payment')->money($this->uid, $code, $amount, 'APP')){
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }else{
            if($code == 'paypal'){
                $this->pagedata['paypal_form_html'] = $data['html'];
                $this->tmpl = __TPL_DIR.'default/trade/payment/paypal.html';
                $data['html'] = $this->output(true);
                $this->tmpl = null;
            }          
            $this->msgbox->add(L('创建支付请求失败'), 213);
        }
    }

    public function payment_return($params)
    {
        $this->check_login();
        if(!$code && !($code = $params['code'])){
            $this->msgbox->add(L('未指定支付方式'), 211);
        }else if(!$return_data =$params['return_data']){
            $this->msgbox->add(L('支付返回参数不正确'), 212);
        }else if($obj = K::M('trade/payment')->loadPayment($code)){
            $_GET = array_merge($_GET, json_decode($return_data, true));
            if($trade = $obj->return_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add(L('支付的订单不存在'), 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'order'){ //订单支付
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('trade/order')->detail_by_no($trade['trade_no']);
                        $this->msgbox->add('success');//订单支付成功                      
                        $forward = $this->mklink('mobile/order:detail', array($trade['trade_no']));
                    }else if($log['from'] == 'money'){ //余额充值
                        K::M('trade/payment')->payed_money($log, $trade);
                        $this->msgbox->add('success');//充值余额成功
                    }
                }else{
                    if($log['from'] == 'order'){
                        $this->msgbox->add(L('该订单已经支付过了'), 213);
                    }else if($log['from'] == 'money'){
                        $this->msgbox->add(L('已经充值成功，请不要重复提交'), 214);
                    }
                }
            }else{
                $this->msgbox->add(L('支付验证签名失败'), 215);
            }
        }        
    }

    public function package($params)
    {
        $data = array();
        if($package = K::M('member/money')->package()){
            foreach($package as $k=>$v){
                $data[] = array('chong'=>$k, 'song'=>$v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>$data));
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
        }else if(md5($passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add(L('支付密码不正确'), 212);
        }else if(!$log = K::M('payment/log')->log_by_no($trade_no)){
            $this->msgbox->add(L('支付订单不存在'), 213);
        }else {
            if($log['from'] == 'order') {
                if(!$order = K::M('order/order')->detail($log['order_id'])){
                    $this->msgbox->add(sprintf(L('订单不存在或已被删除%s'), $trand_no), 214);
                }else if($this->uid != $order['uid']){
                    $this->msgbox->add(L('非法操作'), 215);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add(L('订单已取消不可支付'), 216);
                }else if($order['pay_status']){
                    $this->msgbox->add(L('该订单已经支付过了'), 217);
                }else if($order['order_status']==8){
                    $this->msgbox->add(L('该订单已经完成'), 218);
                }else if($this->MEMBER['money'] <= $order['amount']){
                    $this->msgbox->add(L('余额不足，请更换支付方式'), 219);
                }else{
                    $up_data = array('pay_status'=>1,'pay_time'=> __TIME,'pay_ip'=>__IP,  'pay_code'=>'money','order_status'=>0,'lasttime'=>time());
                    $up = K::M('order/order')->update($order['order_id'],$up_data); 
                    $trade = array('trade_no'=>$trade_no, 'pay_trade_no'=>$trade_no, 'order_id'=>$log['order_id'], 'amount'=>$log['amount'], 'code'=>'money');
                    if(K::M('member/member')->update_money($this->uid, -$order['amount'], sprintf(L('余额支付订单(ID:%s)'), $order['order_id']))){
                        $this->MEMBER['money'] = $this->MEMBER['money'] - $order['amount'];     
                        K::M('order/log')->create(array('order_id'=>$order['order_id'],'from'=>'member','log'=>L('订单使用余额支付成功'),'type'=>2));
                        K::M('payment/log')->set_payed($trade_no);
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->msgbox->set_data('data',$trade);   
                    }
                }
            }else if($log['from'] == 'paotui'){
                if(!$paotui = K::M('paotui/paotui')->detail($log['order_id'])){
                    $this->msgbox->add(sprintf(L('订单不存在或已被删除%s'), $trand_no), 214);
                }else if($this->uid != $paotui['uid']){
                    $this->msgbox->add(L('非法操作'), 215);
                }else if($paotui['order_status'] < 0){
                    $this->msgbox->add(L('订单已取消不可支付'), 216);
                }else if($paotui['pay_status']){
                    $this->msgbox->add(L('该订单已经支付过了'), 217);
                }else if($paotui['order_status']==8){
                    $this->msgbox->add(L('该订单已经完成'), 218);
                }else if($this->MEMBER['money'] <= ($paotui['paotui_amount']+$paotui['danbao_amount'])){
                    $this->msgbox->add(L('余额不足，请更换支付方式'), 219);
                }else{
                    // 补价支付
                    $up_data1 = array('pay_status'=>1,'pay_time'=> __TIME,'pay_ip'=>__IP,  'pay_code'=>'money','order_status'=>8);
                    if($paotui['order_status'] == 5 && $paotui['pay_status'] == 0) {
                        $chajia = $paotui['jiesuan_amount'] - $paotui['danbao_amount']; 
                        if($chajia > 0 && $chajia == $log['amount']) {
                            $up = K::M('paotui/paotui')->update($paotui['paotui_id'],$up_data1); 
                            $trade = array('trade_no'=>$trade_no, 'pay_trade_no'=>$trade_no, 'paotui_id'=>$log['order_id'], 'amount'=>$log['amount'], 'code'=>'money');
                            if($this->MEMBER['money'] < $chajia){
                                $this->msgbox->add(L('账户余额不足'),555);
                            }else if(K::M('member/member')->update_money($this->uid, -$chajia, sprintf(L('余额支付订单(ID:%s)'), $paotui['paotui_id']))) {
                                $this->MEMBER['money'] = $this->MEMBER['money'] - $chajia;    
                                K::M('paotui/log')->create(array('paotui_id'=>$paotui['paotui_id'],'from'=>'member','log'=>L('订单补差价支付成功'),'type'=>2));
                                K::M('payment/log')->update($log['log_id'],array('payment'=>'money','payedip'=>__IP,'payedtime'=>__TIME));       
                                K::M('trade/payment')->payed_paotui($log, $trade);
                                //配送员获得第二次补价支付的金额
                                K::M('staff/staff')->update_money($paotui['staff_id'], $chajia, sprintf(L('订单补差价结算(ID:%s)'), $paotui['paotui_id']));
                                $this->msgbox->set_data('data',$trade);   
                            }
                        }else {
                            $this->msgbox->add(L('差价金额不正确'),220);
                        } 
                    }else {
                        // 正常支付
                        $up_data2 = array('pay_status'=>1,'pay_time'=> __TIME,'pay_ip'=>__IP,  'pay_code'=>'money','order_status'=>0);
                        $up = K::M('paotui/paotui')->update($paotui['paotui_id'],$up_data2);  
                        $trade = array('trade_no'=>$trade_no, 'pay_trade_no'=>$trade_no, 'paotui_id'=>$log['order_id'], 'amount'=>$log['amount'], 'code'=>'money');
                        if(K::M('member/member')->update_money($this->uid, -($paotui['paotui_amount']+$paotui['danbao_amount']), sprintf(L('余额支付订单(ID:%s)'), $paotui['paotui_id']))){
                            $this->MEMBER['money'] = $this->MEMBER['money'] - ($paotui['paotui_amount']+$paotui['danbao_amount']);    
                            K::M('paotui/log')->create(array('paotui_id'=>$paotui['paotui_id'],'from'=>'member','log'=>L('订单使用余额支付成功'),'type'=>2));
                            K::M('payment/log')->set_payed($trade_no);
                            K::M('trade/payment')->payed_paotui($log, $trade);
                            $this->msgbox->set_data('data',$trade);   
                        }
                    }   
                }
            }  
        } 
    }
}
