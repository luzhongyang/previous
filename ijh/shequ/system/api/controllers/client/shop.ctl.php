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
class Ctl_Client_Shop extends Ctl
{

    protected $_allow_fields = 'shop_id,city_id,contact,cate_id,cate_title,mobile,phone,title,have_waimai,have_tuan,have_quan,have_maidan,have_dingzuo,have_paidui,have_diancan,lng,lat,banner,logo,score,business_id,area_id,addr,avg_amount,comments,max_youhui,intro,info,verify_name,tmpl_type,yysj_status';

    // 社区首页请求接口
    public function index($params)
    {
        $banners = $services = $advs = $index_cate = array();
        // 首页轮播
        if($adv = K::M('adv/adv')->adv_by_name('首页轮播')){
            if($banner_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                $banners = array();
                foreach($banner_items as $k=>$v){
                    if($v['audit']){
                        $banners[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                    }                    
                }
            }
        }
        if(empty($banners)){
            $banners= array(array('adv_id'=>0, 'title'=>'默认图片', 'link'=>'###', 'thumb'=>'default/index_banner.png'));
        }
        // 首页格子广告
        if($adv = K::M('adv/adv')->adv_by_name('首页格子广告')){           
            if($adv_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){                
                $index = 0;
                $advs = array();
                foreach($adv_items as $k=>$v){
                    if($v['audit']){
                        if(++$index > 4){
                            break;
                        }
                        $advs[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                    }
                }
            }
        }
        if(count($advs) < 4){
            for($i=count($advs); $i<4; $i++){
                $advs[] = array('adv_id'=>0, 'title'=>'默认图片', 'link'=>'###', 'thumb'=>'default/index_adv.png');
            }
        }

        // 服务分类
        if($service_items = K::M('adv/item')->items_by_adv(4)) {
            foreach($service_items as $k=>$v) {
                $services[] = $this->filter_fields('item_id,title,link,thumb', $v);
            }
        }else {
            $services = array();
        }
        
        //新服务分类
        $index_cate = K::M('app/cate')->items();
        foreach($index_cate as $ck => $cv){
            if($cv['cid'] > 0){
                $cate = K::M('waimai/cate')->detail($cv['cid']);
                $index_cate[$ck]['cate_title'] = $this->filter_fields('title', $cate);
            }
        }
        // 推荐商家列表
        $filter = $orderby = $shop_items = $items = array();
        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经纬度错误',211);
        }else{
            // 搜索商家
            if($title = $params['title']){
                $filter['title'] = "LIKE:%".$title."%";
            }
            // 距离用户5公里范围内周边商户
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT, 5);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $page = max((int)$params['page'], 1);
            $limit = 10;
            if($shop_list = K::M('shop/shop')->items($filter, null, $page, $limit, $count)){
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields, $val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  //计算用户与商家的距离（单位米）
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $shop_items[$k] = $val;
                }
                $shop_items = $this->_format_shop_items($shop_items);
            }else{
                $shop_items = array();
            }
        }

