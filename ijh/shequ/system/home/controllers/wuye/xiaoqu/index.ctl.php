<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Xiaoqu_Index extends Ctl_Wuye
{
    
    /**
     * 绑定的小区列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['wuye_id'] = $this->wuye_id;
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/xiaoqu')->items($filter, array('xiaoqu_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/xiaoqu/index.html';
    }
    
     /**
     * 小区详情
     */
    public function detail($xiaoqu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('不存在的小区',211);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/xiaoqu/detail.html';
        }
    }
    
    /**
     * 编辑小区
     */
    public function edit($xiaoqu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('不存在的新闻',211);
        }else if($data = $this->checksubmit('data')){
            if(K::M('xiaoqu/xiaoqu')->update($xiaoqu_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/xiaoqu/edit.html';
        }
    }
   
}
