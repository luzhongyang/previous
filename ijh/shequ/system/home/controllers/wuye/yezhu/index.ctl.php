<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Yezhu_Index extends Ctl_Wuye
{
    
    /**
     * 业主列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/yezhu')->items($filter, array('xiaoqu_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/yezhu/index.html';
    }
    
    /**
     * 业主详情
     */
    public function detail($yezhu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('不存在的业主',211);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/yezhu/detail.html';
        }
    }
    
    /**
     * 创建业主
     */
    public function create(){
        $this->check_wuye_bind_xiaoqu();
        if($data = $this->checksubmit('data')){
            $data['audit'] = 1;
            if($yezhu_id = K::M('xiaoqu/yezhu')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/yezhu/index:index'));
            } 
        }else{
           $this->tmpl = 'wuye/yezhu/create.html';
        }   
        
    }
    
    /**
     * 编辑业主
     */
    public function edit($yezhu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('不存在的业主',211);
        }else if($data = $this->checksubmit('data')){
            if(K::M('xiaoqu/yezhu')->update($yezhu_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/yezhu/edit.html';
        }
    }
    
    /**
     * 删除业主
     */
    public function delete($yezhu_id){
        $this->check_wuye_bind_xiaoqu();
        
        if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('不存在的业主',211);
        }else{
            if(K::M('xiaoqu/yezhu')->delete($yezhu_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
    /**
     * 设置状态
     */
     public function set_audit($yezhu_id,$audit){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('不存在的业主',211);
        }else if(!in_array($audit,array(-1,0,1))){
            $this->msgbox->add('错误',212);
        }else{
            if(K::M('xiaoqu/yezhu')->update($yezhu_id,array('audit'=>$audit))){
                $this->msgbox->add('设置成功');
            }
        }
    }
    
}
