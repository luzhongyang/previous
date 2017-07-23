<?php
namespace Home\Controller;
use \Think\Controller;

class IndexController extends Controller{
	public function __construct(){
		parent::__construct();

		//加载模型
		$this->User = M('User');
		$this->Recom=M('Recommendation');
		$this->Article = M('Article');
		$this->Question = M('Question');
		$this->Tag = M('Tag');
		$this->Professor = M('Professor');
		$this->Link = M('Link');
	}

	//网站首页
	public function index(){
		//获取已解决问题数
		$array['question_count'] = $this->Question->where('status=2')->count('id');
		//获取推荐列表
		$array['recom'] = $this->Recom->where('type=1 AND status=1')->order('created_time desc,sort')->limit(5)->field('id,title,url,picture')->select();
		//获取最新公告
		$array['annou'] = $this->Recom->where('type=2 AND status=1')->order('created_time desc,sort')->limit(10)->getField('id,title,url');

		//获取最新文章
		$array['article'] = $this->Article->where('status=1')->order('created_time')->limit(7)->field('id,title,view,logo')->select();
		$array['count_article'] = count($array['article']);
		//获取热门文章
		$array['hot_article'] = $this->Article->where('status=1')->order('view')->limit(10)->getField('id,title');
		//获取待解决问题
		$array['question'] = $this->Question->where('status=1')->order('created_time')->limit(10)->getField('id,user_id,title,description,money,created_time');
		//获取最新问题
		$array['new_question'] = $this->Question->where('status>0')->order('created_time')->limit(20)->field('id,user_id,title,description,money,created_time')->select();
		//获取问题分类
		$array['question_category'] = D('Question')->get_category();
		//获取悬赏问题
		$array['reward_question'] = $this->Question->where('status=1 AND money>0')->order('money desc')->limit(10)->field('id,title,money')->select();
		//获取热门讨论话题
		$array['hot_tag'] = $this->Tag->order('sum')->limit(10)->getField('id,title');
		//推荐答主
		$array['professor'] = $this->Professor->join('__USER__ ON __PROFESSOR__.user_id = __USER__.id')->where(C('DB_PREFIX')+'user.status=1 AND '+C('DB_PREFIX')+'professor.status=1')->	order('adopt')->limit(9)->getField('user_id,avatar,username,real_name,skill,adopt,agree');
		//获取财富榜
		$array['rich_list'] = $this->User->order('money desc')->limit(10)->field('id,username,avatar,money')->select();
		//获取经验榜
		//$array['rank_list'] = $this->User->order('experience')->limit(20)->getField('id,username,avatar,experience');
		//获取最新采纳
		$array['new_adopt'] = D('Answer')->get_new_adopt();
		//获取友情链接
		$array['link_list'] = $this->Link->order('sort')->select();
		//获取热点检索
		$array['hot_search'] = D('Search')->sort_by_initial();
		$this->assign($array);
		$this->display();
	}

	public function verify()
	{
		ob_clean();
		$verify = new \Think\Verify();
		$verify->entry();
	}

	//搜索
	public function search(){
		$query = I('query');
		if(empty($query)){
			$this->error('检索词不能为空','/');
		}
		$project = I('project');
		$result=D('Search')->search($query,$project);

		$this->assign($result);
		$this->assign('query',$query);
		$this->display();
	}

	public function sendsms()
	{
		$mobile = '17755193651';
		$code="131452";
		$key = 'login_code';
		$Send = new \Vendor\Alidayu\Send;
		$rlt = $Send->sendsms($mobile,$code,$key);
		echo '<pre>';print_r($rlt);die;
	}

	public function get_rate()
	{
		echo '<pre>';print_r(D('Common/Systemconfig')->get_rate());die;
	}
}