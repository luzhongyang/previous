<?php
/**
* 搜索关键词管理
*/
namespace Admin\Controller;
use Think\Controller;
class SearchController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['search'] = array('like',"%".$_REQUEST['name']."%");
	}
	public function index(){
		$this->display();
	}

	//保存配置
	public function save_setting(){
		C('xs_open',(int)I('post.xs_open'));
		C('php_path',I('post.php_path'));
		C('search_placeholder',I('search_placeholder'));
		$this->success('保存成功');
	}

	//平滑重建索引
	public function rebuild_index(){
		$projects = array('goods','user','question','article','tag');
		foreach($projects as $project){
			$xs = new \XS($project);
			$index = $xs->index;
			$index->beginRebuild();
			$result=exec(C('php_path').' ../../../vendor/hightman/xunsearch/util/Indexer.php --rebuild --source=mysql://'.C('DB_USER').':',C('DB_PWD').'@'.C('DB_HOST').'/'.C('DB_NAME').' --sql="select '.C('xs_'.$project).' from'.C('DB_PREFIX').$project.'" --project='.$project);
			$index->endRebuild();
		}
		
		$this->success('索引重建成功',U('index'));
	}

	//测试索引重建
	public function rebuild(){
		$xs = new \XS('goods');
			$index = $xs->index;
			$index->beginRebuild();
			$result=exec('/www/wdlinux/php/bin/php ../../../vendor/hightman/xunsearch/util/Indexer.php --rebuild --source=mysql://ask:ask@yuanshen@localhost/ask --sql="select id,title,description,created_time from goods" --project=goods');
			$index->endRebuild();
	}

	//清空索引
	public function clean_index(){
		$projects = array('goods','user','question','article','tag');

		foreach($projects as $project){
			$xs = new \XS($project);
			$index = $xs->index->clean();
		}

		$this->success('清空索引成功',U('index'));
	}
}