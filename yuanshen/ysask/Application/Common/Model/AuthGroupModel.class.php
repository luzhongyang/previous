<?php
// 角色模型
namespace Common\Model;
use Think\Model;
class AuthGroupModel extends CommonModel{
	public $_validate = array(
		array('title','require','名称必填'),
		array('title','','名称已经存在',0,'unique',3),
	);
	public $_auto=array(
		array('created_time','time',1,'function'),
		array('updated_time','time',2,'function'),
	);

	public function getRules($admin_id){
        $admin_id = (int) $admin_id;
        $row = $this->where(" admin_id = '{$admin_id}' ")->select();

        $rules = explode(',', $row[0]['rules']);
        foreach($rules as $val){
            $items[$val] = $val;
        }
        return $items;
    }
}
