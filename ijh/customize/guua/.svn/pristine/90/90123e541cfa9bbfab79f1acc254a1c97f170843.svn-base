<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Mall_Product extends Ctl {

    public function index($page = 1) {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if ($SO = $this->GP('SO')) {
            $pager['SO'] = $SO;
            if ($SO['product_id']) {
                $filter['product_id'] = $SO['product_id'];
            }
            if ($SO['cate_id']) {
                $filter['cate_id'] = $SO['cate_id'];
            }
            if ($SO['title']) {
                $filter['title'] = "LIKE:%" . $SO['title'] . "%";
            }
        }
        if ($items = K::M('mall/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }
        $this->pagedata['cates'] = K::M('mall/cate')->options();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:mall/product/items.html';
    }

    public function so() {
        
        $this->pagedata['cates'] = K::M('mall/cate')->options();
        $this->tmpl = 'admin:mall/product/so.html';
    }

    public function detail($product_id = null) {
        if (!$product_id = (int) $product_id) {
            $this->msgbox->add('未指定要查看内容的ID', 211);
        } else if (!$detail = K::M('mall/product')->detail($product_id)) {
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        } else {
            $cate = K::M('mall/cate')->get_cate();
            $this->pagedata['cate'] = $cate;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:mall/product/detail.html';
        }
    }

    public function create() {
        if ($data = $this->checksubmit('data')) {
            if ($_FILES['data']) {
                foreach ($_FILES['data'] as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach ($attachs as $k => $attach) {
                    if ($attach['error'] == UPLOAD_ERR_OK) {
                        if ($a = $upload->upload($attach, 'mall')) {
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if ($product_id = K::M('mall/product')->create($data)) {
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?mall/product-index.html');
            }
        } else {
            // 商品分类名称
            $cate = K::M('mall/cate')->get_cate();
            $this->pagedata['cate'] = $cate;
            $this->tmpl = 'admin:mall/product/create.html';
        }
    }

    public function edit($product_id = null) {
        if (!($product_id = (int) $product_id) && !($product_id = $this->GP('product_id'))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        } else if (!$detail = K::M('mall/product')->detail($product_id)) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        } else if ($data = $this->checksubmit('data')) {
            if ($_FILES['data']) {
                foreach ($_FILES['data'] as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach ($attachs as $k => $attach) {
                    if ($attach['error'] == UPLOAD_ERR_OK) {
                        if ($a = $upload->upload($attach, 'mall')) {
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if (K::M('mall/product')->update($product_id, $data)) {
                $this->msgbox->add('修改内容成功');
            }
        } else {
            $cate = K::M('mall/cate')->get_cate();
            $this->pagedata['cate'] = $cate;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:mall/product/edit.html';
        }
    }

    public function doaudit($product_id = null) {
        if ($product_id = (int) $product_id) {
            if (K::M('mall/product')->batch($product_id, array('audit' => 1))) {
                $this->msgbox->add('审核内容成功');
            }
        } else if ($ids = $this->GP('product_id')) {
            if (K::M('mall/product')->batch($ids, array('audit' => 1))) {
                $this->msgbox->add('批量审核内容成功');
            }
        } else {
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($product_id = null) {
        if ($product_id = (int) $product_id) {
            if (!$detail = K::M('mall/product')->detail($product_id)) {
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            } else {
                if (K::M('mall/product')->delete($product_id)) {
                    $this->msgbox->add('删除内容成功');
                }
            }
        } else if ($ids = $this->GP('product_id')) {
            if (K::M('mall/product')->delete($ids)) {
                $this->msgbox->add('批量删除内容成功');
            }
        } else {
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

}
