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
class Ctl_Tuan_Shop extends Ctl
{
	protected  $shop_allow_fields = 'shop_id,contact,mobile,phone,title,passwd,money,total_money,tixian_money,tixian_percent,have_waimai,have_tuan,have_quan,have_maidan,audit,clientip,dateline,lng,lat,score';

    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    protected function score_order($a, $b)
    {
        if ($a['mark'] == $b['mark']) {
            return 0;
        }
        return ($a['mark'] > $b['mark']) ? -1 : 1;
    }

    protected function avg_order($a, $b)
    {
        if ($a['avg_amount'] == $b['avg_amount']) {
            return 0;
        }
        return ($a['avg_amount'] < $b['avg_amount']) ? -1 : 1;
    }

    public function index()
    {
        //echo '<pre>'; print_r($this->request['UxLocation']); exit;  
        if($area_items = K::M('data/area')->items($filter,$orderby,$page,$limit,$count)) {
            $this->pagedata['areas'] = $area_items;
        }
        if($business_items = K::M('data/business')->items($filter,$orderby,$page,$limit,$count)) {
            $this->pagedata['business'] = $business_items;
        }
        $this->pagedata['cate_tree']  = K::M('shop/cate')->tree();
    	$this->tmpl = 'tuan/index.html';
    }

    // 拥有团购功能的商户列表
    public function loadtuanitems()
    { 
        $filter = $orderby = array(); $lng = $lat = $range = $distance = $squares = $page = $sort = null;
        // 分类条件
        if($cate_id = (int)$this->GP('cate_id')) {
            if(!$cate_id){
                unset($filter['cate_id']);
            }else{
                $cate = K::M('shop/cate')->detail($cate_id);
                if($cate['parent_id'] != 0) {
                    $filter['cate_id'] = $cate_id;
                }else {
                    if($cates = K::M('shop/cate')->items(array('parent_id'=>$cate_id))) {
                        foreach($cates as $k=>$v) {
                            $cate_ids[] = $v['cate_id'];
                        }
                        $filter['cate_id'] = $cate_ids;
                    }else {
                        $filter['cate_id'] = $cate_id;
                    }
                }
            }
        }

        $lng = $this->GP('lng');
        $lat = $this->GP('lat');
        if(!$lng || !$lat){
            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
        }
        if($range = $this->GP('range')) {
            $distance = $range;
        }else {
            $cfg = K::M('system/config')->get('site');
            $distance = $cfg['pei_range'];
        }

        if($lng && $lat){
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, $distance);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        }
        
        // 区域条件
        if($business_id = $this->GP('business_id')) {
            $filter['business_id'] = $business_id;
            unset($filter['lng']);unset($filter['lat']);
        }

        if($area_id = $this->GP('area_id')) {
            $filter['area_id'] = $area_id;
            unset($filter['lng']);unset($filter['lat']);
        }
        
        $filter['audit'] = 1;
        $filter['closed'] = 0;
        $page = max((int)$this->GP('page'), 1);

        if(($page <= 10) && $shop_items = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)) {
            foreach($shop_items as $k=>$val) {    
                $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $lng, $lat);
                $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                $val['url'] = $this->mklink('tuan/product:goodsitems', array('arg0'=>$val['shop_id']));  
                $val['mark'] = ($val['score']/$val['comments']) ? round($val['score']/$val['comments'],2) : 0 ;
                $shop_items[$k] = $val;
            }

            // 排序条件
            if($this->GP('sort') == 'default' || $this->GP('sort') == 'nearly') {  //按默认和距离最近排序
                uasort($shop_items, array($this, 'juli_order')); 
            }elseif($this->GP('sort') == 'score') {
                uasort($shop_items, array($this, 'score_order'));   // 按评分从高到低排序
            }elseif($this->GP('sort') == 'avg_amount')  {
                uasort($shop_items, array($this, 'avg_order'));   // 按人均从低到高排序
            }   
            $items = array_slice($shop_items, ($page-1)*10, 10, true);  

        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));  
    }
}