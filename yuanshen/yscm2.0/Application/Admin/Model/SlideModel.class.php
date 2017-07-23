<?php
namespace Admin\Model;
use Think\Model;
class SlideModel extends CommonModel{

	protected $insertFields	= array('typeid','title','banner','url','logo','status','content','orders'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','typeid','title','banner','url','logo','status','content','orders'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('title', 'require', '名称不能为空！', 1, 'regex', 3),
			array('url', 'require', '链接不能为空！', 1, 'regex', 3),
			array('banner', 'require', 'banner图片不能为空！', 1, 'regex', 3),
			array('content', 'require', '内容不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',1,'function'), // 对update_time字段在更新的时候写入当前时间戳
	);
}