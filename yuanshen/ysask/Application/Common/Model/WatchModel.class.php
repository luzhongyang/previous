<?php
namespace Common\Model;
use Think\Model;

class WatchModel extends CommonModel{

	protected $pk = 'id';
    protected $tableName = 'watch';

    // 	自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);

	/**
	 * 根据用户id获取关注列表	
	 * int $user_id 用户id
	 * string $type 关注的类型
	 * int $p 当前页数
	 * int $limit 一页显示的记录条数
	 */
	public function get_watch_list($user_id,$type='user',$p=1,$limit=10){
		$map['user_id']=array('EQ',$user_id);
		$map['source_type']=array('EQ',$type);
		$count = $this->where($map)->count('id');
		$result = $this->where($map)->order('created_time desc')->page($p,$limit)->getField('source_id',true);
		$list = array();
		foreach($result as $value){
			$r =M($type)->where('id='.$value)->find();
			if($r)$list[]=$r;
			else $count--;
		}
		$r = array('list'=>$list,'count'=>$count);
		return $r;
	}

	/**
	 * 根据source_id获取粉丝列表	
	 * int $source_id 资源id
	 * string $type 类型
	 * int $p 当前页数
	 * int $limit 一页显示的记录条数
	 */
	public function get_fans_list($source_id,$type='user',$p=1,$limit=10){
		$map['source_id']=array('EQ',$source_id);
		$map['source_type']=array('EQ',$type);
		$count = $this->where($map)->count('id');
		$result = $this->where($map)->order('created_time desc')->page($p,$limit)->getField('user_id',true);
		$list = array();
		foreach($result as $value){
			$fan=M('User')->where('id='.$value)->find();
			if($fan)$list[]=$fan;
			else $count--;
		}
		$r = array('list'=>$list,'count'=>$count);
		return $r;
	}
}