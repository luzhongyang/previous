<?php
namespace Common\Model;
use Think\Model;

class SmslogModel extends Model{

	protected $pk = 'id';
	protected $tableName = 'sms_log';

	protected $insertFields	= array('id','mobile','content','status','created_ip','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('mobile','content','status','created_ip'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('mobile', 'require', '手机号不能为空！', 1, 'regex', 3),
		array('content', 'require', '短信内容不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
	);


	public function lasttime_by_ip($ip){
        $res = $this->field('created_time')->where(array('created_ip'=>$ip))->order(array('id'=>'desc'))->find();
        return (int)$res['created_time'];
    }
}