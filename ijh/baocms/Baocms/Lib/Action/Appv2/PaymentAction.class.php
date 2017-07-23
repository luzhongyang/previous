<?php

class PaymentAction extends  CommonAction{
    

    public function app_pay()
    {
        //余额支付单独处理
        $log_id = I('order_id');
        $code = I('code');
        $password = I('password');
        if(!$logs = D('Paymentlogs')->find($log_id)){
            $this->showmsg("支付订单不存在", 1001);
        }else if($logs['is_paid']){
            $this->showmsg("订单已经支付", 1002);
        }else if($code == 'money'){
            if(!$member = D('Users')->find($logs['user_id'])){
                $this->showmsg('该订单不支付余额支付',1003);
            }elseif($password != $member['password']){
                $this->showmsg('支付密码错误',1003);
            }
            if($member['money'] < $logs['need_pay']){
                $this->showmsg('余额不足',1004);
            }
            if(D('Payment')->logsPaid($logs['log_id'])){
                D('Users')->addMoney($member['user_id'],$logs['need_pay']*(-1),'支付订单扣款');
            }            
            $this->showmsg('支付成功');
        }else{
            $logs['title'] = '订单支付';
            if($logs['order_id']){
                $logs['title'] = '订单支付('.$logs['order_id'].')';
            }elseif($logs['type'] == 'money'){
                $logs['title'] = '余额充值(用户ID:'.$logs['user_id'].')';
            }elseif($logs['type'] == 'gold'){
                $logs['title'] = '金块充值(用户ID:'.$logs['user_id'].')';
            }            
            $payment = D('Payment')->getCode($logs);
            $this->showmsg(array('data'=>$logs,'payment'=>$payment));
        }        
    }

