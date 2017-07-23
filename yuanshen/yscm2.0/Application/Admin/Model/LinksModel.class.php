<?php
namespace Admin\Model;
use Think\Model;
class LinksModel extends CommonModel{

	protected $insertFields	= array('name','url','logo','target','content','status','type','rel','orders'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','name','url','logo','target','content','status','type','rel','orders'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('name','require','网站名称必填！',3),
		array('url','require','网站地址必填',3),
		array('url','','网站地址已存在',3,'unique',3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',3,'function'),
	);
}