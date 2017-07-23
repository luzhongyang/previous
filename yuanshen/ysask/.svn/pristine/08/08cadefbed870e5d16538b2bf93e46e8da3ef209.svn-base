<?php
/**
* WxmenuController
* @version: 1.1.0
* @author: wxz.553@163.com
* @copyright © 2016 168282.com All rights reserved.
*/
namespace Admin\Controller;
class WxmenuController extends CommonController {
	//微信菜单的数据模型
	private $wx_menu_mod;
	private $menu;
	/**
	* 初始化
	*/
	protected function _initialize(){
		parent::_initialize();
		$this->wx_menu_mod = D('wx_menu');
		$this->menu = $this->get_menu();
	}

	/**
	* 列表
	*/
	public function index(){
		$this->assign('menu',$this->menu);
		$this->display();
	}

	/**
	* 新增数据
	*/
	public function add() {
		//关键词列表
		$keyword = D('wx_keyword')->order('id desc')->select();
		$this->assign('keyword',$keyword);
		$this->assign('menu_list',$this->menu);
		$this->display();
	}
	public function insert() {
		if (IS_POST) {
			$data = $this->wx_menu_mod->create();
			if($data['event_type'] == 1) {
				$data['event_content'] = json_encode(array('url' => $_POST['url']));
			}
			if($data['event_type'] == 2) {
				$data['event_content'] = json_encode(array('key' => $_POST['key']));
			}
			if($this->wx_menu_mod->add($data)) {
				$this->success("操作成功");
			}else {
				$this->error("操作失败");
			}
		}else{
			$this->error("操作失败");
		}
		
	}

	/**
	* 编辑数据
	*/
	public function edit() {
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error("请选择要编辑的菜单！");
		}
		//关键词列表
		$keyword = D('wx_keyword')->order('id desc')->select();
		$this->assign('keyword',$keyword);
		$menu = $this->wx_menu_mod->where('id='.(int)$id)->find();
		$menu['event_content'] = json_decode($menu['event_content'],true);
		$this->assign('menu',$menu);
		$this->assign('menu_list',$this->menu);
		$this->display();		
	}
	public function update() {
		$id = $_REQUEST['id'];
		if(empty($id)) {
			$this->error("请选择要编辑的菜单！");
		}
		if(IS_POST) {
			$data = $this->wx_menu_mod->create();
			if($data['event_type'] == 1) {
				$data['event_content'] = json_encode(array('url' => $_POST['url']));
			}
			if($data['event_type'] == 2) {
				$data['event_content'] = json_encode(array('key' => $_POST['key']));
			}
			//$data['event_content'] = json_encode(array('url' => $_POST['url']));
			if($this->wx_menu_mod->save($data)) {
				$this->success("操作成功");
			}else {
				$this->error("操作失败");
			}
			exit;
		}else{
			$this->error("操作失败");
		}
			
	}

	/**
	* 删除
	*/
	public function foreverdelete() {
		$id = I('get.id');
		if(empty($id)) {
			$this->error("请选择要删除的菜单！");
		}
		$this->wx_menu_mod->where('id in('.$id.') or pid in('.$id.')')->delete();
		$this->success("操作成功");
	}

	/**
	* 生成菜单
	*/
	public function createmenu() {
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;

		$options = array(
			'token' => $Setting_config['wx_token'],
			'encodingaeskey' => $Setting_config['wx_encodingaeskey'],
			'appid' => $Setting_config['wx_appid'],
			'appsecret' => $Setting_config['wx_appsecret']
		);

		$weObj = new \Wechat($options);
		//获取菜单操作:
		// $menu = $weObj->getMenu();
		//设置菜单
		$data = $this->process_menu();
		if($weObj->createMenu($data)){
			$this->success("操作成功");
		}else{
			$this->error("操作失败");
		}

	}


	/**
	* 撤销菜单
	*/
	public function cancelmenu() {
		require "Data/Conf/config.ini.php";
		$Setting_config = $array;

		$options = array(
			'token' => $Setting_config['wx_token'],
			'encodingaeskey' => $Setting_config['wx_encodingaeskey'],
			'appid' => $Setting_config['wx_appid'],
			'appsecret' => $Setting_config['wx_appsecret']
		);
		$weObj = new \Wechat($options);
		if($weObj->deleteMenu()) {
			$this->success("操作成功");
		}else{
			$this->error("操作失败");
		}

	}

	/**
	* 获取栏目
	*/
	private function get_menu() {
		$menu = $this->wx_menu_mod->order('list_sort asc,pid asc')->select();
		$menu = $this->process_cate($menu);
		return $menu;
	} 

	private function process_menu() {
		$menu = $this->menu;
		$data = array();
		$i = 0;
		foreach ($menu as $k => $v) {
			if($v['pid'] == 0 && $v['status'] == 1) {
				$data[$i]['name'] = $v['name'];
				$sub = array();
				//是否有子级
				$j = 0;
				foreach ($menu as $sk => $sv) {
					if($sv['pid'] == $v['id'] && $sv['status'] == 1) {
						$event_content = json_decode($sv['event_content'],true);
						if($sv['event_type'] == 1) {
							array_push($sub, array('type' => 'view', 'name' => $sv['name'], 'url' => $event_content['url']));
						}
						if($sv['event_type'] == 2) {
							array_push($sub, array('type' => 'click', 'name' => $sv['name'], 'key' => $event_content['key']));
						}
					$j++;
					}
				}
				if(count($sub) >= 1) {
					$data[$i]['sub_button'] = $sub;
				}else {
					$event_content = json_decode($v['event_content'],true);
					if($v['event_type'] == 1) {
						$data[$i]['type'] = 'view';
						$data[$i]['url'] = $event_content['url'];
					}
					if($v['event_type'] == 2) {
						$data[$i]['type'] = 'click';
						$data[$i]['key'] = $event_content['key'];
					}
				}
				$i++;
			}
		}
		return array('button' => $data);
	} 
}