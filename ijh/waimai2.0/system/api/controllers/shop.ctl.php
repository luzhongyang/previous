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
class Ctl_Shop extends Ctl
{

    protected $_allow_fields = 'shop_id,city_id,city_name,d,youhui,freight_stage,orders,cate_title,title,cate_id,phone,mobile,logo,lat,lng,addr,avg_score,score,score_fuwu,score_kouwei,pei_time,comments,praise_num,min_amount,first_amount,pei_amount,freight,freight_price,pei_type,yy_status,yy_stime,yy_ltime,yy_stime_line,yy_ltime_line,is_new,online_pay,info,orders,youhui,youhui_title,order_youhui,coupon_title,coupon,pintuan,weidian,yy_status_type';

    public function index($params)
    {
        $this->items($params);
    }
    
    public function items($params)
    { 
        //status 0:未使用,1:已使用;
       $filter = $orderby = $items = $lnglat = array();
       //分类筛选
        if($cate_id = (int)$params['cate_id']){
            if($ids = K::M('shop/cate')->children_ids($cate_id)){
                $cate_ids = explode(',', $ids);
            }
            $cate_ids[] = $cate_id;
            $filter['cate_id'] = $cate_ids;
        }     
        $u_lng = $params['lng'];        
        $u_lat = $params['lat'];        
        if(!$u_lng || !$u_lat){
            $this->msgbox->add(L('经纬度不正确'),211);
        }else{
            // 排序
            if($params['order'] == 'default'){
                $orderby['orderby'] = 'ASC';
                $orderby['praise_num'] = 'DESC';
                $orderby['orders'] = 'DESC';
            }else if ($params['order'] == 'sales') { // 销量最高
                $orderby['orders'] = 'desc';
            } else if ($params['order'] == 'price') { // 起送价最低
                $orderby['min_amount'] = 'asc';
            } else {
                $orderby['orderby'] = 'ASC';
                $orderby['praise_num'] = 'DESC';
                $orderby['orders'] = 'DESC';
            }

            // 筛选
            if($params['is_new']) { //是否新店
                $filter['is_new'] = 1;
            }
            if ($params['online_pay']) { // 是否支持在线支付
                $filter['online_pay'] = 1;
            }


            if($params['pei_type'] === "0"){
                $filter['pei_type'] = 0;//商家送
            }else if($params['pei_type'] === "1"){
                $filter['pei_type'] = '>=:1';  //配送员,平台送
            }else if($params['pei_type'] === "2"){
                $filter['pei_type'] = '>=:0';  //不限
            }else {
                $filter['pei_type'] = array(0,1,2);
            }

            
            if($params['youhui'] == 'coupon') {  //商家优惠券
                $filter[':SQL'] = "coupon !=''";
            }else if($params['youhui'] == 'youhui') {   //下单立减
                $filter[':SQL'] = "youhui !=''";
            }else if($params['youhui'] == 'first_amount') {  //新用户优惠
                $filter['first_amount'] = '>:0';
            }

            if($title = $params['title']){
                $filter['title'] = "LIKE:%".$title."%";
            }
            
            //使用此函数计算得到结果后，带入sql查询。
            $squares = K::M('helper/round')->returnSquarePoint($u_lng, $u_lat,50);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            /*
            if($city_id){
                $filter['city_id'] = $city_id;   //城市筛选
            }
            */
            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $filter['verify_name'] = 1;

            //最多返回到第100条
            if(($page <= 100) && $shop_list = K::M('shop/shop')->items($filter, $orderby,1,$limit, $count_shop)){

                //K::M('system/logs')->log('____shop_list', array($shop_list,$this->system->db->SQLLOG()));

                array_values($index_cates);
                $new_shop_list = array();
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields($this->_allow_fields, $val);
                    $val['juli_sort'] = K::M('helper/round')->juli($val['lng'], $val['lat'], $u_lng, $u_lat);  //距离m
                    $val['juli'] = K::M('helper/format')->juli($val['juli_sort']); //格式化显示
                    $val['avg_score'] = ($val['score_kouwei'] + $val['score_fuwu'])/2;
                    $val['score'] = (round($val['avg_score'] / $val['comments'], 2) >= 5 ? 5 : round($val['avg_score'] / $val['comments'], 2));
                    $val['collect'] = 0;
                    if($val['logo'] == "default/shop_logo.png"){
                        $val['logo'] = null;
                    }

                    $freight = $val['pei_amount'];

                        $juli = $val['juli_sort'];
                        $juli = ceil($juli / 10);
                        $juli = $juli/100;//新距离计算方式wu.
                        $_freight = array();
                        $_max_freight = array('fkm' => 0, 'fm' => 0);

                        if(is_array($val['freight_stage']) ) {

                            foreach ($val['freight_stage'] as $ksss => $v) {
                                if ($juli <= $v['fkm']) {
                                    if ($_freight && $_freight['fkm'] > $v['fkm']) {
                                        $_freight = $v;
                                    } else if (empty($_freight)) {
                                        $_freight = $v;
                                    }
                                }
                                if ($v['fkm'] > $_max_freight['fkm']) {
                                    $_max_freight = $v;
                                }
                            }

                            $freight = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                        }
                    $val['pei_amount'] = $freight;
                    unset($val['coupon']);
                    $new_shop_list[$k] = $val;
//                    if( 618470 == $val['shop_id'])
//                    {
//                        echo $freight;
//                        print_r($val);
////                        die;
//                    }

                }

                $shop_list = $new_shop_list;


                //app 排序错误, 排序在sql里面加,不要利用数组排序!
                $items = array_slice($shop_list, ($page-1)*10, 10, true);

                //查出我的关注商家ID列表
                if($this->uid && $items){
                    $shop_ids = array();
                    foreach($items as $k=>$v){
                        $shop_ids[$v['shop_id']] = $v['shop_id'];
                    }
                    if($collect_list = K::M('shop/collect')->items(array('uid'=>$this->uid,'shop_id'=>$shop_ids))){
                        foreach($collect_list as $k=>$v){
                            if($items[$v['shop_id']]){
                                $items[$v['shop_id']]['collect'] = 1;
                            }
                        }
                    }
                }
            }else {
                $items = array();
            }
        
            //幻灯片
            if($adv = K::M('adv/item')->items(array('adv_id'=>1,'audit'=>1,'closed'=>0),array('item_id'=>'asc'), $page,$limit,$count)) {
                foreach($adv as $k=>$v) {
                    $advs[] = $this->filter_fields('adv_id,title,link,thumb', $v);
                }
            }else {
                $advs= array();
            }


            $index_cates = K::M('shop/cate')->items(array('parent_id'=>0),array(),1,7);
            foreach($index_cates as $ick => $icv){
                $index_cates[$ick]['type'] = 0;
            }
            $pt = array(
                'cate_id'=>0,
                'parent_id'=>0,
                'title'=>'拼团',
                'icon'=>'photo/201606/20160629_E8C9C0B3C7379E7D1AFFAF3D88FDE439.png',
                'ico'=>'photo/201606/20160629_E8C9C0B3C7379E7D1AFFAF3D88FDE439.png',
                'childrens'=>array(),
                'link'=>'/pintuan',
                'type'=>1
            );
            $more = array(
                'cate_id'=>0,
                'parent_id'=>0,
                'title'=>'更多',
                'icon'=>'photo/201607/functIco8.png',
                'ico'=>'photo/201607/functIco8.png',
                'childrens'=>array(),
                'link'=>'',
                'type'=>2
            );
            $index_cates[] = $pt;
            $index_cates[] = $more;

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('advs'=>array_values($advs),'cates'=>array_values($index_cates),'items'=>array_values($items), 'total_count'=>$count_shop));
        }
    }
    
    
    
    
    protected function juli_order($a, $b)
    {
        if ($a['juli_sort'] == $b['juli_sort']) {
            return 0;
        }
        return ($a['juli_sort'] < $b['juli_sort']) ? -1 : 1;
    }

    protected function avg_score_order($a, $b)
    {
        if ($a['score'] == $b['score']) {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }

    protected function pei_time_order($a, $b)
    {
        if ($a['pei_time'] == $b['pei_time']) {
            return 0;
        }
        return ($a['pei_time'] < $b['pei_time']) ? -1 : 1;
    }

//获取商户分类
    public function cate()
    {
        $all_shop_num = 0;
        $all_cate = K::M('shop/cate')->items();
        foreach($all_cate as $k=>$v) {
            $all_shop_num += $v['shop_num'];
        }
        $first[] = array(
            'cate_id'=>0,
            'parent_id'=>0,
            'title'=>'全部',
            'icon'=>'photo/201607/cate1.png',
            'orderby'=>0,
            'dateline'=>0,
            'ico'=>'photo/201607/cate1.png',
            'shop_num'=>$all_shop_num,
            'childrens'=>array()
        );
        
        if($tree = K::M('shop/cate')->tree()){
            foreach($tree as $k=>$v){
                $extea_add = 0;
                if($v['childrens']){
                    $a['cate_id'] = $v['cate_id'];
                    $a['parent_id']  = $v['parent_id'];
                    $a['title'] = '全部'.$v['title'];
                    $a['icon'] = $v['icon'];
                    $a['orderby'] = $v['orderby'];
                    $a['dateline'] = $v['dateline'];
                    $a['ico'] = $v['ico'];
                    foreach($v['childrens'] as $k2=>$v2) {
                        $extea_add += $v2['shop_num'];
                    }
                    $a['shop_num'] = $v['shop_num'] + $extea_add;
                    $v['childrens'] = array_merge(array($a), $v['childrens']);
                    $tree[$k] = $v;
                } else{
                    $tree[$k]['childrens'] = array();
                }
                $tree[$k]['shop_num'] = $tree[$k]['shop_num'] + $extea_add;

            }

            $items = array_merge($first,$tree);
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
        }else{
            $this->msgbox->add('获取失败',300);
        }
    }

    public function cate_bak($params)
    {
        $u_lng = $params['lng'];        
        $u_lat = $params['lat'];        
        $squares = K::M('helper/round')->returnSquarePoint($u_lng, $u_lat,10);
        $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
        $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        
        $tree = array();
        $tree[] = array(
            'cate_id'=>0,
            'parent_id'=>0,
            'title'=>'全部',
            'icon'=>'photo/201607/cate1.png',
            'orderby'=>0,
            'dateline'=>0,
            'ico'=>'photo/201607/cate1.png',
            'shop_num'=>0,
            'childrens'=>array()
        );
        if($items = K::M('shop/cate')->fetch_all()){
            $total_num = 0;
            foreach($items as $k=>$v){
                if($v['parent_id']){
                    $tree[$v['parent_id']]['childrens'][] = $v;
                }else{
                    $v['childrens'] = array();
                    $tree[$v['cate_id']] = array_merge((array)$items[$v['cate_id']], $v);
                }
                $total_num += $v['shop_num'];
            }
            
            foreach($tree as $k=>$v){
                if($v['childrens']){
                    $a = $items[$k];
                    $a['title'] = '全部'.$a['title'];
                    $v['childrens'] = array_merge(array($a), $v['childrens']);
                    $tree[$k] = $v;
                }
            }
            $tree[0]['shop_num'] = $total_num;
        }
        
        foreach($tree as $k=>$v) {
            if($v['childrens']) {
                foreach($v['childrens']  as $k2=>$v2) {
                    $parent_shop_num = 0;
                    if($v2['parent_id'] == $v['cate_id']) {
                        $parent_shop_num += $v2['shop_num'];
                    }
                    $tree[$k]['shop_num'] = $tree[$k]['shop_num'] + $parent_shop_num;
                    $tree[$k]['childrens'][0]['shop_num'] = $tree[$k]['childrens'][0]['shop_num'] + $parent_shop_num;   
                }
            }
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
    }

    // public function cate($params)
    // {
    //     $u_lng = $params['lng'];        
    //     $u_lat = $params['lat'];        
    //     $squares = K::M('helper/round')->returnSquarePoint($u_lng, $u_lat,10);
    //     $filter['lat'] = "`lat` BETWEEN '" . $squares['left-bottom']['lat']. "' AND '" .$squares['right-top']['lat'] . "'";
    //     $filter['lng'] = "`lng` BETWEEN '" . $squares['left-bottom']['lng']. "' AND '" .$squares['right-top']['lng'] . "'";
        
        
    //     $tree = array();
    //     $tree[] = array(
    //         'cate_id'=>0,
    //         'parent_id'=>0,
    //         'title'=>'全部',
    //         'icon'=>'photo/201607/cate1.png',
    //         'orderby'=>0,
    //         'dateline'=>0,
    //         'ico'=>'photo/201607/cate1.png',
    //         'shop_num'=>0,
    //         'cate_num'=>0,
    //         'childrens'=>array()
    //     );
    //     $tree[] = array_values(K::M('shop/cate')->get_cate_count($filter['lng'], $filter['lat']));
    //     $this->msgbox->add('success');
    //     $this->msgbox->set_data('data', array('items'=>$tree));
    // }
    
    
    public function cate_index($params){
        $items = K::M('shop/cate')->items(array('parent_id'=>0));
        $pt = array(
            'cate_id'=>0,
            'parent_id'=>0,
            'title'=>'拼团',
            'icon'=>'photo/201606/20160629_E8C9C0B3C7379E7D1AFFAF3D88FDE439.png',
            'ico'=>'photo/201606/20160629_E8C9C0B3C7379E7D1AFFAF3D88FDE439.png',
            'childrens'=>array(),
            'link'=>'/pintuan'
        );
        $items[] = $pt;
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
    
    public function detail_info($params){
        
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add(L('商户不存在'), 211);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商户不存在或已被删除'),212);
        }else if(empty($detail['audit'])){
            $this->msgbox->add(L('商户审核中不可下单'),212);
        }else{
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $detail['coupon_count'] = K::M('shop/coupon')->count(array('shop_id'=>$detail['shop_id']));
            $detail['collect'] = 0;
            if($this->uid && K::M('shop/collect')->count(array('uid'=>$this->uid,'shop_id'=>$detail['shop_id']))){
                $detail['collect'] = 1;
            }
        }
        
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('detail'=>$detail));
        
    }
    
    public function detail($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add(L('商户不存在'), 211);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商户不存在或已被删除'),212);
        }else if(empty($detail['audit'])){
            $this->msgbox->add(L('商户审核中不可下单'),212);
        }else{
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $detail['agv'] = round($detail['praise_num']/$detail['comments'],2)*100; // 好评率计算好传递给APP
            $detail['avg_score'] = ($detail['score_fuwu']+$detail['score_kouwei'])/2;
            $detail['score'] = (round($detail['avg_score'] / $detail['comments'], 2) >= 5 ? 5 : round($detail['avg_score'] / $detail['comments'], 2));
            //echo '<pre>';print_R($detail);die;
            $detail['collect'] = 0;
            if($this->uid && K::M('shop/collect')->count(array('uid'=>$this->uid,'shop_id'=>$detail['shop_id']))){
                $detail['collect'] = 1;
            }

            $cate_list = K::M('waimai/productcate')->items(array('shop_id' => $shop_id), array('parent_id'=>'ASC'));

            //$product_list = K::M('waimai/product')->items(array('shop_id'=>$shop_id), null, 1, 5000);


            /*foreach($cate_list as $k => $v){
                if($res = K::M('waimai/productcate')->items(array('parent_id' => $v['cate_id']), null, 0, 100)){
                    $cate_list[$k]['children'] = array_values($res);
                }else{
                    $cate_list[$k]['children'] = array();
                }
            }*/

            $menu_list = array();
            //遍历分类构造菜单数组
            $ids = array();
            foreach($cate_list as $ck => $cv){
                $ids[$ck] = $ck;
                if($cv['children']){
                    foreach($cv['children'] as $cvk => $cvv){
                       $ids[$cvv['cate_id']] = $cvv['cate_id']; 
                    }
                }
            }
            $orderby = array();
            $orderby['orderby'] = 'desc';
            $orderby['sales'] = 'desc';
            $menu_list = K::M('waimai/product')->items(array('shop_id'=>$shop_id,'is_onsale'=>1,'closed'=>0),$orderby,1,10000);  //查询出所有ID的列表
            foreach($menu_list as $kkk => $vvv){
                if($vvv['is_spec'] == 1){
                    $spec = K::M('waimai/productspec')->items(array('product_id'=>$vvv['product_id']));
                    $spec_arr = array();
                    foreach($spec as $speck=>$specv){
                        $spec_arr[$specv['price']] = $specv['price'];
                    }
                    $spec_price = min($spec_arr);
                    $menu_list[$kkk]['price'] = $spec_price;
                    $menu_list[$kkk]['spec'] = array_values($spec);
                }else{
                   $menu_list[$kkk]['spec'] = array();
                }
            }
   
            //print_r($menu_list);die;
            //循环写出对应分类的结构
            // $menu = array();
            // foreach($cate_list as $clk => $clv){
            //     $cate_list[$clk]['product'] = array();//此行安卓兼容用
            //     foreach($menu_list as $lk2 => $lv2){
            //         if($clk == $lv2['cate_id']){
            //             $cate_list[$clk]['product'][] = $lv2;
            //         }
            //     }
            //     if($clv['children']){
            //         foreach($clv['children'] as $clvk => $clvv){
            //             foreach($menu_list as $lk => $lv){
            //                 if($clvv['cate_id'] == $lv['cate_id']){
            //                     $cate_list[$clk]['children'][$clvk]['product'][] = $lv;
            //                     $cate_list[$clk]['product'][] = $lv;
            //                 }
            //             }
            //         }
            //     }

            // }
            foreach($cate_list as $k=>$v){
                $v['product'] = array();
                $cate_list[$k] = $v;
            }
            foreach($menu_list as $k=>$v){
                if($cate = $cate_list[$v['cate_id']]){
                    $cate_list[$v['cate_id']]['product'][] = $v;
                }
            }
            $items = array();
            foreach($cate_list as $k=>$v){
                if($cate = $cate_list[$v['parent_id']]){
                    $items[$v['parent_id']]['product'] = array_merge($items[$v['parent_id']]['product'], $v['product']);
                }else{
                    $items[$k] = $v;
                }
            }
            foreach($cate_list as $k => $v){
                if(count($v['product']) == 0){
                    unset($cate_list[$k]);
                }
            }

    
            //商家界面数据开始
            $coupon_filter['ltime'] = '>=:' . __TIME;
            $coupon_filter['shop_id'] = $shop_id;
            $coupon_filter['sku'] = '>:0';
            $coupon_filter['closed'] = 0;
            $detail['coupon_count'] = K::M('shop/coupon')->count($coupon_filter);
            $detail['pintuan_count'] = K::M('pintuan/product')->count(array('shop_id'=>$detail['shop_id'],'is_onsale'=>1,'closed'=>0));
            $pics = K::M('shop/pic')->items(array('shop_id'=>$detail['shop_id']));
            $pics_array = array();
            foreach($pics as $pk => $pv){
                $pics_array[$pk] = $pv['photo'];
            }
            $detail['pics'] = array_values($pics_array);
            $detail['pics_count'] = count($detail['pics']);
            
            //评价数据开始
            
            $comment_array = array();
            $comment_array['bad_comment'] = 0;
            $comment_array['m_comment'] = 0;
            $comment_array['good_comment'] = 0;
            $comment_array['all_comment'] = 0;
            if($comment_items = K::M('shop/comment')->items(array('shop_id'=>$shop_id,'closed'=>0))) {
                foreach($comment_items as $k=>$v) {
                    if((($v['score_fuwu']+$v['score_kouwei'])/2) < 3) {
                        $comment_array['bad_comment'] += 1;
                    }
                    if((($v['score_fuwu']+$v['score_kouwei'])/2) == 3) {
                        $comment_array['m_comment'] += 1;
                    }
                    if((($v['score_fuwu']+$v['score_kouwei'])/2) > 3) {
                        $comment_array['good_comment'] += 1;
                    }
                    $comment_array['all_comment'] += 1;
                }
            }
            
            // $comment_array['all_comment'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id));
            // $comment_array['good_comment'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'score_fuwu'=>'>:3','score_kouwei'=>'>:3'));
            // $comment_array['m_comment'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'score_fuwu'=>3,'score_kouwei'=>3));
            // $comment_array['bad_comment'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'score_fuwu'=>'<:3','score_kouwei'=>'<:3'));
            //$comment_array['m_comment'] = $comment_array['all_comment'] - $comment_array['good_comment'] - $comment_array['bad_comment'];
            
            K::M('system/logs')->log('comment', $this->system->db->SQLLOG());
            
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('shop/detail', array($detail['shop_id']), null, 'www'),
                'share_title'=> $detail['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $detail['logo'],
                'share_content'=>$detail['title']
            );
            
            //各种链接返回
            $link = array(
                    'pintuan_link'=>$this->mklink('pintuan/shop', array($detail['shop_id']), null, 'www'),
                   // 'widian_link'=>$this->mklink('weidian/shop', array($detail['shop_id']), null, 'www'),
                    'widian_link'=>$this->mklink('weidian_'.$detail['shop_id'].'/index/', null, null, 'www'),
            );
            if($detail['phone']) {
                $detail['mobile'] = $detail['phone'];
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail,'catelist'=>array_values($items),'comment_array'=>$comment_array,'share'=>$share,'link'=>$link));
            
        }
    }

    
    public function comment_items($params) {  //加载评论
        $page = max((int) $params['page'], 1);
        
        $filter = array();
        //$limit = 10;
        $filter['shop_id'] = $params['shop_id'];
        $type = (int)$params['type'];
        
       
        if($params['content'] == 1){ // 只显示有评价内容的评价记录
            $filter[':SQL'] = " `content`<>''";
        }
        if(($page<=100) && $items = K::M('shop/comment')->items($filter, array('comment_id' => 'desc'), 1, $limit, $count)) {
            $uids = array();
            foreach ($items as $k => $val) {
                $uids[$val['uid']] = $val['uid'];
            }
            $users = K::M('member/member')->items_by_ids($uids);
            foreach ($items as $k => $val) {
                $items[$k]['dateline'] = date('Y-m-d H:i', $val['dateline']);
                foreach ($users as $kk => $v) {
                    if ($val['uid'] == $v['uid']) {
                        $items[$k]['mobile'] = $v['mobile'];
                        $items[$k]['face'] = $v['face'];
                        $items[$k]['nickname'] = $v['nickname'];
                    }
                        //容错
                        if(!$items[$k]['mobile']){
                            $items[$k]['mobile'] = '匿名';
                        }
                        if(!$items[$k]['face']){
                            $items[$k]['face'] = '/default/face.png';
                        }
                        if(!$items[$k]['nickname']){
                            $items[$k]['nickname'] = '匿名';
                        }
                }
                if($val['have_photo']==1){
                    $photo = K::M('shop/photo')->items(array('comment_id'=>$val['comment_id']));
                    $new_photo = array();
                    foreach($photo as $pk => $pv){
                        $new_photo[$pk] = $pv['photo'];
                    }
                    $items[$k]['photo'] = array_values($new_photo);
                } 
                if($val['pei_time']){
                    $items[$k]['pei_time'] = K::M('shop/comment')->timestr($val['pei_time']);
                }
                if(!empty($val['reply'])){
                    $items[$k]['reply_time'] = date('Y-m-d H:i', $val['reply_time']);
                }
                $items[$k]['avg_score'] = ($items[$k]['score_fuwu']+$items[$k]['score_kouwei'])/2;
            }
            foreach($items as $k=>$v) {
                if($type == 3) { //好评
                    if($v['avg_score']<=3) {
                        unset($items[$k]);
                    }
                }
                if($type == 2) { //中评
                    if($v['avg_score'] < 3 || $v['avg_score']>3) {
                        unset($items[$k]);
                    }
                }
                if($type == 1) { //差评
                    if($v['avg_score']>=3) {
                        unset($items[$k]);
                    }
                }
            }
            $items = array_slice($items, ($page-1)*10, 10, true);
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => array_values($items),'sql'=>$this->system->db->SQLLOG()));
    }
    
    
    /*public function coupon($params){
		
		$filter = array();
		
		if($params['shop_id']){
			$filter['shop_id']=$params['shop_id'];
		}else{
			$filter['ltime']='>:'.time();
			$filter['sku']='>:0';
		}
        
        $count = K::M('shop/coupon')->count($filter);
        $page = max((int)$params['page'], 1);
        if($items = K::M('shop/coupon')->items($filter, null, $page, 20,$count)){
            $ids = array();
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('coupon_id,shop_id,order_amount,coupon_amount,stime,ltime,use_count,sku,orderby,dateline',$v);
                $ids[$v['shop_id']] = $v['shop_id'];
            }
            $shops = K::M('shop/shop')->items_by_ids($ids);
            foreach($items as $kk => $vv){
                $items[$kk]['title'] = $shops[$vv['shop_id']]['title'];
                $items[$kk]['logo'] = $shops[$vv['shop_id']]['logo'];
				$items[$kk]['have'] = 0;
				$items[$kk]['used'] = 0;
				$items[$kk]['over'] = 0;
            }
			if($my_coupon = K::M('member/coupon')->items(array('uid'=>$this->uid,'shop_id'=>$params['shop_id']),null,1,1000)){

				foreach($my_coupon as $k=>$v){
					
					foreach($items as $kk => $vv){
						if($v['coupon_id'] == $vv['coupon_id']){
							$items[$v['coupon_id']]['have'] = 1;
							if($v['status'] == 1){
								$items[$v['coupon_id']]['used'] = 1;
							}
							if($v['ltime'] < time())	{
								$items[$v['coupon_id']]['over'] = 1;
							}
						}
					}
									
				}
			}
			
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'total_count'=>$count));
    }*/
    
    
    public function coupon($params){
		
        $filter = array();

        if($params['shop_id']){
            $filter['shop_id']=$params['shop_id'];
        }
        $filter['ltime']='>=:'.time();
        $filter['sku']='>:0';
        $filter['closed'] = 0;
        $count = K::M('shop/coupon')->count($filter);
        $page = max((int)$params['page'], 1);
        if($items = K::M('shop/coupon')->items($filter, null, $page, 5000,$count)){
            $ids = array();
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('coupon_id,shop_id,order_amount,coupon_amount,stime,ltime,use_count,sku,orderby,dateline,status_label',$v);
                $ids[$v['shop_id']] = $v['shop_id'];
                $items[$k]['status_label'] = '未领取';
            }
            $shops = K::M('shop/shop')->items_by_ids($ids);
            foreach($items as $kk => $vv){
                $items[$kk]['title'] = $shops[$vv['shop_id']]['title'];
                $items[$kk]['logo'] = $shops[$vv['shop_id']]['logo'];
            }
        
            if($my_coupon = K::M('member/coupon')->items(array('uid'=>$this->uid,'shop_id'=>$ids),null,1,1000)){
                foreach($my_coupon as $k=>$v){
                    foreach($items as $kk => $vv){
                        if($v['coupon_id'] == $vv['coupon_id']){
                            //unset($items[$v['coupon_id']]);
                            $items[$v['coupon_id']]['status_label'] = '已领取';
                        }
                    }
                }
            }		
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'total_count'=>$count));
    }
    
    
    //店内搜索
    public function search($params){
        if(!$params['keyword']){
            $this->msgbox->add(L('没有输入关键词!'),212);
        }else if(!$shop_id = $params['shop_id']){
            $this->msgbox->add(L('错误的商户!'),213);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('错误的商户'),214);
        }else{
            $filter = array();
            $filter['shop_id'] = $shop_id;
            $filter['title'] = "LIKE:%".$params['keyword']."%";
            $count = K::M('waimai/product')->count($filter);
            $page = (int)$params['page'];
            $limit = 10;
            $products = K::M('waimai/product')->items($filter,$orderby,$page,$limit,$count);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($products),'total_count'=>$count));
        }
    }
    
 }
