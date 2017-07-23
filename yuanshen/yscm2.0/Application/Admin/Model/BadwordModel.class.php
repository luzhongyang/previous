<?php
namespace Admin\Model;
use Think\Model;
class BadwordModel extends CommonModel{

	protected $insertFields	= array('badword','level','replaceword'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','badword','level','replaceword'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('badword','require','敏感词必填！',3),
		
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'), //3 添加和修改都执行
	);
}