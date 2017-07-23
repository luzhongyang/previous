<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Near extends Ctl_Cloud
{
    
    public function index(){
        $this->tmpl = 'cloud/near/index.html';
    }
    
    
    public function loaddata($page=1){
        
        $filter = array('closed'=>0,'status'=>1);
        $page = max((int)$page, 1);
        $limit = 10;
        if($items = K::M('cloud/attr')->items($filter,array('lottery_time'=>'desc'), $page, $limit, $count)){
            $uids = $goods_id = array();
            foreach($items as $k=>$v){
                $uids[$v['win_uid']] = $v['win_uid'];
                $goods_id[$v['goods_id']] = $v['goods_id'];
            }
            if($uids){
                $users = K::M('member/member')->items_by_ids($uids);
            }
            if($goods_id){
                $goods_items = K::M('cloud/goods')->items_by_ids($goods_id);
            }
            foreach($items as $k=>$v){
                foreach($goods_items as $k1=>$v1){
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
        $this->pagedata['items'] = $items;
        //print_r($items);die;
        $this->tmpl = 'cloud/near/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    
    
}
