<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Yuyue_Zhuohao extends Ctl_Biz
{
    
   public function create($params)
   {
        if(!$data = $this->check_fields($params, 'cate_id,title,number')){
            $this->msgbox->add('参数错误', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($zhuohao_id = K::M('yuyue/zhuohao')->create($data)){
                $this->msgbox->set_data('data', array('zhuohao_id'=>$zhuohao_id));
            }
        }
   }

   public function edit($params)
   {
        if(!$zhuohao_id = (int)$params['zhuohao_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('修改的桌号不存在或已经删除', 212);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限修改该内容', 213);
        }else if(!$data = $this->check_fields($params, 'cate_id,title,number')){
            $this->msgbox->add('参数错误', 214);
        }else{
            if(K::M('yuyue/zhuohao')->update($zhuohao_id, $data)){
                $this->msgbox->set_data('data', array('zhuohao_id'=>$zhuohao_id));
            }
        }
   }

   public function delete($params)
   {
        if(!$ids = K::M('verify/check')->ids($params['zhuohao_id'])){
            $this->msgbox->add('未指删除的内容', 211);
        }else if(!$items = K::M('yuyue/zhuohao')->items_by_ids($ids)){
            $this->msgbox->add('未指删除的内容', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                } 
            }
            if($del_ids){
                K::M('yuyue/zhuohao')->delete($del_ids);
            }
            $this->msgbox->add('success');
        }
   }

   public function items($params)
   {
        $filter = array('shop_id'=>$this->shop_id);
        if($cate_id = (int)$params['cate_id']){
            $filter['cate_id'] = $cate_id;
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('yuyue/zhuohao')->items($filter, null, $page, $limit)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
   }

   public function detail($params)
   {
        if(!$zhuohao_id = (int)$params['zhuohao_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('桌号不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限删除改内容', 213);
        }else{
            $detail['cate_title'] = '其它';
            if($cate = K::M('yuyue/zhuohaocate')->detail($detail['cate_id'])){
                if($cate['shop_id'] == $this->shop_id){
                    $detail['cate_title'] = $cate['title'];
                }
            }
            $this->msgbox->set_data('data', array('zhuohao_detail'=>$detail));
        }
   }


   public function createCate($params)
   {
        if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add('参数错误', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($cate_id = K::M('yuyue/zhuohaocate')->create($data)){
                $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
            }
        }    
   }

   public function editCate($params)
   {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$cate = K::M('yuyue/zhuohaocate')->detail($cate_id)){
            $this->msgbox->add('修改的分类不存在或已经删除', 212);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限修改内容', 213);
        }else if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add('参数错误', 214);
        }else{
            if(K::M('yuyue/zhuohaocate')->update($cate_id, $data)){
                $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
            }
        }
   }

   public function deleteCate($params)
   {
        if(!$ids = K::M('verify/check')->ids($params['cate_id'])){
            $this->msgbox->add('未指删除的内容', 211);
        }else if(!$items = K::M('yuyue/zhuohaocate')->items_by_ids($ids)){
            $this->msgbox->add('未指删除的内容', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['cate_id']] = $v['cate_id'];
                } 
            }
            if($del_ids){
                $zhuohao_ids = array();
                if($items = K::M('yuyue/zhuohao')->items(array('cate_id'=>$del_ids, 'shop_id'=>$this->shop_id), null, 1, 500)){
                    foreach($items as $v){
                        $zhuohao_ids[$v['cate_id']] = $v['cate_id'];
                    }
                }
                if(K::M('yuyue/zhuohaocate')->delete($del_ids)){
                    if($zhuohao_ids){
                        K::M('yuyue/zhuohao')->delete($zhuohao_ids);
                    }
                }
            }
            $this->msgbox->add('success');
        }
   }

   public function cateDetail($params)
   {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$cate = K::M('yuyue/zhuohaocate')->detail($cate_id)){
            $this->msgbox->add('修改的分类不存在或已经删除', 212);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限删除改内容', 213);
        }else{
            $this->msgbox->set_data('data', array('cate_detail'=>$cate));
        }
   }

   public function cateItems($params)
   {
        $tree = array();
        if($cate_list = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id))){
            foreach($cate_list as $v){
                $v['childrens'] = array();
                $tree[$v['cate_id']] = $v;
            }
        }
        if($items = K::M('yuyue/zhuohao')->items(array('shop_id'=>$this->shop_id), null, 1, 500)){
            $other_items = array();
            foreach($items as $v){
                if($tree[$v['cate_id']]){
                    $tree[$v['cate_id']]['childrens'][] = $v;
                }else{
                    $other_items[] = $v;
                }
            }
            if(!empty($other_items)){
                //$tree['-1'] = array('cate_id'=>0, 'title'=>'其它','childrens'=>$other_items); //2016年10月24日10:23:43 cate_id==0导致删除分类的时候导致走报错跳转流程
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
   }
}