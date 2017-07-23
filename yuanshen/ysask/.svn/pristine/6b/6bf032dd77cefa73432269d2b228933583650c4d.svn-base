<?php
namespace Common\Model;
use Think\Model;

class ProfessorFormvalModel extends CommonModel
{
	protected $pk = 'id';
	protected $tableName = 'professor_formval';

	protected $insertFields	= array('p_id','p_form_id','p_form_value','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','p_id','p_form_id','p_form_value'); // 编辑数据时允许写入的字段

	protected $_validate = array(
		array('p_id', 'require', '答主不能为空！', 1, 'regex', 3),
		array('p_form_id', 'require', '表单id不能为空！', 1, 'regex', 3),
		array('p_form_value', 'require', '表单值不能为空！', 1, 'regex', 3),

	);

	protected $_auto = array(
		array('created_time','time',1,'function'),
	);
}