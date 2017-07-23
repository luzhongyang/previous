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
            'paotui' => '外卖/跑腿',
        );
        $this->msgbox->set_data('data', $type);
    }

    /**
     * 服务分类
     * @param $from
     */
    public function cate($params)
    {
        $params['from'] = 'paotui';
        if(!$from = $params['from']){
            $items = array();
            switch($from){
                case 'house':
                    $items = K::M('house/cate')->items(array('parent_id' => '>:0'));
                    break;
                case 'paotui':
                    $items = K::M('paotui/cate')->items();
                    break;
                case 'weixiu':
                    $items = K::M('weixiu/cate')->items(array('parent_id' => '>:0'));
                    break;
                default:
                    $items = K::M('paotui/cate')->items();
            }
            $this->msgbox->set_data('data', array('items' => array_values($items)));
        }
    }

}

class Ctl_Staff_Staff extends Ctl_Staff
{
    
}
