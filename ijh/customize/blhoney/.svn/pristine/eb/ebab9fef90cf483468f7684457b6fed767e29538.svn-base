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
            $system->request['act'] = $match[1].'_verify';
            $system->request['args'] = array($match[2], $match[4]);
        }
    }

    public function return_verify($code, $from=null)
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
                    }else{ //订单支付
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('order/order')->detail($log['order_id']);
                        $this->msgbox->add('支付订单成功');
                        $forward = $this->mklink('order:detail', array($log['order_id']));
                    }
                }else{
                    if($log['from'] == 'money'){
                        $this->msgbox->add('已经充值成功，请不要重复提交', 214);
                    }else{
                        $this->msgbox->add('该订单已经支付过了', 213);
                    }
                }
            }else{
                $this->msgbox->add('支付验证签名失败', 215);
            }
            if(defined('IN_WEIXIN') && $code == 'alipay'){
                $this->msgbox->set_js('window.top.location.href="'.$forward.'";'); 
            }else{
                $this->msgbox->set_data('forward', $forward); 
            }            
        }
    }

    public function notify_verify($code, $from=null)
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

    public function order($code=null, $order_id=null, $kind=null, $passwd=null)
    {
        if(!($order_id = (int)$order_id) && !($order_id = (int)$this->GP('order_id'))){
            $this->error(404);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->error(404);
        }else if($this->check_login()){
            if($kind == 'ordered') {
                if(!$order = K::M('order/order')->detail($order_id)){
                    $this->msgbox->add('您的订单不存在或已经删除', 211);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add('订单已经取消不可支付', 212);
                }else if($order['order_status'] == 8){
                    $this->msgbox->add('订单已经完成不可支付', 212);
                }else if($order['pay_status'] == 1){
                    $this->msgbox->add('该订单已经支付过了,不需要重复支付', 213);
                }else if((float)$order['amount'] == 0){
                    $this->msgbox->add('订单无需在线支付', 215);
                }else{
                    $amount = $order['amount'];
                    if($code == 'money'){
                        //使用余额支付
                        if($this->MEMBER['money'] < $order['amount']){
                            $this->msgbox->add('账户余额不足！',555);
                        }else {
                            if(md5($passwd) == $this->MEMBER['paypasswd']) {
                                if($this->MEMBER['money'] >= $amount){
                                    K::M('member/member')->update_money($this->uid, -$amount, '预约支付订单(ID:'.$order_id.')');
                                }
                            }else{
                                $this->msgbox->add('支付密码不正确',255)->response();
                            }                     
                            if($res = K::M('order/order')->update($order['order_id'], array('pay_status'=>1, 'pay_time'=>__TIME, 'pay_code'=>'money','lasttime'=>time()))){                  
                                if ($this->MEMBER['wx_openid']) {
                                    //获取模版消息配置
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title'=>'恭喜您！预约订单支付成功！订单完成！', 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => '订单支付成功'), 'remark' =>'恭喜,您的预约订单于'.date('Y-m-d H:i:s',time()).'支付成功，订单交易完成！');
                                    $url = K::M('helper/link')->mklink('order:detail',array($detail['order_id']), array(), 'www');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_order_status'], $url, $a);
                                    $b = array('title'=>'编号：#'.$order['order_id'].'预约订单支付成功！余额减少'.$amount, 'items' => array('keyword1' => '普通会员', 'keyword2' => '预约订单支付','keyword3' => '余额减少'.$oprice,'keyword4' =>$oprice,'keyword5' => $money), 'remark' =>'恭喜,您的账户于'.date('Y-m-d H:i:s',time()).'支付预约订单成功！');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_member_money'], $url, $b);
                                }
                                $this->msgbox->add('预约订单支付成功');
                                $this->msgbox->set_data('forward', $this->mklink('ucenter/order:items'));
                            }
                        }
                    }else{
                        if($url = K::M('trade/payment')->order($code, $order,'ordered','ordered')){
                            if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                                $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl'=>$url, 'amount'=>$amount,'order_id'=>$order['order_id']));
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
            
            }else if($kind == 'mall') {
                if(!$order = K::M('mall/order')->detail($order_id)) {
                    $this->msgbox->add('您的订单不存在或已经删除', 211);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add('订单已经取消不可支付', 212);
                }else if($order['order_status'] == 8){
                    $this->msgbox->add('订单已经完成不可支付', 212);
                }else if($order['pay_status'] == 1){
                    $this->msgbox->add('该订单已经支付过了,不需要重复支付', 213);
                }else if((float)$order['product_price'] == 0){
                    $this->msgbox->add('订单无需在线支付', 215);
                }else{
                    $amount = $order['product_price'];
                    if($code == 'money'){
                        //使用余额支付
                        if($this->MEMBER['money'] < $order['product_price']){
                            $this->msgbox->add('账户余额不足！',555);
                        }else {
                            if(md5($passwd) == $this->MEMBER['paypasswd']) {
                                if($this->MEMBER['money'] >= $amount){
                                    K::M('member/member')->update_money($this->uid, -$amount, '商城支付订单(ID:'.$order_id.')');
                                }
                            }else{
                                $this->msgbox->add('支付密码不正确',255)->response();
                            }                     
                            if($res = K::M('mall/order')->update($order['order_id'], array('pay_status'=>1, 'pay_time'=>__TIME, 'pay_code'=>'money','lasttime'=>time()))){                  
                                if ($this->MEMBER['wx_openid']) {
                                    //获取模版消息配置
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title'=>'恭喜您！商城订单支付成功！订单完成！', 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => '商城订单支付成功'), 'remark' =>'恭喜,您的预约订单于'.date('Y-m-d H:i:s',time()).'支付成功，订单交易完成！');
                                    $url = K::M('helper/link')->mklink('order:detail',array($detail['order_id']), array(), 'www');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_order_status'], $url, $a);
                                    $b = array('title'=>'编号：#'.$order['order_id'].'商城订单支付成功！余额减少'.$amount, 'items' => array('keyword1' => '普通会员', 'keyword2' => '商城订单支付','keyword3' => '余额减少'.$oprice,'keyword4' =>$oprice,'keyword5' => $money), 'remark' =>'恭喜,您的账户于'.date('Y-m-d H:i:s',time()).'支付商城订单成功！');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_member_money'], $url, $b);
                                }
                                $this->msgbox->add('商城订单支付成功');
                                $this->msgbox->set_data('forward', $this->mklink('ucenter/mall:orderitems'));
                            }
                        }
                    }else{
                        if($url = K::M('trade/payment')->order($code, $order,'mall','mall')){
                            if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                                $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl'=>$url, 'amount'=>$amount,'order_id'=>$order['order_id']));
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
        }
    }
    
    public function paotui($code=null, $paotui_id=null)
    {

        if(!($paotui_id = (int)$paotui_id) && !($paotui_id = (int)$this->GP('paotui_id'))){
            $this->error(404);
        }else if(empty($code) && !($code = $this->GP('code'))){
            $this->error(404);
        }else if($this->check_login()){
            
            if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
                $this->msgbox->add('您的订单不存在或已经删除', 211);
            }else if($paotui['order_status'] < 0){
                $this->msgbox->add('订单已经取消不可支付', 212);
            }else if($paotui['order_status'] == 8){
                $this->msgbox->add('订单已经完成不可支付', 212);
            }else if($paotui['pay_status'] == 1){
                $this->msgbox->add('该订单已经支付过了,不需要重复支付', 213);
            }else if((float)($paotui['paotui_amount']+$paotui['danbao_amount']) == 0){
                $this->msgbox->add('订单无需在线支付', 215);
            }else{
                $amount = $paotui['paotui_amount'] + $paotui['danbao_amount'];
                if($code == 'money'){
                    if($paotui['order_status'] == 5 && $paotui['pay_status'] == 0) {
                        // 补价支付
                        if($paylog = K::M('payment/log')->find(array('order_id'=>$paotui['paotui_id'], 'from'=>'paotui', 'uid'=>$paotui['uid'], 'payed'=>2))) {
                            $chajia = $paotui['jiesuan_amount'] - $paotui['danbao_amount'];  
                            if($chajia > 0 && $chajia == $paylog['amount']) {
                                if($this->MEMBER['money'] < $chajia){
                                    $this->msgbox->add('账户余额不足！',555);
                                }else if(K::M('member/member')->update_money($this->uid, -$chajia, '支付订单(ID:'.$paotui['paotui_id'].')')){
                                    $this->MEMBER['money'] = $this->MEMBER['money'] - $chajia;                         
                                    if($res = K::M('paotui/paotui')->update($paotui['paotui_id'], array('order_status'=>8, 'pay_status'=>1, 'pay_time'=>__TIME, 'pay_code'=>'money'))){ 
                                        K::M('payment/log')->update($paylog['log_id'],array('payment'=>'money','payedip'=>__IP,'payedtime'=>__TIME)); 
                                        //配送员获得第二次补价支付的金额
                                        K::M('staff/staff')->update_money($paotui['staff_id'], $chajia, "订单补价结算(ID:{$paotui['paotui_id']})");                
                                        $this->msgbox->add('订单补差价支付成功');
                                        $this->msgbox->set_data('forward', $this->mklink('paotui:detail', array($paotui['paotui_id'])));
                                    }

                                }
                            }else {
                                $this->msgbox->add('差价金额不正确',216);
                            }
                        }
                    }else { 
                        //正常余额支付
                        if($this->MEMBER['money'] < $amount){
                            $this->msgbox->add('账户余额不足！',555);
                        }else if(K::M('member/member')->update_money($this->uid, -$amount, '支付订单(ID:'.$paotui['paotui_id'].')')){
                            $this->MEMBER['money'] = $this->MEMBER['money'] - $amount;                        
                            if($res = K::M('paotui/paotui')->update($paotui['paotui_id'], array('pay_status'=>1, 'pay_time'=>__TIME, 'pay_code'=>'money'))){                  
                                if ($this->MEMBER['wx_openid']) {
                                    //获取模版消息配置
                                    $wx_config = $this->system->config->get('wx_config');
                                    $config = $this->system->config->get('site');
                                    $a = array('title'=>'恭喜您！订单支付成功！订单完成！', 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => '订单支付成功'), 'remark' =>'恭喜,您的订单于'.date('Y-m-d H:i:s',time()).'支付成功，订单交易完成！');
                                    $url = K::M('helper/link')->mklink('paotui:detail',array($paotui['paotui_id']), array(), 'www');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_order_status'], $url, $a);
                                    $b = array('title'=>'编号：#'.$paotui['paotui_id'].'订单支付成功！余额减少'.$amount, 'items' => array('keyword1' => '普通会员', 'keyword2' => '订单支付','keyword3' => '余额减少'.$oprice,'keyword4' =>$oprice,'keyword5' => $money), 'remark' =>'恭喜,您的账户于'.date('Y-m-d H:i:s',time()).'支付订单成功！');
                                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['tmpl_member_money'], $url, $b);
                                }
                                if(!$log = K::M('payment/log')->log_by_order_id($paotui['paotui_id'])){
                                    $log = array('uid'=>$paotui['uid'], 'from'=>'paotui', 'order_id'=>$paotui['paotui_id'], 'trade_no'=>$paotui['paotui_id'], 'payment'=>$code, 'amount'=>($paotui['paotui_amount']+$paotui['danbao_amount']),'payedtime'=>__TIME); //插入订单记录表
                                    if(!$log_id = K::M('payment/log')->create($log)){
                                        return false;
                                    }
                                    $log = K::M('payment/log')->detail($log_id);
                                }
                                $this->msgbox->add('订单支付成功');
                                $this->msgbox->set_data('forward', $this->mklink('paotui:detail', array($paotui['paotui_id'])));
                            }
                        }
                    }   
                }else{
                    if($url = K::M('trade/payment')->paotui($code, $paotui)){
                        if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                            $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl'=>$url, 'amount'=>$amount,'paotui_id'=>$paotui['paotui_id']));
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
    }

    public function money($code=null,$amount=null)
    {
        $code = $this->GP('code');
        $amount = $this->GP('amount');
        if(!$code){
            $this->msgbox->add('没有选择支付方式',212);
        }else if(empty($amount)){
            $this->msgbox->add('付款金额不合法', 211);
        }else if($this->check_login()){
            if($ret = K::M('trade/payment')->money($this->uid, $code, $amount)){
                $url = $ret['url'];
                $trade_no = $ret['trade_no'];
                if(!defined('IN_WEIXIN') && strpos($url, 'wxpay')){
                    $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl'=>$url, 'amount'=>$amount,'order_no'=>$trade_no));
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

    
    public function get_payed($from=null,$order_id=null)
    {
        $from = $this->GP('from');
        $order_id = $this->GP('order_id');
        if(!$from || !$order_id){
            $this->ajaxReturn(array('status'=>'error'));
        }else if($from != 'order' && $from != 'money'){
            $this->ajaxReturn(array('status'=>'error'));
        }

        $uid = $this->MEMBER['uid'];
        $r = K::M('payment/log') -> find(array('uid'=>$uid,'payment'=>'wxpay','from'=>$from,'trade_no'=>$order_id),array('log_id'=>'desc'));

        if($r){
            if($r['payed'] == 1){
                $this->ajaxReturn(array('status'=>'success','payed'=>1));
            }else{
                $this->ajaxReturn(array('status'=>'error'));
            }
        }else{
            $this->ajaxReturn(array('status'=>'error'));
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
                $url = K::M('helper/link')->mklink('order:detail', array($log['order_id']), array(), 'base');
            }
            if($log['from'] == 'ordered') {
                $url = K::M('helper/link')->mklink('order:detail', array($log['order_id']), array(), 'base');
            }
            if($log['from'] == 'mall') {
                $url = K::M('helper/link')->mklink('ucenter/mall:detail', array($log['order_id']), array(), 'base');
            }
            if($log['from'] == 'money') {
                $url = K::M('helper/link')->mklink('ucenter/money:index', array(),array(),'base');
            }
        }
        header("Location:{$url}");
        exit;
    }

}
