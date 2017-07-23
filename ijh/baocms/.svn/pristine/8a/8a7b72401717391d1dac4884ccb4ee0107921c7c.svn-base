<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class PaymentlogsModel extends CommonModel{
    protected $pk   = 'log_id';
    protected $tableName =  'payment_logs';
    
    public function getLogsByOrderId($type,$order_id){
        $order_id = (int)$order_id;
        $type = addslashes($type);
        return $this->find(array('where'=>array('type'=>$type, 'order_id'=>$order_id)));
    }

    public function sendWeixinTempMsgByOrderId($order_id=0, $uid=0, $str=''){
        include_once "Baocms/Lib/Net/Wxmesg.class.php";
        if(empty($str)){
        	$str = '亲，您的订单已创建成功，我们会立即为您备货。订单详情如下：';
        }
		if (!empty($order_id) && !empty($uid)) {
        	$orderPayTpye = $this->getOrderPayTpye($order_id, $uid);
			if (is_array($order_id)) {
	    		foreach ($order_id as $k => $v) {
	                if ($order = D('Order')->find($v)) {
	                    if ($goods = D('Ordergoods')->where(array('order_id'=>$order['order_id']))->find()) {
	                        if ($order['is_daofu'] == 0) {
	                        	$payType = $orderPayTpye;
                            }elseif($order['is_daofu'] == 1){
                            	$payType = '货到付款';
                            }else{
                            	$payType = '';
                            }
	                        //====================微信支付通知==商城=========================
	                        /*微信商城订单通知用户消息-开始*/
	                        $notice_data = array(
	                            'first'   => $str,
	                            'orderNum'   => $order['order_id'],
	                            'goodsName'  => $goods['title'],
	                            'buyNum'    => $goods['num'],
	                            'money'    => round($goods['total_price']/100,2).'元',
	                            'payType'    => $payType,
	                            'remark'  => '详情请登录-http://'.$_SERVER['HTTP_HOST']
	                        );
	                        $notice_data = Wxmesg::order($notice_data);
	                        Wxmesg::net($uid, 'OPENTM202297555', $notice_data);
	                        /*微信商城订单通知用户消息-结束*/
	                        //====================微信支付通知==商城=========================
	                    }
	                }
	            }
	    	}else{
		        if ($order = D('Order')->find($order_id)) {
		            if ($goods = D('Ordergoods')->where(array('order_id'=>$order['order_id']))->find()) {
		                if ($order['is_daofu'] == 0) {
                        	$payType = $orderPayTpye;
                        }elseif($order['is_daofu'] == 1){
                        	$payType = '货到付款';
                        }else{
                        	$payType = '';
                        }
		                //====================微信支付通知==商城=========================
		                /*微信商城订单通知用户消息-开始*/
		                $notice_data = array(
		                    'first'   => $str,
		                    'orderNum'   => $order['order_id'],
		                    'goodsName'  => $goods['title'],
		                    'buyNum'    => $goods['num'],
		                    'money'    => round($goods['total_price']/100,2).'元',
		                    'payType'    => $payType,
		                    'remark'  => '详情请登录-http://'.$_SERVER['HTTP_HOST']
		                );
		                $notice_data = Wxmesg::order($notice_data);
		                Wxmesg::net($uid, 'OPENTM202297555', $notice_data);
		                /*微信商城订单通知用户消息-结束*/
		                //====================微信支付通知==商城=========================
		            }
		        }
		    }
		}
    }

    protected function getOrderPayTpye($order_id, $uid){
    	$payType = '';
    	if ($type = D('Payment')->getPayments()) {
	    	if (is_array($order_id)) {
				$order_ids = implode(",",$order_id);
				if ($logs_obj = D('Paymentlogs')->where(array('order_ids'=>$order_ids, 'is_paid'=>1, 'user_id'=>$uid))->find()) {
					$payType = $type[$logs_obj['code']]['name'] ? $type[$logs_obj['code']]['name'] : '';
				}
	    	}else{
	    		if ($logs_obj = D('Paymentlogs')->where(array('order_id'=>$order_id, 'is_paid'=>1, 'user_id'=>$uid))->find()) {
					$payType = $type[$logs_obj['code']]['name'] ? $type[$logs_obj['code']]['name'] : '';
				}else{
					if ($logs_obj = D('Paymentlogs')->where(array('order_ids'=>array('LIKE', '%' . $order_id.',' . '%'), 'is_paid'=>1, 'user_id'=>$uid))->find()) {
						$payType = $type[$logs_obj['code']]['name'] ? $type[$logs_obj['code']]['name'] : '';
					}
				}
	    	}
		}
		return $payType;
    }
}