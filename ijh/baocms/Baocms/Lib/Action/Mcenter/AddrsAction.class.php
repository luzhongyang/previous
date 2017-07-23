<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class AddrsAction extends CommonAction {

	public function index() {
		$u = D('Users');
		$ud = D('UserAddr');
                //$addr = $ud -> where('user_id='.$this->uid) -> select();
                $addr = $ud -> where(array('user_id' => $this->uid ,'closed'=>0)) -> select();
                $this->assign('addr',$addr);
                $this->mobile_title = '我的地址';
		$this->display(); // 输出模板
	}
  
}