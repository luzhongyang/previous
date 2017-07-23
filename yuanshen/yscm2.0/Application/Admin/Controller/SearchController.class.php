<?php
/**
* 搜索关键词管理
*/
namespace Admin\Controller;
use Think\Controller;
class SearchController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['search'] = array('like',"%".$_REQUEST['name']."%");
	}
}