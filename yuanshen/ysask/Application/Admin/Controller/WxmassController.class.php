<?php
/**
* WxmassController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;
class WxmassController extends BaseController {
	private $options = array();
	/**
	* 初始化
	*/
	protected function _initialize(){
		parent::_initialize();
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->options = array(
			'token' => $Setting_config['wx_token'],
			'encodingaeskey' => $Setting_config['wx_encodingaeskey'],
			'appid' => $Setting_config['wx_appid'],
			'appsecret' => $Setting_config['wx_appsecret']
		);
	}

	/**
	* 列表
	*/
	public function index(){
		//群发消息
		$where = 'type="mass"';
		$count = D('wx_reply')->where($where)->count('id');
		$page = new \Page($count,$this->pagesize);
		$mass = D('wx_reply')->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		foreach ($mass as $key => $value) {
			if($value['rtype'] == 2) {
				$r = D('wx_resource')->find($value['rid']);
				$articles = json_decode($r['articles'],true);
				$r['articles'] = $articles;
				$mass[$key]['resource'] = $r;
			}
		}
		$page_str = $page->show();
		$this->assign('page',$page_str);
		$this->assign('mass',$mass);
		$this->display();
	}

	public function add(){
		//资源列表
		$resource = D('wx_resource')->order('id desc')->select();
		foreach ($resource as $key => $value) {
			$articles = json_decode($value['articles'],true);
			$resource[$key]['articles'] = $articles;
		}
		$this->assign('resource',$resource);
		$this->display();
	}

	public function send() {
		if(IS_POST) {
			$data = $_POST;
			//群发消息
			$wc = new \Wechat($this->options);
			if($data['rtype'] == 1) {
				$msg = array();
				$msg['filter'] = array('is_to_all' => true);
				$msg['msgtype'] = 'text';
				$msg['text'] = array('content' => $data['content']);
			}
			if($data['rtype'] == 2) {
				if($data['rid'] == 0) {
					$this->error('请选择发送的图文素材!');
					return;
				}

				$msg = array();
				$msg['filter'] = array('is_to_all' => true);
				$msg['msgtype'] = 'mpnews';
				$resource = D('wx_resource')->find($data['rid']);
				$msg['mpnews'] = array('media_id' => $resource['media_id']);
			}
			$result = $wc->sendGroupMassMessage($msg);
			//if($result['errcode'] == 0) {
			$data['created_time'] = time();
			if(D('wx_reply')->add($data)) {
				$this->success('操作成功!');
				return;
			}
			//}
		}else{
			$this->error('操作失败!');
		}
	}

	/**
	* 删除
	*/
	public function foreverdelete() {
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error('请选择要删除的消息！');
			return;
		}
		if($id && is_array($id)) {
			$id = implode(',', $id);
		}
		D('wx_reply')->delete($id);
		$this->success('操作成功!');
	}
}