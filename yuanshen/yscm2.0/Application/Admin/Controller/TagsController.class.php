<?php
/**
* TAG标签管理
*/
namespace Admin\Controller;
use Think\Controller;
class TagsController extends CommonController{
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