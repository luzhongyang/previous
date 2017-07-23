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

import::C('client/shop');
class Ctl_Client_Tuan extends Ctl_Client_Shop
{
    //protected  $_allow_fields = 'shop_id,contact,mobile,phone,title,tixian_percent,have_waimai,have_tuan,have_quan,have_maidan,lng,lat,score,business_id,area_id,avg_amount,comments,logo,city_name,cate_title';
    protected $_allow_fields = 'shop_id,city_id,contact,cate_id,cate_title,mobile,phone,title,have_waimai,have_tuan,have_quan,have_maidan,have_dingzuo,have_paidui,have_diancan,lng,lat,banner,logo,score,business_id,area_id,addr,avg_amount,comments,max_youhui,intro,info,verify_name,tmpl_type,yysj_status';

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

    // 拥有团购功能的商户列表
    public function items($params)
    {
        $filter = $orderby = $tuan_items = $ids = array();
        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经纬度错误',211);
        }else {
            if($range = $params['range']) {
                $distance = $range;
            }else {
                $distance = 5;
            }
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT, $distance);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];

            //分类筛选
            if($cate_id = (int)$params['cate_id']){
                if($ids = K::M('shop/cate')->children_ids($cate_id)){
                    $cate_ids = explode(',', $ids);
                }
                $cate_ids[] = $cate_id;
                $filter['cate_id'] = $cate_ids;
            }

            //商圈筛选
            if($business_id = (int)$params['business_id']) {
                $filter['business_id'] = $business_id;
                unset($filter['lng']);unset($filter['lat']);
            }
            if($area_id = (int)$params['area_id']) {
                $filter['area_id'] = $area_id;
                unset($filter['lng']);unset($filter['lat']);
            }

            // 排序
            if(isset($params['order'])){
                if($params['order'] == 'avg_amount') { // 人均最低
                    $orderby['avg_amount'] = 'ASC';
                }
            }
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $filter['have_tuan'] = 1;
            $page = max((int)$params['page'], 1);
            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)) {
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields,$val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $val['mark'] = round($val['score']/$val['comments'], 2);
                    $shop_list[$k] = $val;
                }
                if($params['order'] == 'juli' || $params['order'] == ''){  //默认和距离最近
                    uasort($shop_list, array($this, 'juli_order'));
                }
                if(!$params['order'] && !$params['business_id'] && !$params['area_id'] && $params['page']==1) {
                    uasort($shop_list, array($this, 'juli_order'));
                }
                if($params['order'] == 'score') {
                    uasort($shop_list, array($this, 'score_order'));   // 按评分从高到低排序
                }
                $items = array_slice($shop_list, ($page-1)*10, 10, true);
            }else {
                $items = array();
            }
            $items = $this->_format_shop_items($items);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }
    /* 拥有券商品列表
     * @param shop_id,
     * @param page
     */
    public function quan($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
           $this->msgbox->add('商户ID不存在',211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在',212);
        }else{
            $allow_fields = 'tuan_id,shop_id,city_id,type,title,desc,price,market_price,photo,views,stime,ltime,sale_type,sale_sku,sale_count,sales,virtual_sales,info,orderby,audit,closed,clientip,dateline,max_buy,min_buy';
            $items = $filter = $orderby = array();
            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $filter['type'] = 'quan';
            $filter['stime']  = '<=:' . __TIME;
            $filter['ltime']  = '>=:' . __TIME;
            $filter['shop_id'] = $shop_id;
            $filter['is_onsale'] = 1;
            $orderby['orderby'] = 'ASC';
            $limit = 10;
            if($items = K::M('tuan/tuan')->items($filter, $orderby, $page, $limit, $count)) {
                foreach($items as $k=>$v) {
                    $items[$k] = $this->filter_fields($allow_fields,$v);
                }
            }else {
                $items = array();
            }

            $shop = $this->filter_fields($this->_allow_fields, $shop);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'shop_detail'=>$shop,'total_count'=>$count));
        }
    }

    /* 团购商品列表
     * @param shop_id,
     * @param page
     */
    public function goods($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
           $this->msgbox->add('商户ID不存在',211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在',212);
        }else{
            $allow_fields = 'tuan_id,shop_id,city_id,type,title,desc,price,market_price,photo,views,stime,ltime,sale_type,sale_sku,sale_count,sales,virtual_sales,info,orderby,audit,closed,clientip,dateline,max_buy,min_buy';
            $items = $filter = $orderby = array();
            $page = max((int)$params['page'], 1);            
            $filter['closed'] = 0;
            $filter['is_onsale'] = 1;
            //$filter['audit'] = 1; //目前未使用审核字段，导致后台显示与前提不一到，接口先去掉该限制
            //$filter['type'] = array('tuan','quan');
            // $filter['stime']  = '<=:' . __TIME;
            // $filter['ltime']  = '>=:' . __TIME;
            $filter['shop_id'] = $shop_id;
            $orderby['orderby'] = 'ASC';
            $limit = 10;
            if($items = K::M('tuan/tuan')->items($filter, $orderby, $page, $limit, $count)) {
                foreach($items as $k=>$v) {
                    $items[$k] = $this->filter_fields($allow_fields,$v);
                }
            }else {
                $items = array();
            }
            $shop = $this->filter_fields($this->_allow_fields, $shop);
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'shop_detail'=>$shop,'total_count'=>$count));
        }
    }

    /**
     * 团购商品详情[修改]
     * @param $tuan_id
     */
    public function detail($params)
    {
        if(!$tuan_id = (int)$params['tuan_id']) {
            $this->msgbox->add('商品ID不存在',211);
        }else if(!$tuan = K::M('tuan/tuan')->detail($tuan_id)) {
            $this->msgbox->add('商品不存在',212);
        }else {
            $orderids = $order_ids = array();
            $allow_fields = "tuan_id,shop_id,city_id,type,title,desc,price,market_price,photo,views,stime,ltime,sale_count,virtual_sales,info,orderby,audit,notice,detail,sales,orders,ticket_merge,min_buy,max_buy,stock_type,stock_num,dateline,is_onsale";
            $shop = K::M('shop/shop')->detail($tuan['shop_id']);
            $tuan = $this->filter_fields($allow_fields, $tuan);
            $tuan['sale_type'] = $tuan['stock_type'];
            $tuan['sale_sku'] = $tuan['stock_num'];
            $tuan['sale_type'] = $tuan['stock_type'];
            $tuan['sale_sku'] = $tuan['stock_num'];
            $tuan['addr'] = $shop['addr'];
            $siteCfg = K::M('system/config')->get('site');
            $tuan['detail'] = '<base href="'.$siteCfg['siteurl'].'/" /><style>img{width:100%}</style>'.$tuan['detail'];
            $tuan['mobile'] = $shop['phone'] ? $shop['phone'] : $shop['mobile'];
            $tuan['expired_status'] = 0;
            if(!$tuan['is_onsale']){
                $tuan['tuan_status'] = 'off_sales';
            }else if($tuan['ltime'] < __TIME){
                $tuan['tuan_status'] = 'expired';
            }else{
                $tuan['tuan_status'] = 'on_sales';
            }
            $_LNG = $params['lng'];
            $_LAT = $params['lat'];
            if(!$_LNG || !$_LAT){
                $_LNG = __LNG;
                $_LAT = __LAT;
            }
            if($_LNG && $_LAT){
                $tuan['juli'] = K::M('helper/round')->juli($shop['lng'], $shop['lat'], $_LNG, $_LAT); 
                $tuan['juli_label'] = K::M('helper/format')->juli($tuan['juli']);
            }else{
                $tuan['juli'] = 0;
                $tuan['juli_label'] = '<0.1km';
            }
            
            $filter['shop_id'] = $tuan['shop_id'];
            $filter['closed'] = 0;
            $filter['audit'] = 1;
            $filter['is_onsale'] = 1;
            $filter['tuan_id'] = '<>:'.$tuan_id; // 除了本团购之外的其他四个团购
            if($other_items = K::M('tuan/tuan')->items($filter, array('tuan_id'=>'DESC'), 1, 4, $count)) {
                foreach($other_items as $k=>$v) {
                    $other_items[$k] = $v;
                }
                $tuan['other'] = array_values($other_items);
            }else {
                $tuan['other'] = array();
            }
            if($comment_items = K::M('shop/comment')->items(array('shop_id'=>$tuan['shop_id']),array('comment_id'=>'desc'), 1, 3,$count)){
                    $ids = array();
                    foreach($comment_items as $k=>$v){
                        $ids[] = $v['comment_id'];
                        $uids[] = $v['uid'];
                        $comment_items[$k]['photos'] = array();
                    }
                    if($photos = K::M('shop/commentphoto')->items(array('comment_id'=>$ids))) {
                        foreach($comment_items as $k=>$v){
                            $comment_items[$k] = $this->filter_fields('comment_id,score,score_fuwu,score_kouwei,uid,content,reply,reply_time,dateline',$v);
                            foreach($photos as $photo){
                                if($v['comment_id']==$photo['comment_id']){
                                    if(CLIENT_OS != 'ANDROID'){
                                        $comment_items[$photo['comment_id']]['photo'][] = $this->filter_fields('photo_id,photo', $photo);
                                    }
                                    $comment_items[$photo['comment_id']]['photos'][] = $this->filter_fields('photo_id,photo', $photo);
                                    
                                }
                            }
                        }
                    } 
                    if($member_items = K::M('member/member')->items(array('uid'=>$uids))) {
                        foreach($member_items as $k1 => $v1) {
                            foreach($comment_items as $k2 => $v2) {
                                if($v1['uid'] == $v2['uid']) {
                                    $comment_items[$k2]['nickname'] = $v1['nickname'];
                                    $comment_items[$k2]['face'] = $v1['face'];
                                } 
                            }
                        }
                    } 
                    $tuan['comment_list'] = array_values($comment_items);       
            }else {
                $tuan['comment_list'] = array();
            }
             //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('tuan/product/goodsdetail', array($tuan['shop_id'],$tuan_id), null, 'www'),
                'share_title'=> $tuan['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $tuan['photo'],
                'share_content'=> $tuan['title']
            );
            K::M('tuan/tuan')->update_count($tuan_id, 'views');
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$tuan,'share'=>$share));
        }
    }

    // 团购商品详情页-全部评价
    public function comment($params) {
        if(!$tuan_id = (int)$params['tuan_id']) {
            $this->msgbox->add('商品不存在',211);
        }else if(!$tuan = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('商品不存在',214);
        }else{
            if($t_order_items = K::M('tuan/order')->items(array('tuan_id'=>$tuan_id))) {
                foreach($t_order_items as $k=>$v) {
                    $orderids[] = $v['order_id'];
                }
                if($order_items = K::M('order/order')->items(array('order_id'=>$orderids,'order_status'=>8,'from'=>'tuan'))) {
                    foreach($order_items as $k=>$v) {
                        $order_ids[] = $v['order_id'];
                    }
                }
            }
            $page = max((int)$params['page'], 1);
            if($comment_items = K::M('shop/comment')->items(array('order_id'=>$order_ids),array('comment_id'=>'desc'),$page,10,$count)){
                $ids = array();
                foreach($comment_items as $k=>$v){
                    $ids[] = $v['comment_id'];
                    $uids[] = $v['uid'];
                    $comment_items[$k]['photos'] = array();
                }
                if($photos = K::M('shop/commentphoto')->items(array('comment_id'=>$ids))) {
                    foreach($comment_items as $k=>$v){
                        foreach($photos as $photo){
                            if($v['comment_id']==$photo['comment_id']){
                                $comment_items[$k] = $this->filter_fields('comment_id,score,score_fuwu,score_kouwei,uid,content,reply,reply_time,dateline',$v);
                                $comment_items[$k]['photo'][] = $this->filter_fields('photo_id,photo', $photo);
                            }
                        }
                    }
                }
                if($member_items = K::M('member/member')->items(array('uid'=>$uids))) {
                    foreach($member_items as $k1 => $v1) {
                        foreach($comment_items as $k2 => $v2) {
                            if($v1['uid'] == $v2['uid']) {
                                $comment_items[$k2]['nickname'] = $v1['nickname'];
                                $comment_items[$k2]['face'] = $v1['face'];
                            }
                        }
                    }
                }
                $comment_items = array_values($comment_items);
            }else {
                $comment_items = array();
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($comment_items),'total_count'=>$count));
        }
    }

    // 团购首页附近-商圈
    public function business($params)
    {
        if(!$city_code = $params['city_code']) {
            $this->msgbox->add('区号不正确',210);
        }else if(!$city = K::M('data/city')->find(array('city_code'=>$city_code))) {
            $this->msgbox->add('区号不存在',211);
        }else {
            $filter1['city_id'] = $city['city_id'];
            $orderby1['area_id'] = 'ASC';
            if($area_items = K::M('data/area')->items($filter1,$orderby,1,500,$count)) {
                foreach($area_items as $k=>$v) {
                    $areaids[] = $v['area_id'];
                }
                $filter2['area_id'] = $areaids;
                $orderby2['business_id'] = 'ASC';
                if($business_items = K::M('data/business')->items($filter2,$orderby2,1,500,$count)) {
                    foreach($area_items as $k1=>$v1) {
                        $area_items[$v1['area_id']]['business'] = array();
                        foreach($business_items as $k2=>$v2) {
                            if($v1['area_id'] == $v2['area_id']) {
                                $area_items[$v2['area_id']]['business'][] = $this->filter_fields('business_id,business_name', $v2);
                            }
                        }
                    }
                }
            }else {
                $area_items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',array('items'=>array_values($area_items)));
        }
    }
 }
