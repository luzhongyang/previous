<?php
namespace Common\Model;
use Think\Model;
class ExperiencelogModel extends Model{

	protected $pk = 'id';
	protected $tableName = 'experience_log';

	protected $insertFields = array('user_id','action','source_id','intro','number','created_time');
	protected $updateFields = array('user_id','action','source_id','intro','number');

	protected $_validate = array(
		array('user_id','require','用户id不能为空'),
		array('number','require','经验变动值number不能为空'),
		);
	protected $_auto = array(
		array('created_time','time',1,'function')
	);

	//经验值变动
	public function change($user_id,$data) {
		if(!$this->token(false)->create($data)){
			return false;
		}
		$this->add();
		$result=M('User')->where(array('user_id'=>$user_id))->setInc('experience', $data['number']);
		return $result;
	}
}