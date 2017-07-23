<?php
namespace Admin\Controller;
use Think\Controller;

class ArticleController extends CommonController{

	public function _filter(&$map)
	{
		$map['closed'] = 0;
		if($name = I('post.name')) {
			$map['title'] = array('like',"%".$name."%");
		}
		$status = I('post.status');
		if($status === 'noaudit') {
			$map['status'] = 0;
		}else if($status === 'pass') {
			$map['status'] = 1;
		}else {
			$map['status'] = array('in','0,1');
		}
		if($cate_id = I('post.cate_id')) {
			if($cate_id > 0) {
				$map['category_id'] = $cate_id;
			}
		}
		$this->assign('name',$name);
		$this->assign('status',$status);
		$this->assign('cate_id',$cate_id);
	}

	public function _before_index()
	{
		$users = D('User')->getField('id,username,created_time');
		$cates = D('Category')->where(array('type'=>'article'))->getField('id,title,status');
		$this->assign('users',$users);
		$this->assign('cates',$cates);
	}

	public function _before_detail()
	{
		$cates = D('Category')->where(array('type'=>'article'))->getField('id,title,status');
		$this->assign('cates',$cates);	
	}
}