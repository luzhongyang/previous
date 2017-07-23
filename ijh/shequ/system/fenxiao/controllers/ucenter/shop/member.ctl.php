<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Member extends Ctl_Ucenter_Shop
{

    /**
     * 我的团队成员
     */
    public function index(){
        
        $this->tmpl = 'fenxiao/ucenter/shop/member/index.html';
    }
 
    public function loaditems($page=1){
        $filter = array();
        $filter['fenxiao'][':OR'] = array('invite2'=>$this->uid,'invite3'=>$this->uid);
        $page = max((int)$page, 1);
        $filter['shop_id'] = $this->FENXIAO['shop_id'];
        //print_r($filter);die;
        $limit = 10;
        if(!$items = K::M('fenxiao/member')->items_by_shop($filter,array('id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        //print_r($items);die;
        $sids = array();
        foreach($items as $k=>$v){
            $sids[$v['sid']] = $v['sid'];
            if($v['invite2'] == $this->uid){
                $items[$k]['level'] = '二级';
            }elseif($v['invite3'] == $this->uid){
                $items[$k]['level'] = '三级';
            }
        }
        $this->pagedata['count'] = count($items);
        $this->pagedata['fx_shops'] = K::M('fenxiao/fenxiao')->items_by_ids($sids);
        
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'fenxiao/ucenter/shop/member/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
        
    }


    
}