    //充值接口
    public function recharge($order_id,$type,$code='alipay'){
        $token = $this->_param('BAOCMS_TOKEN');
        $token = urldecode($token);
        $uid = (int)getUid($token);
        if (!$uid) {
           $this->showmsg('用户未登录',1001);
        }

        if(!in_array($type,array('money','gold'))){
            $this->showmsg('类型错误',2001);
        }
       
        //查询是否有该订单的记录
        if(!$logs = D('Paymentlogs')->where(array('log_id'=>$order_id))->find()){
            //生成log
            $logs = array(
                'type' => $type,
                'user_id' => $uid,
                'code' => $code,
                'need_pay' => $logs['need_pay'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);
        }else{
            if($code != $logs['code']){
                D('Paymentlogs')->where('log_id ='.$logs['log_id'])->save(array('code'=>$code));
                $logs['code'] = $code;
            }
        }
         file_put_contents('logs.txt',D('Paymentlogs')->getLastSql());
        
        $logs['title'] = $order_title;

        $payment = D('Payment')->getCode($logs);
        
        $this->showmsg(array('data'=>$logs,'payment'=>$payment));
        
    }
    
    
    public function app_payment($order_id,$type,$code='alipay',$password=null){
        $token = $this->_param('BAOCMS_TOKEN');
        $token = urldecode($token);
        $uid = (int)getUid($token);
        if (!$uid) {
           $this->showmsg('用户未登录',1001);
        }
        //'tuan'-团购,'ele'-外卖,'ding'-订座,'breaks'-优惠买单,'hotel'-酒店,'farm'-农家乐,'crowd'-众筹,'goods'-商城
        if($type == 'tuan'){
            $order_title = '团购订单';
            $order = D('Tuanorder')->find($order_id);
        }else if($type == 'ele'){
            $order_title = '外卖订单';
            $order = D('Eleorder')->find($order_id);
        }else if($type == 'ding'){
            $order_title = '订座订单';
            $order = D('Shopdingorder')->find($order_id);
            $order['need_pay'] = $order['amount'];
        }else if($type == 'breaks'){
            $order_title = '优惠买单订单';
            $order = D('Breaksorder')->find($order_id);
        }else if($type == 'hotel'){
            $order_title = '酒店订单';
            $order = D('Hotelorder')->find($order_id);
        }else if($type == 'farm'){
            $order_title = '农家乐订单';
            $order = D('Farmorder')->find($order_id);
        }else if($type == 'crowd'){
            $order_title = '众筹订单';
            $order = D('Goodslist')->find($order_id);
            $order['need_pay'] = $order['price'];
        }else if($type == 'goods'){
            $order_title = '商城订单';
            $order = D('Order')->find($order_id);
            $order['need_pay'] = $order['total_price'];
        }else if($type == 'mart'){
            $order_title = '微店订单';
            $order = D('Order')->find($order_id);
            $order['need_pay'] = $order['total_price'];
        }

        if($type == "crowd"){
            if($order['user_id'] != $uid){
                $this->showmsg('非法操作1',1002);
            }  
        }else if($type == "mart"){
            if($order['user_id'] != $uid){
                $this->showmsg('非法操作2',1002);
            }  
        }else{
            if($order['user_id'] != $uid){
                $this->showmsg('非法操作3',1002);
            }  
        }
        
        //查询是否有该订单的记录

        if(!$logs = D('Paymentlogs')->getLogsByOrderId($type, $order_id)){
            //生成log
            $logs = array(
                'type' => $type,
                'user_id' => $uid,
                'order_id' => $order_id,
                'code' => $code,
                'need_pay' => $order['need_pay'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);
        }else{
            if($code != $logs['code']){
                D('Paymentlogs')->where('log_id ='.$logs['log_id'])->save(array('code'=>$code));
                $logs['code'] = $code;
            }
        }

        //余额支付单独处理
        if($code == 'money'){
            $member = D('Users')->find($uid);
            if($password != $member['password']){
                $this->showmsg('支付密码错误',1003);
            }
            if($member['money'] < $logs['need_pay']){
                $this->showmsg('余额不足',1004);
            }
            if($type == 'ding'){
                D('Users')->addMoney($member['user_id'],$order['amount']*(-1),'支付订单扣款');
            }if($type == 'crowd'){
                D('Users')->addMoney($member['user_id'],$order['price']*(-1),'支付订单扣款');
            }else{
                D('Users')->addMoney($member['user_id'],$logs['need_pay']*(-1),'支付订单扣款');
            }
            
            /*$pdata = array(
                'is_paid'=>1,
                'pay_time'=>time(),
                'pay_ip'=>get_client_ip()
            );
            D('Paymentlogs')->where('log_id ='.$logs['log_id'])->save($pdata); //改变支付状态*/
            
            
            
            D('Payment')->logsPaid($logs['log_id']);
            
            $this->showmsg('支付成功');
            
        }else{

            $logs['title'] = $order_title;
            $payment = D('Payment')->getCode($logs);
            $this->showmsg(array('data'=>$logs,'payment'=>$payment));
        }


    }

  
    public function payment($log_id, $code='alipay'){
        
        //取log日志 是否为有效的log_id
        if (empty($this->uid)) {
           $this->showmsg('用户未登录',1001);
        }
        $log_id = (int) $log_id;
        $logs = D('Paymentlogs')->find($log_id);
        if (empty($logs) || $logs['user_id'] != $this->uid || $logs['is_paid'] == 1) {
            $this->ajaxReturn('没有有效的支付记录！',1002);
        }else if($logs['code'] != $code){
            //update payment code 为参数传来的
            K::M('Paymentlogs')->save(array('log_id'=>$log_id,'code'=>$code));
            $logs['code'] = $code;
        }
        if($data = D('Payment')->getCode($logs)){
             //$url 支付成功后让APP打开的webview页面URL 
            if($logs['type'] == 'ele'){
                $url = U('mcenter/eleorder/detail',array('order_id'=>$logs['order_id']));
            }elseif($logs['type'] == 'tuan'){
                $url = U('mcenter/tuan/detail',array('order_id'=>$logs['order_id']));
            }elseif($logs['type'] == 'gold'||$logs['type'] == 'fzmoney'||$logs['type'] == 'money'){
                $url = U('mcenter/index/index');
            }elseif($logs['type'] == 'ding'){
                 $url = U('mcenter/ding/detail',array('order_id'=>$logs['order_id']));
            }elseif($logs['type'] == 'hotel'){
                $url = U('mcenter/hotel/detail',array('order_id'=>$logs['order_id']));
            }elseif($logs['type'] == 'farm'){
                $url = U('mcenter/farm/detail',array('order_id'=>$logs['order_id']));
            }
            $this->showmsg(array('data'=>$data, 'show_url'=>$url));
        }else{
            $this->showmsg("支付失败",1010);
            //返回错误信息
        }

    }

    public function log($log_id){
        //取log日志 是否为有效的log_id
        if (empty($this->uid)) {
           $this->showmsg('用户未登录',1001);
        }
        //dump($this->uid);
        $log_id = (int) $log_id;
        $logs = D('Paymentlogs')->find($log_id);
        if (empty($logs) || $logs['user_id'] != $this->uid || $logs['is_paid'] == 1) {
            $this->showmsg('没有有效的支付记录！',1002);
        }else{
            $this->showmsg($logs);
        }
        //json log
    }
    
    public function respond()
    {

        $code = $this->_get('code');
        if (empty($code)) {
            $this->error('没有该支付方式！');
            die;
        }
                
        $ret = D('Payment')->respond($code);
        if ($ret == false) {
            echo  'FAID';
            die;
        }else{
           echo 'SUCESS';
            die;            
        }
    }

    public function redirect()
    {
        $log_id = I('log_id');
        if(!$log = D('Paymentlogs')->find($log_id)){
            $this->error('订单不存在');
        }else{
            switch ($log['type']) {
                case 'tuan':
                    $url = U('mcenter/tuan/index');
                    break;
                case 'mall' :  case 'goods' :
                    $url = U('mcenter/goods/index');
                    break;
                case 'ele' :
                    $url = U('mcenter/eleorder/index');
                    break;
                case 'ding' :
                    $url = U('mcenter/ding/index');
                    break;
                case 'breaks' :
                    $url = U('mcenter/breaks/index');
                    break;
                case 'money' : 
                    $url = U('mcenter/money/index');
                    break;
                case 'fzmoney' :
                default:
                    $url = U('mcenter/member/index');
                    break;
            }
            header("Location:{$url}");
            exit;
        }
    }
}