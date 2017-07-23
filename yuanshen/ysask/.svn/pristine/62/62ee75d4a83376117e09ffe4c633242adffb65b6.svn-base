<?php
/**
* WxreplyController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;
class WxreplyController extends CommonController {
	/**
	* 列表
	*/
	public function index(){
		//关注回复
		$subscribe  = D('wx_reply')->where('type="subscribe"')->find();
		$this->assign('subscribe',$subscribe);
		//默认回复
		$default  = D('wx_reply')->where('type="default"')->find();
		$this->assign('default',$default);
		//资源列表
		$resource = D('wx_resource')->order('id desc')->select();
		foreach ($resource as $key => $value) {
			$articles = json_decode($value['articles'],true);
			$resource[$key]['articles'] = $articles;
		}
		$this->assign('resource',$resource);
		$this->display();
	}

	public function setreply() {
		if(IS_POST) {
			$data = D('wx_reply')->create();
			$reply = D('wx_reply')->where('type="'.$data['type'].'"')->find();
			if($reply) {
				if(D('wx_reply')->where('type="'.$reply['type'].'"')->save($data)) {
					$this->success("设置成功");
					return;
				}
			}else {
				if(D('wx_reply')->add($data)) {
					$this->success("设置成功");
					return;
				}
			}
		}else{
			$this->error("错误操作！");
		}
	}
}