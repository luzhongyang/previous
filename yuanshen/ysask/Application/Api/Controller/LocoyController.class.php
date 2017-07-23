<?php
/**
 * 采集处理
 */
namespace Api\Controller;
use Think\Controller;
class LocoyController extends Controller {

	public function index()
	{
		$passwd = '58d3806117ea3';
		if(I('request.passwd') != $passwd) {
			$this->ajaxreturn(array('status'=>0,'message'=>'验证密码错误'));
		}else {
			if(I('post.')) {
				$data = array();
				$data['title'] = I('post.title');
				$data['content'] = I('post.content');
				$data['user_name'] = I('post.author');
				$data['created_time'] = strtotime(I('post.date'));
				if(!$data['title']) {
					$this->ajaxreturn(array('status'=>0,'message'=>'文章标题不能为空'));
				}else if(!$data['content']) {
					$this->ajaxreturn(array('status'=>0,'message'=>'文章内容不能为空'));
				}else if(!$data['user_name']) {
					$this->ajaxreturn(array('status'=>0,'message'=>'文章发表人不能为空'));
				}else if(!$data['created_time']) {
					$this->ajaxreturn(array('status'=>0,'message'=>'文章发表时间不能为空'));
				}else {
					if($id = D('Common/Article')->add($data)) {
						$this->ajaxreturn(array('status'=>1,'message'=>'执行成功'));
					}else {
						$this->ajaxreturn(array('status'=>1,'message'=>D('Common/Article')->getError()));
					}
				}
			}
		}
	}
}