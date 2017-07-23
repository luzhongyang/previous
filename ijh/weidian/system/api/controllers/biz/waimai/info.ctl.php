<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Info extends Ctl_Biz
{

    public function index($params)
    {
        if($waimai = K::M('waimai/waimai')->detail($this->shop_id)){
            $waimai = $this->filter_fields('shop_id,city_id,cate_id,phone,title,logo,addr,banner,lng,lat,pei_type,online_pay,freight_stage,pei_distance,pei_time,score,yy_status,yy_stime,yy_ltime,yy_xiuxi,is_new,info,tmpl_type', $waimai);
            $cate = K::M('waimai/cate')->detail($waimai['cate_id']);
            if($cate['parent_id'] > 0){
                $father = K::M('waimai/cate')->detail($cate['parent_id']);
            }
            $father_str = $father['title'];
            $cate_str = $cate['title'];
            if($father_str){
                $waimai['cate_str'] = $father_str.'-'.$cate_str;
            }else{
                $waimai['cate_str'] = $cate_str;
            }            
        }else{
            $waimai = array('shop_id'=>$this->shop_id);
        }
        $this->msgbox->set_data('data', $waimai);
    }

    public function settmpl($params)
    {
        if(!in_array($params['tmpl_type'], array('waimai', 'market'))){
            $this->msgbox->add('参数不正确', 211);
        }else{
            K::M('waimai/waimai')->update($this->shop_id, array('tmpl_type'=>$params['tmpl_type']));
            $this->msgbox->set_data('data', array('shop_id'=>$this->shop_id));
        }
    }

}