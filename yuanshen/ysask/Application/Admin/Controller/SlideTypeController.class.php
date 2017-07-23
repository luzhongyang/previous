<?php
/**
* 幻灯片类别管理
*/
namespace Admin\Controller;
use Think\Controller;
class SlideTypeController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['name'] = array('like',"%".I('post.name')."%");
	}
}