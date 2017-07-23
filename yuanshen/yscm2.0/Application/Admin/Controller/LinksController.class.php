<?php
/**
* 友情链接
*/
namespace Admin\Controller;
use Think\Controller;
class LinksController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['name'] = array('like',"%".$_REQUEST['name']."%");
	}
	public function _before_add() {
		$list['orders'] = D('links')->max('orders')+1; //自动填充排序
		$this->assign($list);
	}

}