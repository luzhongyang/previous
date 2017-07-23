<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cloud_Goods extends Ctl
{
    public function index($page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){
                $filter['title'] = "LIKE:%" . $SO['title'] . "%";
            }
        }
        $filter['closed'] = 0;
        if($items = K::M('cloud/goods')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }
        $cate_ids = array();
        foreach($items as $k => $v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('cloud/cate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cloud/goods/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cloud/goods/so.html';
    }
    public function detail($product_id = null)
    {
        if(!$product_id = (int) $product_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }
        else if(!$detail = K::M('cloud/goods')->detail($product_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }
        else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['cates'] = K::M('cloud/cate')->items(array('shop_id' => $detail['shop_id']));
            $this->tmpl = 'admin:cloud/goods/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'goods')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            // print_r($this->GP('photo'));die;
            if($goods_id = K::M('cloud/goods')->create($data)){
                if($photos = $this->GP('photo')){
                    //插入评价
                    foreach($photos as $k => $v){
                        $photo_data = array(
                            'goods_id' => $goods_id,
                            'photo'    => $v
                        );
                        $photo_id = K::M('cloud/photo')->create($photo_data);
                    }
                }
                //print_r($this->system->db->SQLLOG());die;
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', $this->mklink('cloud/goods:index'));
            }
        }
        else{
            $this->tmpl = 'admin:cloud/goods/create.html';
        }
    }
    public function edit($goods_id = null)
    {
        if(!($goods_id = (int) $goods_id) && !($goods_id = $this->GP('goods_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('cloud/goods')->detail($goods_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(K::M('cloud/goods')->update($goods_id, $data)){
                if($photos = $this->GP('photo')){
                    //插入评价
                    K::M('cloud/photo')->delete_by_goods_id($goods_id);
                    foreach($photos as $k => $v){
                        $photo_data = array(
                            'goods_id' => $goods_id,
                            'photo'    => $v
                        );
                        $photo_id = K::M('cloud/photo')->create($photo_data);
                    }
                }
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $this->pagedata['items'] = K::M('cloud/photo')->items(array('goods_id'=>$goods_id),array('photo_id'=>'asc'));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cloud/goods/edit.html';
        }
    }
    public function delete($goods_id = null)
    {
        if($goods_id = (int) $goods_id){
            if(!$detail = K::M('cloud/goods')->detail($goods_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('cloud/goods')->batch($goods_id, array('closed' => 1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('goods_id')){
            if(K::M('cloud/goods')->batch($ids, array('closed' => 1))){
                $this->msgbox->add('批量删除内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}
