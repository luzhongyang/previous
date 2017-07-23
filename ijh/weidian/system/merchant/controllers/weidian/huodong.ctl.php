<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Huodong extends Ctl_Weidian
{
    
    /**
     * 活动列表
     */
    public function index()
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['stime'])){if($SO['stime'][0] && $SO['stime'][1]){$a = strtotime($SO['stime'][0]); $b = strtotime($SO['stime'][1])+86400;$filter['stime'] = $a."~".$b;}}
            if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('weidian/huodong')->items($filter, array('id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/huodong/index.html';
    }
    
    /**
     * 创建活动
     */
    public function create(){
        $this->check_weidian();
        if($data = $this->checksubmit('data')){
            if(!$data['title']) {
                $this->msgbox->add('请填写活动名称',212)->response();
            }else if(!$data['stime']) {
                $this->msgbox->add('请填写活动开始时间',213)->response();
            }else if(!$data['ltime']){
                $this->msgbox->add('请填写活动结束时间',214)->response();
            }else if(!$data['link']) {
                $this->msgbox->add('请填写活动链接',215)->response();
            }
            $data['title'] = strip_tags($data['title']);
            $data['shop_id'] = $this->shop_id;
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if($id = K::M('weidian/huodong')->create($data,true)){
                $this->msgbox->add('添加活动成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian/huodong/index'));
            }else{
                $this->msgbox->add('添加活动失败');
            } 
        }else{
           $this->tmpl = 'merchant:weidian/huodong/create.html';
        }   
    }
    
    
    /**
     * 编辑活动
     */
    public function edit($id){
        $this->check_weidian();
        if(!$detail = K::M('weidian/huodong')->detail($id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            if(!$data['title']) {
                $this->msgbox->add('请填写活动名称',212)->response();
            }else if(!$data['stime']) {
                $this->msgbox->add('请填写活动开始时间',213)->response();
            }else if(!$data['ltime']){
                $this->msgbox->add('请填写活动结束时间',214)->response();
            }else if(!$data['link']) {
                $this->msgbox->add('请填写活动链接',215)->response();
            }
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            $data['title'] = strip_tags($data['title']);
            if(K::M('weidian/huodong')->update($id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian/huodong/edit',array('args'=>$id)));
            }
        }else{
            
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weidian/huodong/edit.html';
        }
    }
    
   
    /**
     * 删除活动
     */
    public function delete($id){
        $this->check_weidian();
        if(!$detail = K::M('weidian/huodong')->detail($id)){
            $this->msgbox->add('不存在的广告',211);
        }else{
            if(K::M('weidian/huodong')->delete($id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    //批量删除
    public function dels(){
        $this->check_weidian();
        if (!$ids = $this->GP('ids')) {
            $this->msgbox->add('请选择产品', 210);
        } else {
            foreach ($ids as $v) {
                K::M('weidian/huodong')->delete($v);
            }
            $this->msgbox->add('删除内容成功');
        }
    }
    
    
    /**
     * 设置状态
     */
     public function set_status($id){
        $this->check_weidian();
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
    
    public function so()
    {
        $this->check_weidian();
        $this->tmpl = 'merchant:weidian/huodong/so.html';
    }
}
