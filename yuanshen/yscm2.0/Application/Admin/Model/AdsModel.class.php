<?php
namespace Admin\Model;
use Think\Model;
class AdsModel extends CommonModel{

	protected $insertFields	= array('name','content'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','name','content'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('name', 'require', '广告名称不能为空！', 1, 'regex', 3),
			array('content', 'require', '广告内容不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'),
	);
}