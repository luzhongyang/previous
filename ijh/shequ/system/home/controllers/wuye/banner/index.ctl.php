<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Banner_Index extends Ctl_Wuye
{
    
    /**
     * 轮播广告列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        if($items = K::M('xiaoqu/banner')->items($filter, array('banner_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/banner/index.html';
    }
    
    /**
     * 创建轮播
     */
    public function create(){
        $this->check_wuye_bind_xiaoqu();
        if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            if($news_id = K::M('xiaoqu/banner')->create($data)){
                $this->msgbox->add('添加轮播广告成功');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/banner/index:index'));
            } 
        }else{
           $this->tmpl = 'wuye/banner/create.html';
        }   
    }
    
    
    /**
     * 编辑轮播
     */
    public function edit($banner_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            if(K::M('xiaoqu/banner')->update($banner_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/banner/edit.html';
        }
    }
    
    /**
     * 设置状态
     */
     public function audit($banner_id,$status){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if(!in_array($status,array(0,1))){
            $this->msgbox->add('错误',212);
        }else{
            if(K::M('xiaoqu/banner')->update($banner_id,array('audit'=>$status))){
                $this->msgbox->add('设置成功');
            }
        }
    }
    
    /**
     * 删除轮播
     */
    public function delete($banner_id){
        $this->check_wuye_bind_xiaoqu();
        
        if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else{
            if(K::M('xiaoqu/banner')->delete($banner_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
}
