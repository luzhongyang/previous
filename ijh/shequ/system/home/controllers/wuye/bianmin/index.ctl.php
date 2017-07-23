<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Bianmin_Index extends Ctl_Wuye
{
    
    /**
     * 便民服务列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $bianmin_ids = array();
        if($items = K::M('xiaoqu/bianmin')->items($filter, array('bianmin_id'=>'desc'), $page, $limit, $count)){
            foreach($items as $k => $v){
                $bianmin_ids[$v['bianmin_id']] = $v['bianmin_id'];
            }
            if($bianmin_report = K::M('xiaoqu/bianmin/report')->items(array('bianmin_id'=>$bianmin_ids))){
                foreach($bianmin_report as $k => $v){
                    $items[$v['bianmin_id']]['report'][] = $v;
                    $items[$v['bianmin_id']]['report_count'] += 1;
                }
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/bianmin/index.html';
    }
    
    /**
     * 创建便民服务
     */
    public function create(){
        $this->check_wuye_bind_xiaoqu();
       if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['intro'] = strip_tags($data['intro']);
            if($yezhu_id = K::M('xiaoqu/bianmin')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/bianmin/index:index'));
            } 
        }else{
           $bianmin_cate = K::M('xiaoqu/bianmin/cate')->items();
            $this->pagedata['cate'] = $bianmin_cate;
            $this->tmpl = 'wuye/bianmin/create.html';
        }
    }
    
    /**
     * 编辑便民服务
     */
    public function edit($bianmin_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('不存在的便民服务',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['intro'] = strip_tags($data['intro']);
            if(K::M('xiaoqu/bianmin')->update($bianmin_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $bianmin_cate = K::M('xiaoqu/bianmin/cate')->items();
            $this->pagedata['cate'] = $bianmin_cate;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/bianmin/edit.html';
        }
    }
    
    /**
     * 便民服务详情
     */
    public function detail($bianmin_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('该服务不存在!',211);
        }else{
            //查询被举报的信息            
            $filter = $pager =  array();
            $pager['page'] = $page = max((int)$page, 1);
            $pager['limit'] = $limit = 10;
            $filter['bianmin_id'] = $detail['bianmin_id'];
            if($items = K::M('xiaoqu/bianmin/report')->items($filter, array('report_id'=>'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/bianmin/detail.html';
        }
    }
    
    /**
     * 删除便民
     */
    public function delete($bianmin_id){
        $this->check_wuye_bind_xiaoqu();
        
        if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('不存在的便民服务',211);
        }else{
            if(K::M('xiaoqu/bianmin')->delete($bianmin_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
}
