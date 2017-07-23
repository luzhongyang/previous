<?php
namespace Common\Model;
use Think\Model;

class ProfessorFormModel extends CommonModel
{
	protected $pk = 'id';
	protected $tableName = 'professor_form';

	protected $insertFields	= array('p_cate_id','form_title','form_type','form_value','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','p_cate_id','form_title','form_type','form_value','updated_time'); // 编辑数据时允许写入的字段

	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('form_title', 'require', '表单标题不能为空！', 1, 'regex', 3),
		array('form_type', 'require', '表单类型不能为空！', 1, 'regex', 3),
		array('form_value', 'require', '表单值不能为空！', 1, 'regex', 3),
	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);
}