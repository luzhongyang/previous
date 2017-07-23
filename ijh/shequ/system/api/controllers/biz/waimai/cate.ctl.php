<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Cate extends Ctl_Biz_Waimai
{

    public function items($params)
    {
        $items = array();
        if($cate_list = K::M('waimai/cate')->fetch_all()){
            foreach($cate_list as $k=>$v){
                if(empty($v['parent_id'])){
                    $v['childrens'] = array();
                    $v['children'] = &$v['childrens'];
                    $items[$k] = $v;
                }
            }
            foreach($cate_list as $k=>$v){
                if($items[$v['parent_id']]){
                    $items[$v['parent_id']]['childrens'][] = $v;
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
}