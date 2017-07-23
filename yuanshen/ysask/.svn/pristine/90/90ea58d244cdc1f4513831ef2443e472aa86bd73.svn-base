<?php
namespace Install\Controller;
use Think\Controller;
class IndexController extends Controller{
	public function _initialize(){
		if (file_exists('./Data/install.lock')) {
			$this->error('程序已经安装,如需重新安装请删除data/install.lock文件','/');
		}
	}

	public function index(){
		/* 步骤确认 */
		$step = I('get.step', 1);
		$step = ($step < 1 || $step > 5) ? 1 : $step;
		$this->assign('step', $step);
		$action = '_step' . $step;
		$this->$action();
	}

	/* 步骤一：协议确认 */
	protected function _step1(){
		if (IS_POST) {
			if (I('post.agree') != 1) {
				$this->error('请先同意该系统协议方可安装');
			}
			session('step1', 'ok');
			redirect(U('index/index', array('step' => 2)));
		}
		$this->display('Index/step1');
	}

	/* 步骤二：环境确认 */
	protected function _step2(){
		$this->stepCheck(1);
		/* 目录可写检测 */
		$dirCheck = array(
			APP_PATH . 'Common/Conf/',
			'./Uploads/',
			DATA_PATH,
			RUNTIME_PATH,
		);

		if (IS_POST){
			foreach ($dirCheck as $item) {
				if (!is_writable($item)) {
					$this->error('目录：'.$item.'不可写，请检查权限');
				}
			}
			if (!function_exists('imagecreatetruecolor')) {
				$this->error('当前环境不支持GD库，请配置正确环境');
			}
			session('step2', 'ok');
			redirect(U('index/index', array('step' => 3)));
		}
		$this->assign('dirCheck', $dirCheck);
		$this->display('Index/step2');
	}

	/* 步骤三：数据库信息安装 */
	protected function _step3(){
		$this->stepCheck(2);

		if (IS_POST) {
			$post = I('post.');
			//if ($post['db_host'] == '' || $post['db_user'] == '' || $post['db_pass'] == '' || $post['db_name'] == '') {
			if ($post['db_host'] == '' || $post['db_user'] == '' || $post['db_name'] == '') {
				$this->error('请输入完整的数据库信息');
			}

			$res = mysqli_connect($post['db_host'], $post['db_user'], $post['db_pass'], $post['db_name']);
			if (!$res) {
				$this->error('请输入正确的数据库信息');
			}
			if ($post['admin_username'] == '' || $post['admin_password'] == '' ){
				$this->error('请输入管理员信息');
			}

			/* 数据库信息写入文件 */
			$dbconfig = "<?php
			return array(
				'DB_TYPE' => 'mysql',
				'DB_HOST' => '{$post['db_host']}',
				'DB_PORT' => '3306',
				'DB_NAME' => '{$post['db_name']}',
				'DB_USER' => '{$post['db_user']}',
				'DB_PWD' => '{$post['db_pass']}',
				'DB_PREFIX' => '{$post['db_prefix']}',
			);";

			if (!file_put_contents('./Data/Conf/db.php', $dbconfig)) {
				$this->error('配置信息写入失败，请检查目录权限');
			}
			session('step3', 'ok');
			session('admin', array(
				'username' => $post['admin_username'],
				'password' => $post['admin_password'],
			));
			redirect(U('index/index', array('step' => 4)));
		}
		$this->display('Index/step3');
	}

	/* 步骤四：安装数据表 */
	protected function _step4(){
		$this->stepCheck(3);
		$rs = M();
		if (IS_AJAX) {
			/* 连接数据库 */
			$mysqli = new \mysqli(C('DB_HOST'), C('DB_USER'), C('DB_PWD'), C('DB_NAME'));
			$mysqli->query('set names utf8');
			/*if ($mysqli->connect_error) {
				$this->error('数据库连接失败');
			}*/
			$path = APP_PATH . 'Install/Data/yscms.sql';
			if (I('post.start') == 1) {
				/* 数据库安装文件检测 */
				if (!file_exists($path)) {
					$this->error('数据库安装文件不存在，请检查安装包完整性');
				}
				$this->ajaxReturn(array('status' => 1, 'info' => '数据库安装文件检测完毕'));
			}

			if (I('post.start') == 2) {
				/* 安装数据表 */
				$sql = file_get_contents($path);
//				$arr = explode(';', $sql);

				if(C('DB_PREFIX') != 'ys_'){
					$sql = str_replace('NOT EXISTS `ys_', 'NOT EXISTS `'.C('DB_PREFIX'), $sql);

					$sql = str_replace('insert  into `ys_', 'insert  into `'.C('DB_PREFIX'), $sql);

				}

				$rs->execute(trim($sql));

//				foreach ($arr as $item) {
//
//					if(C('DB_PREFIX') != 'ys_'){
//						$sql = str_replace('NOT EXISTS `ys_', 'NOT EXISTS `'.C('DB_PREFIX'), $sql);
//
//						$sql = str_replace('insert  into `ys_', 'insert  into `'.C('DB_PREFIX'), $sql);
//
//					}
//
//					$sql .= ';';
//					$rs->execute(trim($sql));

//					$error = strtolower($mysqli->error) ;
//					echo '<pre>';
//					echo $error;

//					$result = $mysqli->query($sql);
//					$error = strtolower($mysqli->error) ;
//					echo '<pre>';
//					echo $error;
//					$this->error($mysqli->query($sql) );
					/*
					if (!$r) {
						$this->_cleanDb($mysqli);
						$this->error('安装失败,错误：'.$mysqli->error, U('index/index', array('step' => 3)));
					}*/
//				}


				$this->ajaxReturn(array('status' => 1, 'info' => '数据表安装完毕'));
			}
			if (I('post.start') == 3) {
				/* 添加管理员信息 */
				$admin = session('admin');
				M()->execute('truncate table '.C('DB_PREFIX').'admin');
				$s = M('admin')->data(array('nickname' =>'超级管理员','username' => $admin['username'],'password' => substr_pwd($admin['password']),'portrait'=>'/Public/admin/images/profile_small.jpg','email'=>'admin@168282.com','create_time' => time(),'last_time' => time(),'type' => 1,'status' => 1))->add();
				if (!$s){
					$this->_cleanDb($mysqli);
					$this->error('添加管理员信息出错!', U('index/index', array('step' => 3)));
				}
				$this->ajaxReturn(array('status' => 1, 'info' => '管理员信息添加完成'));
			}
			if (I('post.start') == 4) {
				/* 安装成功 */
				session('step4', 'ok');
				$this->ajaxReturn(array('status' => 1, 'info' => U('index/index', array('step' => 5))));
			}
			exit;
		}
		$this->display('Index/step4');
	}

	/* 步骤五：生成锁文件 */
	protected function _step5(){
		$this->stepCheck(4);
		@file_put_contents('./Data/install.lock', md5(mt_rand(0, 9999)));
		$this->display('Index/step5');
	}

	/* 跳步检测 */
	protected function stepCheck($step){
		if (is_null(session('step' . $step)) || session('step' . $step) != 'ok') {
			$this->error('请不要跳过步骤操作', U('index/index', array('step' => $step)));
		}
	}

	/* 清空数据库 */
	protected function _cleanDb(Mysqli $mysqli){
		$results = $mysqli->query('show tables;');
		if ($results) {
			while ($table = $results->fetch_array()) {
				$mysqli->query('DROP TABLE IF EXISTS '.$table[0]);
			}
			$results->free();
		}
	}
}