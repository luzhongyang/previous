<?php
/**
 * 前台话题
 */
namespace Home\Controller;
use Home\Controller\EmptyController;

class TagController extends EmptyController{

	public function __construct()
	{
		parent::__construct();
		$this->pagesize = 10;
	}


	/*话题首页*/
	public function index()
	{
		$userinfo = session('user');
		$map = array('closed'=>0);
		$cate_list = M('Category')->where(array('type'=>'tag','status'=>1,'closed'=>0))->order(array('created_time'=>'desc'))->select();
		if($cate_id = (int)I('get.cate_id')) {
			$map['category_id'] = $cate_id;
			$this->assign('cate_id',$cate_id);
		}

		$count = M('Tag')->where($map)->count('id');
		$Page = new \Think\Page($count,$this->pagesize);
		$show = $Page->show();
		$allow_fields = 'id,title,logo,description,watch';
		$list = M('Tag')->where($map)->order(array('watch'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->getField($allow_fields);
		foreach($list as $k=>$v) {
			$follow = M('Watch')->where(array('user_id'=>$userinfo['id'],'source_id'=>$v['id'],'source_type'=>'Tag'))->find();
			if($follow) {
				$list[$k]['is_followed'] = 1;
				$list[$k]['attention_id'] = $follow['id'];
			}else {
				$list[$k]['is_followed'] = 0;
				$list[$k]['attention_id'] = 0;
			}
		}
		$assign = array(
			'cate_list'		=>	$cate_list,
			'page'			=>	$show,
			'list'			=>	$list,
			'nav'			=>	'tag'
		);
		$this->assign('data', $assign);
		$this->display();
	}


	/*话题详情页*/
	public function detail()
	{
		$userinfo = session('user');
		if(!$tag_id = (int)I('get.id')) {
			$this->error('未指定要查看的内容ID');
		}else if(!$detail = M('Tag')->find($tag_id)) {
			$this->error('要查看的内容不存在');
		}else {
			//	话题详情
			$follow = M('Watch')->where(array('user_id'=>$userinfo['id'],'source_id'=>$detail['id'],'source_type'=>'Tag'))->find();
			if($follow) {
				$detail['is_followed'] = 1;
				$detail['attention_id'] = $follow['id'];
			}else {
				$detail['is_followed'] = 0;
				$detail['attention_id'] = 0;
			}
			//	话题关联问答、文章、百科(description)列表
			$type = I('get.type');
			if($type == 'article') {
				$where['tag_ids'] = array('like',','.$id.',');
				$count = M('Article')->where($where)->count('id');
				$Page = new \Think\Page($count,$this->pagesize);
				$show = $Page->show();
				$allow_fields = 'id,user_id,title,summary,description,view,agree,created_time';
        		$list = M('Article')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('created_time desc')->select($allow_fields);
        		foreach($list as $k=>$v) {
        			$list[$k]['type'] = 'article';
        			$user = M('User')->where(array('id'=>$v['user_id']))->getField('id,username,avatar');
        			if($user) {
        				$list[$k]['user_avatar'] = $user[$v['user_id']]['avatar'];
        				$list[$k]['user_name'] = $user[$v['user_id']]['user_name'];
        			}
        		}
        		$this->assign('type',$type);
			}else if($type == 'baike') {
				$topitems = $detail['description'];
			}else {
				$where['tag_ids'] = array('like',','.$id.',');
				$count = M('Question')->where($where)->count('id');
				$Page = new \Think\Page($count,$this->pagesize);
				$show = $Page->show();
				$allow_fields = 'id,user_id,title,description,view,collect,created_time';
        		$list = M('Question')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('created_time desc')->select($allow_fields);
        		foreach($list as $k=>$v) {
        			$user = M('User')->where(array('id'=>$v['user_id']))->getField('id,username,avatar');
        			if($user) {
        				$list[$k]['user_avatar'] = $user[$v['user_id']]['avatar'];
        				$list[$k]['user_name'] = $user[$v['user_id']]['user_name'];
        			}
        		}
        		$this->assign('type','');
			}

			$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
			$db_pre = C('DB_PREFIX');
			$orderby_filter = " `{$db_pre}user`.`answer` DESC,`{$db_pre}user`.`article` DESC,`{$db_pre}user`.`updated_time` DESC ";
			$hot_pro_sql = "SELECT `{$db_pre}user`.`id`,`{$db_pre}user`.`avatar`,`{$db_pre}user`.`username`,`{$db_pre}user`.`agree` FROM `{$db_pre}professor` LEFT JOIN `{$db_pre}user` ON `{$db_pre}professor`.`user_id`=`{$db_pre}user`.`id` WHERE `{$db_pre}user`.`status`>'0' AND `{$db_pre}professor`.`status`='1' ORDER BY ".$orderby_filter." LIMIT "." 10";
			$Model = new \Think\Model();
			$hot_pro_list = $Model->query($hot_pro_sql);
			$assign = array(
				'detail'		=>	$detail,
				'list'			=>	$list,
				'hot_tag_list'	=>	$hot_tag_list,
				'hot_pro_list'	=>	$hot_pro_list
			);
			$this->assign('data',$assign);
			$this->display();
		}
	}
}