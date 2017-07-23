<?php
/**
* 答主管理
*/
namespace Admin\Controller;
use Think\Controller;
class ProfessorController extends CommonController{

	//	搜索
	public function _filter(&$map){
		$map['status'] = array('egt',0); //大于等于0
		$map['real_name'] = array('like',"%".I('post.real_name')."%");
	}

	public function _before_index(){
		$cate_list = D('Category')->where(array('type'=>'professor'))->getField('id,title,status');
		$this->assign('cate_list',$cate_list);
	}

	public function _before_edit() {
		$cate_list = D('Category')->where(array('type'=>'professor'))->getField('id,title,status');
		$this->assign('cate_list',$cate_list);
	}
}