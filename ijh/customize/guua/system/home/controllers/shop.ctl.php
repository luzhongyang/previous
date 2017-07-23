<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Shop extends Ctl 
{

    public function index() 
    {
        //查询商家分类
        $cate_list = K::M('shop/cate')->fetch_all();
        $pager = array();
        //分类
        if($cate_id = (int)$this->GP('cate_id')){
            if($cate = $cate_list[$cate_id]){
                $pager['cate'] = $cate;
                $pager['cate_id'] = $cate_id;
            }
        }
        if($cat_id = (int)$this->GP('cat_id')){
             $pager['cat_id'] = $cat_id;
        }
        if($title = (int)$this->GP('title')){
             $pager['title'] = $title;
        }
        if($order = in_array($this->GP('order'), array('time', 'juli', 'sales', 'score', 'price'))){
            $pager['order'] = $order;
        }  
        //筛选
        if($this->GP('is_new')) {//是否新店
            $pager['is_new'] = 1;
        }
        if($this->GP('online_pay')) {// 是否支持在线支付
            $pager['online_pay'] = 1;
        }
        if($this->GP('youhui_first')) {  // 首单优惠
            $pager['youhui_first'] = 1;
        }
        if($this->GP('youhui_order')) {  // 下单立减
            $pager['youhui_order'] = 1;
        }
        if(in_array($this->GP('pei_type'),array(1,2))) {          // 配送类型
            $pager['pei_type'] = $this->GP('pei_type');
        }
        //print_r($pager);die;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cate_tree'] = K::M('shop/cate')->tree();
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
           //使用此函数计算得到结果后，带入sql查询。
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            //分类
            if($cate_id = (int) $this->GP('cate_id')){
                if($cate = $cate_list[$cate_id]){
                    $pager['cate'] = $cate;
                    if($ids = K::M('shop/cate')->children_ids($cate_id)){
                        $cate_ids = explode(',', $ids);
                    }
                    $cate_ids[] = $cate_id;
                    $filter['cate_id'] = $cate_ids;
                }
            }
            
            //排序
            if($this->GP('order') == 'time') { // 送餐速度最快
                $orderby['pei_time'] = 'ASC';
            }else if($this->GP('order') == 'sales') { // 销量最高
                $orderby['orders'] = 'DESC';
            }else if($this->GP('order') == 'score') { // 评价最好
                $orderby['score'] = 'DESC';
            }else if($this->GP('order') == 'price') { // 起送价最低
                $orderby['min_amount'] = 'ASC';
            }
 
            //筛选
            if((int)$this->GP('is_new')) {//是否新店
                $filter['is_new'] = 1;
            }
            if($this->GP('online_pay')) {     // 是否支持在线支付
                $filter['online_pay'] = 1;
            }
            if((int)$this->GP('youhui_first')) {  // 首单优惠
                $filter['first_amount'] = '>:0';
            }
            if((int)$this->GP('youhui_order')) {  // 下单立减
                $filter['youhui'] = "<>:''";
            }

            if($pei_type = (int)$this->GP('pei_type')){
                // 配送类型1:商家配送,2:第三方配送
                if($pei_type == 1){
                    $filter['pei_type'] = 0;
                }else if($pei_type == 2){
                    $filter['pei_type'] = array(1, 2);
                }
            }
            
            $page = max((int)$this->GP('page'), 1);
            $limit = 10;
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)){
                $ids = array();
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields('shop_id,city_id,city_name,juli,youhui,orders,cate_title,title,cate_id,phone,freight,logo,lat,lng,addr,score,score_fuwu,score_kouwei,pei_time,comments,praise_num,min_amount,first_amount,pei_amount,pei_type,yy_status,yy_stime,yy_ltime,is_new,online_pay,info,orders,url', $val);                
                    $val['juli'] = K::M('helper/round')->getdistances($val['lng'], $val['lat'], $lng, $lat);  //距离
                    $val['collect'] = 0;
                    $val['url'] = $this->mklink('shop/detail', array($val['shop_id']));
                    $shop_list[$k] = $val;
                    $ids[$val['shop_id']] = $val['shop_id'];

                    /*$youhui_str = '';
                    if($youhuis){
                        foreach($youhuis as $kkk => $vvv){
                            $youhui_str=$youhui_str.'满'.$vvv['order_amount'].'减'.$vvv['youhui_amount'];
                        }
                        $shop_list[$k]['youhui_str'] = $youhui_str;
                    }*/
                }
                $youhuis = K::M('shop/youhui')->select(array('shop_id'=>$ids));
                foreach($shop_list as $kk => $vv){
                    $shop_list[$kk]['first_amount_title'] = sprintf(L("首次下单立减%s元"), $vv['first_amount']);
                    $str = '';
                    foreach($youhuis as $kkk => $vvv){
                        if($kk == $vvv['shop_id']){
                            $str .= sprintf(L("满%s减%s"), $vvv['order_amount'], $vvv['youhui_amount']);
                        }
                    }
                    $shop_list[$kk]['youhui_str'] = $str;
                }

                if($this->GP('order') == 'juli'){
                    uasort($shop_list, array($this, 'juli_order'));
                }
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
            K::M('system/logs')->log('api.shop.items.sql',$this->system->db->SQLLOG());
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
            
        }else{
            $this->msgbox->add(L('没有指定经纬度'), 211);
        }
    }

    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    public function detail($shop_id) 
    {
        
        $shop_id = (int) $shop_id;
        if (!$shop_id) {
            $this->error(404);
        } else if (!$detail = K::M('shop/shop')->detail($shop_id)) {
            $this->error(404); //$this->msgbox->add('商家不存在', 302);
        } else if ($detail['audit'] != 1 || $detail['closed'] = 0) {
            $this->error(404); //$this->msgbox->add('商家未通过审核或商家被删除', 303);
        }
        $cate_list = K::M('product/cate')->items(array('shop_id' => $shop_id));
        $product_list = K::M('product/product')->items(array('shop_id' => $shop_id, 'closed'=>0),null,1,10000);
        $cate_ids  = array();
        foreach ($product_list as $k => $val) {
            if ($val['sale_type'] == 1) {
                if ($val['sale_sku'] - $val['sale_count'] > 0) {
                    $product_list[$k]['sku'] = $val['sale_sku'] - $val['sale_count'];
                } else {
                    $product_list[$k]['sku'] = 0;
                }
            } else {
                $product_list[$k]['sku'] = 999;
            }
            $cate_ids[$val['cate_id']] = $val['cate_id'];
        }
        $cates = array();
        foreach($cate_list as $k=>$val){
            foreach($cate_ids as $kk=>$v){
                if($val['cate_id'] == $v){
                    $cates[$k] = $val;
                }
            }
        }
        $carts = $this->getcart($shop_id);

        foreach ($cates as $k => $v) {
            $items[$v['cate_id']] = array();
            foreach ($product_list as $kk => $val) {
                if ($carts[$val['product_id']]['cart_num'] > 0) {
                    $val['cart_num'] = $carts[$val['product_id']]['cart_num'];
                } else {
                    $val['cart_num'] = 0;
                }
                if ($v['cate_id'] == $val['cate_id']) {
                    $items[$val['cate_id']][] = $val;
                }
            }
        }
        $total = 0;
        foreach ($carts as $k=>$val){
            $total += $val['cart_num'];
        }
        
        $this->pagedata['total'] = $total;
        $this->pagedata['detail'] = $detail;
        $this->pagedata['cates'] = $cates;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/detail.html';
    }

    public function product($product_id) {
        $product_id = (int) $product_id;
        if (!$product_id) {
            $this->msgbox->add(L('商品不存在'), 301);
        } else if (!$product = K::M('product/product')->detail($product_id)) {
            $this->msgbox->add(L('商品不存在'), 302);
        } else if ($product['closed'] = 0) {
            $this->msgbox->add(L('商品已下架'), 303);
        }
        $carts = $this->getcart($product['shop_id']);
        if ($carts[$product_id]['cart_num'] > 0) {
            $product['cart_num'] = $carts[$product_id]['cart_num'];
        } else {
            $product['cart_num'] = 0;
        }
        if ($product['sale_type'] == 1) {
            if ($product['sale_sku'] - $product['sale_count'] > 0) {
                $product['sku'] = $product['sale_sku'] - $product['sale_count'];
            } else {
                $product['sku'] = 0;
            }
        } else {
            $product['sku'] = 999;
        }
        $total = 0;
        foreach ($carts as $k=>$val){
            $total += $val['cart_num'];
        }
        $this->pagedata['total'] = $total;
        $this->pagedata['product'] = $product;
        $detail = K::M('shop/shop')->detail($product['shop_id']);
        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'shop/product.html';
    }

    public function shop($shop_id) {   //商家
        $shop_id = (int) $shop_id;
        if (!$shop_id) {
            $this->msgbox->add(L('商家不存在'), 301);
        } else if (!$detail = K::M('shop/shop')->detail($shop_id)) {
            $this->msgbox->add(L('商家不存在'), 302);
        } else if ($detail['audit'] != 1 || $detail['closed'] = 0) {
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }

        if($res = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $detail['collect'] = 1;
        }else{
            $detail['collect'] = 0;
        }
        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'shop/shop.html';
    }

    public function comment($shop_id) {    //点评
        $shop_id = (int) $shop_id;
        if (!$shop_id) {
            $this->msgbox->add(L('商家不存在或已被删除'), 301);
        } else if (!$detail = K::M('shop/shop')->detail($shop_id)) {
            $this->msgbox->add(L('商家不存在或已被删除'), 302);
        } else if ($detail['audit'] != 1 || $detail['closed'] = 0) {
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }
        $detail['agv'] = round($detail['praise_num'] / $detail['comments'], 2) * 100;
        $this->pagedata['detail'] = $detail;
        $this->tmpl = 'shop/comment.html';
    }

    public function items() {  //加载评论
        $page = max((int) $this->GP('page'), 1);
        $filter = array();
        $limit = 10;
        $filter['shop_id'] = (int) $this->GP('shop_id');
        $items = K::M('shop/comment')->items($filter, array('comment_id' => 'desc'), $page, $limit, $count);
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
                }
            }
            if($val['have_photo']>1){
                $photo = K::M('shop/photo')->items(array('comment_id'=>$val['comment_id']));   
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
        if(!$shop_id = (int)$shop_id) {
            $this->msgbox->add(L('商家不存在'),202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'),203);
         } else if ($detail['audit'] != 1 || $detail['closed'] = 0) {
            $this->msgbox->add(L('商家未通过审核或商家被删除'),204);
        }else if($result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add(L('已经收藏过了'),205);
        }else if(K::M('shop/collect')->create(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add(L('SUCCESS'));
        }else{
            $this->msgbox->add(L('SUCCESS'));
        }
    }

    
    public function cancel($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int)$shop_id) {
            $this->msgbox->add(L('商家不存在或已被删除'),202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'),203);
        }else if($detail['audit'] !=1||$detail['closed'] !=0) {
            $this->msgbox->add(L('商家未通过审核或商家被删除'),204);
        }else if(!$result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add(L('您还没有收藏该商家'),205);
        }else {
            if(K::M('shop/collect')->delete('shop_id='.$shop_id.' and uid='.$this->uid)){  //
                $this->msgbox->add(L('SUCCESS'));
            }

        }


    }
 
}