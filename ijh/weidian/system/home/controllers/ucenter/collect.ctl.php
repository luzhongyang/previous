<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Collect extends Ctl_Ucenter
{

    /* 收藏列表
    * @param $type,收藏类型,1:店铺,2:人员
    */
    public function items($type)
    {
        $this->check_login();
        if(!$type){
           $this->msgbox->add('参数不正确', 200);
        }else if(!in_array($type, array(1,2))){
           $this->msgbox->add('参数不正确', 210);
        }else{
            if($collect_items = K::M("member/collect")->items(array('uid'=>$this->uid, 'type'=>$type, 'status'=>1))) {
                foreach($collect_items as $k=>$v) {
                    $ids[] = $v['can_id'];
                }
            }

            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
            if($type == 1) {
                $shop_items = K::M('shop/shop')->items(array('shop_id'=>$ids));
                foreach($shop_items as $k=>$item){
                   $shop_items[$k]['juli'] = K::M('helper/round')->juli($item['lng'],$item['lat'], $lng, $lat);
                   $shop_items[$k]['juli_label'] = K::M('helper/format')->juli($shop_items[$k]['juli']);
                }
                $this->pagedata['items'] = $shop_items;
                $this->tmpl = "ucenter/collect/shop.html";
            }else {
                $staff_items = K::M('staff/staff')->items(array('staff_id'=>$ids));
                $this->pagedata['items'] = $staff_items;
                $this->tmpl = "ucenter/collect/staff.html";
            }

        }
    }
    
    // 收藏
    public function collect($status, $type, $can_id)
    {
        $this->check_login();
        $data = array();
        $type = (int)$type;
        $status = (int)$status;
        $can_id = (int)$can_id;
        $detail = K::M('member/collect')->find(array('uid'=>$this->uid,'can_id'=>$can_id,'type'=>$type));
        if($detail) {
            if(K::M('member/collect')->update($detail['collect_id'],array('status'=>$status,'dateline'=>__TIME))) {
                if($status == 0) {
                    $this->msgbox->add('取消收藏成功');
                }else {
                    $this->msgbox->add('收藏成功');
                } 
            }
        }else {
            if($collect_id = K::M('member/collect')->create(array('uid'=> $this->uid,'type'=>$type,'can_id'=>$can_id,'status'=>1,'dateline'=>__TIME))) {
                $this->msgbox->add('恭喜您，收藏成功');
            }
        }
    }
}
