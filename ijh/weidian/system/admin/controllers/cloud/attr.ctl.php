<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cloud_Attr extends Ctl
{
    public function index($goods_id = null, $page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($goods_id = (int) $goods_id){
            $filter['goods_id'] = $goods_id;
        }
        else{
            unset($filter['goods_id']);
        }
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['uid']){
                $filter['win_uid'] = $SO['uid'];
            }
            if($SO['cloud_num']){
                $filter['cloud_num'] = $SO['cloud_num'];
            }
        }
        $filter['closed'] = 0;
        if($items = K::M('cloud/attr')->items($filter, array('cloud_num' => 'asc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(array($goods_id), array('{page}')), array('SO' => $SO));
        }
        $goods_ids = $uids = array();
        foreach($items as $k => $v){
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $uids[$v['win_uid']] = $v['win_uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_ids);
        $this->pagedata['cates'] = K::M('cloud/cate')->fetch_all();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['detail'] = K::M('cloud/goods')->detail($goods_id);
        $this->tmpl = 'admin:cloud/attr/items.html';
    }
    public function so($goods_id = null)
    {
        $goods_id = (int) $goods_id;
        $this->pagedata['goods_id'] = $goods_id;
        $this->tmpl = 'admin:cloud/attr/so.html';
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
    public function create($goods_id = null)
    {
        $goods_id = (int) $goods_id;
        $goods = K::M('cloud/goods')->detail($goods_id);
        $last_good = K::M('cloud/attr')->find(array('goods_id' => $goods_id,'closed'=>0), array('cloud_num' => 'desc'));
        if($data = $this->checksubmit('data')){
            if($data['cloud_num'] <= $last_good['cloud_num']){
                $this->msgbox->add('云购期数填写不正确', 211)->response();
            }
            if($data['win_uid']){
                $data['is_set'] = 1;
            }
            if($buytime = $this->GP('buytime')){  //购买时间
                if(is_array($buytime)){
                    if($buytime[0] && $buytime[1]){
                        $a = strtotime($buytime[0]);
                        $b = strtotime($buytime[1]);
                        $filter = array($a,$b);
                    }
                }
            }
            //print_r(K::M('member/cloud')->Select_uids(54));die;
            if($start_num = (int) $this->GP('start_num')){
                $data['join'] = $start_num;
            }
            $data['goods_id'] = $goods_id;
            $data['cate_id'] = $goods['cate_id'];
            if($attr_id = K::M('cloud/attr')->create($data,false)){
                K::M('cloud/number')->createStart($data['price'],$attr_id); //创建所有云购码
                //下面创建初始化订单
                if($start_num){
                    K::M('cloud/order')->orderStart($data['price'],$start_num, $data['win_uid'],$filter,$attr_id,$goods_id);
                }
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', $this->mklink('cloud/attr:index', array($goods_id)));
            }
        }
        else{
            $this->pagedata['cloud_num'] = $last_good['cloud_num'] + 1;
            $this->pagedata['detail'] = K::M('cloud/goods')->detail($goods_id);
            $this->tmpl = 'admin:cloud/attr/create.html';
        }
    }
    public function edit($attr_id = null)
    {
        if(!($attr_id = (int) $attr_id) && !($attr_id = $this->GP('attr_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('cloud/attr')->detail($attr_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($data = $this->checksubmit('data')){
            if(K::M('cloud/attr')->update($attr_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $detail['goods'] = K::M('cloud/goods')->detail($detail['goods_id']);
            $user = K::M('member/member')->detail($detail['win_uid']);
            $detail['nickname'] = $user['nickname'];
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cloud/attr/edit.html';
        }
    }
    public function delete($attr_id = null)
    {
        if($attr_id = (int) $attr_id){
            if(!$detail = K::M('cloud/attr')->detail($attr_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('cloud/attr')->batch($attr_id, array('closed' => 1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('attr_id')){
            if(K::M('cloud/attr')->batch($ids, array('closed' => 1))){
                $this->msgbox->add('批量删除内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}
