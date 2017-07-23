<?php
/**
* 短信配置
*/
namespace Admin\Controller;
use Think\Controller;
class SmsController extends BaseController {

	/*APPKey及APPsecret*/
	public function index()
	{
		if(IS_POST) {
			require "Data/Conf/config.ini.php";
			$post = I('post.');
            $Setting_config = $array;
            $Setting_config["sms_appkey"] = intval($post["sms_appkey"]);
            $Setting_config["sms_appsecret"] = $post["sms_appsecret"];
            $Setting_config["sms_signname"] = $post["sms_signname"];
            $Setting_config["sms_tmpl"] = $post["sms_tmpl"];
            $config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
            //保存配置
            file_put_contents("Data/Conf/config.ini.php",$config);
            //	序列化存储到数据库(备份)
			// $k = 'sms';
			// $v = serialize($post);
			// $title = '短信设置';
			// D('Systemconfig')->where(array('k'=>$k))->save(array('v'=>$v,'title'=>$title,'dateline'=>time()));
            $this->success("设置成功");
		}else {
			require "Data/Conf/config.ini.php";
            $Setting_config = $array;
            $this->Setting_config=$Setting_config;
			$this->display();
		}
	}
}