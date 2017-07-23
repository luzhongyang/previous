<?php
namespace Common\Model;
use Think\Model;
class OrderModel extends CommonModel{

	protected $pk	= 'id';
	protected $tableName = 'order';

	protected $insertFields	= array('user_id','type','source_id','number','amount','contact','phone','address','freight','order_status','pay_status','pay_time','comment_status','created_time');
	protected $updateFields	= array('user_id','contact','phone','address','freight','order_status','pay_status','pay_time','comment_status','updated_time');

	protected $_validate = array(
		array('source_id', 'require', '商品id不能为空！', 1, 'regex', 3),
		array('number', 'require', '商品数量不能为空！', 1, 'regex', 3),
		array('amount', 'require', '订单金额不能为空！', 1, 'regex', 3),
	);

	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);

	//	获取
	public function getType($key)
	{
		if($key == 0) {
			$data = array('logtype'=>'shop_order', 'ordertype'=>'商城订单');
		}else if($key == 1) {
			$data = array('logtype'=>'article_order', 'ordertype'=>'付费文章订单');
		}else if($key == 2) {
			$data = array('logtype'=>'answer_order', 'ordertype'=>'付费答案订单');
		}else {
			$data = array('shop_order', 'article_order', 'answer_order');
		}
		return $data;
	}

	//	更新支付状态
	public function set_payed($log=array())
	{
		$order_id = $log['source_id'];
        if(!$order = $this->find($order_id)){
            return false;
        }else if($res = $this->save(array('order_id'=>$order_id,'pay_status'=>1))) {
            $a = array('order_id'=>$order_id,'pay_time'=>time(),'updated_time'=>time());
            $this->save($a);
            $logmsg = '订单支付成功';
            D('Common/Orderlog')->add(array('order_id'=>$order_id,'type'=>'payment','log'=>$logmsg,'status'=>$order['order_status']));
        }
        return $res;
	}
}
