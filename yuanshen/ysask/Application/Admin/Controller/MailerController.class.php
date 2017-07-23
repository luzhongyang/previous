<?php
/**
* 邮件配置
*/
namespace Admin\Controller;
use Think\Controller;
class MailerController extends BaseController {

    /*SMTP邮件设置*/
    public function index(){
        if (IS_POST) {
            require "Data/Conf/config.ini.php";
            $Setting_config = $array;
            $Setting_config["mail_model"] = intval($_POST["mail_model"]);
            $Setting_config["mail_smtp"] = $_POST["mail_smtp"];
            $Setting_config["mail_address"] = $_POST["mail_address"];
            $Setting_config["mail_loginname"] = $_POST["mail_loginname"];
            $Setting_config["mail_password"] = $_POST["mail_password"];
            $Setting_config["mail_smtp_port"] = intval($_POST["mail_smtp_port"]);
            $Setting_config["mail_fromname"] = $_POST["mail_fromname"];
            $Setting_config["mail_smtpauth"] = 'True';
            $Setting_config["mail_charset"] = 'UTF-8';
            $Setting_config["mail_ishtml"] = 'True';

            $config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";

            //保存配置
            file_put_contents("Data/Conf/config.ini.php",$config);
            //  序列化存储到数据库(备份)
            $post = $_POST;
            $k = 'mail';
            $v = serialize($post);
            $title = '邮件设置';
            D('Systemconfig')->where(array('k'=>$k))->save(array('v'=>$v,'title'=>$title,'created_time'=>time()));
            $this->success("设置成功");
        }else{
            // require "Data/Conf/config.ini.php";
            // $Setting_config = $array;
            // $this->Setting_config=$Setting_config;
            $config = D('Systemconfig')->where(array('k'=>'mail'))->find();
            $this->Setting_config = unserialize($config['v']);
            $this->display();
        }
    }
}

