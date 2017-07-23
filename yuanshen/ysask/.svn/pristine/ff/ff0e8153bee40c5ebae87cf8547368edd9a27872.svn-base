<?php
namespace Common\Model;
use Think\Model;
class RecommendationModel extends Model{
	protected $insertFields = array('title','url','logo','sort','status','created_time');
	protected $updateFields = array('title','url','logo','sort','status','updated_time');
	protected $_validate = array(
		array('title','require','标题不能为空'),
		array('url','require','链接地址不能为空'),
		);
	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
		);

	/*根据条件查询推荐公告表
	public function getList($type=1,$status=1,$limit=10,$order='sort'){
		$Recom = D('Recommendation');
		$list = $Recom->order($order)->limit($limit)->where('status='+$status+' AND type='+$type)->select();
		var_dump($Recom->getLastSql());
		return $list;
	}*/
}