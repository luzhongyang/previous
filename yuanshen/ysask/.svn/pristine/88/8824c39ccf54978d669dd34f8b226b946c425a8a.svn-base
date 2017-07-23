<?php
/**
* 广告管理
*/
namespace Admin\Controller;
use Think\Controller;
class AdController extends CommonController{
	//前置操作
	public function _before_insert(){
		$array = $_POST;
		write_file('./Data/Ggjs/'.$array['name'].'.js',tojs(stripslashes(trim($array['content']))));
	}

	// 更新广告
	public function _before_update(){
		$array = $_POST;
		$rs = M("Ad");
		$data['name'] = trim($array['name']);
		$data['content'] = stripslashes(trim($array['content']));
		if(empty($data['name'])){
		    $rs->where('id='.$array['id'])->delete();
		}else{
			write_file('./Data/Ggjs/'.$data['name'].'.js',tojs($data['content']));
			$rs->save($data);
		}
	}

	// 删除广告
	public function _before_foreverdelete(){
		$rs = M("Ad");
		$where['id'] = $_GET['id'];
		$array = $rs->field('name')->where($where)->find();
		@unlink('./Data/Ggjs/'.$array['name'].'.js');
	}
}