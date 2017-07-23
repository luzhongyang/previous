<?php
/**
* 内链管理
*/
namespace Admin\Controller;
use Think\Controller;
class ChainController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['keyword'] = array('like',"%".$_REQUEST['name']."%");
	}
}