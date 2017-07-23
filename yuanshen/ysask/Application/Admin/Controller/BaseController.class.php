<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
	protected function _initialize(){ //初始化
		$this->checklogin(); // 检查用户是否登录
		$this->total_user();// 总注册用户
		$this->today_user();// 今日注册用户
		$this->total_article();//文章总数
		$this->total_answer();//回答总数
		$this->total_content();// 总内容
		// 引入
		require APPS_PATH.'Lib/Util/Cookie.class.php';
		// 权限验证
		$Auth=new \Think\Auth();
		$rule_name = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$result = $Auth->check($rule_name,$_SESSION['userid']);
		if($_SESSION['username']==C('ADMIN_AUTH_KEY')){  //以用户名来判断是否是超级管理员，绕过验证。
			return true;
		}else{
			if(!$result){
				$this->assign('jumpUrl', \Cookie::get('_currentUrl_'));
				$this->error('没有权限访问');
			}
		}
	}

	// 空方法提示
	public function _empty(){
		header("HTTP/1.0  404  Not Found");
		$this->display('Public:404');	//加载Public下的404.html 模板
	}

	// 总用户数
	public function total_user(){
		$obj=M('user');
		$total_user=$obj->count('id');
		$this->assign('total_user',$total_user);
	}

	// 今日注册用户
	public function today_user(){
		$obj=M('user');
		$cur_date = strtotime(date('Y-m-d',time()));
		$today_user=$obj->where('created_time>='.$cur_date)->count('id');
		$this->assign('today_user',$today_user);
	}

	//	文章总数
	public function total_article()
	{
		$obj = M('Article');
		$total_article = $obj->count('id');
		$this->assign('total_article',$total_article);
	}

	//	回答总数
	public function total_answer()
	{
		$obj = M('Answer');
		$total_answer = $obj->count('id');
		$this->assign('total_answer',$total_answer);
	}

	// 总内容
	public function total_content(){
		return 20;
	}

	// 检查用户是否登录
	protected function checklogin() {
		//设置超时为30分钟
		$nowtime = time();
		$s_time = $_SESSION['logintime'];
		if (($nowtime - $s_time) > 1800){
			session(null);
			$this->error('登录超时，请重新登录', U('/Admin/login'));
		} else {
			$_SESSION['logintime'] = $nowtime;
		}
	}

	//分类解析
	protected function process_cate(&$cate,$pid=0,$level=0,$html='--'){
	    static $tree = array();
	    foreach($cate as $v){
	        if($v['pid'] == $pid){
	            $v['sort'] = $level;
	            $v['html'] = str_repeat($html,$level);
	            $tree[] = $v;
	            $this->process_cate($cate,$v['id'],$level+1);
	        }
	    }
	    return $tree;
	}

}