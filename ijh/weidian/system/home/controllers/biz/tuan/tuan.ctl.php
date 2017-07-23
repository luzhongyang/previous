<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tuan_Tuan extends Ctl_Biz
{
    
    public function index($page=1)
    {
        $this->check_tuan();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($this->shop['have_quan']==0) {
            $filter['type'] = 'tuan';
        }else {
            $filter['type'] = array('tuan','quan');
        }
        if($items = K::M('tuan/tuan')->items($filter, array('tuan_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/tuan/tuan/index.html';
    }

    
    public function create()
    {
        $this->check_tuan();
        if($data = $this->checksubmit('data')){
            if($data['min_buy'] < 1 ) {
                $this->msgbox->add('最小购买数不能小于1',211);
            }else if($data['max_buy'] > 99) {
                $this->msgbox->add('最大购买数不能超过99',212);
            }else {
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'tuan')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }
                $data['city_id'] = $this->shop['city_id'];
                $data['shop_id'] = $this->shop_id;
                $data['stime'] = strtotime($data['stime']);
                $data['ltime'] = strtotime($data['ltime']);
                
                if($product_id = K::M('tuan/tuan')->create($data)){
                    $this->msgbox->add('添加内容成功');
                } 
            }    
        }else{
            $this->pagedata['shop'] = $this->shop;
            $this->tmpl = 'biz/tuan/tuan/create.html';
        }   
        
    }

    public function edit($tuan_id=null)
    {
        $this->check_tuan();
        if(!($tuan_id = (int)$tuan_id) && !($tuan_id = $this->GP('tuan_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if($data['min_buy'] < 1 ) {
                $this->msgbox->add('最小购买数不能小于1',211);
            }else if($data['max_buy'] > 99) {
                $this->msgbox->add('最大购买数不能超过99',212);
            }else {
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'tuan')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }
                $data['stime'] = strtotime($data['stime']);
                $data['ltime'] = strtotime($data['ltime']);
                if(K::M('tuan/tuan')->update($tuan_id, $data)){
                    $this->msgbox->add('修改内容成功');
                }  
            } 
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/tuan/tuan/edit.html';
        }       
        
    }

    public function delete($tuan_id=null)
    {
        $this->check_tuan();
        if($tuan_id = (int)$tuan_id){
            if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('tuan/tuan')->batch($tuan_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    
    public function del($tuan_id){
        $this->check_tuan();
        if(!$tuan_id = (int)$tuan_id){
            $this->error(404);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('团购不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop['shop_id']){
            $this->msgbox->add('非法操作', 212);
        }else{
            if($delete = K::M('tuan/tuan')->delete($tuan_id)){
                $this->msgbox->add('删除成功!');
            }else{
                $this->msgbox->add('删除失败', 213);
            }
        }
        
    }

    // 上架、下架
    public function onsale($tuan_id) 
    {
        $this->check_tuan();
        if(!$tuan_id = (int)$tuan_id) {
            $this->msgbox->add('商品不存在',210);
        }else if(!$tuan = K::M('tuan/tuan')->detail($tuan_id)) {
            $this->msgbox->add('商品不存在',211);
        }else if($tuan['shop_id'] != $this->shop['shop_id']) {
            $this->msgbox->add('非法操作',212);
        }else {
            if($tuan['is_onsale'] != 1) {
                if(K::M('tuan/tuan')->update($tuan_id, array('is_onsale'=>1))) {
                    $this->msgbox->add('上架成功');
                }else {
                    $this->msgbox->add('上架失败',213);
                }
            }else {
                if(K::M('tuan/tuan')->update($tuan_id, array('is_onsale'=>0))) {
                    $this->msgbox->add('下架成功');
                }else {
                    $this->msgbox->add('下架失败',213);
                }
            } 
        }
    }
     
}