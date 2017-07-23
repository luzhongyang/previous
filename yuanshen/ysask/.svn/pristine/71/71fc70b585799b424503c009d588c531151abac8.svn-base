<?php
namespace Common\Model;
use Think\Model;

class DiscussModel extends CommonModel{

	protected $pk = 'id';
	protected $tableName = 'discuss';

	protected $insertFields	= array('admin_id','category_id','title','content','sort','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','category_id','title','content','comment','collect','support','agree','disagree','sort','updated_time','closed'); // 编辑数据时允许写入的字段

	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);

}