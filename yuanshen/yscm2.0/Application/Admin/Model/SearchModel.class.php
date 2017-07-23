<?php
namespace Admin\Model;
use Think\Model;
class SearchModel extends CommonModel{

	protected $insertFields	= array('search','hits','status'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','search','hits','status'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('search','require','搜索词必填！',3),
		array('hits','require','搜索量必填',3),
		array('hits','number','搜索量必需为数据类型',3),
		
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'),
	);
}