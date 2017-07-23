<?php
// 角色模型
namespace Admin\Model;
use Think\Model;
class AuthGroupModel extends CommonModel{
	public $_validate = array(
		array('title','require','名称必填'),
		array('title','','名称已经存在',0,'unique',3),
	);
	public $_auto=array(
		array('create_time','time',1,'function'),
		array('update_time','time',2,'function'),
	);
}
