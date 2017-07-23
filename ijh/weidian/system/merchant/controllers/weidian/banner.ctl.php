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
class Ctl_Weidian_Banner extends Ctl_Weidian
{
    
    /**
     * 轮播广告列表
     */
    public function index($page=1,$orderby=0)
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['audit'] == 1){
                $filter['audit'] = 1;
            }else if($SO['audit'] == 0){
                $filter['audit'] = 0;
            }else if($SO['audit'] == 2) {
                $filter['audit'] = array(0,1);
            }
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $this->pagedata['orderby'] = $orderby;
        if($orderby){
            $orderby = array('banner_id'=>'asc');
        }else{
            $orderby = array('banner_id'=>'desc');
        }
        if($items = K::M('weidian/banner')->items($filter, $orderby, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink("merchant/weidian/banner:index", array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/banner/index.html';
    }

    /**
     * 创建轮播
     */
    public function create(){
        $this->check_weidian();
        if($data = $this->checksubmit('data')){
            if(!$data['title']) {
                $this->msgbox->add('请填写广告标题',210)->response();
            }else if(!$data['photo']){
                $this->msgbox->add('请上传图片',211)->response();
            }else if(!$data['link']) {
                $this->msgbox->add('请填写广告链接',212)->response();
            }
            $data['title'] = strip_tags($data['title']);
            $data['shop_id'] = $this->shop_id;
            if($id = K::M('weidian/banner')->create($data,true)){
                $this->msgbox->add('添加轮播广告成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian/banner/index:index'));
            }else{
                $this->msgbox->add('添加轮播广告失败');
            } 
        }else{
           $this->tmpl = 'merchant:weidian/banner/create.html';
        }   
    }
    
    
    /**
     * 编辑轮播
     */
    public function edit($banner_id){
        $this->check_weidian();
        if(!$detail = K::M('weidian/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            if(K::M('weidian/banner')->update($banner_id, $data)){
                $this->msgbox->add('修改内容成功');
                //$this->msgbox->set_data('forward', $this->mklink('merchant/weidian/banner/index:index'));
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weidian/banner/edit.html';
        }
    }
    
    /**
     * 设置状态
     */
     public function audit($banner_id,$status){
        $this->check_weidian();
        if(!$detail = K::M('weidian/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if(!in_array($status,array(0,1))){
            $this->msgbox->add('错误',212);
        }else{
            if(K::M('weidian/banner')->update($banner_id,array('audit'=>$status))){
                $this->msgbox->add('设置成功');
            }
        }
    }
    
    /**
     * 删除轮播
     */
    public function delete($banner_id){
        $this->check_weidian();
        if(!$detail = K::M('weidian/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else{
            if(K::M('weidian/banner')->delete($banner_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    public function dels(){
        $this->check_weidian();
        if (!$ids = $this->GP('ids')) {
            $this->msgbox->add('请选择产品', 210);
        } else {
            foreach ($ids as $v) {
                K::M('weidian/banner')->delete($v);
            }
            $this->msgbox->add('删除内容成功');
        }
    }
    
    public function so(){
        $this->check_weidian();
        $this->tmpl = 'merchant:weidian/banner/so.html';
    }
}
