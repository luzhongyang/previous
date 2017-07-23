<?php
/**
* 后台菜单管理
*/
namespace Admin\Controller;
use Think\Controller;
class AuthRuleController extends CommonController{
	public function _filter(&$map){
		$map['title'] = array('like',"%".I('post.name')."%");
	}

	//权限列表
	public function _before_index(){
		$data=D('AuthRule')->getTreeData('tree','sort','title');
		$this->assign("lists",$data);
	}

	//添加权限
	public function _before_add(){
		$data=D('AuthRule')->getTreeData('tree','sort','title');
		$this->assign("lists",$data);
		$list['sort'] = D('AuthRule')->max('sort')+1; //自动填充排序
		$this->assign($list);
	}

	//修改权限
	public function _before_edit(){
		$data=D('AuthRule')->getTreeData('tree','sort','title');
		$this->assign("lists",$data);
	}
}
