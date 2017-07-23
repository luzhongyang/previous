<?php
namespace Admin\Model;
use Think\Model;
class CommonModel extends Model{

	/**
	* 根据条件禁用表数据
	* @access public
	* @param array $options 条件
	* @return boolen
	*/
	public function forbid($options,$field='status'){
		if(FALSE === $this->where($options)->setField($field,0)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	/**
	* 根据条件批准表数据
	* @access public
	* @param array $options 条件
	* @return boolen
	*/

	public function nopass($options,$field='status'){
		if(FALSE === $this->where($options)->setField($field,2)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	/**
	* 根据条件恢复表数据
	* @access public
	* @param array $options 条件
	* @return boolen
	*/
	public function resume($options,$field='status'){
		if(FALSE === $this->where($options)->setField($field,1)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	/**
	* 根据条件恢复表数据
	* @access public
	* @param array $options 条件
	* @return boolen
	*/
	public function recycle($options,$field='status'){
		if(FALSE === $this->where($options)->setField($field,0)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	public function recommend($options,$field='is_recommend'){
		if(FALSE === $this->where($options)->setField($field,1)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	public function unrecommend($options,$field='is_recommend'){
		if(FALSE === $this->where($options)->setField($field,0)){
			$this->error =  L('_OPERATION_WRONG_');
			return false;
		}else {
			return True;
		}
	}

	/**
	* 添加数据
	* @param  array $data  添加的数据
	* @return int  新增的数据id
	*/
	public function addData($data){
		// 去除键值首尾的空格
		foreach ($data as $k => $v) {
			$data[$k]=trim($v);
		}
		$id=$this->add($data);
		return $id;
	}

	/**
	* 修改数据
	* @param   array   $map    where语句数组形式
	* @param   array   $data   数据
	* @return  boolean  操作是否成功
	*/
	public function editData($map,$data){
		// 去除键值首位空格
		foreach ($data as $k => $v) {
			$data[$k]=trim($v);
		}
		$result=$this->where($map)->save($data);
		return $result;
	}

	/**
	* 删除数据
	* @param   array   $map    where语句数组形式
	* @return  boolean  操作是否成功
	*/
	public function deleteData($map){
		if (empty($map)) {
			die('where为空的危险操作');
		}
		$result=$this->where($map)->delete();
		return $result;
	}

	/**
	* 获取全部数据
	* @param  string $type  tree获取树形结构 level获取层级结构
	* @param  string $order 排序方式   
	* @return array  结构数据
	*/
	public function getTreeData($type='tree',$order='',$name='name',$child='id',$parent='pid'){
		// 判断是否需要排序
		if(empty($order)){
			$data=$this->select();
		}else{
			$data=$this->order($order.' is null,'.$order)->select();
		}
		// 获取树形或者结构数据
		if($type=='tree'){
			$data=\Org\Util\Data::tree($data,$name,$child,$parent);
		}elseif($type="level"){
			$data=\Org\Util\Data::channelLevel($data,0,'&nbsp;',$child);
		}
		return $data;
	}
}
?>