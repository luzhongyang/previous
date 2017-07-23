<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Pintuan extends Ctl
{

    /**
     * 拼团
     */
    public function index($cate_id)
    {
        //查询分类
        $cate = K::M('weidian/productcate')->fetch_all();
        foreach($cate as $k => $v){
            if($v['shop_id'] != $this->shop_id){
                unset($cate[$k]);
            }
        }
        foreach($cate as $k => $v){
            if($v['parent_id'] > 0){
                $cate[$v['parent_id']]['children'][] = $v;
                unset($cate[$k]);
            }
        }
        if($title = strip_tags(trim($this->GP('title')))){
            $pager['title'] = $title;
        }
        if($cate_id = (int) $cate_id){
            $pager['cate_id'] = $cate_id;
        }
        $this->pagedata['cate_id'] = $cate_id;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cate'] = $cate;
        $this->tmpl = 'weidian/pintuan/index.html';
    }

    public function loaditems($page = 1)
    {

        //查询默认拼团列表
        $filter = array(
            'shop_id' => $this->shop_id,
            'type'    => 'pintuan',
            'closed'  => 0
        );

        if($title = strip_tags(trim($this->GP('title')))){
            $filter['title'] = "LIKE:%" . $title . "%";
        }
        if($cate_id = (int) $this->GP('cate_id')){
            $res = K::M('weidian/productcate')->getChildren($cate_id);
            $filter['cate_id'] = $res;
        }

        $page = max((int) $page, 1);
        $limit = 10;

        if(!$product = K::M('weidian/product')->items($filter, array('product_id' => 'desc'), $page, $limit, $count)){
            $product = array();
        }

        $product_ids = array();
        foreach($product as $k => $v){
            $product[$k]['is_collect'] = 0;
            $product_ids[$v['product_id']] = $v['product_id'];
        }
 
        $product_details = K::M('weidian/pintuan/product')->items_by_ids($product_ids);
        foreach($product_details as $k => $v){
            if($product[$v['product_id']]){
                $product[$v['product_id']]['detail'] = $v;
            }
        }

        //查询我的收藏列表
        $collects = K::M('weidian/collect')->items(array('product_id' => $product_ids, 'uid' => $this->uid));
        foreach($collects as $k => $v){
            if($product[$v['product_id']]){
                $product[$v['product_id']]['is_collect'] = 1;
            }
        }

        $count_num = K::M('weidian/product')->count($filter);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['product'] = $product;
        $this->tmpl = 'weidian/pintuan/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    /**
     * 拼团详情
     */
    public function detail($product_id)
    {
        if(!(int) $product_id || !$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('产品不存在!', 211);
        }
        else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('该产品不属于当前店铺!', 212);
        }
        else if($detail['type'] != 'pintuan'){
            $this->msgbox->add('产品错误非拼团类!', 213);
        }
        else{
            $detail['detail'] = K::M('weidian/pintuan/product')->detail($product_id);
            if($detail['detail']['tuan_type'] == 1){
                $detail['detail']['level'] = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $product_id));
            }
            //查询我的收藏状态
            $is_collect = K::M('weidian/collect')->items(array('product_id' => $product_id, 'uid' => $this->uid));
            $this->pagedata['is_collect'] = $is_collect;

            if($attrgroups = K::M('weidian/product/attrgroup')->items(array('product_id' => $product_id), array('attr_group_id' => 'asc'))){
                $group_ids = array();
                foreach($attrgroups as $k => $v){
                    $group_ids[$v['attr_group_id']] = $v['attr_group_id'];
                }
                $values = K::M('weidian/product/attrvalue')->items(array('attr_group_id' => $group_ids), array('attr_value_id' => 'asc'));
                foreach($attrgroups as $k => $v){
                    foreach($values as $k1 => $v1){
                        if($v['attr_group_id'] == $v1['attr_group_id']){
                            $attrgroups[$k]['values'][] = $v1;
                        }
                    }
                }
                $this->pagedata['attrgroups'] = $attrgroups;
            }

            $detail['intro'] = htmlspecialchars_decode($detail['intro']);

            $this->pagedata['length'] = count($attrgroups);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'weidian/pintuan/detail.html';
        }
    }
    
    /**
     * 开团后的详情
     * @param type $order_id 
     */
    public function open_detail($group_id){

        if(!$arr_group = K::M('weidian/pintuan/group')->detail($group_id)){
            $this->msgbox->add('错误!',212);
        }else if(!$detail = K::M('weidian/product')->detail($arr_group['product_id'])){
            $this->msgbox->add('错误!',213);
        }else if(!$arr_order = K::M('weidian/pintuan/order')->order_from_group_id($arr_group['group_id'])){
            $this->msgbox->add('错误!',214);
        }else if(!$arr_product = K::M('weidian/pintuan/product')->detail($arr_group['product_id'])){
            $this->msgbox->add('错误!',215);
        }else{
            $pintuan_order = K::M('weidian/pintuan/order')->items(array('uid'=>$this->uid,'group_id'=>$group_id));
            K::M('weidian/pintuan/group')->group_auto_check($group_id); //检测当前团是否过期
            $detail['detail'] = K::M('weidian/pintuan/product')->detail($arr_group['product_id']);
            $product_id = $arr_group['product_id'];
            if($detail['detail']['tuan_type'] == 1){
                $detail['detail']['level'] = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $product_id));
            }
            //查询我的收藏状态
            $is_collect = K::M('weidian/collect')->items(array('product_id' => $product_id, 'uid' => $this->uid));
            $arr_group['master'] = K::M('member/member')->detail($arr_group['master_id']);
            $this->pagedata['arr_order'] = $arr_order;
            $this->pagedata['arr_order_count'] = count($arr_order);

            //查询规格
            if($attrgroups = K::M('weidian/product/attrgroup')->items(array('product_id' => $product_id), array('attr_group_id' => 'asc'))){
                $group_ids = array();
                foreach($attrgroups as $k => $v){
                    $group_ids[$v['attr_group_id']] = $v['attr_group_id'];
                }
                $values = K::M('weidian/product/attrvalue')->items(array('attr_group_id' => $group_ids), array('attr_value_id' => 'asc'));
                foreach($attrgroups as $k => $v){
                    foreach($values as $k1 => $v1){
                        if($v['attr_group_id'] == $v1['attr_group_id']){
                            $attrgroups[$k]['values'][] = $v1;
                        }
                    }
                }
                $this->pagedata['attrgroups'] = $attrgroups;
                $this->pagedata['length'] = count($attrgroups);
            }

            
            //检测当前访问用户是否已经参团
            $join_uids = array();
            foreach($arr_order as $k => $v){
                $join_uids[$v['uid']] = $v['uid'];
            }
            if(in_array($this->uid,$join_uids)){
                $is_join = 1;
            }else{
                $is_join = 0;
            }
            
            //相关产品
            $like_product = K::M('weidian/product')->items(array('shop_id'=>$this->shop_id,'type'=>'pintuan','product_id'=>'<>:'.$product_id));

            $detail['intro'] = htmlspecialchars_decode($detail['intro']);
            //检测团长是否购买,未购买,不允许分享
            $master_is_buy = K::M('weidian/pintuan/group')->master_is_buy($group_id);
            $this->pagedata['like_product'] = $like_product;
            $this->pagedata['master_is_buy'] = $master_is_buy;
            $this->pagedata['is_join'] = $is_join;
            $this->pagedata['group'] = $arr_group;
            $this->pagedata['arr_order'] = $arr_order;
            $this->pagedata['order'] = array_values($pintuan_order);
            $this->pagedata['detail'] = $detail;
            $this->pagedata['is_collect'] = $is_collect;

            $this->tmpl = 'weidian/pintuan/open_detail.html';
        }

    }
    
    
    
    
    

    /**
     * 商品收藏
     */
    public function ajax_collect($product_id)
    {
        $this->check_login();
        if(IS_AJAX){
            if(!(int) $product_id || !$detail = K::M('weidian/product')->detail($product_id)){
                $this->msgbox->add('商品错误!', 211);
            }
            else{
                //查询该商品是否被收藏
                $is_collect = K::M('weidian/collect')->find(array('product_id' => $product_id, 'uid' => $this->uid,'shop_id'=>$detail['shop_id']));
                if($is_collect){
                    K::M('weidian/collect')->delete($is_collect['collect_id']);
                    $this->msgbox->add('取消收藏成功!');
                }
                else{
                    K::M('weidian/collect')->create(array('product_id' => $product_id, 'uid' => $this->uid,'shop_id'=>$detail['shop_id']));
                    $this->msgbox->add('收藏商品成功!');
                }
            }
        }
    }

    /**
     * 下单页面
     * product_id 产品ID
     * type 1:单独购买 2:开团
     * num 商品个数
     * stock_id 属性ID
     */
    public function order($product_id, $type, $num, $stock_id)
    {

        if(!$product_id = (int) $product_id){
            $this->msgbox->add('商品错误!', 211);
        }
        else if(!$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('商品错误!', 212);
        }
        else if(!$detail['detail'] = K::M('weidian/pintuan/product')->detail($product_id)){
            $this->msgbox->add('商品错误!', 213);
        }
        else if(!in_array($type, array(1, 2))){
            $this->msgbox->add('购买方式错误!', 214);
        }
        else if($num > $detail['stock']){
            $this->msgbox->add('库存不足!', 216);
        }
        else if($num < 1){
            $this->msgbox->add('数量错误!', 217);
        }
        else{
            if($type == 2){  //如果是开团类型，数量一定是1
                $num = 1;
            }

            //如果是阶梯团，查询阶梯团信息
            if($detail['detail']['tuan_type'] == 1){
                if($detail['level'] = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $product_id))){
                    $level = array();
                    foreach($detail['level'] as $k => $v){
                        $level[$v['price']] = $v['price'];
                    }
                    $detail['level']['min'] = min($level);
                    $detail['level']['max'] = max($level);
                }
            }

            //如果不是阶梯团，才会涉及查询规格属性
            if($detail['detail']['tuan_type'] == 0 && $stock_id > 0){
                if($stock = K::M('weidian/product/attrstock')->detail($stock_id)){
                    //统一拼团多属性价格为商品原价
                    $stock['price'] = $detail['wei_price'];
                    $this->pagedata['stock'] = $stock;
                }
            }



            //查询我的地址
            $my_addr = K::M('member/addr')->items(array('uid' => $this->uid));
            if($my_addr){
                foreach($my_addr as $k => $v){
                    if($v['is_default'] == 1){
                        $default_addr = $v;
                    }
                }
                if(!$default_addr){
                    $default_addr = array_slice($my_addr, 0, 1);
                    $default_addr = $default_addr[0];
                }
            }

            //计算本次订单需要支付的价格
            if($type == 1){
                if($stock){
                    $price = $stock['price'] * $num;
                }
                else{
                    $price = $detail['price'] * $num;
                }
            }
            else if($type == 2){
                if($detail['detail']['tuan_type'] == 1){
                    $price = $detail['detail']['money_pre'];
                }
                else{
                    if($stock){
                        $price = $stock['price'] * $num;
                    }
                    else{
                        $price = $detail['wei_price'] * $num;
                    }
                }
            }

            //查询可使用的优惠券
            $coupon = K::M('member/coupon')->items(array('shop_id' => $detail['shop_id'], 'uid' => $this->uid, 'ltime' => '>:' . time(), 'status' => 0, 'order_amount' => '<=:' . $price), array('coupon_amount'=>'desc'));
            $new_coupon = array();
            foreach($coupon as $k => $v){
                $new_coupon[$v['coupon_amount']] = $v;
                break;
            }

            $new_coupon = max($new_coupon);
            $this->pagedata['price'] = $price; //传递本次订单价格，用来选择优惠券
            $this->pagedata['coupon'] = $new_coupon;
            $this->pagedata['default_addr'] = $default_addr;
            $this->pagedata['type'] = $type;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['num'] = $num;
            $this->pagedata['stock_id'] = $stock_id;
    
            if($type == 1){//单人
                $this->tmpl = 'weidian/pintuan/order_one.html';
            }
            else if($type == 2){//团
                $this->tmpl = 'weidian/pintuan/order_tuan.html';
            }
        }
    }
    
    
    
    /**
     * 参团页面
     * product_id 产品ID
     * num 商品个数
     * stock_id 属性ID
     */
    public function join_order($product_id, $group_id, $num, $stock_id)
    {
        if(!$product_id = (int) $product_id){
            $this->msgbox->add('商品错误!', 211);
        }
        else if(!$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('商品错误!', 212);
        }
        else if(!$detail['detail'] = K::M('weidian/pintuan/product')->detail($product_id)){
            $this->msgbox->add('商品错误!', 213);
        }
        else if($num > $detail['stock']){
            $this->msgbox->add('库存不足!', 216);
        }
        else if($num < 1){
            $this->msgbox->add('数量错误!', 217);
        }
        else if(!$group_id = (int)$group_id){
            $this->msgbox->add('错误!', 218);
        }
        else if(!$group = K::M('weidian/pintuan/group')->detail($group_id)){
            $this->msgbox->add('团错误!', 219);
        }
        else{
            //如果不是阶梯团，才会涉及查询规格属性
            if($detail['detail']['tuan_type'] == 0){
                if($stock = K::M('weidian/product/attrstock')->detail(array('attr_stock_id' => $stock_id))){
                    //统一拼团多属性价格为商品原价
                    $stock['price'] = $detail['wei_price'];
                    $this->pagedata['stock'] = $stock;
                }
            }

            //查询我的地址
            $my_addr = K::M('member/addr')->items(array('uid' => $this->uid));
            if($my_addr){
                foreach($my_addr as $k => $v){
                    if($v['is_default'] == 1){
                        $default_addr = $v;
                    }
                }
                if(!$default_addr){
                    $default_addr = array_slice($my_addr, 0, 1);
                    $default_addr = $default_addr[0];
                }
            }

            //计算本次订单需要支付的价格
            if($detail['detail']['tuan_type'] == 1){
                $price = $detail['detail']['money_pre'];
            }
            else{
                if($stock){
                    $price = $stock['price'] * $num;
                }
                else{
                    $price = $detail['price'] * $num;
                }
            }

            $this->pagedata['price'] = $price; //传递本次订单价格，用来选择优惠券
            $this->pagedata['default_addr'] = $default_addr;
            $this->pagedata['type'] = $type;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['group'] = $group;
            $this->pagedata['num'] = $num;
            $this->pagedata['stock_id'] = $stock_id;
            $this->tmpl = 'weidian/pintuan/order_join.html';
        }
        
        
    }
    
    

    /**
     * 创建订单
     * product_id 产品ID
     * type 1:单独购买 2:开团
     * num 商品个数
     * stock_id 属性ID
     */
    public function order_create()
    {
        $this->check_login();
        if(IS_AJAX){
            if(!$product_id = (int) $this->GP('product_id')){
                $this->msgbox->add('商品错误!', 211);
            }
            else if(!$detail = K::M('weidian/product')->detail($product_id)){
                $this->msgbox->add('商品错误!', 212);
            }
            else if(!$detail['detail'] = K::M('weidian/pintuan/product')->detail($product_id)){
                $this->msgbox->add('商品错误!', 213);
            }
            else if(!$type = (int) $this->GP('type')){
                $this->msgbox->add('购买方式错误!', 214);
            }
            else if(!in_array($type, array(1, 2))){
                $this->msgbox->add('购买方式错误!', 215);
            }
            else if(!$num = (int) $this->GP('num')){
                $this->msgbox->add('数量错误!', 217);
            }
            else if($num < 1){
                $this->msgbox->add('数量错误!', 218);
            }
            else if($num > $detail['stock']){
                $this->msgbox->add('库存不足!', 219);
            }
            else if(!$pei_type = (int) $this->GP('pei_type_val')){
                $this->msgbox->add('配送方式错误!', 220);
            }
            else if($pei_type == 1 && !(int) $this->GP('addr_id')){
                $this->msgbox->add('收货地址错误!', 221);
            }
            else if($pei_type == 1 && !$addr = K::M('member/addr')->detail((int) $this->GP('addr_id'))){
                $this->msgbox->add('收货地址错误!', 222);
            }
            else if($detail['is_onsale'] == 0){
                $this->msgbox->add('该商品已下架!', 223);
            }
            else if($detail['closed'] == 1){
                $this->msgbox->add('该商品不存在!', 224);
            }
            else if($detail['type'] != 'pintuan'){
                $this->msgbox->add('该商品不是拼团商品!', 225);
            }
            else if((int)$this->GP('coupon_id') > 0 && !$coupon = K::M('member/coupon')->find(array('uid'=>$this->uid,'coupon_id'=>(int) $this->GP('coupon_id'),'shop_id'=>$this->shop_id))){
                $this->msgbox->add('不存在的优惠券!', 226);
            }
            else if($coupon && $coupon['uid'] != $this->uid){
                $this->msgbox->add('非法优惠券!', 227);
            }
            else if($coupon && $coupon['shop_id'] != $this->shop_id){
                $this->msgbox->add('优惠券不可用!', 228);
            }
            else if($coupon && $coupon['status'] == 1){
                $this->msgbox->add('优惠券已使用!', 229);
            }
            else if($coupon && $coupon['ltime'] <= __TIME){
                $this->msgbox->add('优惠券已过期!', 230);
            }
            else if($pei_type == 2 && !$this->GP('pei_time')){
                $this->msgbox->add('没有选择自提时间!', 231);
            }else{
               if($this->GP('pei_time')){
                   $pei_time = strtotime($this->GP('pei_time'));
               }
                //如果是阶梯团，查询阶梯团信息
                if($detail['detail']['tuan_type'] == 1){
                    if($detail['level'] = $gl_level = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $product_id))){
                        $level = array();
                        foreach($detail['level'] as $k => $v){
                            $level[$v['price']] = $v['price'];
                        }
                        $detail['level']['min'] = min($level);
                        $detail['level']['max'] = max($level);
                    }
                }

                //如果不是阶梯团，才会涉及查询规格属性
                if($detail['detail']['tuan_type'] == 0 && $stock_id > 0){
                    if($stock = K::M('weidian/product/attrstock')->detail(array('attr_stock_id' => $stock_id))){
                        //统一拼团多属性价格为商品原价
                        $stock['price'] = $detail['wei_price'];
                        $this->pagedata['stock'] = $stock;
                    }
                }

                //计算本次订单需要支付的价格
                if($type == 1){
                    if($stock){
                        $price = $stock['price'] * $num;
                    }
                    else{
                        $price = $detail['price'] * $num;
                    }
                }
                else if($type == 2){
                    if($detail['detail']['tuan_type'] == 1){
                        $price = $detail['detail']['money_pre'];
                    }
                    else{
                        if($stock){
                            $price = $stock['price'] * $num;
                        }
                        else{
                            $price = $detail['wei_price'] * $num;
                        }
                    }
                }

                //在此判断优惠券是否合法
                if($coupon['order_amount'] > $price){
                    $this->msgbox->add('该优惠券不可使用!', 231)->response();
                }

                // 是否团长必须购买
                if($type == 2){  // 如果是开团类型
                    $num = 1;  //如果是开团类型，数量一定是1
                    $group = array(
                        'city_id'             => $this->weidian['city_id'],
                        'shop_id'             => $this->shop_id,
                        'group_title'         => $detail['title'], //组团标题
                        'user_num'            => $detail['detail']['user_num'], //product的成团人数 
                        'master_id'           => $this->uid,
                        'start_time'          => __TIME,
                        'end_time'            => __TIME + $detail['detail']['tuan_time'] * 86400,
                        'order_count'         => $detail['detail']['master_need_buy'], //如果不买，就是 0
                        'order_success_count' => 0, //未支付， 0 
                        'status'              => 0,
                        'product_id'          => $detail['product_id'],
                        'money_pre'           => $detail['detail']['money_pre'],
                        'tuan_type'           => $detail['detail']['tuan_type']
                    );
                }
                else if($type == 1){// 如果是单人购买
                    $group = array(
                        'city_id'             => $this->weidian['city_id'],
                        'shop_id'             => $this->shop_id,
                        'user_num'            => 1,
                        'master_id'           => $this->uid,
                        'start_time'          => __TIME,
                        'end_time'            => __TIME + $detail['detail']['tuan_time'] * 86400,
                        'order_count'         => 1,
                        'status'              => 0, //支付成功,更改status 为 1 
                        'product_id'          => $detail['product_id'],
                        'order_count'         => 1, //如果不买，就是 0
                        'order_success_count' => 0, //未支付， 0 , 支付成功 1
                    );
                }
                $pintuan_group_id = K::M('weidian/pintuan/group')->create($group);

                //如果是阶梯团，插入阶梯数据冗余信息到group_level表里。
                if($detail['detail']['tuan_type'] == 1){
                    foreach($gl_level as $k => $v){
                        $gl_data = array(
                            'group_id'=>$pintuan_group_id,
                            'product_id'=>$v['product_id'],
                            'level'=>$v['level'],
                            'user_num'=>$v['user_num'],
                            'price'=>$v['price']
                        );
                        K::M('weidian/pintuan/grouplevel')->create($gl_data);
                    }
                }
                
                $data = array(
                    'city_id'      => $this->weidian['city_id'],
                    'shop_id'      => $this->shop_id,
                    'uid'          => $this->uid,
                    'from'         => 'weidian',
                    'order_status' => 0,
                    'online_pay'   => 1,
                    'pay_status'   => 0,
                    'intro'        => $stock['stock_real_name'],
                    'staff_id'     => 0,
                    'order_from'   => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    'amount'       => $price - $coupon['coupon_amount'],
                    
                );

                if($pei_type == 2){  // 自提
                    $freight = 0;
                    $data['contact'] = $this->MEMBER['nickname'];
                    $data['mobile'] = $this->MEMBER['mobile'];
                    $data['pei_type'] = 3;
                    $data['pei_time'] = $pei_time;
                    $data['pei_amount'] = 0;
                    $data['o_lat'] = $this->weidian['lat'];
                    $data['o_lng'] = $this->weidian['lng'];
                    $data['total_price'] = $price;
                } 
                else if($pei_type == 1){// 配送
                    $freight = $detail['ship_fee'];
                    $data['contact'] = $addr['contact'];
                    $data['mobile'] = $addr['mobile'];
                    $data['addr'] = $addr['addr'];
                    $data['house'] = $addr['house'];
                    $data['lng'] = $addr['lng'];
                    $data['lat'] = $addr['lat'];
                    $data['pei_type'] = 0; //商户自己发货
                    $data['pei_amount'] = $freight;
                    $data['total_price'] = $price + $freight;
                    $data['amount'] = $data['amount'] + $detail['ship_fee'];
                }



                //如果是开团并且无需团长必须购买
                if($detail['detail']['master_need_buy'] == 0 && $type == 2){
                    //这里获取用户的选择buy_status
                    $buy_status = (int)$this->GP('buy_status');
                    if($buy_status == 0){
                        $data['pay_status'] = 1;
                        $go_pay = 1;
                    }else{
                        $go_pay = 0;
                    }
                }else{
                    $go_pay = 0;
                }

                // 创建订单记录
                if($order_id = K::M('order/order')->create($data)){
                    $order = K::M('order/order')->detail($order_id);
                    
                    //创建微店主订单表记录
                    $wdata = array(
                        'order_id'         => $order_id,
                        'product_number'   => $num,
                        'product_price'    => $detail['wei_price'],
                        'freight'          => $freight,
                        'type'             => 'pintuan'
                    );
                    
                    K::M('weidian/order')->create($wdata);

                    // 创建子订单
                    $pdata = array(
                        'order_id'         => $order_id,
                        'product_name'     => $detail['title'],
                        'product_number'   => $num,
                        'product_price'    => $detail['wei_price'],
                        'tuan_time'        => $detail['detail']['tuan_time'],
                        'money_master'     => 0,
                        'freight'          => $freight,
                        'group_id'         => $pintuan_group_id,
                        'uid'              => $this->uid,
                        'is_money_pre'     => 0,
                    );

                    //只有阶梯团必须要定金，其它都是全款
                    if($detail['detail']['tuan_type'] == 1){
                        $pdata['is_money_pre'] = 1;
                        $pdata['money_need_pay'] = $detail['detail']['money_pre'];
                    }

                    //组团有佣金
                    if($type == 2){
                        $pdata['money_master'] = $detail['detail']['money_master'];
                    }

                    K::M('weidian/pintuan/order')->create($pdata);


                    // 创建订单商品记录 可用于再来一单
                    if($detail['detail']['master_need_buy'] > 0 || $type == 1){
                        $opdata = array(
                            'order_id'       => $order_id,
                            'product_id'     => $detail['product_id'],
                            'product_name'   => $detail['title'],
                            'product_price'  => $detail['wei_price'],
                            'package_price'  => $freight,
                            'product_number' => $num,
                            'amount'         => $order['amount'],
                        );
                    }
                    else{
                        $opdata = array(
                            'order_id'       => $order_id,
                            'product_id'     => $detail['product_id'],
                            'product_name'   => $detail['title'],
                            'product_price'  => $detail['wei_price'],
                            'package_price'  => 0,
                            'product_number' => 0,
                            'amount'         => 0,
                        );
                    }
                    K::M('weidian/pintuan/orderproduct')->create($opdata);
                    K::M('shop/shop')->update_count($shop_id, 'orders', 1);
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                    K::M('shop/msg')->create(array('shop_id' => $this->shop_id, 'title' => '订单已提交', 'content' => '订单已提交', 'is_read' => 0, 'type' => 1, 'order_id' => $order_id));
                    //设置优惠券为已使用
                    if( 0 == $go_pay ){
                        if($coupon){
                            K::M('member/coupon')->update($coupon['cid'],array('status'=>1));
                        }
                    }


                    $this->msgbox->add('开团成功');
                    $arr_group = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id));
                    $arr_ret = array(
                        'order_id'         => $order_id,
                        'pay_status'       => $order['pay_status'],
                        'group_id'         => $arr_group['group_id'],
                        'total_price'      => $order['total_price'],
                        'amount'           => $order['amount'],
                        'dateline'         => $order['dateline'],
                        'go_pay'           => $go_pay
                    );
                    $this->msgbox->set_data('order', $arr_ret);
                }
            }
        }
    }
    
    
     /**
     * 参团生成订单
     * product_id 产品ID
     * num 商品个数
     * stock_id 属性ID
     */
    function order_join_create($product_id, $group_id, $num, $stock_id){

        $this->check_login();
        if(IS_AJAX){
            
            $return = K::M('weidian/pintuan/order')->check_tuan_join((int)$this->GP('group_id'), $this->uid);

            if(2 == $return['status']){
                $this->msgbox->add($return['message'], 230);
            }
            else if(!$product_id = (int) $this->GP('product_id')){
                $this->msgbox->add('商品错误!', 211);
            }
            else if(!$detail = K::M('weidian/product')->detail($product_id)){
                $this->msgbox->add('商品错误!', 212);
            }
            else if(!$detail['detail'] = K::M('weidian/pintuan/product')->detail($product_id)){
                $this->msgbox->add('商品错误!', 213);
            }
            else if(!$group_id = (int)$this->GP('group_id')){
                $this->msgbox->add('错误!', 218);
            }
            else if(!$group = K::M('weidian/pintuan/group')->detail($group_id)){
                $this->msgbox->add('团错误!', 219);
            }
            else if(!$shop = K::M('shop/shop')->detail($detail['shop_id'])){
                $this->msgbox->add('商家不存在', 211);
            }
            else if(!$num = (int) $this->GP('num')){
                $this->msgbox->add('数量错误!', 217);
            }
            else if($num < 1){
                $this->msgbox->add('数量错误!', 218);
            }
            else if($num > $detail['stock']){
                $this->msgbox->add('库存不足!', 219);
            }
            else if(!$pei_type = (int) $this->GP('pei_type_val')){
                $this->msgbox->add('配送方式错误!', 220);
            }
            else if($pei_type == 1 && !(int) $this->GP('addr_id')){
                $this->msgbox->add('收货地址错误!', 221);
            }
            else if($pei_type == 1 && !$addr = K::M('member/addr')->detail((int) $this->GP('addr_id'))){
                $this->msgbox->add('收货地址错误!', 222);
            }
            else if($detail['is_onsale'] == 0){
                $this->msgbox->add('该商品已下架!', 223);
            }
            else if($detail['closed'] == 1){
                $this->msgbox->add('该商品不存在!', 224);
            }
            else if($detail['type'] != 'pintuan'){
                $this->msgbox->add('该商品不是拼团商品!', 225);
            }
            else if($pei_type == 2 && !$this->GP('pei_time')){
                $this->msgbox->add('没有选择自提时间!', 231);
            }else{

                if($this->GP('pei_time')){
                   $pei_time = strtotime($this->GP('pei_time'));
                }

                //如果不是阶梯团，才会涉及查询规格属性
                if($detail['detail']['tuan_type'] == 0){
                    if($stock = K::M('weidian/product/attrstock')->detail(array('attr_stock_id' => $this->GP('stock_id')))){
                        //统一拼团多属性价格为商品原价
                        $stock['price'] = $detail['wei_price'];
                        $this->pagedata['stock'] = $stock;
                    }
                }

                //计算本次订单需要支付的价格
              
                    if($detail['detail']['tuan_type'] == 1){
                        $price = $group['money_pre'];
                    }
                    else{
                        if($stock){
                            $price = $stock['price'] * $num;
                        }
                        else{
                            $price = $detail['price'] * $num;
                        }
                    }
                    
                    $data = array(
                    'city_id'      => $shop['city_id'],
                    'shop_id'      => $shop['shop_id'],
                    'uid'          => $this->uid,
                    'from'         => 'weidian',
                    'order_status' => 0,
                    'online_pay'   => 1,
                    'pay_status'   => 0,
                    'intro'        => $stock['stock_real_name'],
                    'staff_id'     => 0,
                    'order_from'   => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    'amount'       => $price,                    
                    );


                    if($pei_type == 2){  // 自提
                        $freight = 0;
                        $data['contact'] = $this->MEMBER['nickname'];
                        $data['mobile'] = $this->MEMBER['mobile'];
                        $data['pei_type'] = 3;
                        $data['pei_time'] = $pei_time;
                        $data['pei_amount'] = 0;
                        $data['o_lat'] = $this->weidian['lat'];
                        $data['o_lng'] = $this->weidian['lng'];
                        $data['total_price'] = $price;
                    } 
                    else if($pei_type == 1){// 配送
                        $freight = $detail['ship_fee'];
                        $data['contact'] = $addr['contact'];
                        $data['mobile'] = $addr['mobile'];
                        $data['addr'] = $addr['addr'];
                        $data['house'] = $addr['house'];
                        $data['lng'] = $addr['lng'];
                        $data['lat'] = $addr['lat'];
                        $data['pei_type'] = 0; //商户自己发货
                        $data['pei_amount'] = $freight;
                        $data['total_price'] = $price + $freight;
                        $data['amount'] = $data['amount'] + $detail['ship_fee'];
                    }


                    // 创建订单记录
                    if($order_id = K::M('order/order')->create($data)){
                        $update_group = array(
                            'order_count' => $group['order_count'] + 1
                        );
                        K::M('weidian/pintuan/group')->update($group_id, $update_group);

                        $order = K::M('order/order')->detail($order_id);

                        //预付款,还是全款
                        if($group['money_pre'] > 0 && $group['tuan_type'] == 1){
                            $is_money_pre = 1;
                        }
                        else{
                            $is_money_pre = 0;
                        }
                        
                        //创建微店主订单表记录
                        $wdata = array(
                            'order_id'         => $order_id,
                            'product_number'   => $num,
                            'product_price'    => $detail['wei_price'],
                            'freight'          => $freight,
                            'type'             => 'pintuan'
                        );

                        K::M('weidian/order')->create($wdata);
         
                        // 创建子订单
                        $pdata = array(
                            'order_id'         => $order_id,
                            'product_name'     => $detail['title'],
                            'product_number'   => $num,
                            'product_price'    => $detail['wei_price'],
                            'tuan_time'        => $detail['detail']['tuan_time'],
                            'money_master'     => 0,
                            'freight'          => $freight,
                            'group_id'         => $group_id,
                            'uid'              => $this->uid,
                            'is_money_pre'     => $is_money_pre,
                        );
                        
                        //只有阶梯团必须要定金，其它都是全款
                        if($detail['detail']['tuan_type'] == 1){
                            $pdata['is_money_pre'] = 1;
                            $pdata['money_need_pay'] = $detail['detail']['money_pre'];
                        }

                         //组团有佣金
                        $pdata['money_master'] = $detail['detail']['money_master'];

                        K::M('weidian/pintuan/order')->create($pdata);

                        // 创建订单商品记录 可用于再来一单
                        $opdata = array(
                            'order_id'       => $order_id,
                            'product_id'     => $detail['product_id'],
                            'product_name'   => $detail['title'],
                            'product_price'  => $detail['wei_price'],
                            'package_price'  => $freight,
                            'product_number' => $num,
                            'amount'         => $order['amount'],
                        );

                        K::M('weidian/pintuan/orderproduct')->create($opdata);
                        K::M('shop/shop')->update_count($shop_id, 'orders', 1);
                        K::M('member/member')->update_count($this->uid, 'orders', 1);
                        K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                        K::M('shop/msg')->create(array('shop_id' => $shop['shop_id'], 'title' => '订单已提交', 'content' => '订单已提交', 'is_read' => 0, 'type' => 1, 'order_id' => $order_id));
                        $this->msgbox->add('订单提交成功');
                        $this->msgbox->set_data('order', array('order_id' => $order_id, 'pay_status' => $order['pay_status']));
                    }
 
            }
        }
        
    }
    
    
    
    public function change_size($product_id)
    {
        if(!(int) $product_id || !$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('产品不存在!', 211);
        }
        else if($detail['shop_id'] != ($this->shop_id)){
            $this->msgbox->add('产品错误!', 212);
        }
        else if($detail['type'] != 'pintuan'){
            $this->msgbox->add('产品错误!', 213);
        }
        elseif(!$stock_name = $this->GP('stock_name')){
            $this->msgbox->add('规格不存在!', 214);
        }
        else{
            if($res = K::M('weidian/product/attrstock')->find(array('product_id' => $product_id, 'stock_name' => $stock_name))){
                $attr_product = K::M('weidian/product')->find(array('product_id' => $product_id));
                //取消拼团价格,
                $this->msgbox->add('success');
                $this->msgbox->set_data('attr_stock_id', $res['attr_stock_id']);
                $this->msgbox->set_data('wei_price', $attr_product['wei_price']);
                $this->msgbox->set_data('price', $attr_product['price']);
            }
            else{
                $this->msgbox->add('商品不存在', 215);
            }
        }
    }
    
    
     // 取消订单
    public function order_cancel()
    {
        $this->check_login();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if($order['from'] != 'weidian'){
            $this->msgbox->add('非法操作', 214);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消', 214);
        }
        else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态', 215);
        }
        else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $this->msgbox->add('订单取消成功');
        }
        else{
            $this->msgbox->add('订单取消失败', 216);
        }
    }
    
    
    // 确认送达
    public function arrived()
    {
        $this->check_login();
        $order_id = (int) $this->GP('order_id');
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('确认送达成功', 214); //订单已经确认,无需重复确认. 更改友好提示
        }else if(!in_array($order['order_status'], array(1, 3, 4))){
            $this->msgbox->add('商家还未配送完成不可确认', 215);
        }else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->add('确认送达成功');
        }else{
            $this->msgbox->add('确认送达失败', 222);
        }
    }
    

    // 加法减法操作
    public function js_method($method_arg){
        $real_buy = $this->GP('real_buy');
        $ship_fee = $this->GP('ship_fee');
        $method_post = $this->GP('method');
        if ($method_arg == $method_post) {
            if ('delete' == $method_post) {
                //减法
                $real_buy = $real_buy - $ship_fee;
            } else {
                //加法
                $real_buy = $real_buy + $ship_fee;
            }
        }


        $this->msgbox->add('success');
        $this->msgbox->set_data('real_buy', $real_buy);
    }

}
