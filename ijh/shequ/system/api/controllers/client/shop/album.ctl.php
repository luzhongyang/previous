<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Shop_Album extends Ctl
{
    /* 商家相册
     * @param shop_id
     * @
     */
    public function item($params = null)
    {
        if(empty($params['shop_id'])){
            $this->msgbox->add('参数不正确!', 211);
        }
        $filter = array();
        if($params['type'] == 0){
            $filter['type'] = array(1,2);
        }else {
            $filter['type'] = $params['type'];
        }
        $filter['shop_id'] = $params['shop_id'];
        $limit = 9;
        $page = max((int)$params['page'], 1);
        if($items = K::M('shop/albumphoto')->items($filter,array('photo_id'=>'desc'),$page,9,$count)) {
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('photo_id,photo,type', $v);
            }
        }else {
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
}
