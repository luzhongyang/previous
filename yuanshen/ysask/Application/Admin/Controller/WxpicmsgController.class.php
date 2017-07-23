<?php
/**
* WxpicmsgController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;

class WxpicmsgController extends BaseController {
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
		//资源列表
		$count = D('wx_resource')->count('id');
		$page = new \Page($count,$this->pagesize);
		$resource = D('wx_resource')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		foreach ($resource as $key => $value) {
			$articles = json_decode($value['articles'],true);
			foreach ($articles as $k => $v) {
				$img = D('wx_img')->where('media_id="'.$v['thumb_media_id'].'"')->find();
				$articles[$k]['image'] = $img;
			}
			$resource[$key]['articles'] = $articles;
		}
		$page_str = $page->show();
		$this->assign('page',$page_str);
		$this->assign('resource',$resource);
		$this->display();
	}

	/**
	* 添加
	**/
	public function add(){
		$this->display();
	}
	public function insert(){
		if (IS_POST) {
			$data = $_POST;
			$articles = $data['articles'];
			$wc = new \Wechat($this->options);
			$result = $wc->uploadForeverArticles(array('articles' => $articles));
			if(isset($result['media_id'])) {
				$time = time();
				$data['created_time'] = $time;
				//$data['articles'] = json_encode($articles);
				$data['media_id'] = $result['media_id'];
				//微信获取
				$result = $wc->getForeverMedia($data['media_id']);
				$data['articles'] = json_encode($result['news_item']);

				if( D('wx_resource')->add($data)) {
					$this->success('操作成功!');
					return;
				}
			}
			$this->error('操作失败!');
			return;
		}else{
			$this->error('错误操作!');
		}
	}

	/**
	* 编辑
	**/
	public function edit(){
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error('请选择要编辑的消息！');
			return;
		}
		$resource = D('wx_resource')->find($id);
		$articles = json_decode($resource['articles'],true);
		foreach ($articles as $key => $value) {
			$img = D('wx_img')->where('media_id="'.$value['thumb_media_id'].'"')->find();
			$articles[$key]['image'] = $img;
		}
		$resource['articles'] = $articles;
		$this->assign('resource',$resource);
		$count = D('wx_img')->count('id');
		$page = new \Page($count,$this->pagesize);
		$img = D('wx_img')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$page_str = $page->show();
		$this->assign('count',$count);
		$this->assign('img',$img);
		$this->display();
	}
	public function update(){
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error('请选择要编辑的消息！');
			return;
		}
		$resource = D('wx_resource')->find($id);
		if(IS_POST) {
			if($resource) {
				$data = $_POST;
				$articles = $data['articles'];

				$wc = new \Wechat($this->options);
				$result = $wc->delForeverMedia($resource['media_id']);
				if($result) {
					//上传
					$result = $wc->uploadForeverArticles(array('articles' => $articles));
					if(isset($result['media_id'])) {
						$data['media_id'] = $result['media_id'];
						//微信获取
						$result = $wc->getForeverMedia($data['media_id']);
						$data['articles'] = json_encode($result['news_item']);

						if( D('wx_resource')->save($data)) {
							$this->success('操作成功!');
							return;
						}
					}
				}
				$this->error('操作失败!');
				return;
			}
		}else{
			$this->error('错误操作!');
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
		$resource = D('wx_resource')->find($id);
		if($resource) {
			$wc = new \Wechat($this->options);
			$result = $wc->delForeverMedia($resource['media_id']);
			if($result['errcode'] == 0) {
				D('wx_resource')->delete($id);
				$this->success('操作成功!');
				return;
			}
		}
		$this->error('操作失败!');
	}
}