<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Mesg extends Ctl
{
	/**
	 * 消息列表
	 * @param $this->staff_id
	 * @param $page
	 */
	public function items($params)
	{
		$this->check_login();
		if(!$this->staff_id){
			$this->msgbox->add('参数不正确',200);
		}else{
			$page = isset($params['page']) ? $params['page'] : 1;
			$orderby = array('is_read'=>'asc', 'dateline' => 'DESC');
			$filter['staff_id'] = $this->staff_id;
			$items = K::M('staff/msg')->items($filter, $orderby, $page, 20);
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
		}
	}

	/**
	 * 将消息状态设为已读
	 * @param msg_id
	 */
	public function read($params)
	{
		$this->check_login();
		if(!$msg_id=$params['msg_id']){
			$this->msgbox->add('参数不正确',200);
		}else{
			if(K::M("staff/msg")->update($msg_id, array('is_read'=>1))){
				$this->msgbox->add('消息已读');
			}else{
				$this->msgbox->add('未知错误',201);
			}
		}
	}
}