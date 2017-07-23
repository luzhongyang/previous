<?php
namespace Common\Model;
use Think\Model;

class UserdataModel extends Model{

	protected $pk = 'user_id';
    protected $tableName = 'user_data';

    //根据用户id计算用户安全等级
    public function get_security_lv($user_id){
    	$user_data = $this->where('user_id='.$user_id)->field('email_status,mobile_status')->find();
    	$lv = 0;
    	if($user_data['mobile_status'] == 1){
    		$lv += 40;
    	}
    	if($user_data['email_status'] == 1){
    		$lv += 30;
    	}
    	return $lv;
    }
}