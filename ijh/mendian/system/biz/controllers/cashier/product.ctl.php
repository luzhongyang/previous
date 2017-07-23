<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Product extends Ctl_Cashier_Cashier
{

     public function so()
    {

        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
        $this->tmpl = 'merchant:weidian/product/so.html';
    }

    public function index($page=1)
    {
       
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('cashier/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/cashier/product/index.html';
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
            $data['type'] = 'default';
            if($product_id = K::M('cashier/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/cashier/product:index'));
            }
        }else{
            $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
            $this->pagedata['shop_id'] = $this->shop_id;
           	$this->tmpl = 'biz/cashier/product/create.html';
        }   
    }

    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/product')->detail($product_id)){
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
            if(K::M('cashier/product')->update($product_id, $data)){
                $this->attr_group($product_id);
                $this->attr_stock($product_id);
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian/product/edit',array('args'=>$product_id)));
            }  
        }else{
            $stock_items = K::M('weidian/product/attrstock')->items(array('product_id'=>$product_id),array('attr_stock_id'=>'asc'));
            $attr_group = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id),array('attr_group_id'=>'asc'));
            $attr_group_ids = $titles = $title2s = array();
            foreach($attr_group as $k=>$v){
                $attr_group_ids[$v['attr_group_id']] = $v['attr_group_id'];
                $titles[] = $v['title'];
            }
            $jq_names = K::M('weidian/name')->items(array('title'=>$titles));
            foreach($attr_group as $k=>$v){
                foreach($jq_names as $k1=>$v1){
                    if($v['title'] == $v1['title']){
                        $attr_group[$k]['key'] = $v1['key'];
                    }
                }
            }
            $attr_value = K::M('weidian/product/attrvalue')->items(array('attr_group_id'=>$attr_group_ids),array('attr_value_id'=>'asc'));
            foreach($attr_value as $k=>$v){
                $title2s[] = $v['title'];
            }
            $jq_values = K::M('weidian/value')->items(array('title'=>$title2s));
            foreach($attr_value as $k=>$v){
                foreach($jq_values as $k1=>$v1){
                    if($v['title'] == $v1['title']){
                        $attr_value[$k]['key'] = $v1['key'];
                    }
                }
            }
            foreach($stock_items as $k=>$v){
                $stock_real_names = array_filter(explode("/", $v['stock_real_name']));
                $stock_reals = array();
                foreach($stock_real_names as $k1=>$v1){
                    foreach($attr_value as $k2=>$v2){
                        if($v1 == $v2['title']){
                            $stock_reals[] = $v2;
                        }
                    }
                }
                
                $stock_items[$k]['stock_reals'] =  $stock_reals;
            }
            //print_r($stock_items);die;
            $this->pagedata['attr_group'] = $attr_group;
            $this->pagedata['attr_value'] = $attr_value;
            $this->pagedata['stock_items'] = $stock_items;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'merchant:weidian/product/edit.html';
        }       
    }
    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('cashier/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('cashier/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

}