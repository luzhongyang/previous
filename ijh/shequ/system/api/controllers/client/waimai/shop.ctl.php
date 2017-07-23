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
class Ctl_Client_Waimai_Shop extends Ctl
{
    protected  $_allow_fields = 'shop_id,city_id,cate_id,title,banner,logo,declare,addr,views,orders,comments,praise_num,score,score_fuwu,score_kouwei,first_amount,min_amount,freight,pei_amount,pei_time,pei_distance,pei_type,yy_status,yy_stime,yy_ltime,yy_xiuxi,is_new,online_pay,youhui,info,delcare,pmid,verify_name,tmpl_type,dateline,phone,freight_stage,is_daofu,is_ziti,lat,lng,orderby,cate_title,freight_price,youhui_title,yysj_status';

    // 距离排序辅助uasort()
    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    protected function score_order($a, $b)
    {
        if ($a['score'] == $b['score']) {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }
    
    /*外卖商户分类*/
    public function cate($params)
    {
        if(!$cate = K::M('waimai/cate')->tree()) {
            $cate = array();
        }else{
            foreach($cate as $k => $v){
                if($v['childrens']){
                    $cate[$k]['childrens'] = array_values($v['childrens']);
                    $cate[$k]['children'] = array_values($v['childrens']);
                }else{
                    $cate[$k]['childrens'] = array();
                    $cate[$k]['children'] = array();
                }
            }
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($cate)));
    }
    
    /*外卖商户列表*/
    public function items($params)
    {
        $filter = $orderby = $items = $lnglat = array();
        $filter = array('closed'=>0, 'audit'=>1);
        //分类筛选
        if($cate_id = (int)$params['cate_id']){
            if($ids = K::M('waimai/cate')->children_ids($cate_id)){
                $cate_ids = explode(',', $ids);
            }
            $cate_ids[] = $cate_id;
            $filter['cate_id'] = $cate_ids;
        }   

        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经纬度错误',211);
        }else{
            if($params['order'] == 'time') { 
                $orderby['pei_time'] = 'ASC';
            }else if($params['order'] == 'sales') { 
                $orderby['orders'] = 'DESC';
            }else if($params['order'] == 'score') { 
                $orderby['score'] = 'DESC';
            }else if($params['order'] == 'price') { 
                $orderby['min_amount'] = 'ASC';
            }
            // 筛选 filter
            if($params['filter'] == 'is_new') { //是否新店
                $filter['is_new'] = 1;
            }
            if ($params['filter'] == 'online_pay') { // 是否支持在线支付
                $filter['online_pay'] = 1;
            }
            if($params['filter'] == 'youhui_first') {  // 首单优惠
                $filter['first_amount'] = '>:0';
            }
            if($params['filter'] == 'youhui_order') {  // 下单立减
                $filter[':SQL'] = "youhui !=''";
            }

            //使用此函数计算得到结果后，带入sql查询。
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT, 5);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];

            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            //最多返回到第100条
            if(($page <= 10) && $waimai_items = K::M('waimai/waimai')->items($filter, $orderby, 1, 5000, $count)){
                foreach($waimai_items as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields,$val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $val['score'] = ($val['score']/$val['comments']) ? round($val['score']/$val['comments'],2) : 0 ;
                    $waimai_items[$k] = $val;
                }
                if($params['order'] == 'juli') {
                    uasort($waimai_items, array($this, 'juli_order'));
                }
                if($params['order'] == 'score') {
                    uasort($waimai_items, array($this, 'score_order'));
                }
                $items = array_slice($waimai_items, ($page-1)*10, 10, true);
               
            }else {
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count,'sql'=>$this->system->db->SQLLOG()));
        }
    }

    // 商超列表
    public function marketitems($params)
    {
        $filter = $orderby = $items = $lnglat = array();
        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经纬度错误',211);
        }else{
            $filter = array('audit'=>1, 'closed'=>0);
            //使用此函数计算得到结果后，带入sql查询。
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT, 5);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];

            $page = max((int)$params['page'], 1);
            $limit = 10;
            $filter['cate_id'] = 5; //写死商超分类5
            //最多返回到第100条
            if($items = K::M('waimai/waimai')->items($filter, $orderby, $page, $limit, $count)){
                foreach($items as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields,$val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $val['score'] = ($val['score']/$val['comments']) ? round($val['score']/$val['comments'],2) : 0 ;
                    $items[$k] = $val;
                }              
            }else {
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }

    public  function detail($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中', 213);
        }else if(empty($shop['have_waimai'])){
            $this->msgbox->add('商户未开启外送店铺', 214);
        }else if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商户未开通外送店铺', 215);
        }else if(empty($detail['audit'])){
            $this->msgbox->add('店铺正在审核中', 213);
        }else{
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('shop/detail', array($shop_id), null, 'www'),
                'share_title'=> $detail['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $detail['logo'],
                'share_content'=>$detail['title']
            );
            $detail['lat'] = $shop['lat'];
            $detail['lng'] = $shop['lng'];
            $detail['addr'] = $shop['addr'];
            $detail['juli'] = K::M('helper/round')->juli(__LNG, __LAT, $detail['lng'], $detail['lat']);
            $detail['juli_label'] = K::M('helper/format')->juli($detail['juli']);
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $this->msgbox->set_data('data', array('waimai_detail'=>$detail, 'share'=>$share));
        }
    }
}