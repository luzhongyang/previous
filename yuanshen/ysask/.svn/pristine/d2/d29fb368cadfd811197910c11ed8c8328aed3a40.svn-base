<?php
namespace Admin\Controller;
use Think\Controller;

class DiscussController extends CommonController{

	public function _filter(&$map)
	{
		$map['closed'] = 0;
		if($name = I('post.name')) {
			$map['title'] = array('like',"%".$name."%");
		}
		if($cate_id = I('post.cate_id')) {
			if($cate_id > 0) {
				$map['category_id'] = $cate_id;
			}
		}
		$this->assign('name',$name);
		$this->assign('cate_id',$cate_id);
	}

	public function _before_index()
	{
		$cates = D('Category')->where(array('type'=>'discuss'))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	public function _before_add()
	{
		$cates = D('Category')->where(array('type'=>'discuss'))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	public function _before_edit()
	{
		$cates = D('Category')->where(array('type'=>'discuss'))->getField('id,title,status');
		$this->assign('cates',$cates);
	}
	
	public function _before_detail()
	{
		$admins = D('Admin')->getField('id,username,created_time');
		$cates = D('Category')->where(array('type'=>'discuss'))->getField('id,title,status');
		$this->assign('admins',$admins);
		$this->assign('cates',$cates);	
	}
}