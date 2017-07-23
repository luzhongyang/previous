<?php
namespace Common\Model;
use Think\Model;
class UsermoneylogModel extends CommonModel{

    protected $pk = 'id';
    protected $tableName = 'user_money_log';

    public function log($user_id, $data) {
		if(!$user_id = (int)$user_id) {
			return false;
		}else if(!$data['change_val'] = (float)$data['change_val']) {
			return false;
		}else if(!$data['intro']) {
			return false;
		}else {
			$data['user_id'] = $user_id;
			$data['created_time'] = time();
			return $this->add($data);
		}
	}
}