        $this->msgbox->set_data('data', array('advs'=>$advs, 'services'=>$services,'index_cate'=>array_values($index_cate), 'banners'=>$banners, 'shop_items'=>array('items'=>array_values($shop_items), 'total_count'=>$count)));

    }

    // 首页推荐商家
    public function shopsuggest($params)
    {
        $filter = $orderby = $items = array();
        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经纬度错误',211);
        }else{
            // 距离用户5公里范围内周边商户
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT, 5);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;

            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)){
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields, $val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $shop_list[$k] = $val;
                }
                uasort($shop_list, array($this, 'juli_order')); // 距离由近到远排序
                $items = array_slice($shop_list, ($page-1)*10, 10, true);
                $items = $this->_format_shop_items($items);
            }else{
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }

    // 商户分类
    public function cate($params)
    {
        $tree = array();
        if($tree = K::M('shop/cate')->tree()){
            foreach($tree as $k=>$v){
                if($v['childrens']){
                    $parent = $v;
                    unset($parent['childrens']);
                    $parent['title'] = '全部分类';
                    $v['childrens'] = array_merge(array($k=>$parent), $v['childrens']);
                }
                $v['childrens'] = array_values($v['childrens']);
                $tree[$k] = $v;
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
    }

    // 商圈列表
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
			$this->msgbox->set_data('data',array('items'=>(array)array_values($area_items)));
        }        
    }

    //商户详情
    public function detail($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add('参数不正确!', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除!',212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可下单!',212);
        }else{
            $waimai_default = array('shop_id'=>0,'cate_id'=>0,'cate_title'=>'','title'=>'','logo'=>0,'pei_distance'=>0,'pei_type'=>0,'yy_status'=>0, 'tmpl_type'=>'waimai');
            if($shop['have_waimai'] == 1) {
                if($waimai_detail = K::M('waimai/waimai')->detail($shop_id)){
                    if(empty($waimai_detail['audit'])) {
                        $waimai_detail = $waimai_default;
                        $shop['have_waimai'] = 0;
                    }else{
                        $waimai_detail = $this->filter_fields('shop_id,city_id,cate_id,cate_title,title,logo,pei_distance,pei_type,yy_status,tmpl_type,yysj_status', $waimai_detail);
                    }
                }else {
                    $shop['have_waimai'] = 0;
                    $waimai_detail = $waimai_default;
                }
            }else{
                $waimai_detail = $waimai_default;
            }
            $tuan_detail = array(
                'childrens' => array(),
                'total_sales'    => 0
            );
            if($shop['have_tuan'] == 1) {
				//去除审核限制
                //if($tuan_items = K::M('tuan/tuan')->items(array('shop_id'=>$shop_id,'closed'=>0,'audit'=>1,'type'=>'tuan','is_onsale'=>1), null, 1, 2, $count)) {
                if($tuan_items = K::M('tuan/tuan')->items(array('shop_id'=>$shop_id,'closed'=>0,'type'=>'tuan','is_onsale'=>1), null, 1, 2, $count)) {
                    foreach($tuan_items as $k=>$v) {
                        $total_sales += $v['virtual_sales'] + $v['sales'];
                        $tuan_detail['childrens'][] = $this->filter_fields('title,price,photo,virtual_sales,sales,market_price,shop_id,tuan_id,orders', $v);
                    }
                    $tuan_detail['total_sales'] = $total_sales;
                }else{
                    $shop['have_tuan'] = 0;
                    $tuan_detail['total_sales'] = K::M('tuan/tuan')->total_sales(array('type'=>'tuan', 'shop_id'=>$shop_id));
                }
            }
            $quan_detail = array(
                'childrens' => array(),
                'total_sales' => 0
            );
            if($shop['have_quan'] == 1) {
				//去除审核限制
                //if($quan_items = K::M('tuan/tuan')->items(array('shop_id'=>$shop_id,'closed'=>0,'audit'=>1,'type'=>'quan','is_onsale'=>1), null, 1, 2, $count)) {
                if($quan_items = K::M('tuan/tuan')->items(array('shop_id'=>$shop_id,'closed'=>0,'type'=>'quan','is_onsale'=>1), null, 1, 2, $count)) {
                    $total_sales = 0;
                    foreach($quan_items as $k=>$v) {
                        $total_sales += $v['virtual_sales'] + $v['sales'];
                        $quan_detail['childrens'][] = $this->filter_fields('title,price,photo,sales,market_price,shop_id,tuan_id,orders', $v);
                    }
                    $quan_detail['total_sales'] = $total_sales;
                }else{
                    $shop['have_quan'] = 0;
                    $quan_detail['total_sales'] = K::M('tuan/tuan')->total_sales(array('type'=>'quan', 'shop_id'=>$shop_id));
                }
            }
            $maidan_detail = array('title'=>'在线买单','shop_id'=>0,'type'=>0,'config'=>array(),'discount'=>0,'orders'=>0,'max_youhui'=>0);
            if($shop['have_maidan'] == 1) {
                if($maidan_detail = K::M('maidan/maidan')->detail($shop_id)) {
                    if($maidan_detail['type'] == 0){
                        $maidan_detail['config'] = unserialize($maidan_detail['config']);
                        foreach($maidan_detail['config'] as $ck => $cv){
                            $title .= '每满'.$cv['m'].'减'.$cv['d'].'元,';
                        }
                        $title = substr($title,0,-1);
                        $order = $maidan_detail['orders'];
                    }else{
                        $discount = $maidan_detail['discount']/10;
                        $title = "{$discount}折优惠";
                        $total_sales = $maidan_detail['orders'];
                    }
                    if($maidan_detail['max_youhui']){
                        $title = $title.",最大优惠{$maidan_detail['max_youhui']}元";
                    }
                    $maidan_detail['total_sales'] = $total_sales;
                    $maidan_detail['title'] = $title;
                }else{
                    $maidan_detail = array('title'=>'在线买单', 'shop_id'=>0,'type'=>0,'config'=>array(),'discount'=>0,'total_sales'=>0,'max_youhui'=>0); 
                }
            }

            $comment_detail = array();
            if($comment_list = K::M('shop/comment')->items(array('shop_id'=>$shop_id),array('comment_id'=>'desc'),$page,3,$count)) {
                $comment_ids = $uids = array();
                foreach($comment_list as $k=>$v) {
                    $comment_ids[$v['comment_id']] = $v['comment_id'];
                    $uids[$v['uid']] = $v['uid'];
                    $v = $this->filter_fields('comment_id,score,score_fuwu,score_kouwei,uid,content,reply,reply_time,dateline',$v);
                    $v['face'] = 'default/face.png';
                    $v['nickname'] = '匿名';
                    $v['photos'] = array();
                    $comment_list[$k] = $v;
                }
                if($member_list = K::M('member/member')->items_by_ids($uids)) {
                    foreach($comment_list as $k=>$v){
                        if($m = $member_list[$v['uid']]){
                            $v['face'] = $m['face'];
                            $v['nickname'] = $m['nickname'];
                            $comment_list[$k] = $v;
                        }
                    }
                }
                if($comment_photo_list = K::M('shop/commentphoto')->items(array('comment_id'=>$comment_ids))) {
                    foreach($comment_photo_list as $k=>$v){
                        $comment_list[$v['comment_id']]['comment_photos'][] = array('photo_id'=>$v['photo_id'], 'photo'=>$v['photo']);
                    }
                }
                $comment_detail = array_values($comment_list);
            }
            $shop = $this->filter_fields($this->_allow_fields, $shop);
            $shop['juli'] = K::M('helper/round')->juli(__LNG, __LAT, $shop['lng'], $shop['lat']);
            $shop['juli_label'] = K::M('helper/format')->juli($shop['juli']);
            $shop['waimai_detail'] = $waimai_detail;
            $shop['tuan_detail'] = $tuan_detail;
            $shop['quan_detail'] = $quan_detail;
            $shop['maidan_detail'] = $maidan_detail;
            $shop['comment_detail'] = $comment_detail;

            $shop['comment_counts'] = $shop['comments'];             
            // 高于同行,去除该功能，保留字段(percent)防止旧版APP崩溃
            // $tonghang_score = K::M('shop/shop')->count(array('score'=>'<:' .$shop['score']));
            // $total_score = K::M('shop/shop')->count();
            // $shop['percent'] = round($tonghang_score/$total_score, 2)*100 . "%";
            // $shop['photo_count'] = K::M('shop/albumphoto')->count(array('shop_id'=>$shop_id));
            // $shop['orders'] = K::M('order/order')->count(array('shop_id'=>$shop_id));
            $shop['percent'] = "0%";            
            $shop['orders'] = (int)$shop['orders'];
            $shop['photo_count'] = K::M('shop/albumphoto')->count(array('shop_id'=>$shop_id));
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('shop/detail', array($shop_id), null, 'www'),
                'share_title'=> $shop['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $shop['logo'],
                'share_content'=>$shop['title']
            );
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$shop,'share'=>$share));
        }
    }

    // 更多商家列表
    public function items($params)
    {
        //status 0:未使用,1:已使用;
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
            }else if($area_id = (int)$params['area_id']) {
                $filter['area_id'] = $area_id;
                unset($filter['lng']);unset($filter['lat']);
            }

            // 排序
            if(isset($params['order'])){
                if($params['order'] == 'avg_amount') { // 人均最低
                    $orderby['avg_amount'] = 'ASC';
                }else if($params['order'] == 'socre'){

                }else if($params['order'] == 'juli'){

                }else{
                    
                }
            }
            // 搜索
            if($title = $params['title']){
                $filter['title'] = "LIKE:%".$title."%";
            }
            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 100, $count)){
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields, $val);
                    $val['juli'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $val['juli_label'] = K::M('helper/format')->juli($val['juli']);
                    $val['mark'] = round($val['score']/$val['comments'], 2);
                    $shop_list[$k] = $val;
                }
                if($params['order'] == 'juli' /*|| $params['order'] == ''*/){  //默认和距离最近
                    uasort($shop_list, array($this, 'juli_order'));
                }elseif($params['order'] == 'score') {
                    uasort($shop_list, array($this, 'score_order'));   // 按评分从高到低排序
                }
                if($shop_items = array_slice($shop_list, ($page-1)*10, 10, true)){
					$shop_items = $this->_format_shop_items($shop_items);
				}else{
					$shop_items = array();
				}
            }else{
                $shop_items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($shop_items), 'total_count'=>$count));
        }
    }

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
        if ($a['mark'] == $b['mark']) {
            return 0;
        }
        return ($a['mark'] > $b['mark']) ? -1 : 1;
    }

    protected function _format_shop_items($shop_items)
    {
        foreach($shop_items as $k=>$v){
            $shop_ids[$v['shop_id']] = $v['shop_id'];
            $v['maidan_detail'] = array('maidan_label'=>'支持在线买单');
            $v['tuan_detail'] = array('tuan_label'=>'支持商品团购');
            $v['quan_detail'] = array('quan_label'=>'支持购买代金券');
            $shop_items[$k] = $v;
        }
        if($maidan_list = K::M('maidan/maidan')->items_by_ids($shop_ids)){
            foreach($maidan_list as $k=>$v){
                if($v['type']){
                    $label = sprintf("%s折,最高优惠￥%s", $v['discount'], $v['max_youhui']);
                }else{
                    if($config = unserialize($v['config'])){
                        $youhui_label = array();
                        foreach($config as $kk=>$vv){
                            $youhui_label[] = sprintf("每%s满%s减", $vv['m'], $vv['d']);
                        }
                        $label = implode(",", $youhui_label);
                    }
                }
                $shop_items[$v['shop_id']]['maidan_detail'] = array('maidan_label'=>$label);
            }
        }
        if($tuan_list = K::M('tuan/tuan')->items(array('shop_id'=>$shop_ids, 'closed'=>0, 'audit'=>1, 'is_onsale'=>1, 'type'=>'tuan'))){
            $label_list = array();
            foreach($tuan_list as $k=>$v){
                $label_list[$v['shop_id']][] = $v['title'];
            }
            foreach($label_list as $k=>$v){
                $shop_items[$k]['tuan_detail'] = array('tuan_label'=>implode(',', $v));
            }
        }
        if($quan_list = K::M('tuan/tuan')->items(array('shop_id'=>$shop_ids, 'closed'=>0, 'audit'=>1, 'is_onsale'=>1, 'type'=>'quan'))){
            $label_list = array();
            foreach($tuan_list as $k=>$v){
                $label_list[$v['shop_id']][] = $v['title'];
            }
            foreach($label_list as $k=>$v){
                $shop_items[$k]['quan_detail'] = array('quan_label'=>implode(',', $v));
            }
        }
        return $shop_items;
    }

}
