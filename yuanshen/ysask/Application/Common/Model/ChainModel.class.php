<?php
namespace Common\Model;
use Think\Model;
class ChainModel extends CommonModel{

	protected $insertFields	= array('keyword','url','number','target','status'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','keyword','url','number','target','status'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('keyword','require','网站名称必填！',3),
		array('url','require','网站地址必填',3),
		array('number','require','频率必填',3),
		array('number','number','频率必需是数字',3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
	);
}