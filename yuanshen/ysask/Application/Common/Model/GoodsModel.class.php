<?php
namespace Common\Model;
use Think\Model;

class GoodsModel extends Model{
	protected $_validate = array(
		array('category_id','require','商品类别不能为空'),
		array('title','require','标题不能为空'),
		);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
	);
}