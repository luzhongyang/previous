<?php
namespace Common\Model;
use Think\Model;
class PageModel extends CommonModel{
	protected $pk = 'id';
	protected $tableName = 'page';

	protected $_validate = array(
		array('title', 'require', '标题不能为空！', 1, 'regex', 3),
		array('content', 'require', '内容不能为空！', 1, 'regex', 3),
	);

	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);
}