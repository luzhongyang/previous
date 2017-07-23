<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends CommonModel{
	protected $insertFields	= array('username','password','sex','email','status','avatar','qq','phone','level','money','create_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','username','password','sex','email','status','avatar','qq','phone','level','money','create_time'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
			array('password', 'require', '密码不能为空！', 1, 'regex', 3),
			array('email', 'require', '邮箱不能为空！', 1, 'regex', 3),
			array('email','','邮箱已经存在！',0,'unique',3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('password','substr_pwd',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
		array('create_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
	);
}
