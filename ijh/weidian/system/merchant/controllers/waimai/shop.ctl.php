<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('waimai');
class Ctl_Waimai_Shop extends Ctl_Waimai
{

   public function pei()
   {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data,'min_amount,freight,pei_distance,pei_type,pei_amount,fkm,fm,sm')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if($data['fkm']){
                    $freight_stage = array();
                    foreach($data['fkm'] as $k => $v){
                        $freight_stage[$k]['fkm'] = intval($v);
                        $freight_stage[$k]['fm'] = intval($data['fm'][$k]);
                        $freight_stage[$k]['sm'] = intval($data['sm'][$k]);
                        if(!$data['fkm'][$k] || !$data['sm'][$k]){
                           unset($freight_stage[$k]['fkm']);
                           unset($freight_stage[$k]['fm']);
                           unset($freight_stage[$k]['sm']);
                        }
                    }
                }
                foreach($freight_stage as $key => $val){
                    if(!$val){
                        unset($freight_stage[$key]);
                    }
                }
                $data['freight_stage'] = serialize($freight_stage);
                K::M('waimai/waimai')->update($this->shop_id,$data);
                K::M('waimai/waimai')->update_pei_distance($this->shop_id,$data['fkm']);
                $this->msgbox->add('配送设置成功');
            }
        }else{
            $this->pagedata['detail'] = K::M('waimai/waimai')->detail($this->shop_id);
            $this->tmpl = 'merchant:waimai/shop/pei.html';
        }
    }

    
    public function have()
    {
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        $shop = K::M('shop/shop')->detail($this->shop_id);
        if($data = $this->checksubmit('data')){
            if(!$data['title'] = htmlspecialchars($data['title'])){
                $this->msgbox->add('没有填写店铺名称！',211)->response();
            }else if(!$data['logo']){
                $this->msgbox->add('没有店铺logo！',213)->response();
            }else if(!$data['cate_id'] = intval($data['cate_id'])){
                $this->msgbox->add('没有选择分类！',215)->response();
            }else if(!$data['phone'] = $data['phone']){
                $this->msgbox->add('没有填写电话！',216)->response();
            }else if(!$data['phone'] = K::M('verify/check')->mobile($data['phone'])){
                $this->msgbox->add('电话格式不正确！',217)->response();
            }else if(!$data['tmpl_type']){
                $this->msgbox->add('没有选择显示模版！',219)->response();
            }
            //K::M('waimai/waimai')->update($this->shop_id, array('tmpl_type'=>$data['tmpl_type']));
            if(!$waimai){ // 新建
                $data['shop_id'] = $this->shop_id;
                $data['addr'] = $shop['addr'];
                if($add = K::M('waimai/waimai')->create($data)){
                    $this->msgbox->add('提交成功等待管理员审核！');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/waimai/shop/have.html'));
                }else{
                    $this->msgbox->add('提交失败！',301);
                }
            }else{  //修改
                if($update = K::M('waimai/waimai')->update($waimai['shop_id'],$data)){
                    $this->msgbox->add('修改成功！');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/waimai/shop/have.html'));
                }else{
                    $this->msgbox->add('修改失败！',301);
                }
            }
            
        }else{
            if($shop['have_waimai']==1) {
                $this->pagedata['have_waimai'] = 1;
            }else {
                $this->pagedata['have_waimai'] = 0;
            }
            $waimai_cate = K::M('waimai/cate')->tree();
            $this->pagedata['waimai'] =  $waimai;
            $this->pagedata['shop'] = $shop;
            $this->pagedata['waimai_cate'] = $waimai_cate;
            $this->tmpl = 'merchant:waimai/shop/have.html';
            
        }

    }
    
    
     public function youhui()
    {
         $this->check_waimai();
        if($data = $this->checksubmit()){
            if(!$data = $this->check_fields($data, 'youhui_id,order_amount,youhui_amount,orderby,first_amount')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{

                if($data = $this->checksubmit('data')) {
                    $data['first_amount'] = intval($data['first_amount']);
                    $up = K::M('waimai/waimai')->update($this->shop_id,$data);
                }
                
                $data1 = $data2 = $datas1 = $datas2 = array();
                if($data1 = $this->checksubmit('data1')) {
                    foreach($data1['youhui_id'] as $k=>$v) {
                        foreach($data1['order_amount'] as $k2=>$v2) {
                            if($k == $k2) {
                                $datas1[$v]['order_amount'] = $v2;
                            }  
                        }
                        foreach($data1['youhui_amount'] as $k3=>$v3) {
                            if($k == $k3) {
                                $datas1[$v]['youhui_amount'] = $v3;
                            }
                        }
                        foreach($data1['orderby'] as $k4=>$v4) {
                            if($k == $k4) {
                                $datas1[$v]['orderby'] = $v4;
                            } 
                        }    
                    }  
                    foreach($datas1 as $kk=>$vv) {
                        if((int)$vv['order_amount'] == 0 && (int)$vv['youhui_amount'] == 0 ) {
                           unset($datas1[$kk]);
                        }
                    } 
                    foreach ($datas1 as $kk => $vv) {
                        K::M('waimai/youhui')->update($kk,$vv);
                        $waimai_youhui[] = (float)$vv['order_amount'].':'.(float)$vv['youhui_amount']; 
                    }
                    $waimai_youhui = implode(',', $waimai_youhui);
                      
                }
                if($data2 = $this->checksubmit('data2')) {
                    foreach($data2['order_amount'] as $k=>$v) {
                        if($v['order_amount'] > 0) {
                            $datas2['order_amount'] = $v;
                            foreach($data2['youhui_amount'] as $k2=>$v2) {
                                if($k == $k2) {
                                    $datas2['youhui_amount'] = $v2;
                                }
                            }
                            foreach($data2['orderby'] as $k3=>$v3) {
                                if($k == $k3) {
                                    $datas2['orderby'] = $v3;
                                }
                            }
                            $datas2['shop_id'] = $this->shop_id;
                            K::M('waimai/youhui')->create($datas2);
                            $waimai_youhui2[] = (float)$datas2['order_amount'].':'.(float)$datas2['youhui_amount'];
                        } 
                    } 
                    $waimai_youhui2 = implode(',', $waimai_youhui2);
                }
                K::M('waimai/waimai')->update($this->shop_id, array('youhui'=>$waimai_youhui . ',' .$waimai_youhui2));        
                $this->msgbox->add('外卖优惠设置成功'); 
            }
        }else{
            $filter = array('shop_id'=>$this->shop_id);
            if($items = K::M('waimai/youhui')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $waimai = K::M('waimai/waimai')->detail($this->shop_id);
            $this->pagedata['detail'] = $waimai;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'merchant:waimai/shop/youhui.html';
        }
    }
    
    
    public function yhdelete()
    {

        if($youhui_id = (int)$this->GP('youhui_id')){
            if(!$detail = K::M('waimai/youhui')->detail($youhui_id)){
                $this->msgbox->add('你要删除的优惠不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/youhui')->delete($youhui_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的优惠ID', 401);
        }

    }
  

}