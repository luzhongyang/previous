<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Share extends Ctl_Cloud
{
    
    public function index($goods_id=null)
    {
        $this->pagedata['goods_id'] = $goods_id;
        $this->tmpl = 'cloud/share/items.html';
    }

    
    public function loaddata($page=1){
        if($goods_id = (int)$this->GP('goods_id')){
            $filter = array('goods_id'=>$goods_id);
        }
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cloud/share')->items($filter,null, $page, $limit, $count)){
            $items = array();
        }
        $goods_ids = $uids = $attr_ids = $share_ids = array();
        foreach($items as $k=>$v){
            //$items[$k]['link'] = $this->mklink('cloud/share:detail',array($v['share_id']));
            //$items[$k]['link'] = "http://sq.o2o.ijh.cc/cloud/share/index.html";
            $uids[$v['uid']] = $v['uid'];
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $attr_ids[$v['attr_id']] = $v['attr_id'];
            $share_ids[$v['share_id']] = $v['share_id'];
        }
        if($uids){
            $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        }
        if($goods_ids){
            $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_ids);
        }
        if($attr_ids){
            $this->pagedata['attrs'] = K::M('cloud/attr')->items_by_ids($attr_ids);
        }
        $photos = K::M('cloud/sharephoto')->items(array('share_id'=>$share_ids));
        foreach($items as $k=>$v){
            foreach($photos as $k1=>$v1){
                if($v['share_id'] == $v1['share_id']){
                    $items[$k]['photos'][] = $v1['photo'];
                }
            }
        }
        $count_num = K::M('cloud/share')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/share/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    public function detail($share_id)
    {
        if(!$share_id = (int)$share_id){
             $this->msgbox->add('分享不存在',211);
        }elseif(!$detail = K::M('cloud/share')->detail($share_id)){
             $this->msgbox->add('分享不存在',212);
        }elseif(!$attr = K::M('cloud/attr')->detail($detail['attr_id'])){
            $this->msgbox->add('分享云购不存在',213);
        }elseif($attr['status']  !=1||$attr['share_status'] !=1 ){
            $this->msgbox->add('分享云购不存在',214);
        }else{
            $detail['user'] = K::M('member/member')->detail($detail['uid']);
            $detail['attr'] = $attr;
            $detail['goods'] = K::M('cloud/goods')->detail($attr['goods_id']);
            $detail['photos'] = K::M('cloud/sharephoto')->items(array('share_id'=>$share_id)); 
            $detail['buy_num'] = K::M('cloud/order')->member_num_count(array('uid'=>$detail['uid'],'attr_id'=>$detail['attr_id']),false);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'cloud/share/detail.html'; 
        }
        
    }


}
