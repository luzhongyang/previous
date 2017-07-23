<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Product extends Ctl_Biz
{
   
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('product/product')->items($filter, array('orderby'=>'asc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('product/cate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/product/index.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:product/product/so.html';
    }

    public function detail($product_id = null)
    {
        if(!$product_id = (int)$product_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('product/product')->detail($product_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cates'] = K::M('product/cate')->items(array('shop_id'=>$detail['shop_id']));
            $this->tmpl = 'biz/product/detail.html';
        }
    }
    

    public function create()
    { 
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            if($product_id = K::M('product/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/product:index'));

            } 
        }else{
           $this->pagedata['shop_id'] = $this->shop_id;  
           $this->pagedata['tree'] = K::M('product/cate')->tree($this->shop_id); 
           $this->tmpl = 'biz/product/create.html';
        }
    }

    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('product/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
                    if($_FILES['data']){
            foreach($_FILES['data'] as $k=>$v){
                foreach($v as $kk=>$vv){
                    $attachs[$kk][$k] = $vv;
                }
            }
            $upload = K::M('magic/upload');
            foreach($attachs as $k=>$attach){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = $upload->upload($attach, 'product')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }
        $data['price'] = abs($data['price']);
            if(K::M('product/product')->update($product_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['tree'] = K::M('product/cate')->tree($this->shop_id); 
            $this->tmpl = 'biz/product/edit.html';
        }
    }

    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('product/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 212);
            }else if(K::M('product/spec')->count(array('product_id'=>$product_id))){
                $this->msgbox->add('该商品下有规格不能删除', 213);
            }else{
                if(K::M('product/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
    
    public function spec($product_id=null) 
    { 
        $product_id = (int)$product_id;
        if($data = $this->checksubmit()) {
            if(!$data = $this->check_fields($data, 'spec_id,spec_name,price,sale_sku,spec_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                $data1 = $data2 = $datas1 = $datas2 = array();

                if($data1 = $this->checksubmit('data1')) {
                    if($_FILES['data1']){
                        foreach($_FILES['data1'] as $k=>$v){
                            foreach($v as $kk=>$vv){
                                $attachs1[$kk][$k] = $vv;
                            }
                        }
                        foreach($attachs1 as $k=>$attach1){
                            $photots1[]  =$attach1;
                        }
                    }
                    foreach($data1['spec_id'] as $k=>$v) {
                        foreach($data1['spec_name'] as $k2=>$v2) {
                            if($k == $k2) {
                                $datas1[$v]['spec_name'] = $v2;
                            }  
                        }
                        foreach($data1['price'] as $k3=>$v3) {
                            if($k == $k3) {
                                $datas1[$v]['price'] = $v3;
                            }
                        }
                        foreach($data1['sale_sku'] as $k4=>$v4) {
                            if($k == $k4) {
                                $datas1[$v]['sale_sku'] = $v4;
                            } 
                        }  
                        $up_photo1[$k]['name'] = $photots1[0]['name'][$k];
                        $up_photo1[$k]['type'] = $photots1[0]['type'][$k];
                        $up_photo1[$k]['tmp_name'] = $photots1[0]['tmp_name'][$k];
                        $up_photo1[$k]['error'] = $photots1[0]['error'][$k];
                        $up_photo1[$k]['size'] = $photots1[0]['size'][$k];
        
                        $upload = K::M('magic/upload');
                        foreach($up_photo1 as $kp=>$vp){
                            if($vp['error'] == UPLOAD_ERR_OK){
                                if($a = $upload->upload($vp, 'product')){
                                    if($k == $kp) {
                                        $datas1[$v]['spec_photo'] = $a['photo'];
                                    } 
                                }
                            }
                        }
                        $datas1[$v]['spec_id'] = $v;
                    }  
                    foreach($datas1 as $kk=>$vv) {
                        K::M('product/spec')->update($kk,$vv);  
                        $pro_spec[] = $vv['spec_id'] . ':' . (float)$vv['price'];
                    }  
                    $pro_spec = implode(',', $pro_spec);     
                }
                if($data2 = $this->checksubmit('data2')) {
                    
                    if($_FILES['data2']){
                        foreach($_FILES['data2'] as $k=>$v){
                            foreach($v as $kk=>$vv){
                                $attachs2[$kk][$k] = $vv;
                            }
                        }
                        foreach($attachs2 as $k=>$attach2){
                            $photots2[]  =$attach2;
                        }
                    }
                    foreach($data2['spec_name'] as $k=>$v) {
                        $datas2['spec_name'] = $v;
                        foreach($data2['price'] as $k2=>$v2) {
                            if($k == $k2) {
                                $datas2['price'] = $v2;
                            }
                        }
                        foreach($data2['sale_sku'] as $k3=>$v3) {
                            if($k == $k3) {
                                $datas2['sale_sku'] = $v3;
                            }
                        }
                        $up_photo2[$k]['name'] = $photots2[0]['name'][$k];
                        $up_photo2[$k]['type'] = $photots2[0]['type'][$k];
                        $up_photo2[$k]['tmp_name'] = $photots2[0]['tmp_name'][$k];
                        $up_photo2[$k]['error'] = $photots2[0]['error'][$k];
                        $up_photo2[$k]['size'] = $photots2[0]['size'][$k];
                        $upload = K::M('magic/upload');
                        foreach($up_photo2 as $kp=>$vp){
                            if($vp['error'] == UPLOAD_ERR_OK){
                                if($a = $upload->upload($vp, 'product')){
                                    $datas2['spec_photo'] = $a['photo'];
                                }
                            }
                        }
                        $datas2['product_id'] = $product_id;
                        $spec_id = K::M('product/spec')->create($datas2);
                        $pro_spec2[] = $spec_id . ':' . (float)$datas2['price'];
                    }     
                }   
                K::M('product/product')->update($product_id, array('is_spec'=>1));
                $this->msgbox->add('规格设置成功'); 
            }
        }else {
            $filter = array('product_id'=>$product_id);
            if($items = K::M('product/spec')->items($filter, array('spec_id'=>'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($product_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;

            $this->pagedata['product_id'] = $product_id;
            $this->tmpl = 'biz/product/spec.html';
        } 
    }

    public function spec_del($spec_id, $product_id)
    {
        if($spec_id = (int)$spec_id){
            if(!$detail = K::M('product/spec')->detail($spec_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['product_id'] != $product_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('product/spec')->delete($spec_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}