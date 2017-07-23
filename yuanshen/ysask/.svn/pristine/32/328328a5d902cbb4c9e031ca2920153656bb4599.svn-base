<?php
/**
* 微信配置
*/
namespace Admin\Controller;
use Think\Controller;
class WxsettingController extends CommonController{
	public function index(){
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->Setting_config=$Setting_config;
		$this->display();
	}
	public function update(){
		if (IS_POST) {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["wx_turn"] = $_POST["wx_turn"];
			$Setting_config["wx_appid"] = $_POST["wx_appid"];
			$Setting_config["wx_appsecret"] = $_POST["wx_appsecret"];
			$Setting_config["wx_token"] = $_POST["wx_token"];
			$Setting_config["wx_encodingaeskey"] = $_POST["wx_encodingaeskey"];			
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success("设置成功");
		}else{
			$this->error("操作错误！");
		}
	}

}