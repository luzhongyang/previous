<?php
/**
* 搜索关键词管理
*/
namespace Admin\Controller;
use Think\Controller;
class XunsearchController extends CommonController{


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