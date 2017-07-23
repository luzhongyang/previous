<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff extends Ctl
{

    public function __construct(&$system)
    {
        parent::__construct($system);
        if($this->request['ctl'] != 'staff/staff'){
        	$this->check_login();
        }        
    }
	
	/**
	 * 服务人员类型列表
	 */
	public function type()
	{
		$type = array(
			'house'  => '家政',
			'paotui' => '跑腿',
			'weixiu' => '家政'
		);
        $this->msgbox->set_data('data', $type);
	}


	/** 
	 * 服务分类
	 * @param $from
	 */
	public function cate($params)
	{
		if(!$from = $params['from']){
			$this->msgbox->add('参数不正确',200);
		}else if(!in_array($from, array('house','paotui','weixiu'))){
			$this->msgbox->add('非法操作',201);
		}else{
			$items = array();
			switch($from){
				case 'house': 
					$items = K::M('house/cate')->items(array('parent_id'=>'>:0'));
				break;
				case 'paotui': 
					$items = K::M('paotui/cate')->fetch_all();
				break;
				case 'weixiu': 
					$items = K::M('weixiu/cate')->items(array('parent_id'=>'>:0'));
				break;
			}
			$this->msgbox->set_data('data', array('items'=>array_values($items)));
		}
	}
}

class Ctl_Staff_Staff extends Ctl_Staff{}