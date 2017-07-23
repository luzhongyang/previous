<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_News_Index extends Ctl_Wuye
{
    
    /**
     * 新闻列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/news')->items($filter, array('news_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/news/index.html';
    }
    
    /**
     * 创建新闻
     */
    public function create(){
        $this->check_wuye_bind_xiaoqu();
        if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['intro'] = strip_tags($data['intro']);
            $data['content'] = strip_tags($data['content']);
            if($news_id = K::M('xiaoqu/news')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/news/index:index'));
            } 
        }else{
           $this->tmpl = 'wuye/news/create.html';
        }   
    }
    
    /**
     * 新闻详情
     */
    public function detail($news_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/news')->detail($news_id)){
            $this->msgbox->add('不存在的新闻',211);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/news/detail.html';
        }
    }
    
    /**
     * 编辑新闻
     */
    public function edit($news_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/news')->detail($news_id)){
            $this->msgbox->add('不存在的新闻',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['intro'] = strip_tags($data['intro']);
            $data['content'] = strip_tags($data['content']);
            if(K::M('xiaoqu/news')->update($news_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/news/edit.html';
        }
    }
    
    /**
     * 删除新闻
     */
    public function delete($news_id){
        $this->check_wuye_bind_xiaoqu();
        
        if(!$detail = K::M('xiaoqu/news')->detail($news_id)){
            $this->msgbox->add('不存在的新闻',211);
        }else{
            if(K::M('xiaoqu/news')->delete($news_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
}
