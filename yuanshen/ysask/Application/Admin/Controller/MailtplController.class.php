<?php
/**
* 邮件模板
*/
namespace Admin\Controller;
use Think\Controller;
class MailtplController extends CommonController {
	public function _before_insert() {
		if(!$_POST['created_time']){
			$_POST['created_time'] = time();
		}
	}
}

