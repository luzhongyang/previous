<?php
/**
* WxkeywordController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;
class WxkeywordController extends CommonController {
	/**
	* 列表
	*/
	public function index(){
		$count = D('wx_keyword')->count('id');
		$page = new \Page($count,$this->pagesize);
		$keyword = D('wx_keyword')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$page_str = $page->show();
		$this->assign('page',$page_str);
		$this->assign('keyword',$keyword);
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
	public function insert(){
		if (IS_POST) {
			$data = $_POST;
			if(trim($data['keyword']) != '') {
				$time = time();
				$data['created_time'] = $time;

				if( D('wx_keyword')->add($data)) {
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

	public function edit(){
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error('请选择要编辑的用户！');
			return;
		}
		$keyword = D('wx_keyword')->find($id);
		$this->assign('keyword',$keyword);
		//资源列表
		$resource = D('wx_resource')->order('id desc')->select();
		foreach ($resource as $key => $value) {
			$articles = json_decode($value['articles'],true);
			$resource[$key]['articles'] = $articles;
		}
		$this->assign('resource',$resource);
		$this->display();
	}

	public function update(){
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error('请选择要编辑的用户！');
			return;
		}
		if (IS_POST) {
			$data = $_POST;
			if(trim($data['keyword']) != '') {
				if( D('wx_keyword')->save($data)) {
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
		D('wx_keyword')->delete($id);
		$this->success('操作成功!');
	}
}