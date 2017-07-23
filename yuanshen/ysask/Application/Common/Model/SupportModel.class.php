<?php
namespace Common\Model;
use Think\Model;

class SupportModel extends Model{

	protected $pk = 'id';
    protected $tableName = 'support';

    //	自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);
}