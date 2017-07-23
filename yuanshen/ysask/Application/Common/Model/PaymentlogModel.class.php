<?php
namespace Common\Model;
use Think\Model;

class PaymentlogModel extends Model
{
	protected $pk = 'id';
	protected $tableName = 'payment_log';

	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('created_ip','get_client_ip',1,'function'),
	);

    //  生成唯一商户订单号
	public function create_trade_no()
    {
        $i = rand(0, 99999999);
        do{
            if (99999999 == $i) {
                $i = 0;
            }
            ++$i;
            $no = date("Ymd") . str_pad($i, 8, "0", STR_PAD_LEFT);
            $order_no = $this->query("SELECT trade_no FROM __TABLE__ WHERE trade_no='{$no}'");
        } while ($order_no);
        return $no;
    }

    //  根据商户订单号查询一条支付日志
    public function log_by_no($no)
    {
        if(!is_numeric($no)){
            return false;
        }
        $sql = "SELECT * FROM __PAYMENT_LOG__ WHERE trade_no=$no";
        return $this->query($sql);
    }

    //  根据订单ID查询一条支付日志
    public function log_by_order_id($order_id, $type)
    {
        if(!is_numeric($order_id)){
            return false;
        }
        $sql = "SELECT * FROM __TABLE__ WHERE `id`='{$order_id}' AND `type`='{$type}'";
        return $this->query($sql);
    }

    //  更新日志状态为已支付
    public function set_payed($no, $pay_trade_no='')
    {
        if(!is_numeric($no)){
            return false;
        }

        if($res = $this->where(array('trade_no'=>$no))->save(array('payed'=>1))) {
            $a = array('pay_trade_no'=>$pay_trade_no, 'payedip'=>get_client_ip(), 'payedtime'=>time());
            $this->where(array('trade_no'=>$no))->save($a);
        }
        return $res;
    }
}