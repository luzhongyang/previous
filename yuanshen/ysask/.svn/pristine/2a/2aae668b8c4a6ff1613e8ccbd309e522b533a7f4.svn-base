<?php
/**
* 后台答主自定义表单管理
*/
namespace Admin\Controller;
use Think\Controller;
class ProfessorFormController extends CommonController{

	public function _before_index()
	{
		$cates = D('Category')->where(array('type'=>'professor','closed'=>0))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	public function _before_add()
	{
		$cates = D('Category')->where(array('type'=>'professor','closed'=>0))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	public function _before_edit()
	{
		$cates = D('Category')->where(array('type'=>'professor','closed'=>0))->getField('id,title,status');
		$this->assign('cates',$cates);
	}
}