<?php
namespace Admin\Model;
use Think\Model;
class TagsModel extends CommonModel{

	protected $insertFields	= array('name','listdir','image','description','active','sort','seo_title','seo_keywords','seo_description'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','name','listdir','image','description','active','sort','seo_title','seo_keywords','seo_description'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('name','require','Tag标签名必填！',3),
		array('description','require','标签描述必填！',3),
		array('name','','TAG名称已存在',0,'unique',3),
	);
}