<?php
namespace Common\Model;
use Think\Model;
class SearchModel extends CommonModel{

	protected $insertFields	= array('search','hits','status','created_time'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','search','hits','status','updated_time'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('search','require','搜索词必填！',3),
		array('hits','require','搜索量必填',3),
		array('hits','number','搜索量必需为数据类型',3),

	);

	// 自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);

	/**
	*建立索引
	* @param string $project 项目名称，可以是article、question、user、goods、tag
	* @param array $data 必须且只能包含id,title,description,created_time
	*/
	function addIndex($project,$data){
		//echo $project.'<br>';
		//var_dump($data);exit;
		$xs = new \XS($project);
		$index = $xs->index;
		// 创建文档对象
		$doc = new \XSDocument;
		$doc->setFields($data);
		//添加到索引数据库中
		$index->add($doc);

		return true;
	}

	/**
	*更新索引
	* @param string $project 项目名称，可以是article、question、user、goods、tag
	* @param array $data 必须且只能包含id,title,description,created_time
	*/
	function updateIndex($project,$data){
		$xs = new \XS($project);
		$index = $xs->index;
		// 创建文档对象
		$doc = new \XSDocument;
		$doc->setFields($data);
		//添加到索引数据库中
		$index->update($doc);

		return true;
	}

	/**
	*删除索引
	* @param string $project 项目名称，可以是article、question、user、goods、tag
	* @param array $ids 可以是数字或者数组array(1,2,3)批量删除
	*/
	function deleteIndex($project,$id){
		$xs = new \XS($project);
		$index = $xs->index;
		$index->del($id);
		return true;
	}

	/**
	 * 搜索
	 */
	public function search($query,$project=''){
		if(empty($project)){
			$projects = array('user','question','article','goods');
		}else{
			$projects = array($project);
		}
		$result=array();
		foreach($projects as $project){
			if(C('xunsearch_open')){
				//迅搜
				$xs = new \XS($project); // 建立 XS 对象
				$result[$project]=$xs->search->setQuery($query)->addWeight('title', $query)->search(); // 设置搜索语句
			}else{
				//检索
				$where['title'] = array('like','%'.$query.'%');
				$where['description'] = array('like','%'.$query.'%');
				$where['_logic'] = 'OR';
				$result[$project] = M($project)->where($where)->select();
			}
		}
		if(!C('xunsearch_open')){
			//默认搜索要统计检索词,xunsearch自带统计功能
			$Search = D('Search');
			$where['query'] = $query;
			$exist = $Search->where($where)->find();
			if($exist){
				//检索词已存在
				$exist['scount'] = $exist['scount']+1;
				$exist['row']= count($result);
				$exist['updated_time'] = time();
				D('search')->save($exist);
			}else{
				//添加记录
				$Search->query = $query;
				$Search->scount = 1;
				$Search->row = count($result);
				$Search->created_time = time();
				$Search->updated_time = time();
				$Search->add();
			}
		}
		return $result;
	}

	/**
	 * 热搜关键词
	 * @param string $project 项目名称，可以是article、question、user、goods、tag
	 * @param int    $limit   返回的词数上线，最大为50
	 * @param string $type    指定排序类型，默认为total总量，可选lastnum(上周)和currnum(本周)
	 * @return array $words   返回值是以搜索词为键、 搜索指数为值的关联数组
	 */
	public function get_hot_query($project='question',$limit=6,$type='total'){
		if(C('xunsearch_open')){
			$xs = new \XS($project); // 建立 XS 对象
			$search = $xs->search;
			$words = $search->getHotQuery($limit,$type); // 获取
		}else{
			$words = M('Search')->order('scount desc')->limit($limit)->select();//默认的检索只统计总量
		}

		return $words;
	}

	/**
	 * 获取相关搜索词
	 * @param string $query   搜索词
	 * @param string $project 项目名称，可以是article、question、user、goods、tag
	 * @param int    $limit   返回的词数上线，最大为20
	 * @return array $words   返回搜索词组成的数组
	 */
	public function get_related_query($query,$project='question',$limit=6){
		if(C('xunsearch_open')){
			$xs = new \XS($project); // 建立 XS 对象
			$search = $xs->search;
			$words = $search->getRelatedQuery($query,$limit); // 获取
		}else{
			$where['query'] = array('like','%'.$query.'%');
			$words = M('Search')->where($where)->order('scount desc')->limit($limit)->getField('query',true);
		}

		return $words;
	}

	/**
	 * 获取搜索建议
	 * @param string $query   搜索词
	 * @param string $project 项目名称，可以是article、question、user、goods、tag
	 * @param int    $limit   返回的词数上线，最大为20
	 * @return array $words   返回搜索词组成的数组
	 */
	function get_expanded_query($query,$project='question',$limit=10){
		if(C('xunsearch_open')){
			$xs = new \XS($project); // 建立 XS 对象
			$search = $xs->search;
			$words = $search->getExpandedQuery($query,$limit); // 获取
		}else{
			$where['query'] = array('like',$query.'%');
			$words = M('Search')->where($where)->order('scount desc')->limit($limit)->getField('query',true);
		}
		return $words;
	}

	/**
	 * 按首字母对热搜关键词进行分类
	 */
	public function sort_by_initial(){
		$querys = $this->get_hot_query('question',500);
		$result = array();
		foreach($querys as $str){
			$str = $str['query'];
			$fchar=ord($str{0});
			$s1=iconv('UTF-8','gb2312',$str);
			$s2=iconv('gb2312','UTF-8',$s1);
			$s=$s2==$str?$s1:$str;
			$asc=ord($s{0})*256+ord($s{1})-65536;
 			if($asc>=-20319&&$asc<=-20284) $result['A'][]=$str;
			if($asc>=-20283&&$asc<=-19776) $result['B'][]=$str;
			if($asc>=-19775&&$asc<=-19219) $result['C'][]=$str;
			if($asc>=-19218&&$asc<=-18711) $result['D'][]=$str;
			if($asc>=-18710&&$asc<=-18527) $result['E'][]=$str;
			if($asc>=-18526&&$asc<=-18240) $result['F'][]=$str;
			if($asc>=-18239&&$asc<=-17923) $result['G'][]=$str;
		 	if($asc>=-17922&&$asc<=-17418) $result['H'][]=$str;
  			if($asc>=-17417&&$asc<=-16475) $result['J'][]=$str;
 			if($asc>=-16474&&$asc<=-16213) $result['K'][]=$str;
 			if($asc>=-16212&&$asc<=-15641) $result['L'][]=$str;
  			if($asc>=-15640&&$asc<=-15166) $result['M'][]=$str;
 			if($asc>=-15165&&$asc<=-14923) $result['N'][]=$str;
 			if($asc>=-14922&&$asc<=-14915) $result['O'][]=$str;
 			if($asc>=-14914&&$asc<=-14631) $result['P'][]=$str;
 			if($asc>=-14630&&$asc<=-14150) $result['Q'][]=$str;
 			if($asc>=-14149&&$asc<=-14091) $result['R'][]=$str;
 			if($asc>=-14090&&$asc<=-13319) $result['S'][]=$str;
 			if($asc>=-13318&&$asc<=-12839) $result['T'][]=$str;
 			if($asc>=-12838&&$asc<=-12557) $result['W'][]=$str;
 			if($asc>=-12556&&$asc<=-11848) $result['X'][]=$str;
 	 		if($asc>=-11847&&$asc<=-11056) $result['Y'][]=$str;
 			if($asc>=-11055&&$asc<=-10247) $result['Z'][]=$str;
		}
		return $result;
	}
}