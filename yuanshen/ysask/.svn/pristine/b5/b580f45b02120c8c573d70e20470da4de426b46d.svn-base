<?php
/**
* TAG标签管理
*/
namespace Admin\Controller;
use Think\Controller;
class TagController extends CommonController{

	public function _filter(&$map)
	{
		$map['closed'] = 0;
		$map['name'] = array('like',"%".I('post.name')."%");
	}

	public function _before_index()
	{
		$cates = D('Category')->where(array('type'=>'tag'))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	public function _before_add()
	{
		$list['sort'] = D('Tag')->max('sort')+1; //自动填充排序
		$cates = D('Category')->where(array('type'=>'tag'))->getField('id,title,status');
		$this->assign($list);
		$this->assign('cates',$cates);
	}

	public function _before_edit()
	{
		$cates = D('Category')->where(array('type'=>'tag'))->getField('id,title,status');
		$this->assign('cates',$cates);
	}

	//添加数据前置操作
	public function _before_insert() {
		if(!trim($_POST['listdir'])){
			$_POST['listdir'] = pinyin(I('post.name'));
		}
	}

	//更新数据前置操作
	public function _before_update() {
		if(!trim($_POST['listdir'])){
			$_POST['listdir'] = pinyin(I('post.name'));
		}
	}
}