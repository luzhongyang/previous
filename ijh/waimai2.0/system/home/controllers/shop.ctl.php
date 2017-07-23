<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop extends Ctl
{

    public function index()
    {
        $lng = $this->GP('lng');
        $lat = $this->GP('lat');
        if(!$lng || !$lat){
            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
        }
        if($lng && $lat){
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 10);
            $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];
        }
        $total_shop_num = 0;
        //查询商家分类
        $cate_list = K::M('shop/cate')->fetch_all();
        $pager = array();
        //分类
        if($cate_id = (int) $this->GP('cate_id')){
            if($cate = $cate_list[$cate_id]){
                $pager['cate'] = $cate;
                $pager['cate_id'] = $cate_id;
            }
        }
        $this->pagedata['pager'] = $pager;
        $cate_tree = K::M('shop/cate')->tree();
        foreach($cate_tree as $k => $v){
            $cate_tree[$k]['shop_num'] = K::M('shop/shop')->count(array('cate_id'=>$v['cate_id'],'closed'=>0,'audit'=>1,'verify_name'=>1,'lng'=>$filter['lng'],'lat'=>$filter['lat']));
            foreach($v['childrens'] as $k1 => $v1){
                $cate_tree[$k]['childrens'][$k1]['shop_num'] = K::M('shop/shop')->count(array('cate_id'=>$v1['cate_id'],'closed'=>0,'audit'=>1,'verify_name'=>1,'lng'=>$filter['lng'],'lat'=>$filter['lat']));
                $cate_tree[$k]['shop_num'] = $cate_tree[$k]['shop_num'] + $cate_tree[$k]['childrens'][$k1]['shop_num'];
            }
            $total_shop_num += $cate_tree[$k]['shop_num'];
        }
        $this->pagedata['cate_tree'] = $cate_tree;
        $this->pagedata['total_count'] = $total_shop_num;

        $this->tmpl = 'shop/index.html';
    }

    public function loaditems()
    {
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
            $cate_list = K::M('shop/cate')->fetch_all();
            $filter = $pager = $orderby = array();
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 10);
            $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];
            // 分类
            if($cate_id = (int) $this->GP('cate_id')){
                if($cate = $cate_list[$cate_id]){
                    $pager['cate'] = $cate;
                    if($ids = K::M('shop/cate')->children_ids($cate_id)){
                        $cate_ids = explode(',', $ids);
                    }
                    $filter['cate_id'] = $cate_ids;
                }
            }

            // 排序
            if($this->GP('orderby') == 'default'){
                $orderby['orderby'] = 'ASC';
                $orderby['praise_num'] = 'DESC';
                $orderby['orders'] = 'DESC';
            }else if($this->GP('orderby') == 'time'){
                $orderby['pei_time'] = 'ASC';
            }else if($this->GP('order') == 'sales'){
                $orderby['orders'] = 'DESC';
            }else if($this->GP('orderby') == 'score'){
                $orderby['score'] = 'DESC';
            }else if($this->GP('orderby') == 'min_amount'){
                $orderby['min_amount'] = 'ASC';
            }else{
                $orderby['orderby'] = 'ASC';
                $orderby['praise_num'] = 'DESC';
                $orderby['orders'] = 'DESC';
            }


            // 筛选 online_pay: 1, is_new: 1, pei_type: "shop", youhui: "coupon"
            if($this->GP('online_pay')){
                $filter['online_pay'] = 1;
            }
            if($this->GP('is_new')){
                $filter['is_new'] = 1;
            }
            if($this->GP('pei_type') == 'shop'){
                $filter['pei_type'] = 0;
            }else if($this->GP('pei_type') == 'pintai'){
                $filter['pei_type'] = 1;
            }else if($this->GP('pei_type') == 'all'){
                $filter['pei_type'] = array(0, 1, 2);
            }
            if($this->GP('youhui') == 'coupon'){
                $filter[':SQL'] = "coupon !=''";
            }else if($this->GP('youhui') == 'youhui'){
                $filter[':SQL'] = "youhui !=''";
            }else if($this->GP('youhui') == 'first_amount'){
                $filter['first_amount'] = '>:0';
            }

            if($title = $this->GP('title')){
                $filter['title'] = "LIKE:%" . $title . "%";
            }

            $page = max((int) $this->GP('page'), 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $filter['verify_name'] = 1;
//            print_r($filter);die;
            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)){
                $ids = array();
                foreach($shop_list as $k => $val){
                    $val = $this->filter_fields('shop_id,city_id,city_name,juli,youhui,orders,cate_title,title,cate_id,phone,freight,logo,lat,lng,addr,score,score_fuwu,score_kouwei,pei_time,comments,praise_num,min_amount,first_amount,pei_amount,pei_type,yy_status,yy_status_type,yy_stime,yy_ltime,is_new,online_pay,info,orders,link,youhui_title,coupon_title,coupon,freight_price', $val);
                    $val['juli'] = K::M('helper/round')->getdistances($val['lng'], $val['lat'], $lng, $lat);  //距离
                    $val['link'] = $this->mklink('shop/detail', array('args' => $val['shop_id']));
                    $val['avg_score'] = ($val['score_kouwei'] + $val['score_fuwu'])/2;
                    $val['star'] = (round($val['avg_score'] / $val['comments'], 2) >= 5 ? 5 : round($val['avg_score'] / $val['comments'], 2));
                    if($val['pei_time'] == 0) {
                        $val['pei_time'] = 30;
                    }
                    $shop_list[$k] = $val;
                }
                $items = $shop_list;
                if($this->GP('orderby') == 'juli'){
                    uasort($items, array($this, 'juli_order'));
                }
                $items = array_slice($items, ($page - 1) * 10, 10, true);
            }else{
                $items = array();
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items' => array_values($items)));
        }else{
            $this->msgbox->add('没有指定经纬度', 211);
        }
    }

    protected function juli_order($a, $b)
    {
        if($a['juli'] == $b['juli']){
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    public function detail($shop_id)
    {
        $shop_id = (int) $shop_id;
        if(!$shop_id){
            $shop_id = (int) $this->GP('shop_id');  //获取menu菜单用
        }
        if(!$shop_id){
            $this->error(404);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->error(404); //$this->msgbox->add('商家不存在', 302);
        }else if($detail['audit'] != 1 || $detail['closed'] = 0){
            $this->error(404); //$this->msgbox->add('商家未通过审核或商家被删除', 303);
        }
        $cate_list = K::M('waimai/productcate')->items(array('shop_id' => $shop_id));


        $this->pagedata['cate_list'] = $cate_list;

        $children = array();
        foreach($cate_list as $k => $v){
            if(0 == K::M('waimai/product')->count(array('cate_id'=>$v['cate_id']))) {
                unset($cate_list[$k]);
            }

            // if($res = K::M('waimai/productcate')->items(array('parent_id' => $cate_list[$k]['cate_id']), null, 1, $limit,$count)){
            //     $cate_list[$k]['children'] = array_values($res);
            // }else{
            //     $cate_list[$k]['children'] = array();
            // }

        }

        $this->pagedata['left_menu_list'] = $cate_list;

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
        $menu_list = K::M('waimai/product')->items(array('cate_id' => $ids,'shop_id' => $shop_id, 'closed'=>0, 'is_onsale' => 1), $orderby, 1, 10000);  //查询出所有ID的列表
        //print_r($menu_list);die;
        //循环写出对应分类的结构
        $menu = array();

        foreach($cate_list as $clk => $clv){
            foreach($menu_list as $lk2 => $lv2){
                if($clk == $lv2['cate_id']){
                    $menu[$clk][$lv2['product_id']] = $lv2;
                }
            }

            if($clv['children']){
                foreach($clv['children'] as $clvk => $clvv){
                    foreach($menu_list as $lk => $lv){
                        if($clvv['cate_id'] == $lv['cate_id']){
                            $menu[$clvk][$lv['product_id']] = $lv;
                            $menu[$clk][$lv['product_id']] = $lv;
                        }
                    }
                }
            }
        }

        //前端, json解析序列bug,导致排序失效:wu
        $menu_sort = array();
        foreach ($menu as $k => $v) {
            $menu_sort[$k] = array_values($v);
        }
        $menu = $menu_sort;


        $this->pagedata['product_list'] = json_encode($menu);


        //凑一凑的数组
        $new_menu_list = $menu_list;
        foreach($new_menu_list as $mk => $mv){
            if($mv['price'] > $detail['min_amount']){
                unset($mk);
            }
        }
        //查询是否收藏过
        $is_collect = K::M('shop/collect')->count(array('uid' => $this->uid, 'shop_id' => $shop_id));
        if($detail['pei_time'] == 0) {
            $detail['pei_time'] = 30;
        }
        $this->pagedata['is_collect'] = $is_collect;
        $this->pagedata['cou_list'] = $new_menu_list;
        $this->pagedata['children'] = $cate_list;

        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'shop/detail.html';
    }

    /* 商品详情 */

    public function product_detail($product_id)
    {
        if(!$product_id = (int) $product_id){
            $this->msgbox->add('参数不正确', 121);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->error(404);
        }else if(!$shop_detail = K::M('shop/shop')->detail($detail['shop_id'])){
            $this->msgbox->add('非法访问', 124);
        }else{
            if($spec_list = K::M('waimai/productspec')->items(array('product_id' => $product_id))){
                foreach($spec_list as $k => $v){
                    $spec_list[$k]['package_price'] = $detail['package_price'];
                    $spec_list[$k]['sale_type'] = $detail['sale_type'];
                    $spec_list[$k]['stock'] = $detail['stock'];
                    if(empty($v['spec_photo'])){
                        $spec_list[$k]['spec_photo'] = $detail['photo'];
                    }
                }
            }
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = $shop_detail;
            $this->pagedata['spec_list'] = $spec_list;
            $this->tmpl = 'shop/product_detail.html';
        }
    }

    public function shop($shop_id)
    {   //商家
        $shop_id = (int) $shop_id;
        if(!$shop_id){
            $this->msgbox->add(L('商家不存在'), 301);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'), 302);
        }else if($detail['audit'] != 1 || $detail['closed'] = 0){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }else{
            if($res = K::M('shop/collect')->find(array('uid' => $this->uid, 'shop_id' => $shop_id))){
                $detail['collect'] = 1;
            }else{
                $detail['collect'] = 0;
            }
            if($detail['pei_time'] == 0) {
                $detail['pei_time'] = 30;
            }
            $detail['coupons'] = K::M('shop/coupon')->count(array('shop_id' => $shop_id, 'ltime' => ">:" . __TIME, 'sku' => '>:0'));
            $detail['pintuans'] = K::M('pintuan/product')->count(array('shop_id' => $shop_id, 'closed' => 0, 'is_onsale' => 1, 'stock' => ">:0"));
            $this->pagedata['pics'] = K::M('shop/pic')->items(array('shop_id' => $shop_id), array('pic_id' => 'desc'), 1, 100, $count);
            $this->pagedata['pic_count'] = $count;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'shop/shop.html';
        }
    }

    public function comment($shop_id)
    {    //点评
        $shop_id = (int) $shop_id;
        if(!$shop_id){
            $this->msgbox->add(L('商家不存在或已被删除'), 301);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'), 302);
        }else if($detail['audit'] != 1 || $detail['closed'] = 0){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }
        $detail['agv'] = round($detail['praise_num'] / $detail['comments'], 2) * 100;

        $where = array('shop_id' => $shop_id);
        $comment_array = array();
        $comment_array['all_comment'] = K::M('shop/comment')->count($where);

        $where['score_fuwu'] = '>:3';
        $where['score_kouwei'] = '>:3';
        $comment_array['good_comment'] = K::M('shop/comment')->count($where);

        $where = array('shop_id' => $shop_id);
        $where[':SQL'] = " (score_fuwu<3 || score_kouwei <3) "; //差评
        $comment_array['bad_comment'] = K::M('shop/comment')->count($where);

        $comment_array['m_comment'] = $comment_array['all_comment'] - $comment_array['good_comment'] - $comment_array['bad_comment'];

        $this->pagedata['comment_array'] = $comment_array;

        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'shop/comment.html';
    }

    public function items()
    {  //加载评论
        $page = max((int) $this->GP('page'), 1);

        $filter = array();
        $limit = 10;
        $filter['shop_id'] = (int) $this->GP('shop_id');
        $type = (int) $this->GP('type');
        $is_content = (int) $this->GP('is_content');

        if($type == 3){
            $filter['score_fuwu'] = '>:3';
            $filter['score_kouwei'] = '>:3'; //好评
        }else if($type == 2){
           $filter[':SQL'] = " ( score_fuwu=3 && score_kouwei =3) ";  //中评
        }else if($type == 1){
            if(1 == $is_content){
                $filter[':SQL'] = " `content`<>'' && ( score_fuwu<3 || score_kouwei <3) ";
            }else{
                $filter[':SQL'] = " ( score_fuwu<3 || score_kouwei <3) "; //差评
            }

        }

        $items = K::M('shop/comment')->items($filter, array('comment_id' => 'desc'), $page, $limit, $count);
        $uids = array();
        foreach($items as $k => $val){
            $uids[$val['uid']] = $val['uid'];
        }
        $users = K::M('member/member')->items_by_ids($uids);

        foreach($items as $k => $val){
            $items[$k]['dateline'] = date('Y-m-d H:i', $val['dateline']);
            foreach($users as $kk => $v){
                if($val['uid'] == $v['uid']){
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
            if($val['have_photo'] == 1){
                $photo = K::M('shop/photo')->items(array('comment_id' => $val['comment_id']));
                $items[$k]['photo'] = $photo;
            }
            if($val['pei_time']){
                $items[$k]['pei_time'] = K::M('shop/comment')->timestr($val['pei_time']);
            }
            if(!empty($val['reply'])){
                $items[$k]['reply_time'] = date('Y-m-d H:i', $val['reply_time']);
            }
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => array_values($items)));
    }

    public function collect($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 203);
        }else if($detail['audit'] != 1 || $detail['closed'] = 0){
            $this->msgbox->add('商家未通过审核或商家被删除', 204);
        }else{
            if($result = K::M('shop/collect')->find(array('uid' => $this->uid, 'shop_id' => $shop_id))){
                if(K::M('shop/collect')->del($this->uid, $shop_id)){
                    $this->msgbox->add('取消收藏成功', 205);
                }
            }else{
                if(K::M('shop/collect')->create(array('uid' => $this->uid, 'shop_id' => $shop_id))){
                    $this->msgbox->add('收藏商家成功');
                }
            }
        }
    }

    public function cancel($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add(L('商家不存在或已被删除'), 202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'), 203);
        }else if($detail['audit'] != 1 || $detail['closed'] != 0){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 204);
        }else if(!$result = K::M('shop/collect')->find(array('uid' => $this->uid, 'shop_id' => $shop_id))){
            $this->msgbox->add(L('您还没有收藏该商家'), 205);
        }else{
            if(K::M('shop/collect')->delete('shop_id=' . $shop_id . ' and uid=' . $this->uid)){  //
                $this->msgbox->add(L('操作成功'));
            }
        }
    }

    // 优惠券列表
    public function coupon($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 202);
        }else if($detail['audit'] != 1 || $detail['closed'] != 0){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 204);
        }else{
            //查找用户已经领取的列表
            $use_filter = array();
            $use_filter['uid'] = $this->uid;
            if($shop_id > 0){
                $use_filter['shop_id'] = $shop_id;
            }
            $user_coupon = K::M('member/coupon')->select($use_filter);
            $arr_user_coupon = array();
            foreach($user_coupon as $k => $v){
                $arr_user_coupon[] = $v['coupon_id'];
            }
            $this->pagedata['arr_user_coupon'] = $arr_user_coupon;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['items'] = K::M('shop/coupon')->items(array('shop_id' => $shop_id, 'sku' => '>:0', 'ltime' => '>:' . time(), 'closed'=>0), null, 1, 100, $count);
            $this->tmpl = 'shop/coupon.html';
        }
    }

    // 领取优惠券
    public function getcoupon()
    {
        $this->check_login();
        if(!$shop_id = (int) $this->GP('shop_id')){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$coupon_id = (int) $this->GP('coupon_id')){
            $this->msgbox->add('优惠券不存在', 202);
        }else if(!$coupon = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add('优惠券不存在', 203);
        }else if($coupon['ltime'] < __TIME){
            $this->msgbox->add('优惠券已过期', 204);
        }else if($coupon['shop_id'] != $shop_id){
            $this->msgbox->add('非法操作', 205);
        }else if(K::M('member/coupon')->find(array('coupon_id' => $coupon_id, 'uid' => $this->uid))){
            $this->msgbox->add('您已经领取过了', 206);
        }else{
            $data['coupon_id'] = $coupon_id;
            $data['uid'] = $this->uid;
            $data['use_time'] = 0;
            $data['order_id'] = 0;
            $data['status'] = 0;
            $data['order_amount'] = $coupon['order_amount'];
            $data['coupon_amount'] = $coupon['coupon_amount'];
            $data['ltime'] = $coupon['ltime'];
            $data['shop_id'] = $coupon['shop_id'];
            if(K::M('member/coupon')->create($data)){
                K::M('shop/coupon')->update_count($coupon_id, 'sku', -1);
                K::M('shop/coupon')->update_count($coupon_id, 'picked', 1);
                $this->msgbox->add('成功领取' . $coupon['coupon_amount'] . '元优惠券一张');
            }
        }
    }

    // 商家地址地图
    public function locate($shop_id)
    {
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 202);
        }else{
            $this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
            $this->tmpl = 'shop/locate.html';
        }
    }

    // 搜索店内商品页面
    public function searchgoods($shop_id)
    {
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 202);
        }else{
            $this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
            $this->tmpl = 'shop/searchgoods.html';
        }
    }

    // 根据关键词搜索店内商品
    public function searchtitle()
    {
        if(isset($_POST)){
            $filter['closed'] = 0;
            $filter['is_onsale'] = 1;
            $filter['title'] = "LIKE:%" . $this->GP('title') . "%";
            $filter['shop_id'] = (int) $this->GP('shop_id');
            if($items = K::M('waimai/product')->items($filter, null, 1, 500, $count)){
                foreach($items as $k => $v){
                    $items[$k]['url'] = $this->mklink('shop/product_detail', array('args' => $v['product_id']));
                }
                $this->msgbox->set_data('data', array('items' => array_values($items)));
            }else{
                $this->msgbox->set_data('data', array('items' => array()));
            }
        }
    }

    // 举报商家页面
    public function complaint($shop_id)
    {
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 202);
        }else{
            $remarks = K::M('order/order')->get_complaint();
            $this->pagedata['remarks'] = $remarks['shop'];
            $this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
            $this->tmpl = 'shop/complaint.html';
        }
    }

    // 举报商家表单提交
    public function subcomplaint()
    {
        $this->check_login();
        if(!$data['shop_id'] = (int) $this->GP('shop_id')){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$data['title'] = $this->GP('title')){
            $this->msgbox->add('请选择投诉理由', 204);
        }else if(!$data['content'] = $this->GP('content')){
            $this->msgbox->add('请填写描述详情', 205);
        }else if(K::M('order/complaint')->find(array('order_id' => 0, 'shop_id' => $data['shop_id'], 'uid' => $this->uid))){
            $this->msgbox->add('您已经举报过该商家了', 206);
        }else{
            $data['uid'] = $this->uid;
            $data['order_id'] = 0;
            if(K::M('order/complaint')->create($data)){
                $this->msgbox->add('举报成功');
            }else{
                $this->msgbox->add('举报失败', 207);
            }
        }
    }

}
