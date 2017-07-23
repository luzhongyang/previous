<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 * check view code by shzhrui
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Waimai_Shop extends Ctl
{
    /* 外卖首页列表
     * #cate_id,lng,lat,order,is_new,online_pay,youhui_first,youhui_order,pei_type,title,page
     */
    public function index($cate_id)
    {
        $cate_list = K::M('waimai/cate')->fetch_all();
        if($cate_id = (int)$cate_id){
            $this->pagedata['cate_id'] = $cate_id;
        }else {
            $this->pagedata['cate_id'] = 0;
        }
        $this->pagedata['cate_tree'] = K::M('waimai/cate')->tree();

        $this->tmpl = 'waimai/shop/index.html';
    }

    // 下拉加载商家
    public function loadshopitems()
    {
        $filter = $pager = $orderby = array();
        $filter = array('closed'=>0, 'audit'=>1);
        if(!$this->checksubmit()){
            $this->msgbox->add('请求出错', -2)->response();
        }
        $lng = $this->GP('lng');
        $lat = $this->GP('lat');
        if(!$lng || !$lat){
            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
        }
        if($lng && $lat){
            $cate_list = K::M('waimai/cate')->fetch_all();            
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);
            $filter['lat'] =$squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        }
        if($cate_id = (int)$this->GP('cate_id')){
            if($ids = K::M('shop/cate')->children_ids($cate_id)){
                $cate_ids = explode(',', $ids);
            }
            $cate_ids[] = $cate_id;
            $filter['cate_id'] = $cate_ids;
        }   

        if($this->GP('order') == 'time') { 
            $orderby['pei_time'] = 'ASC';
        }else if($this->GP('order') == 'sales') { 
            $orderby['orders'] = 'DESC';
        }else if($this->GP('order') == 'score') { 
            $orderby['score'] = 'DESC';
        }else if($this->GP('order') == 'price') { 
            $orderby['min_amount'] = 'ASC';
        }
        if($this->GP('sort') == 'is_new') {
            $filter['is_new'] = 1;
        }
        if($this->GP('sort') == 'online_pay') {
            $filter['online_pay'] = 1;
        }
        if($this->GP('sort') == 'first_amount') {  
            $filter['first_amount'] = '>:0';
        }
        if($this->GP('sort') == 'youhui_order') {  
            $filter[':SQL'] = "youhui !=''";
        }
        $page = max((int)$this->GP('page'), 1);        
        if(($page <= 10) && ($waimai_items = K::M('waimai/waimai')->items($filter, $orderby, 1, 1000, $count))){
            $shop_ids = array();
            foreach($waimai_items as $k=>$val) {
                $val['juli'] = (int)K::M('helper/round')->juli($val['lng'], $val['lat'], $lng, $lat);  // 用户与商户的距离米
                $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                $val['score'] = ($val['score']/$val['comments']) ? round($val['score']/$val['comments'],2) : 0 ;
                $val['url'] = $this->mklink('waimai/product:index', array($val['shop_id']));
                $waimai_items[$k] = $val; 
            }
            $items = $waimai_items;
            if($this->GP('order') == 'juli') {
                uasort($items, array($this, 'juli_order'));   
            }    
            $items = array_slice( $items, ($page-1)*10, 10, true);  // 每次取10条记录，偏移量为$page-1
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    /*商家详情页*/
    public function seller($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->error(404);
        }else if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->error(404);
        }
        $lng = $this->request['UxLocation']['lng'];
        $lat = $this->request['UxLocation']['lat'];        
        $youhui = explode(',', $detail['youhui']);
        foreach($youhui as $k=>$v){
            $v   =  explode(':', $v);
            if($v[0] && $v[1]) {
                $yh .= '满'.$v[0].'减'.$v[1] . ' ';
            }
        }
        $detail['youhui_label'] = $yh;
        $detail['distance'] = K::M('helper/round')->juli($detail['lng'], $detail['lat'], $lng, $lat);
        $detail['juli_label'] = K::M('helper/format')->juli($detail['distance']);

        $detail['avg_time'] = $detail['pei_time'];
        $this->pagedata['detail']  = $detail;
        $this->pagedata['shop_id'] = $shop_id;
        $this->tmpl = 'waimai/shop/seller.html';
    }

    // 距离排序从小到大
    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }


}
