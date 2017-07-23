<?php
/**
* WximgController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;
class WximgController extends CommonController {
	private $options = array();
		/**
		* 初始化
		*/
		protected function _initialize(){
		parent::_initialize();
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$this->options = array('token' => $Setting_config['wx_token'],
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
		$count = D('wx_img')->count();
		$page = new \Page($count,$this->pagesize);
		$img = D('wx_img')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();

		$page_str = $page->show();
		$this->assign('page',$page_str);
		$this->assign('img',$img);
		$this->display();
	}

	/**
	* 列表
	*/
	public function getlist(){
		//资源列表
		// $count = D('wx_img')->count();
		// $page = new \Think\Page($count,$this->pagesize);
		// $img = D('wx_img')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();

		// $page_str = $page->show();
		// $this->assign('page',$page_str);
		// $this->assign('img',$img);
		// $this->display();
		$count = D('wx_img')->count();
		$page = new \Page($count,$this->pagesize);
		$img = D('wx_img')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();

		$page_str = $page->show();

		if(IS_AJAX) {
			return $this->ajaxReturn(array('data' => $img,'page' => $page_str));
		}

		$this->assign('count',$count);
		$this->assign('page',$page_str);
		$this->assign('img',$img);
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
			//$data = D('wx_img')->create();
			$data = $_POST;
			if(trim($data['path']) != '') {
				$time = time();
				$data['created_time'] = $time;
				$path = '.'.$data['path'];
				$filedata = array('media' => '@'.$path);
				$wc = new \Wechat($this->options);
				$result = $wc->uploadForeverMedia($filedata,'image');
				if(isset($result['url']) && isset($result['media_id'])) {
				$data['url'] = $result['url'];
				$data['media_id'] = $result['media_id'];
					if( D('wx_img')->add($data)) {
					$this->success('操作成功!');
					return;
					}
				}
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
			$this->error('操作失败!');
			return;
		}

		if($id && is_array($id)) {
			$id = implode(',', $id);
		}

		$img = D('wx_img')->where('id in('.$id.')')->select();
		foreach ($img as $key => $value) {
			$wc = new \Wechat($this->options);
			$result = $wc->delForeverMedia($value['media_id']);
			unlink('.'.$value['path']);
		}
		D('wx_img')->delete($id);
		$this->success('操作成功!');
	}
}