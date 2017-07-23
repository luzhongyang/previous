<?php
namespace Common\Model;
use Think\Model;

/**
 * 打赏日志表
 */

class AwardModel extends Model{

	protected $pk = 'id';
    protected $tableName = 'award';

    protected $_auto = array(
		array('created_time','time',1,'function'),
	);
}