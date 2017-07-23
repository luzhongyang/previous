<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Weidian_Huodong extends Ctl_Biz_Weidian
{
    
    /**
     * 活动列表
     */
    public function index()
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('weidian/huodong')->items($filter, array('id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/weidian/huodong/index.html';
    }
    
    /**
     * 创建活动
     */
    public function create(){
        if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['shop_id'] = $this->shop_id;
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if($id = K::M('weidian/huodong')->create($data,true)){
                $this->msgbox->add('添加活动成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/weidian/huodong/index:index'));
            }else{
                $this->msgbox->add('添加活动失败');
            } 
        }else{
           $this->tmpl = 'biz/weidian/huodong/create.html';
        }   
    }
    
    
    /**
     * 编辑活动
     */
    public function edit($id){
        if(!$detail = K::M('weidian/huodong')->detail($id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if(K::M('weidian/huodong')->update($id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $detail['stime'] = date('Y-m-d H:i:s',$detail['stime']);
            $detail['ltime'] = date('Y-m-d H:i:s',$detail['ltime']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/weidian/huodong/edit.html';
        }
    }
    
   
    /**
     * 删除活动
     */
    public function delete($id){
        if(!$detail = K::M('weidian/huodong')->detail($id)){
            $this->msgbox->add('不存在的广告',211);
        }else{
            if(K::M('weidian/huodong')->delete($id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
    
    /**
     * 设置状态
     */
     public function set_status($id){
        if(!$detail = K::M('weidian/huodong')->detail($id)){
            $this->msgbox->add('不存在的活动',211);
        }
        $status = 0;
        if($detail['display'] == 0){
            $status = 1;
        }
        //print_r($status);die;
        if($status == 1){
            $items = K::M('weidian/huodong')->items(array('shop_id'=>$this->shop_id),array('id'=>'desc'));
            $ids = array();
            foreach($items as $k => $v){
                $ids[$v['id']] = $v['id'];
            }
            K::M('weidian/huodong')->update($ids,array('display'=>0));
        }
        //print_r($status);die;
        if(K::M('weidian/huodong')->update($id,array('display'=>$status))){
            
            $this->msgbox->add('设置成功');
        }
       
    }
    
    
}
