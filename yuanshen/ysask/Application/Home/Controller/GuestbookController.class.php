<?php
/**
 * 留言板
 */
namespace Home\Controller;
use Think\Controller;

class GuestbookController extends CommonController{
	/**
	 * 留言
	 */
	public function leave_msg(){
			$Guestbook = D('guestbook');
			$Guestbook->name = session('user.username');
			$Guestbook->email = I('post.email');
			$Guestbook->content = I('post.content');
			$Guestbook->status = 0;
			$Guestbook->created_time = time();
			if(!$Guestbook->create()){
				$this->error($Guestbook->getError());
			}
			$Guestbook->add();
			$this->success('留言成功，审核通过后显示');
		}else{
			$list = M('guestbook')->where('status=1')->limit(100)->select();
			$this->assign('list',$list);
			$this->display();
		}
	}
}