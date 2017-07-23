<?php
namespace Common\Model;
use Think\Model;
class LinkModel extends CommonModel{

	protected $pk = 'id';
	protected $tableName = 'link';

	protected $insertFields	= array('name','url','logo','target','status','type','sort','slogan'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','name','url','logo','target','status','type','sort','slogan'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('name','require','网站名称必填！',3),
		array('url','require','网站地址必填',3),
		array('url','','网站地址已存在',3,'unique',3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);
}