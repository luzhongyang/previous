<?php
/**
* 幻灯片管理
*/
namespace Admin\Controller;
use Think\Controller;
class SlideController extends CommonController{	
	//搜索
	public function _filter(&$map){
		$map['title'] = array('like',"%".I('post.name')."%");
	}

	public function _before_add(){
		$list['orders'] = D('slide')->max('orders')+1; //自动填充排序
		$this->assign($list);
		$types=D('SlideType')->where('status')->order('id')->select();
		$this->assign('types',$types);
	}

	public function _before_edit(){
			$types=D('SlideType')->where('status')->order('id')->select();
			$this->assign('types',$types);
	}

	public function _before_index(){
			$types=D('SlideType')->where('status')->order('id')->select();
			$this->assign('types',$types);
	}
}