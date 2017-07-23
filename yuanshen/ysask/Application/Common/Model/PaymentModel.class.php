<?php
namespace Common\Model;
use Think\Model;

class PaymentModel extends Model
{
	protected $pk = 'id';
	protected $tableName = 'payment';

	/**
	 * [获取接口列表]
	 * @param  [type] $key [接口标识alipay/wxpay/paypal]
	 * @return [type]      [description]
	 */
	public function payment($key='')
    {
        if($items = $this->select()){
            foreach($items as $item){
                if($item['payment'] == $key){
                    return $item;
                }
            }
        }
        return false;
    }


    //  充值支付成功更新用户余额
    public  function payed_money($log=array())
    {
        $amount = (float)$log['amount'];
        $intro = "在线充值￥{$log['amount']}";
        if($res = D('User')->update_money($log['user_id'], $amount, $intro)) {
            return $res;
        }
    }

    // 订单支付成功更新商城订单状态
    public function payed_order($log=array())
    {
        if($log['source_id']){
            if(D('Order')->set_payed($log)){
                if($log['user_id']){
                    D('User')->update_total_money($log['user_id'], (float)$log['amount']);
                }
                return true;
            }
        }
        return false;
    }


    //  支付成功更新悬赏问题状态
    public function payed_question($log)
    {
        $res = D('Question')->set_payed($log);
        if($res) {
            return true;
        }else {
            return false;
        }
    }
}