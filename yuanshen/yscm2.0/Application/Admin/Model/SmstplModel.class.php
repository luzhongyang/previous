<?php
namespace Admin\Model;
use Think\Model;
class SmstplModel extends CommonModel{

	protected $insertFields	= array('key','title','content','status'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','key','title','content','status'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('key', 'require', 'key不能为空！', 1, 'regex', 3),
			array('title', 'require', '标题不能为空！', 1, 'regex', 3),
			array('content', 'require', '内容不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'),
	);
}