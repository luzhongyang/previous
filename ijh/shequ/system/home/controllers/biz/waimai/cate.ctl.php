<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Cate extends Ctl_Biz_Waimai
{
    
    public function index()
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('waimai/productcate')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/waimai/cate/index.html';
    }
    
    
    public function create($parent_id=null)
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
            if($cate_id = K::M('waimai/productcate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', $this->mklink('biz/waimai:cate'));
            } 
        }else{
            $this->pagedata['cates'] = K::M('waimai/productcate')->items(array('parent_id'=>0, 'shop_id'=>$this->shop_id));
            $this->pagedata['parent_id'] = intval($parent_id);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
            $this->tmpl = 'biz/waimai/cate/create.html';
        }
        
    }

    public function edit($cate_id=null)
    {
        if(!($cate_id = (int)$cate_id) && !($cate_id = $this->GP('cate_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/productcate')->detail($cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){

            if(empty($data['title'])){
                $error = '标题为空';
                $this->msgbox->add($error, 431);
                return false;
                die;
            }
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

            if(K::M('waimai/productcate')->update($cate_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/waimai:cate'));
            }  
        }else{
            $this->pagedata['cates'] = K::M('waimai/productcate')->items(array('parent_id'=>0, 'shop_id'=>$this->shop_id));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/cate/waimai/edit.html';
        }    
    }

    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('waimai/productcate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else if(K::M('waimai/productcate')->count(array('parent_id'=>$cate_id))){
                $this->msgbox->add('该分类下有子分类不能删除', 214);
            }else if(K::M('waimai/product')->count(array('cate_id'=>$cate_id,'closed'=>0))){
                $this->msgbox->add('该分类下有商品不能删除', 215);
            }else{
                if(K::M('waimai/productcate')->delete($cate_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    
    
    public function product()
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('waimai/product')->items($filter, array('orderby'=>'asc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('waimai/productcate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
        $this->tmpl = 'biz/waimai/product/index.html';
    }
    
    
    public function open($product_id=null){
        
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else{
            if($detail['open'] == 0){
                $open = 1;
            }else{
                $open = 0;
            }
            $up = K::M('waimai/product')->update($product_id,array('open'=>$open));
            if($up){
                $this->msgbox->add('操作成功!');
            }else{
                $this->msgbox->add('操作失败!',300);
            }
        }
    }
        
    public function product_create()
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
            if($data['sale_type'] == 0) {
                $data['sale_sku'] = 0;
                $data['sale_count'] = 0;
            }
            $data['spec'] = '0';
            $data['shop_id'] = $this->shop_id;
            if($product_id = K::M('waimai/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/product:waimai'));
            } 
        }else{
           $this->pagedata['shop_id'] = $this->shop_id;  
           $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
           $this->pagedata['pcates'] = K::M('waimai/productcate')->tree($this->shop_id);
           $this->tmpl = 'biz/waimai/product/create.html';
        }   
    }

    public function product_edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
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
            if(K::M('waimai/product')->update($product_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['pcates'] = K::M('waimai/productcate')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'biz/waimai/product/edit.html';
        }       
    }

    public function product_delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('waimai/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    public function wmspecs($product_id=null) 
    { 
        $product_id = (int)$product_id;
        if($data = $this->checksubmit()) {
            if(!$data = $this->check_fields($data, 'spec_id,spec_name,price,sale_sku,spec_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                $data1 = $data2 = $datas1 = $datas2 = array();
                if($data1 = $this->checksubmit('data1')) {
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
                        $datas1[$v]['spec_id'] = $v;
                    }  
                    foreach($datas1 as $kk=>$vv) {
                        K::M('waimai/productspec')->update($kk,$vv);  
                        $pro_spec[] = $vv['spec_id'] . ':' . (float)$vv['price'];
                    }  
                    $pro_spec = implode(',', $pro_spec);     
                }
                if($data2 = $this->checksubmit('data2')) {
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
                        $datas2['product_id'] = $product_id;
                        $spec_id = K::M('waimai/productspec')->create($datas2);
                        $pro_spec2[] = $spec_id . ':' . (float)$datas2['price'];
                    }     
                }   

                $pro_specs = array('spec'=>$pro_spec . $pro_spec2,'is_spec'=>1);
                K::M('waimai/product')->update($product_id, $pro_specs);
                $this->msgbox->add('规格设置成功'); 
            }
        }else {
            $filter = array('product_id'=>$product_id);
            if($items = K::M('waimai/productspec')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($product_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;

            $this->pagedata['product_id'] = $product_id;
            $this->tmpl = 'biz/waimai/product/specs.html';
        } 
    }

    public function wmspecs_del($spec_id, $product_id)
    {
        if($spec_id = (int)$spec_id){
            if(!$detail = K::M('waimai/productspec')->detail($spec_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['product_id'] != $product_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/productspec')->delete($spec_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
     
}