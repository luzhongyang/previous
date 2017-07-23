<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Update extends Ctl_Biz
{

    public function index($params)
    {
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        if(!$data = $this->check_fields($params, 'title,phone,cate_id,info')){
            $this->msgbox->add('非法的数据提交',212);
        }else{
            $shop = $this->shop;
            $data['shop_id'] = $this->shop_id;
            $data['city_id'] = $this->shop['city_id'];
            $data['lat'] = $shop['lat'];
            $data['lng'] = $shop['lng'];
            if(($attach = $_FILES['logo']) && ($attach['error'] == UPLOAD_ERR_OK)){
                if($a = K::M('magic/upload')->upload($attach, 'shop')){
                    $data['logo'] = $a['photo'];
                }
            }
            if($shop_id = K::M('waimai/waimai')->update($this->shop_id,$data)){
                $this->msgbox->set_data('data',array('shop_id'=>$shop_id));
                $this->msgbox->add('成功修改申请！');
            }else{
                $this->msgbox->add('修改失败！',300);
            }
        }
  
    }

}