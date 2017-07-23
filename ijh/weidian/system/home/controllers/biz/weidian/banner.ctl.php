<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Weidian_Banner extends Ctl_Biz_Weidian
{

    /**
     * 轮播广告列表
     */
    public function index()
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('weidian/banner')->items($filter, array('banner_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/weidian/banner/index.html';
    }

    /**
     * 创建轮播
     */
    public function create(){
        if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            $data['shop_id'] = $this->shop_id;

            if($id = K::M('weidian/banner')->create($data,true)){
                $this->msgbox->add('添加轮播广告成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/weidian/banner/index:index'));
            }else{
                $this->msgbox->add('添加轮播广告失败');
            }
        }else{
           $this->tmpl = 'biz/weidian/banner/create.html';
        }
    }


    /**
     * 编辑轮播
     */
    public function edit($banner_id){
        if(!$detail = K::M('weidian/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            $data['title'] = strip_tags($data['title']);
            if(K::M('weidian/banner')->update($banner_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/weidian/banner/edit.html';
        }
    }

    /**
     * 设置状态
     */
     public function audit($banner_id,$status){
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
        if(!$detail = K::M('weidian/banner')->detail($banner_id)){
            $this->msgbox->add('不存在的广告',211);
        }else{
            if(K::M('weidian/banner')->delete($banner_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }

}
