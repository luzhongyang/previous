<?php
/**
* 网站配置
*/
namespace Admin\Controller;
use Think\Controller;
class SettingController extends CommonController{
	//系统设置
	public function index(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function index_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["banned_user"] = $_POST["banned_user"];
			$Setting_config["limit_reflesh_time"] = intval($_POST["limit_reflesh_time"]);
			$Setting_config["god_reply_num"] = intval($_POST["god_reply_num"]);
			$Setting_config["is_comment"] = intval($_POST["is_comment"]);
			$Setting_config["comment_check"] = intval($_POST["comment_check"]);
			$Setting_config["site_domain"] = intval($_POST["site_domain"]);
			//$Setting_config["ucenter"] = intval($_POST["ucenter"]);
			//$Setting_config["error_count"] = intval($_POST["error_count"]);
			//$Setting_config["error_interval"] = intval($_POST["error_interval"]);
			$Setting_config["guestbook_check"] = intval($_POST["guestbook_check"]);
			//$Setting_config["message_interval"] = intval($_POST["message_interval"]);
			$Setting_config["site_jifen"] = $_POST["site_jifen"];
			//$Setting_config["site_baidu_api"] = $_POST["site_baidu_api"];
			$Setting_config["ads_file"] = $_POST["ads_file"];
			$Setting_config["site_appkey"] = $_POST["site_appkey"];
			$Setting_config["is_publish"] = intval($_POST["is_publish"]);
			$Setting_config["good_start"] = intval($_POST["good_start"]);
			$Setting_config["good_end"] = intval($_POST["good_end"]);
			$Setting_config["bad_start"] = intval($_POST["bad_start"]);
			$Setting_config["bad_end"] = intval($_POST["bad_end"]);

			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";

			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	/*设置基础信息*/
	public function site(){
		require "Data/Conf/config.ini.php";
		$webtpl = "./Theme/Pc/*";
		$list1 = glob($webtpl);
		foreach ($list1 as $i => $file ) {
			$webdir[$i]["filename"] = basename($file);
		}
		$waptpl = "./Theme/Wap/*";
		$list2 = glob($waptpl);
		foreach ($list2 as $i => $file ) {
			$wapdir[$i]["filename"] = basename($file);
		}
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->assign("wapdir", $wapdir);
		$this->assign("webdir", $webdir);
		$this->display();
	}
	public function site_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["site_title"] = $_POST["site_title"];
			$Setting_config["site_name"] = $_POST["site_name"];
			$Setting_config["site_url"] = $_POST["site_url"];
			$Setting_config["site_murl"] = $_POST["site_murl"];
			$Setting_config["site_seotitle"] = $_POST["site_seotitle"];
			$Setting_config["site_keyword"] = $_POST["site_keyword"];
			$Setting_config["site_description"] = $_POST["site_description"];
			$Setting_config["site_logo"] = $_POST["site_logo"];
			$Setting_config["site_qrcode"] = $_POST["site_qrcode"];
			//$Setting_config["site_url_password"] = $_POST["site_url_password"];
			$Setting_config["site_webtype"] = $_POST["site_webtype"];
			$Setting_config["site_waptype"] = $_POST["site_waptype"];					
			$Setting_config["site_email"] = $_POST["site_email"];
			$Setting_config["site_icp"] = $_POST["site_icp"];
			$Setting_config["site_tongji"] = $_POST["site_tongji"];
			$Setting_config["site_copyright"] = $_POST["site_copyright"];
			$Setting_config["site_status"] = intval($_POST["site_status"]);
			$Setting_config["site_colse"] = $_POST["site_colse"];			
			//保存配置
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			//保存PC端风格配置
			$webconfig["DEFAULT_THEME"] = $_POST["site_webtype"];
			$webconfig = "<?php\r\nreturn ".var_export($webconfig, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/webtpl.php",$webconfig);
			//保存WAP端风格配置
			$wapconfig["DEFAULT_THEME"] = $_POST["site_waptype"];
			$wapconfig = "<?php\r\nreturn ".var_export($wapconfig, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/waptpl.php",$wapconfig);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	/*采集接口设置*/
	public function caiji(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function caiji_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["caiji_authorize"] = $_POST["caiji_authorize"];
			$Setting_config["caiji_userid"] = $_POST["caiji_userid"];
			$Setting_config["caiji_open"] = intval($_POST["caiji_open"]);
			//$Setting_config["caiji_autopic"] = intval($_POST["caiji_autopic"]);
			//$Setting_config["caiji_autoimg"] = intval($_POST["caiji_autoimg"]);
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	/*上传参数设置*/
	public function upload(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function upload_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["upload_size"] = intval($_POST["upload_size"]);
			$Setting_config["upload_img"] = $_POST["upload_img"];
			$Setting_config["upload_video"] = $_POST["upload_video"];
			$Setting_config["upload_file"] = $_POST["upload_file"];
			$Setting_config["upload_path"] = $_POST["upload_path"];
			$Setting_config["upload_style"] = $_POST["upload_style"];
			$Setting_config["upload_http"] = $_POST["upload_http"];
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//存储方式
	public function file(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function file_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["file_type"] = intval($_POST["file_type"]);
			//七牛云配置
			$Setting_config["qiniu_access_key"] = $_POST["qiniu_access_key"];
			$Setting_config["qiniu_secret_key"] = $_POST["qiniu_secret_key"];
			$Setting_config["qiniu_siteurl"] = $_POST["qiniu_siteurl"];
			$Setting_config["qiniu_sitename"] = $_POST["qiniu_sitename"];
			$Setting_config["qiniu_imgstyle1"] = $_POST["qiniu_imgstyle1"];
			$Setting_config["qiniu_imgstyle2"] = $_POST["qiniu_imgstyle2"];
			$Setting_config["qiniu_imgstyle3"] = $_POST["qiniu_imgstyle3"];
			$Setting_config["qiniu_imgstyle4"] = $_POST["qiniu_imgstyle4"];
			//FTP配置
			/*$Setting_config["ftp_host"] = $_POST["ftp_host"];
			$Setting_config["ftp_port"] = intval($_POST["ftp_port"]);
			$Setting_config["ftp_time"] = $_POST["ftp_time"];
			$Setting_config["ftp_user"] = $_POST["ftp_user"];
			$Setting_config["ftp_pass"] = $_POST["ftp_pass"];
			$Setting_config["ftp_dir"] = $_POST["ftp_dir"];
			$Setting_config["ftp_imgdel"] = $_POST["ftp_imgdel"];*/

			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";

			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//第三方登录KEY
	public function oauth(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function oauth_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			/*
			$host=get_host();
			$call_back = $host.'/account/';
			*/
			$Setting_config['THINK_SDK_QQ'] = array(
							'APP_KEY'    => $_POST["qq_key"],
							'APP_SEC' => $_POST["qq_secret"],
							'CALLBACK'   => C("site_url") . '/account/qqcallback',
					);
			$Setting_config['THINK_SDK_SINA'] = array(
							'APP_KEY'    => $_POST["sina_key"],
							'APP_SEC' => $_POST["sina_secret"],
							'CALLBACK'   => C("site_url") . '/account/wbcallback',
					);
			$Setting_config['THINK_SDK_QQM'] = array(
							'APP_KEY'    => $_POST["qqm_key"],
							'APP_SEC' => $_POST["qqm_secret"],
							'CALLBACK'   => C("site_murl") . '/account/qqcallback',
					);
			$Setting_config['THINK_SDK_SINAM'] = array(
							'APP_KEY'    => $_POST["sinam_key"],
							'APP_SEC' => $_POST["sinam_secret"],
							'CALLBACK'   => C("site_murl") . '/account/wbcallback',
					);

			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//水印设置
	public function watermark(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function watermark_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["water_status"] = intval($_POST["water_status"]);
			$Setting_config["water_type"] = intval($_POST["water_type"]);
			//文字水印配置
			$Setting_config["water_font"] = $_POST["water_font"];
			$Setting_config["water_font_color"] = $_POST["water_font_color"];
			//$Setting_config["water_font_font"] = $_POST["water_font_font"];
			$Setting_config["water_font_size"] = intval($_POST["water_font_size"]);
			$Setting_config["water_font_path"] = $_POST["water_font_path"];
			$Setting_config["water_alpha"] = $_POST["water_alpha"];
			//$Setting_config["water_quality"] = $_POST["water_quality"];
			$Setting_config["water_pos"] = $_POST["water_pos"];
			//图片水印配置
			$Setting_config["water_img"] = $_POST["water_img"];
			/*$Setting_config["water_img_width"] = intval($_POST["water_img_width"]);
			$Setting_config["water_img_height"] = intval($_POST["water_img_height"]);*/

			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";

			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//验证码设置
	public function checkcode(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function checkcode_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["is_checkcode"] = intval($_POST["is_checkcode"]);
			$Setting_config["checkcode_type"] = intval($_POST["checkcode_type"]);
			$Setting_config["GEETEST_ID"] = $_POST["GEETEST_ID"];
			$Setting_config["GEETEST_KEY"] = $_POST["GEETEST_KEY"];
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//会员设置
	public function usersetting(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function usersetting_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["open_register"] = intval($_POST["open_register"]);
			$Setting_config["checkemail"] = intval($_POST["checkemail"]);
			$Setting_config["showprotocol"] = intval($_POST["showprotocol"]);
			$Setting_config["protocol"] = $_POST["protocol"];
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//积分策略
	public function userstrategy(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function userstrategy_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["jifen_register"] = intval($_POST["jifen_register"]);
			$Setting_config["jifen_login"] = intval($_POST["jifen_login"]);
			$Setting_config["jifen_tougao"] = intval($_POST["jifen_tougao"]);
			$Setting_config["submit_jihuo"] = intval($_POST["submit_jihuo"]);
			$Setting_config["jifen_sing"] = intval($_POST["jifen_sing"]);
			$Setting_config["jifen_god"] = intval($_POST["jifen_god"]);
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//性能设置
	public function xingneng(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function xingneng_update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["tmpl_cache_on"] =  (bool)$_POST["tmpl_cache_on"];
			$Setting_config["html_cache_on"] =  (bool)$_POST["html_cache_on"];
			$Setting_config["html_cache_index"] = intval($_POST["html_cache_index"]);
			$Setting_config["html_cache_list"] = intval($_POST["html_cache_list"]);
			$Setting_config["html_cache_content"] = intval($_POST["html_cache_content"]);
			$Setting_config["html_cache_other"] = intval($_POST["html_cache_other"]);
			$Setting_config["html_cache_time"] =$_POST["html_cache_time"]* 3600;

			//首页静态缓存
			if (0 < $Setting_config["html_cache_index"]) {
				$Setting_config["html_cache_rules"]["index:index"] = array("{:module}/{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_index"] * 3600);
			}else {
				$Setting_config["html_cache_rules"]["index:index"] = NULL;
			}

			//栏目页静态缓存
			if (0 < $Setting_config["html_cache_list"]) {
				//首页列表
				$Setting_config["html_cache_rules"]["index:index"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//段子列表
				$Setting_config["html_cache_rules"]["index:text"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//图片列表
				$Setting_config["html_cache_rules"]["index:pic"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//GIF图片列表
				$Setting_config["html_cache_rules"]["index:gif"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//视频列表
				$Setting_config["html_cache_rules"]["index:video"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//笑点列表
				$Setting_config["html_cache_rules"]["tags:info"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//积分商城列表
				$Setting_config["html_cache_rules"]["shop:index"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//神回复列表
				$Setting_config["html_cache_rules"]["index:godreply"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//热门笑话列表
				$Setting_config["html_cache_rules"]["index:hotjoke"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//8小时热门列表
				$Setting_config["html_cache_rules"]["hot:index"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//7天热门列表
				$Setting_config["html_cache_rules"]["hot:week"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//30天热门列表
				$Setting_config["html_cache_rules"]["hot:month"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
				//用户主页列表
				$Setting_config["html_cache_rules"]["main:index"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_list"] * 3600);
			}else {
				$Setting_config["html_cache_rules"]["index:index"] = NULL;
				$Setting_config["html_cache_rules"]["index:text"] = NULL;
				$Setting_config["html_cache_rules"]["index:pic"] = NULL;
				$Setting_config["html_cache_rules"]["index:gif"] = NULL;
				$Setting_config["html_cache_rules"]["index:video"] = NULL;
				$Setting_config["html_cache_rules"]["tags:info"] = NULL;
				$Setting_config["html_cache_rules"]["shop:index"] = NULL;
				$Setting_config["html_cache_rules"]["index:godreply"] = NULL;
			}

			//内容页静态缓存
			if (0 < $Setting_config["html_cache_content"]) {
				$Setting_config["html_cache_rules"]["xiaohua:index"] = array("{:module}/{:controller}/{:action}/{id|xiaohuatype}/{id|xiaohuamenu}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_content"] * 3600);
				//积分商城内容和兑换
				$Setting_config["html_cache_rules"]["shop:detail"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_content"] * 3600);
				$Setting_config["html_cache_rules"]["shop:exchange"] = array("{:module}/{:controller}/{:action}/{\$_SERVER.REQUEST_URI|md5}", $Setting_config["html_cache_content"] * 3600);

			}else {
				$Setting_config["html_cache_rules"]["shop:detail"]  = NULL;
				$Setting_config["html_cache_rules"]["shop:exchange"]  = NULL;
			}

			//其它页静态缓存
			if (0 < $Setting_config["html_cache_index"]) {
				//关于我们
				$Setting_config["html_cache_rules"]["about:jianjie"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:gonggao"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:shengming"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:feedback"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:tougao"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:shengao"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:shengji"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["about:jifen"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["index:app"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				//注册登录
				$Setting_config["html_cache_rules"]["account:login"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
				$Setting_config["html_cache_rules"]["account:register"] = array("{:module}/{:controller}/{:action}", $Setting_config["html_cache_other"] * 3600);
			}else {
				$Setting_config["html_cache_rules"]["index:index"] = NULL;
				$Setting_config["html_cache_rules"]["about:jianjie"] = NULL;
				$Setting_config["html_cache_rules"]["about:gonggao"] = NULL;
				$Setting_config["html_cache_rules"]["about:shengming"] = NULL;
				$Setting_config["html_cache_rules"]["about:feedback"] = NULL;
				$Setting_config["html_cache_rules"]["about:tougao"] = NULL;
				$Setting_config["html_cache_rules"]["about:shengao"] = NULL;
				$Setting_config["html_cache_rules"]["about:shengji"] = NULL;
				$Setting_config["html_cache_rules"]["about:jifen"] = NULL;
				$Setting_config["html_cache_rules"]["account:login"] = NULL;
				$Setting_config["html_cache_rules"]["account:register"] = NULL;
			}
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	//URL伪静态设置
	public function rewrite(){
		require "Data/Conf/rewrite.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function rewrite_update(){
		if (IS_POST) {
			require "Data/Conf/rewrite.php";
			$Setting_config = $array;
			//路由控制
			$Setting_config["URL_MODEL"] =  intval($_POST["rewrite_type"]) == 1 ? 2 : 0;
			$Setting_config["URL_ROUTER_ON"] = true;
			$Setting_config["URL_HTML_SUFFIX"] = $_POST["html_suffix"];

			$Setting_config["rewrite_type"] = intval($_POST["rewrite_type"]);
			$Setting_config["html_suffix"] = $_POST["html_suffix"];
			$Setting_config["home_page"] = $_POST["home_page"];
			$Setting_config["joke_text"] = $_POST["joke_text"];
			$Setting_config["joke_pic"] = $_POST["joke_pic"];
			$Setting_config["joke_gif"] = $_POST["joke_gif"];
			$Setting_config["joke_video"] = $_POST["joke_video"];
			$Setting_config["joke_hotjoke"] = $_POST["joke_hotjoke"];
			$Setting_config["joke_hot_hour"] = $_POST["joke_hot_hour"];
			$Setting_config["joke_hot_week"] = $_POST["joke_hot_week"];
			$Setting_config["joke_hot_month"] = $_POST["joke_hot_month"];
			$Setting_config["joke_godreply"] = $_POST["joke_godreply"];
			$Setting_config["joke_cate"] = $_POST["joke_cate"];
			$Setting_config["joke_page"] = $_POST["joke_page"];
			$Setting_config["joke_content"] = $_POST["joke_content"];
			$Setting_config["joke_tags"] = $_POST["joke_tags"];
			$Setting_config["joke_tags_cate"] = $_POST["joke_tags_cate"];
			$Setting_config["joke_tags_page"] = $_POST["joke_tags_page"];
			$Setting_config["joke_user"] = $_POST["joke_user"];
			$Setting_config["joke_user_follows"] = $_POST["joke_user_follows"];
			$Setting_config["joke_user_fans"] = $_POST["joke_user_fans"];
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/rewrite.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

	/*清除缓存*/
	public function clearcache(){			
		clear_cache();
		$this->success("清除缓存成功！",U('admin/index/main'));
	}
}