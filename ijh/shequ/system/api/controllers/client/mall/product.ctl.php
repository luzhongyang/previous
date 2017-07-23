<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Mall_Product extends Ctl
{

    protected $_allow_fields = 'product_id,cate_id,title,photo,jifen,price,freight,info,views,sales,sku,orderby,cate_title';
    
    public function index($params)
    {
        $nav_list = $banner_list = $items = array();
        if($cate_list = K::M('mall/cate')->fetch_all()) {
            $index = 0;
            foreach($cate_list as $v){
                if(empty($v['parent_id'])){                    
                    if(++$index > 7 ){
                        break;
                    }
                    $nav_list[] = $v;
                }
            }
        }
        if($adv = K::M('adv/adv')->adv_by_name('商城首页轮播')){
            if($banner_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                $index = 0;
                $banner_list = array();
                foreach($banner_items as $k=>$v){
                    $banner_list[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                }
            }
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('mall/product')->items(array('closed'=>0), null, $page, $limit)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields($this->_allow_fields, $v);
                $items[$k]['info'] = htmlspecialchars_decode($items[$k]['info']);
            }
        }

        //获取用户积分
        $detail = K::M('member/member')->detail($this->uid);
        $jifen = $detail['jifen'];

        $this->msgbox->set_data('data', array('items'=>array_values($items), 'banner_list'=>array_values($banner_list), 'nav_list'=>array_values($nav_list), 'jifen'=>$jifen));
    }

     // 积分商城商品列表
    public function items($params)
    {
        $filter = $items = array();
        $filter['closed'] = 0;
        if($cate_id = (int)$params['cate_id']){
            if($cate_ids = K::M('mall/cate')->children_ids($params['cate_id'])){
                $filter['cate_id'] = explode(',', $cate_ids);
            }else{
                $filter['cate_id'] = $cate_id;
            }            
        }        
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('mall/product')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields($this->_allow_fields, $v);
                $items[$k]['info'] = htmlspecialchars_decode($items[$k]['info']);
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data',array('items'=>array_values($items), 'total_count'=>$count));        
        $this->msgbox->add('success');
    }
    
    public function cate($params)
    {
        if($tree = K::M('mall/cate')->tree()){
            foreach($tree as $k=>$v){
                $tree[$k]['childrens'] = array_values($v['childrens']);
            }
        }else{
            $tree = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
    }
    
	public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('商品不存在',211);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add('商品不存在',212);
        }else{
            $detail['info'] = htmlspecialchars_decode($detail['info']);
            $siteCfg = K::M('system/config')->get('site');
            $detail['detail'] = '<base href="'.$siteCfg['siteurl'].'/" /><style>img{width:100%}</style>'.$detail['detail'];
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }
}