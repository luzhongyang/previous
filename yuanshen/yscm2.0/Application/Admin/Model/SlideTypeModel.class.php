<?php
namespace Admin\Model;
use Think\Model;
class SlideTypeModel extends CommonModel{

	protected $insertFields	= array('name','remark','status'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','name','remark','status'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('name', 'require', '类别名称不能为空！', 1, 'regex', 3),
			array('remark', 'require', '类别介绍不能为空！', 1, 'regex', 3),
	);
}