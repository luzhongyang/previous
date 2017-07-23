<?php
namespace Common\Model;
use Think\Model;

class QuestionModel extends CommonModel{

	protected $pk = 'id';
    protected $tableName = 'question';

	// 	新增数据时允许写入的字段
	protected $insertFields	= array('user_id','category_id','title','description','money','user_hide','status','updated_time','created_time','tag_id');

	// 	编辑数据时允许写入的字段
	protected $updateFields	= array('user_id','category_id','title','description','money','user_hide','status','pay_status','updated_time','tag_id','adopt_answer_id','adopted_time');

	//	自动验证
	protected $_validate = array(
		array('title','require','标题不能为空'),
		array('category_id', '/^[1-9]\d*$/', '请选择分类！', 1, 'regex', 3),
	);

	// 	自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
	);


	/*相似问题*/
	public function correlations($tag_id,$limit=6)
	{
		$where['tag_ids'] = array('like',','.$tag_id.',');
        $question = M('Question')->where($where)->limit($limit)->order('created_time desc')->getField('id','title');
        return $question;
	}

	/*前台话题页问答列表*/
	public function topitems($id,$limit=15)
	{
		//$sql = "select __QUESTION__.*, __TAGGED__.`tag_id` as `pivot_tag_id`, __TAGGED__.`tagged_id` as `pivot_tagged_id` from __QUESTION__ inner join __TAGGED__ on __QUESTION__.`id` = __TAGGED__.`tagged_id` where __TAGGED__.`tag_id` = '1' and __TAGGED__.`tagged_type` = 'Question' order by `created_time` desc limit 15 offset 0";
		//return $this->query($sql);
		$where['tag_ids'] = array('like',','.$id.',');
        $question = M('Question')->where($where)->limit($limit)->order('created_time desc')->select();
        return $question;
	}


	//获取类别树
	public function get_category(){
		$where=array(
			'type'=>'question',
			'grade'=>1,
			'status'=>1,
			);
		$parent = M('category')->where($where)->order('sort asc')->getField('id,grade,title');
		foreach($parent as $key=>$value){
			$where=array(
			'type'=>'question',
			'grade'=>2,
			'status'=>1,
			'parent_id'=>$key,
			);
			$parent[$key]['children']=M('category')->where($where)->order('sort asc')->getField('id,grade,title');
		}
		return $parent;
	}

	/*采纳答案动作*/
	public function set_adopt($id, $adopt_answer_id)
	{
		if($id = (int)$id && $adopt_answer_id = (int)$adopt_answer_id) {
			$sql = "UPDATE __TABLE__ SET `status`='2',`adopt_answer_id`='{$adopt_answer_id}',`adopted_time`=UNIX_TIMESTAMP(now()),`updated_time`=UNIX_TIMESTAMP(now()) WHERE `id`='{$id}'";
			return $this->execute($sql);
		}
		return false;
	}

	/*更新悬赏问题支付状态*/
	public function set_payed($log)
	{
		$a = array('pay_status'=>1,'updated_time'=>time());
		$res = $this->where(array('id'=>$log[0]['source_id']))->save($a);
        return $res;
	}

	public function getMoneyPack()
	{
		return array(0,10,20,50,100,200);
	}

	/**
	 * 根据用户id获取问题列表
	 */
	public function get_user_question($user_id,$page,$limit=10){
		//获取问题
		$map['user_id']=array('EQ',$user_id);
		$count = $this->where($map)->count('id');
		$result = $this->where($map)->order('created_time desc')->page($page,$limit)->select();
		//获取tag信息
		foreach($result as $key=>$vo){
			if($vo['tag_ids']){
				$result[$key]['tags']=D('Tag')->getTitle($vo['tag_ids']);
			}
		}
		$r = array('count'=>$count,'list'=>$result);
		return $r;
	}
}
