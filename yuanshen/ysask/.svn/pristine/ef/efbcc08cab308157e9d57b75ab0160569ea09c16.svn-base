<?php
/**
* 短信模板配置
*/
namespace Admin\Controller;
use Think\Controller;
class SmstplController extends CommonController {

	public function set()
	{
		if(IS_POST) {
			$data_edit = I('post.data_edit');
			$data_add = I('post.data_add');
			if(is_array($data_edit) && !$data_add) {
				$data = $data_edit;
			}else if(is_array($data_add) && !$data_edit) {
				$data = $data_add;
			}else if(is_array($data_add) && is_array($data_edit)) {
				$data = array_merge($data_edit,$data_add);
			}
			$key_count = $title_count = $smsid_count = 0;
			foreach($data as $k=>$v) {
				// if(!$v['key']) {
				// 	$key_count ++;
				// }
				// if(!$v['title']) {
				// 	$title_count ++;
				// }
				// if(!$v['smsid']) {
				// 	$smsid_count ++;
				// }
				if(!$v['key'] && !$v['title'] && !$v['smsid']) {
					unset($data[$k]);
				}
			}
			// if($key_count > 0) {
			// 	$this->error('模板标识不能为空');
			// }
			// if($title_count > 0) {
			// 	$this->error('模板名称不能为空');
			// }
			// if($smsid_count > 0) {
			// 	$this->error('模板ID不能为空');
			// }
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$Setting_config["sms_tpl"] = $data;
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = ".var_export($Setting_config, TRUE).";\r\n?>";
			file_put_contents("Data/Conf/config.ini.php",$config);
			$this->success('操作成功',U('smstpl/set'));
		}else {
			require "Data/Conf/config.ini.php";
			$Setting_config = $array;
			$list = $Setting_config['sms_tpl'];
			$this->assign('list',$list);
			$this->display();
		}
	}
}