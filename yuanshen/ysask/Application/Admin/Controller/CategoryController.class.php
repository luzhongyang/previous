<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends CommonController{

	public function _filter(&$map){
		if($type = I('post.type')) {
			if($type != 'no') {
				$map['type'] = $type;
			}else {
				$map['type'] = array('in',"question,article,discuss,professor");
			}
		}
		if($name = I('post.name')) {
			$map['title'] = array('like',"%".$name."%");
		}
		$this->assign('type',$type);
		$this->assign('name',$name);
	}
}