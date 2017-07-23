<?php
namespace Common\Model;
use Think\Model;

class AnswerModel extends CommonModel{

	protected $pk = 'id';
	protected $tableName = 'answer';

	protected $insertFields	= array('question_id','question_title','user_id','content','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','content','agree','disagree','collect','comment','money','status','updated_time','closed','adopted_time'); // 编辑数据时允许写入的字段

	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);

	public function get_new_adopt(){
		//查询问题表
		$where['status'] = 2;
		$adopt = M('Question')->where($where)->order('adopted_time')->limit(20)->field('id,title,adopt_answer_id,adopted_time')->select();
		foreach($adopt as $key=>$value){
			$adopt[$key]['answer'] = $this->where('id='.$value['adopt_answer_id'])->field('id,user_id,content')->find();
			$adopt[$key]['user'] = M('User')->where('id='.$adopt[$key]['answer']['user_id'])->field('id,username,avatar')->find();
			$adopt[$key]['adopted_time'] = timestampFormat($value['adopted_time']);//将时间戳转换为多少分钟前
		}
		return $adopt;
	}
}