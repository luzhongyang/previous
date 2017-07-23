<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Past extends Ctl_Cloud
{
    
    public function index($attr_id=null){
        if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'cloud/past/index.html';
       }
    }
    
    
    public function loaddata($page=1){
        
        $filter = array('closed'=>0,'status'=>1);
        if(!$attr_id = $this->GP('attr_id')){
         $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           $filter['goods_id'] = $detail['goods_id'];
       }
        $page = max((int)$page, 1);
        $limit = 10;
        if($items = K::M('cloud/attr')->items($filter,null, $page, $limit, $count)){
            $uids = array();
            foreach($items as $k=>$v){
                $uids[$v['win_uid']] = $v['win_uid'];
            }
            if($uids){
                $users = K::M('member/member')->items_by_ids($uids);
            }
            foreach($items as $k=>$v){
                foreach($goods as $k1=>$v1){
                    if($v['goods_id'] == $v1['goods_id']){
                        $items[$k]['goods'] = $v1;
                    }
                }
                foreach($users as $k2=>$v2){
                    if($v['win_uid'] == $v2['uid']){
                        $items[$k]['users'] = $this->filter_fields('uid,nickname,face', $v2);
                    }
                }
            }
            $count_nums = K::M('cloud/order')->member_num_count(array('uid'=>$uids,'goods_id'=>$detail['goods_id']));
            foreach($items as $k=>$v){
                foreach($count_nums as $k1=>$v1){
                    if($v['attr_id'] == $k1){
                        $items[$k]['lottery_num'] = $v1['buy_num'];
                    }
                }
            }
        }else{
            $items = array();
        }
        $count_num = K::M('cloud/attr')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['detail'] =$detail;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/past/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    
    
}
