<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Print extends Ctl
{
    public function index($page)
    {
        $filter = $pager = $orderby = array();
        $pager['page'] = max(intval($page), 1);
        //$pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('plat_id'=>'desc');
        if($items = K::M('shop/print')->items($filter,$orderby,$page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }      
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/print/index.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,partner,apikey,machine_code,mkey')) {
                $this->msgbox->add('非法的数据提交',210)->response();
            }else {
                if(!$data['title']) {
                    $this->msgbox->add('请填写平台名称',211);
                }else if(!$data['partner']) {
                    $this->msgbox->add('请填写用户ID',212);
                }else if(!$data['apikey']) {
                    $this->msgbox->add('API密钥',213);
                }else if(!$data['machine_code']) {
                    $this->msgbox->add('打印机终端号',214);
                }else if(!$data['mkey']) {
                    $this->msgbox->add('打印机终端密钥',215);
                }else {
                    $data['shop_id'] = $this->shop_id;
                    if($plat_id = K::M('shop/print')->create($data)){
                        $this->msgbox->add('添加内容成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/print:index'));
                    } 
                }
            }
        }else{
            $this->tmpl = 'merchant:shop/print/create.html';
        }
    }

    public function edit($plat_id=null)
    {
        if(!$plat_id = (int)$plat_id){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('shop/print')->detail($plat_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,partner,apikey,machine_code,mkey')) {
                $this->msgbox->add('非法的数据提交',214);
            }else {
                if(!$data['title']) {
                    $this->msgbox->add('请填写平台名称',211);
                }else if(!$data['partner']) {
                    $this->msgbox->add('请填写用户ID',212);
                }else if(!$data['apikey']) {
                    $this->msgbox->add('API密钥',213);
                }else if(!$data['machine_code']) {
                    $this->msgbox->add('打印机终端号',214);
                }else if(!$data['mkey']) {
                    $this->msgbox->add('打印机终端密钥',215);
                }else {
                    if(K::M('shop/print')->update($plat_id, $data)){
                        $this->msgbox->add('修改内容成功');
                    } 
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:shop/print/edit.html';
        }
    }

    public function delete($plat_id=null)
    {
        if($plat_id = (int)$plat_id){
            if(!$detail = K::M('shop/print')->detail($plat_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('shop/print')->delete($plat_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

    public function change()
    {
        if(!$plat_id = (int)$this->GP('plat_id')) {
            $this->msgbox->add('你要设置的内容不存在或已经删除',211);
        }else if(!$detail = K::M('shop/print')->detail($plat_id)) {
            $this->msgbox->add('你要设置的内容不存在或已经删除',211);
        }else {
            $status = $this->GP('status');
            if(K::M('shop/print')->set_status($detail['shop_id'], $plat_id, $status)) {
                $this->msgbox->add('设置成功');
            }
        }
    }
}