<?php
/**
* 留言
*/
namespace Admin\Controller;
use Think\Controller;
class GuestbookController extends CommonController{
	//获取留言列表
	public function index(){
		$status = (int)I('status');
		$where['status']=$status;
		$list = M('guestbook')->where($where)->select();
			$this->assign('list',$list);
			$this->display();
	}

	//审核
	public function check(){
		$id = (int)I('id');
		$status = (int)I('status');
		$result = M('Guestbook')->where('id='.$id)->setField('status',$status);
		if($result){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}

	//删除
	public function delete(){
		$id = (int)I('id');
		if(!$id){
			$this->error('id不能为空');
		}else{
			$result = M('Guestbook')->where('id='.$id)->delete();
			if($result){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
}