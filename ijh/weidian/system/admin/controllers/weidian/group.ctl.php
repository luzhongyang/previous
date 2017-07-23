<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weidian_Group extends Ctl
{
    public function index($page = 1)
    {
        $filter = $pager = array();
        $filter['closed'] = 0;
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['group_id']){
                $filter['group_id'] = $SO['group_id'];
            }
            if($SO['city_id']){
                $filter['city_id'] = $SO['city_id'];
            }
            if($SO['shop_id']){
                $filter['shop_id'] = $SO['shop_id'];
            }
            if($SO['master_id']){
                $filter['master_id'] = $SO['master_id'];
            }
            if(is_array($SO['start_time'])){
                if($SO['start_time'][0] && $SO['start_time'][1]){
                    $a = strtotime($SO['start_time'][0]);
                    $b = strtotime($SO['start_time'][1]) + 86400;
                    $filter['start_time'] = $a . "~" . $b;
                }
            }
            if(is_array($SO['end_time'])){
                if($SO['end_time'][0] && $SO['end_time'][1]){
                    $a = strtotime($SO['end_time'][0]);
                    $b = strtotime($SO['end_time'][1]) + 86400;
                    $filter['end_time'] = $a . "~" . $b;
                }
            }
            if($SO['order_count']){
                $filter['order_count'] = $SO['order_count'];
            }
            if($SO['product_id']){
                $filter['product_id'] = $SO['product_id'];
            }
            if($SO['status']){
                $filter['status'] = $SO['status'];
            }
        }
        if($items = K::M('weidian/pintuan/group')->items($filter, array('group_id' => 'DESC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            $arr_product_id = array();
            $arr_master_id = array();
            $arr_shop_id = array();
            foreach($items as $k => $v){
                $arr_product_id[] = $v['product_id'];
                $arr_master_id[] = $v['master_id'];
                $arr_shop_id[] = $v['shop_id'];
            }
            $arr_product_id = array_unique($arr_product_id);
            $arr_product_title = K::M('weidian/pintuan/product')->select(" product_id in (" . implode(',', $arr_product_id) . ")");
            $arr_master_id = array_unique($arr_master_id);
            $arr_master_nickname = K::M('member/member')->select(" uid in (" . implode(',', $arr_master_id) . ")");
            $arr_shop_id = array_unique($arr_shop_id);
            $arr_shop_name = K::M('shop/shop')->select(" shop_id in (" . implode(',', $arr_shop_id) . ")");
            $view_params = K::M('weidian/pintuan/group')->view_params;
            foreach($items as $k => $v){
                $v['start_time'] = date('Y-m-d H:i', $v['start_time']);
                $v['shop_name'] = $arr_shop_name[$v['shop_id']]['title'];
                $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
                $v['status_cn'] = $view_params['status']['select'][$v['status']];
                $v['product_id_cn'] = $arr_product_title[$v['product_id']]['title'];
                $v['master_id_cn'] = $arr_master_nickname[$v['master_id']]['nickname'];
                $items[$k] = $v;
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weidian/group/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:weidian/group/so.html';
    }
    public function detail($group_id = null)
    {
        if(!$group_id = (int) $group_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }
        else if(!$detail = K::M('weidian/pintuan/group')->detail($group_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }
        else{
            $arr_shop_name = K::M('shop/shop')->select(" shop_id =" . $detail['shop_id']);
            $arr_master_nickname = K::M('member/member')->select(" uid = " . $detail['master_id']);
            $view_params = K::M('weidian/pintuan/group')->view_params;
            $detail['shop_id'] = $arr_shop_name[$detail['shop_id']]['title'];
            $detail['status'] = $view_params['status']['select'][$detail['status']];
            $detail['master_id'] = $arr_master_nickname[$detail['master_id']]['nickname'];
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weidian/group/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($group_id = K::M('pintuan/group')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?pintuan/group-index.html');
            }
        }
        else{
            $this->tmpl = 'admin:weidian/group/create.html';
        }
    }
    public function edit($group_id = null)
    {
        if(!($group_id = (int) $group_id) && !($group_id = $this->GP('group_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('pintuan/group')->detail($group_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($data = $this->checksubmit('data')){
            if(K::M('pintuan/group')->update($group_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weidian/group/edit.html';
        }
    }
    public function doaudit($group_id = null)
    {
        if($group_id = (int) $group_id){
            if(K::M('pintuan/group')->batch($group_id, array('audit' => 1))){
                $this->msgbox->add('审核内容成功');
            }
        }
        else if($ids = $this->GP('group_id')){
            if(K::M('pintuan/group')->batch($ids, array('audit' => 1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($group_id = null)
    {

        if($group_id = (int) $group_id){
            if(!$detail = K::M('pintuan/group')->detail($group_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('pintuan/group')->update($group_id, array('closed' => 1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('group_id')){
            if(K::M('pintuan/group')->update($ids, array('closed' => 1))){
                $this->msgbox->add('批量删除内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}