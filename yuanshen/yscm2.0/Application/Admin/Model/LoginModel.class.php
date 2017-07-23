<?php
namespace Admin\Model;
use Think\Model;
class LoginModel extends CommonModel{
	protected $insertFields	= array('username','content','ip','create_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','username','content','ip','create_time'); // 编辑数据时允许写入的字段

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'),
	);
}