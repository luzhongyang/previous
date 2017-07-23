<?php
namespace Common\Model;
use Think\Model;

class AreaModel extends Model{

	protected $pk = 'id';
    protected $tableName = 'area';

    public function getNameByid($city_id=null)
    {
    	if($city_id = (int)$city_id) {
    		$data1 = $this->find($city_id);
    		$data2 = $this->find($data1['parent_id']);
    		return $data2['name'] . $data1['name'];
    	}
    	return false;
    }
}