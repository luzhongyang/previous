<?php
namespace Common\Model;
use Think\Model;
class MailtplModel extends CommonModel{
	protected $insertFields	= array('key','name','title','content','status'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','key','name','title','content','status'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('key', 'require', 'key不能为空！', 1, 'regex', 3),
			array('key', '', 'key已存在，请重填！', 0, 'unique', 3),
			array('title', 'require', '标题不能为空！', 1, 'regex', 3),
			array('content', 'require', '内容不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
	);
}