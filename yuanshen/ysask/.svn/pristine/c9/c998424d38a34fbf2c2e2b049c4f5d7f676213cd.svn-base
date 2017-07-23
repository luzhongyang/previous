<?php
namespace Common\Model;
use Think\Model;

class ExchangeModel extends CommonModel{

	protected $pk = 'id';
	protected $tableName = 'exchange';

	protected $_auto = array(
		array('created_time','time',1,'function'),
	);

	// 更新商城订单支付状态
	public function set_payed($log, $trade)
	{
		$order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($res = $this->db->update($this->_table, array('pay_status' => 1), "order_id='{$order_id}'", true)){
            $a = array('online_pay'=>1, 'pay_time'=>__TIME,'lasttime'=>__TIME,'pay_code'=>$trade['code']);
            //如果下单时选择了服务人员更新订单order_status为1
            if(in_array($order['from'], array('house', 'weixiu', 'paotui')) && $order['order_status']==0 && $order['staff_id'] > 0){
                $a['order_status'] = 1;
            }
            $this->update($order_id, $a, true);
            if($trade['code'] == 'money') {
                $logmsg = '订单余额支付成功';
            }else {
                $logmsg = '订单支付成功';
            }
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'payment','log'=>$logmsg,'status'=>$order['order_status']));
            if($order['from'] == 'tuan') {
                $tuan_order = K::M('tuan/order')->detail($order_id);
                $this->update($order_id, array('order_status'=>5));
                K::M('tuan/ticket')->create_ticket($order_id);
                $title = sprintf("新的团购订单(单号：%s)", $order_id);
                //$content = sprintf("[%s]下了团购了%s份[%s](单号：%s)", $tuan_order['contact'], $tuan_order['tuan_number'], $tuan_order['tuan_title'], $order_id);
                $content = sprintf("用户(%s)下了团购订单(单号：%s)", $tuan_order['contact'], $order_id);
                K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
            }
        }
        return $res;
	}


}