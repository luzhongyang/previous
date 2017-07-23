<?php
/**
 * 前台讨论
 */
namespace Home\Controller;
use Home\Controller\EmptyController;

class DiscussController extends EmptyController{

	public function __construct()
	{
		parent::__construct();
		$this->pagesize = 10;
	}

	public function index()
	{
		$type = I('request.type');
		$map = array();
		if($type == 'hot') {
			// 热门讨论
			$orderby = array('comment'=>'desc');
		}else if($type == 'new') {
			// 最新讨论
			$orderby = array('created_time'=>'desc');
		}else {
			//	全部
			$type = 'all';
			$orderby = array('created_time'=>'desc');
		}
		$this->assign('type', $type);
		if($cate_id = (int)I('request.cate_id')) {
			$map['category_id'] = $cate_id;
			$this->assign('cate_id', $cate_id);
		}
		$cate_list = M('Category')->where(array('type'=>'discuss','status'=>1,'closed'=>0))->getField('id,parent_id,title');
		$count = M('Discuss')->where($map)->count('id');
		$Page = new \Think\Page($count,$this->pagesize);
		$show = $Page->show();
		$allow_fields = 'id,admin_id,title,content,collect,view,agree,comment,created_time';
		$list = M('Discuss')->where($map)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->getField($allow_fields);
		$hot_list = M('Discuss')->where()->order(array('comment'=>'desc'))->limit(10)->getField($allow_fields);
		$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
		$assign = array(
			'nav'			=>	'discuss',
			'cate_list'		=>	$cate_list,
			'page'			=>	$show,
			'list'			=>	$list,
			'hot_list'		=>	$hot_list,
			'hot_tag_list'	=>	$hot_tag_list
		);
		$this->assign('data',$assign);
		$this->display();
	}

	public function detail()
	{
		if(!$id = (int)I('get.id')) {
			$this->error('未指定要查看的内容ID');
		}else if(!$detail = M('Discuss')->find($id)) {
			$this->error('要查看的内容不存在');
		}else {
			$hot_allow_fields = 'id,admin_id,title,content,collect,view,agree,comment,created_time';
			$hot_list = M('Discuss')->where()->order(array('comment'=>'desc'))->limit(10)->getField($hot_allow_fields);
			$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
			$allow_fields = 'id,user_id,content,created_time,agree,disagree';
			$count = M('Discuss')->where()->count('id');
			$Page = new \Think\Page($count,$this->pagesize);
			$show = $Page->show();
			$list = M('Comment')->where(array('source_id'=>$id,'source_type'=>'Discuss'))->order(array('created_time'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->getField($allow_fields);
			foreach($list as $k=>$v) {
				$user = M('User')->where(array('id'=>$v['user_id']))->getField('id,username,avatar');
				$list[$k]['user_name'] = $user[$v['user_id']]['username'];
				$list[$k]['user_avatar'] = $user[$v['user_id']]['avatar'];
			}
			$worth_list = M('Question')->where(array('status'=>1,'closed'=>0))->order(array('answer'=>'desc'))->limit(10)->select();
			$assign = array(
				'detail'		=>	$detail,
				'hot_list'		=>	$hot_list,
				'hot_tag_list'	=>	$hot_tag_list,
				'page'			=>	$show,
				'list'			=>	$list,
				'worth_list'	=>	$worth_list,
			);
			$this->assign('data', $assign);
			$this->display();
		}
	}

	public function reply()
	{
		$userinfo = session('user');
 		if(IS_POST) {
 			$post = I('post.');
 			$source_id = (int)$post['source_id'];
 			$source_type = $post['source_type'];
 			if(!$detail = M('Discuss')->where(array('id'=>$source_id))) {
 				$this->error('操作的内容不存在');
 			}if($source_type != 'Discuss') {
 				$this->error('操作的内容类型不正确');
 			}if(!$userinfo) {
 				$this->error('抱歉您还未登录');
 			}else {
 				$map = array('user_id'=>$userinfo['id'],'souce_id'=>$source_id,'source_type'=>$source_type);
 				if(M('Comment')->where($map)->find()) {
 					$this->error('您已经回复过了');
 				}
 				$post['user_id'] = $userinfo['id'];
 				if(!$data = D('Comment')->create($post)) {
 					$this->error(D('Comment')->getError());
 				}
 				if(!$rlt = D('Comment')->add($data)) {
 					$this->error(D('Comment')->getError());
 				}
 				$this->success('操作成功',U('discuss/detail',array('id'=>$source_id)));
  			}
 		}
	}

	//	详情页值得一看换一换
	public function changing()
	{
		$list = M('Question')->where(array('status'=>1,'closed'=>0))->order('rand()')->limit(10)->select();
		if(isset($list)) {
			foreach($list as $k=>$v) {
				$list[$k]['created_time'] = date('Y-m-d H:i', $v['created_time']);
			}
			$this->ajaxReturn(array('status'=>1,'data'=>$list));
		}else {
			$this->ajaxReturn(array('status'=>0,'data'=>array()));
		}
	}
}