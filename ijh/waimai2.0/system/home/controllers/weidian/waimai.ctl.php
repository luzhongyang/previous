<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Weidian_Waimai extends Ctl_Weidian 
{
	// 购物车结算列表
	public function get_cart($shop_id)
	{
		$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        $shop = $this->shop;

        $this->pagedata['shop'] = $shop;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/waimai/cart.html';
	}

	// 根据Cookie ajax获取购物车物品列表
	public function ajax_wdcart_list() 
	{
        $shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        $shop = $this->shop;

        // 判断是否打样
        $cur_time = (float) date("H.i", __TIME);
        $yy_stime = (float) str_replace(':', '.', $shop['yy_stime']);
        $yy_ltime = (float) str_replace(':', '.', $shop['yy_ltime']);

        if($shop['yy_status'] == 0 || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
            $this->msgbox->add('商家已经打烊不可下单', 223)->response();
        }
        // 获取用户购物车信息判断是否点餐
        $cart = $this->get_wdcart($shop_id);

        if(empty($cart)){
            $this->msgbox->add('你还没有点餐呢', 223)->response();
        }
        $product_number = $package_price = $product_price = 0;
        $products = "";
        $product_lists = array();
        foreach($cart as $k => $v){
            if($k != $shop_id){
                $this->msgbox->add('商品不是同一家商家的', 202)->response();
            }else{
                foreach($v as $kk => $vv){
                    $pk = $vv['product_id'] . '-' . $vv['spec_id'];
                    $product_ids[$vv['product_id']] = $vv['product_id'];
                    $spec_ids[$vv['spec_id']] = $vv['spec_id'];
                    $product_numbers[$pk] = $vv['number'];
                    $cart_product_list[$pk] = array('product_id' => $vv['product_id'], 'number' => $vv['number'], 'spec_id' => $vv['spec_id']);
                }
            }
        }
        $product_list = K::M('waimai/product')->items_by_ids($product_ids);
        $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);
        foreach($cart_product_list as $pk => $v){
            if(!$p = $product_list[$v['product_id']]){
                //购物车的商品实际不存在
            }else if($p['is_spec']){
                $sp = $spec_lists[$v['spec_id']];
                if(!$v['spec_id'] && $sp){
                    //商品未选规格sku
                    $this->msgbox->add('商品未选规格sku', 231)->response();
                }else if($sp['product_id'] != $v['product_id']){
                    //选择规格与商品ID关联不符
                    $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                }else if($sp['sale_sku'] < $product_numbers[$pk]){
                    $this->msgbox->add('商品库存不足', 233)->response();
                }else{
                    // 带规格
                    $product_lists[$pk]['product_id'] = $p['product_id'];
                    $product_lists[$pk]['spec_id'] = $sp['spec_id'];
                    $product_lists[$pk]['sku_id'] = $p['product_id'] . '-' . $sp['spec_id'];
                    $product_lists[$pk]['title'] = $p['title'];
                    $product_lists[$pk]['spec_name'] = $sp['spec_name'];
                    $product_lists[$pk]['num'] = $product_numbers[$pk];
                    $product_lists[$pk]['price'] = $sp['price'];
                    $product_lists[$pk]['package'] = $sp['package_price'];
                    $product_lists[$pk]['sale_sku'] = $sp['stock'];
                    $product_lists[$pk]['sale_type'] = 1;
                    $product_lists[$pk]['p_id'] = 'p_' . $p['product_id'] . '-' . $sp['spec_id'];
                    $product_lists[$pk]['pic'] = $sp['spec_photo'];
                    $product_lists[$pk]['intro'] = $p['intro'];
                }
            }else{
                // 无规格商品
                if($p['stock'] < $product_numbers[$pk]){
                    $this->msgbox->add('商品库存不足', 211)->response();
                }else{
                    $product_lists[$pk]['product_id'] = $p['product_id'];
                    $product_lists[$pk]['spec_id'] = 0;
                    $product_lists[$pk]['sku_id'] = $p['product_id'] . '-' . '0';
                    $product_lists[$pk]['title'] = $p['title'];
                    $product_lists[$pk]['spec_name'] = "";
                    $product_lists[$pk]['num'] = $product_numbers[$pk];
                    $product_lists[$pk]['price'] = $p['price'];
                    $product_lists[$pk]['package'] = $p['package_price'];
                    $product_lists[$pk]['sale_sku'] = $p['stock'];
                    $product_lists[$pk]['sale_type'] = 1;
                    $product_lists[$pk]['p_id'] = 'p_' . $p['product_id'] . '-' . '0';
                    $product_lists[$pk]['pic'] = $p['photo'];
                    $product_lists[$pk]['intro'] = $p['intro'];
                }
            }
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',array('items'=>array_values($product_lists)));
	}

	// 获取购物车Cookie
	public function get_wdcart($shop_id=null)
	{
        $shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        $shop = $this->shop;

        $cart = json_decode(urldecode($_COOKIE['KT-WDCart']), true);

        $cart_goods = explode(',', $cart[$shop_id]);
        foreach($cart_goods as $key => $val){
            if(preg_match('/^(\d+)-(\d+):(\d+):(\d+)$/', $val, $local)){
                $pk = $local[1] . '-' . $local[2];
                $cart_product_list[$pk] = array(
                    'product_id' => $local[1],
                    'number' => $local[3],
                    'spec_id' => $local[2],
                    'status' =>$local[4],
                );
            }
        }
        $items[$shop_id] = $cart_product_list;
        return $items;

	}

	// 提交订单页面
	public function order_submit($shop_id)
	{
        $shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        $shop = $this->shop;

        // 判断是否打样
        $cur_time = (float) date("H.i", __TIME);
        $yy_stime = (float) str_replace(':', '.', $shop['yy_stime']);
        $yy_ltime = (float) str_replace(':', '.', $shop['yy_ltime']);

        if($shop['yy_status'] == 0 || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
            $this->msgbox->add('商家已经打烊不可下单', 223)->response();
        }

        // 获取用户购物车信息判断是否点餐
        $cart = $this->get_wdcart($shop_id);

        if(empty($cart)){
            $this->msgbox->add('你还没有点餐呢', 223)->response();
        }
        $product_number = $package_price = $product_price = 0;
        $products = "";

        foreach($cart as $k => $v){
            if($k != $shop_id){
                $this->msgbox->add('商品不是同一家商家的', 202)->response();
            }else{
                foreach($v as $kk => $vv){
                    if($vv['status'] == 1) {
                        $pk = $vv['product_id'] . '-' . $vv['spec_id'];
                        $product_ids[$vv['product_id']] = $vv['product_id'];
                        $spec_ids[$vv['spec_id']] = $vv['spec_id'];
                        $product_numbers[$pk] = $vv['number'];
                        $cart_product_list[$pk] = array('product_id' => $vv['product_id'], 'number' => $vv['number'], 'spec_id' => $vv['spec_id']);
                    }
                }
            }
        }

        $product_list = K::M('waimai/product')->items_by_ids($product_ids);
        $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

        foreach($cart_product_list as $pk => $v){
            if(!$p = $product_list[$v['product_id']]){
                //购物车的商品实际不存在
            }else if($p['is_spec']){
                $sp = $spec_lists[$v['spec_id']];
                if(!$v['spec_id'] && $sp){
                    //商品未选规格sku
                    $this->msgbox->add('商品未选规格sku', 231)->response();
                }else if($sp['product_id'] != $v['product_id']){
                    //选择规格与商品ID关联不符
                    $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                }else if($sp['sale_sku'] < $product_numbers[$pk]){
                    $this->msgbox->add('商品库存不足', 233)->response();
                }else{
                    $product_lists[$pk]['title'] = $p['title'];
                    $product_lists[$pk]['spec_name'] = $sp['spec_name'];
                    $product_lists[$pk]['num'] = $product_numbers[$pk];
                    $product_lists[$pk]['price'] = $sp['price'];
                    $product_lists[$pk]['photo'] = $sp['spec_photo'];
                    $product_price += $sp['price'] * $product_numbers[$pk];       //商品总价
                    $package_price += $sp['package_price'] * $product_numbers[$pk]; //总打包费
                    $products .= $sp['product_id'] . ":" . $product_numbers[$pk];
                    $products .= ":" . $sp['spec_id'] . ',';
                }
            }else{
                // 无规格商品
                if($p['stock'] < $product_numbers[$pk]){
                    $this->msgbox->add('商品库存不足', 211)->response();
                }else{
                    $product_lists[$pk]['title'] = $p['title'];
                    $product_lists[$pk]['spec_name'] = '';
                    $product_lists[$pk]['num'] = $product_numbers[$pk];
                    $product_lists[$pk]['price'] = $p['price'];
                    $product_lists[$pk]['photo'] = $p['photo'];
                    $product_price += $p['price'] * $product_numbers[$pk];       //商品总价
                    $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                    $products .= $v['product_id'] . ":" . $product_numbers[$pk];
                    $products .= ':0,';
                }
            }
        }
        // 格式 product_id : num : spec_id
        $products = rtrim($products, ',');
        // 购物车商品列表
        $this->pagedata['products'] = $products;
        $this->pagedata['product_lists'] = $product_lists;
        $this->pagedata['total_package_price'] = $package_price;
        if($product_price < $shop['min_amount']){
            $this->msgbox->add('没有达到配送要求', 212)->response();
        }
        $res = K::M('order/order')->get_time();
        $pei_time_list['start'] = $res['start'];
        $pei_time_list['start_quarter'] = $res['start_quarter'];
        $stime = $res['start'] . ":" . $res['start_quarter'] * 15;
        $rr = explode(':', $shop['yy_ltime']);
        $pei_time_list['end'] = $rr[0];
        $pei_time_list['end_quarter'] = $rr[1] / 15;
        $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;
        if($stime > $shop['yy_ltime']){
            $pei_time_list = array();
        }
        if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
            $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
        }
        if($member = K::M('member/member')->detail($this->uid)){
            $this->pagedata['mymoney'] = $member['money'];
        }

        $c_filter = array(
                'shop_id'=>$shop_id,
                'uid' => $this->uid,
                'use_time' => 0,
                'order_id' => 0,
                'status' => 0,
                'ltime' => '>:' . __TIME,
                ':SQL'=> 'order_amount <=' . $product_price,
            );
        // 首单优惠
        if($shop['first_amount'] && $this->MEMBER['orders']==0){
            $this->pagedata['first_amount'] = $shop['first_amount'];
        }else {
            $this->pagedata['first_amount'] = 0;
        }
        $this->pagedata['m_addr'] = $m_addr;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['product_price'] = $product_price;
        $this->pagedata['coupon_count'] = K::M('member/coupon')->count($c_filter);
        $this->pagedata['addr_list'] = K::M('member/addr')->items(array('uid'=>$this->uid),array('is_default'=>'desc'));
        $this->pagedata['addr_count'] = K::M('member/addr')->count(array('uid'=>$this->uid));
        $this->pagedata['pei_time_list'] = $pei_time_list;
        $this->pagedata['yuji_pei_time'] = $this->pagedata['yuji_ziti_time'] = date('H:i', __TIME + 1800);
        $this->pagedata['package_price'] = $package_price;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/waimai/order_submit.html';

	}

	// 填写备注信息页面
	public function intro_choose()
	{
		$this->pagedata['theme_style'] = $this->default_weidian_theme();
		$this->tmpl = 'weidian/'.$this->default_weidian_theme().'/waimai/intro_choose.html';
	}

	// 新增收货地址ajax提交
    public function createaddr_save()
    {
        if(!empty($_POST)){  
            if(!$contact = K::M('member/addr')->check_contact($this->GP('contact'))) {
                $this->msgbox->add('联系人长度为6至18位字符',210);
            }else if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add('手机号不正确',211);
            }else if(!$addr = $this->GP('addr')) {
                $this->msgbox->add('收货地址不能为空',212);
            }else if(!$house = $this->GP('house')) {
                $this->msgbox->add('门牌号不能为空',213);
            }else if($addr_count = K::M('member/addr')->count(array('uid'=>$this->uid)) >= 5){
                $this->msgbox->add('抱歉，每个用户最多只能新增5个地址',215);
            }else{
                $data = array();
                $data['uid'] = $this->uid;
                $data['contact'] = $contact;
                $data['mobile'] = $mobile;
                $data['addr'] = $addr;
                $data['house'] = $house;
                $data['is_default'] = 1;
                $data['lng'] = '';
                $data['lat'] = '';
                $data['tag'] = 0;
                if($addr_id = K::M('member/addr')->create($data)){
                	K::M('member/addr')->set_default($this->uid,$addr_id);
                    $this->msgbox->add('添加成功');
                }else {
                    $this->msgbox->add('添加失败',216);
                }
            }
        }else {
            $this->msgbox->add('联系人长度为6至18位字符',210);
        }
    }

    // ajax获取配送费计算优惠、结算价格
    public function ajaxorder()
    {
    	$addr_id = (int) $this->GP('addr_id');
        $shop_id = (int) $this->GP('shop_id');
        $pei_type = (int) $this->GP('pei_type');
        $coupon_id = (int) $this->GP('coupon_id');
        $package_price = $this->GP('package_price');
        $product_price = $this->GP('product_price');
        $online_pay = 1;
        $shop = K::M('shop/shop')->detail($shop_id);
        $addr = K::M('member/addr')->detail($addr_id);
        // 首单优惠
        if($shop['first_amount'] && $this->MEMBER['orders']==0){
            $first_youhui = $shop['first_amount']; // 第一单享受首单优惠
        }else{
            $first_youhui = 0; // 不是第一单不享受首单优惠
        }

        $first_price = $product_price - $first_youhui;

        // 根据coupon_id查找优惠券
        $coupon['coupon_amount'] = 0;
        $second_price = $first_price;
        $m_filter = array(
        	'coupon_id'=>$coupon_id,
        	'uid'=>$this->uid,
        	'shop_id'=>$shop_id,
        	'status'=>0,
        	'order_id' =>0,
        	'use_time' =>0,
        	'order_amount'=>'<=:'. $first_price,
        	'ltime'=>'>:'.__TIME
        );
        if($coupon = K::M('member/coupon')->find($m_filter)) {
            $second_price = $first_price - $coupon['coupon_amount'];
        }else {
        	$coupon['coupon_amount'] = 0;
        }
        //echo '<pre>';print_r($product_price);die;
        
        // 获取满足使用条件的满减优惠 
        if($youhui = K::M('shop/youhui')->order_youhui($shop_id, $second_price)){
            $third_price = $second_price - $youhui['youhui_amount'];
        }else{
            $youhui['youhui_amount'] = 0;
            $third_price = $second_price;
        }

        // 计算运费
        if($pei_type == 3){
            // 自提单无需配送费
            $freight = 0;
        }else{
            if($shop['lng'] && $shop['lat'] && $addr['lng'] && $addr['lat']){
                $juli = K::M('helper/round')->getdistances($shop['lng'], $shop['lat'], $addr['lng'], $addr['lat']);
                $juli = ceil($juli / 10);
                $juli = $juli/100;//新距离计算方式wu.
                $_freight = array();
                $_max_freight = array('fkm' => 0, 'fm' => 0);
                foreach($shop['freight_stage'] as $k => $v){
                    if($juli <= $v['fkm']){
                        if($_freight && $_freight['fkm'] > $v['fkm']){
                            $_freight = $v;
                        }else if(empty($_freight)){
                            $_freight = $v;
                        }
                    }
                    if($v['fkm'] > $_max_freight['fkm']){
                        $_max_freight = $v;
                    }
                }
                $freight = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
            }else{
                $freight = 0;
            }
        }
        if($online_pay){
        	//总优惠 = 首单优惠+优惠券+满减优惠
            $total_youhui = $first_youhui + $coupon['coupon_amount'] + $youhui['youhui_amount'];
            // 结算价格= 优惠后价格+打包费+运费-总优惠
            $jiesuan_price = $product_price + $package_price + $freight - $total_youhui;
            
        }else{
            $jiesuan_price = $product_price + $package_price + $freight;
            $total_youhui = 0;
        }

        $this->msgbox->add('success');
        $data['freight'] = $freight;
        $data['total_price'] = $product_price + $freight + $package_price;
        $data['total_youhui'] = $total_youhui;
        $data['jiesuan_price'] = $jiesuan_price;
        $data['manjian_youhui'] = $youhui['youhui_amount'];
        $this->msgbox->set_data('data', $data);
    }

    // 创建订单
    public function create_order()
    {
        $this->check_login();
        if(IS_AJAX){
            if($params = $this->checksubmit('params')){
                if(!$shop_id = (int) $params['shop_id']){
                    $this->msgbox->add('商家不存在', 210);
                }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
                    $this->msgbox->add('商家不存在', 211);
                }else if($shop['audit'] != 1 || $shop['closed'] != 0){
                    $this->msgbox->add('商家不存在或已被删除', 212);
                }else{
                    $current_time = (float) date("H.i", __TIME);
                    $yy_stime = (float) str_replace(':', '.', $shop['yy_stime']);
                    $yy_ltime = (float) str_replace(':', '.', $shop['yy_ltime']);
                    if(strlen($params['pei_time']) == 5){
                        $pei_stime = (float) str_replace(':', '.', $params['pei_time']);
                        $pei_time = strtotime(date('Y-m-d') . $params['pei_time']);
                    }else if(strlen($params['pei_time']) == 11){
                        $pei_time = explode('-', $params['pei_time']);
                        $pei_stime = (float) str_replace(':', '.', $pei_time[0]);
                        $pei_time = strtotime(date('Y-m-d') . $pei_time[0]);
                    }
                    if(empty($shop['yy_status']) || ($current_time < $yy_stime || $current_time > $yy_ltime)){
                        $this->msgbox->add('商家已经打烊不可下单', 220);
                    }else if($pei_stime && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                        $this->msgbox->add('配送时间不在商家营业范围', 221);
                    }else if(!$products = $params['products']){
                        $this->msgbox->add('您还没有订餐呢', 222);
                    }else if($params['pei_type'] == 3 && $shop['is_ziti']==0){
                        $this->msgbox->add('该商户不支持自提', 223);
                    }else if($params['online_pay'] == 1 && !in_array($shop['online_pay'], array(1, 2))){
                        $this->msgbox->add('该商户不支持在线支付', 224);
                    }else if($params['online_pay'] == 0 && !in_array($shop['online_pay'], array(0, 2))){
                        $this->msgbox->add('该商户不支持货到付款', 225);
                    }else if($params['pei_type'] != 3 && !($addr_id = (int) $params['addr_id'])){
                        $this->msgbox->add('请选择收货地址', 226);
                    }else if($params['pei_type'] != 3 && !($addr = K::M('member/addr')->detail($addr_id))){
                        $this->msgbox->add('地址不存在', 227);
                    }else if($params['pei_type'] != 3 && K::M('helper/round')->getdistances($addr['lng'], $addr['lat'], $shop['lng'], $shop['lat']) > ($shop['pei_distance'] * 1000)){
                        $this->msgbox->add('超出配送范围', 228);
                    }else{
                        $order_data = $waimai_order_data = array();

                        // 验证订单商品信息
                        $products = explode(',', $products);
                        $product_ids = $spec_ids = $product_numbers = $cart_product_list = array();
                        foreach($products as $key => $val){
                            if(preg_match('/^(\d+):(\d+):(\d+)$/', $val, $local)){
                                $pk = $local[1] . '-' . $local[3];
                                $product_ids[$local[1]] = $local[1];
                                $spec_ids[$local[3]] = $local[3];
                                $product_numbers[$pk] = $local[2];
                                $cart_product_list[$pk] = array('product_id' => $local[1], 'number' => $local[2], 'spec_id' => $local[3]);
                            }
                        }

                        $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                        $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);
                        $order_product_list = array();
                        foreach($cart_product_list as $pk => $v){
                            if(!$p = $product_list[$v['product_id']]){
                                //购物车的商品实际不存在
                            }if($p['shop_id'] != $shop['shop_id']){
                                $this->msgbox->add('商品不是同一家商家的', 230)->response();
                            }else if($p['is_spec']){
                                $sp = $spec_lists[$v['spec_id']];
                                if(!$v['spec_id'] && $sp){
                                    //商品未选规格sku
                                    $this->msgbox->add('商品未选规格sku', 231)->response();
                                }else if($sp['product_id'] != $v['product_id']){
                                    //选择规格与商品ID关联不符
                                    $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                                }else if( $sp['sale_sku'] < $product_numbers[$pk]){
                                    $this->msgbox->add('商品库存不足', 233)->response();
                                }else{
                                    $_pamount = ($sp['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id' => $v['product_id'],
                                        'spec_id' => $v['spec_id'],
                                        'sale_type' => $p['sale_type'],
                                        'product_number' => $product_numbers[$pk],
                                        'product_name' => $p['title'],
                                        'product_price' => $sp['price'],
                                        'package_price' => $p['package_price'],
                                        'amount' => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price += $sp['price'] * $product_numbers[$pk];
                                    $package_price += $p['package_price'] * $product_numbers[$pk];
                                }
                            }else{
                                if( $p['stock'] < $product_numbers[$pk]){
                                    $this->msgbox->add('商品库存不足', 211)->response();
                                }else{
                                    $_pamount = ($p['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id' => $v['product_id'],
                                        'spec_id' => 0,
                                        'sale_type' => $p['sale_type'],
                                        'product_number' => $product_numbers[$pk],
                                        'product_name' => $p['title'],
                                        'product_price' => $p['price'],
                                        'package_price' => $p['package_price'],
                                        'amount' => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price += $p['price'] * $product_numbers[$pk];
                                    $package_price += $p['package_price'] * $product_numbers[$pk];
                                }
                            }
                        }
                        if($product_price < $shop['min_amount']){
                            $this->msgbox->add('没有达到配送要求', 212)->response();
                        }
                        if(strlen($params['ziti_time']) == 5){
	                        $ziti_time = strtotime(date('Y-m-d') . $params['ziti_time']);
	                    }else if(strlen($params['ziti_time']) == 11){
	                        $ziti_time = explode('-', $params['ziti_time']);
	                        $ziti_time = strtotime(date('Y-m-d') . $ziti_time[0]);
	                    }else {
	                    	$ziti_time = 0;
	                    }

                        $order_data = array(
                            'city_id' => $shop['city_id'],
                            'shop_id' => $shop_id,
                            'staff_id' => 0,
                            'uid' => $this->uid,
                            'from' => 'weidian_waimai',
                            'order_status' => 0,
                            'intro' => $params['intro'],
                            'pay_status' => 0,
                            'pei_time' => $pei_time,
                            'ziti_time' => $ziti_time,
                            'order_from' => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                        );

                        if($params['pei_type'] == 3){
                            $order_data['amount'] = $product_price + $package_price;
                            $order_data['freight'] = 0;
                            $order_data['contact'] = $this->MEMBER['nickname'];
                            $order_data['mobile'] = $this->MEMBER['mobile'];
                            $order_data['pei_type'] = 3;
                            $order_data['pei_amount'] = 0;
                            $order_data['o_lat'] = $shop['lat'];
                            $order_data['o_lng'] = $shop['lng'];
                            $order_data['pei_time'] = 0;
                            $order_data['total_price'] = $product_price + $package_price + $freight;
                        }else{
                            $juli = K::M('helper/round')->getdistances($shop['lng'], $shop['lat'], $addr['lng'], $addr['lat']);
                            $juli = ceil($juli / 10);
                            $juli = $juli/100;//新距离计算方式wu.
                            $_freight = array();
                            $_max_freight = array('fkm' => 0, 'fm' => 0, 'sm' => 0);
                            foreach($shop['freight_stage'] as $k => $v){
                                if($juli <= $v['fkm']){
                                    if($_freight && $_freight['fkm'] > $v['fkm']){
                                        $_freight = $v;
                                    }else if(empty($_freight)){
                                        $_freight = $v;
                                    }
                                }
                                if($v['fkm'] > $_max_freight['fkm']){
                                    $_max_freight = $v;
                                }
                            }
                            $freight = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                            $p_amount = $_freight['sm'] ? $_freight['sm'] : $_max_freight['sm'];
                            $order_data['amount'] = $product_price + $package_price + $freight;
                            $order_data['freight'] = $freight;
                            $order_data['contact'] = $addr['contact'];
                            $order_data['mobile'] = $addr['mobile'];
                            $order_data['addr'] = $addr['addr'];
                            $order_data['house'] = $addr['house'];
                            $order_data['lng'] = $addr['lng'];
                            $order_data['lat'] = $addr['lat'];
                            $order_data['o_lat'] = $shop['lat'];
                            $order_data['o_lng'] = $shop['lng'];
                            if($shop['pei_type'] == 4) {
                                $order_data['pei_type'] = 0;
                            }else {
                                $order_data['pei_type'] = $shop['pei_type'];
                            }

                            $order_data['pei_amount'] = $p_amount;
                            $order_data['ziti_time'] = 0;
                            $order_data['total_price'] = $product_price + $package_price + $freight;
                        }
                        $m_coupon = array();
                        if($params['online_pay'] == 1){
                            // 在线支付享受的优惠顺序 首单优惠 > 店铺优惠券 > 满减优惠 > 红包优惠
                            $order_data['online_pay'] = 1;
                            // 首单优惠
                            if($shop['first_amount'] && $this->MEMBER['orders']==0){
                                $order_data['first_youhui'] = $first_youhui = $shop['first_amount'];
                            }
                            // 店铺优惠券优惠
                            
                            if($coupon_id = (int) $params['coupon_id']){
                                if(!$m_coupon = K::M('member/coupon')->find(array('coupon_id'=>$coupon_id,'uid'=>$this->uid,'order_amount'=>'<=:'.($product_price-$first_youhui)))){
                                    $this->msgbox->add('优惠券不存在', 203)->response();
                                }else if(!$s_coupon = K::M('shop/coupon')->detail($coupon_id)){
                                    $this->msgbox->add('优惠券不存在', 204)->response();
                                }else if($m_coupon['order_id'] || $m_coupon['use_time'] || $m_coupon['status']){
                                    $this->msgbox->add('该优惠券已被使用', 206)->response();
                                }else if($s_coupon['ltime'] < __TIME){
                                    $this->msgbox->add('该优惠券已过期', 207)->response();
                                }else if($s_coupon['order_amount'] > ($product_price - $first_youhui)){
                                    $this->msgbox->add('该优惠券不能使用', 208)->response();
                                }else{
                                    $order_data['coupon_id'] = $coupon_id;
                                    $order_data['coupon'] = $coupon_amount = $s_coupon['coupon_amount'];
                                }
                            }

                            // 满减优惠
                            if($youhui_detail = K::M('shop/youhui')->order_youhui($shop_id, $product_price - $first_youhui - $coupon_amount)){
                                $order_data['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                            }

                            $hongbao_amount = 0;
                            // // 红包优惠
                            // if($hongbao_id = (int) $params['hongbao_id']){
                            //     if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                            //         $this->msgbox->add('红包不存在', 203)->response();
                            //     }else if($hongbao_detail['uid'] != $this->uid){
                            //         $this->msgbox->add('红包信息不正确', 204)->response();
                            //     }else if($hongbao_detail['order_id']){
                            //         $this->msgbox->add('该红包已经使用', 205)->response();
                            //     }else if($hongbao_detail['ltime'] < __TIME){
                            //         $this->msgbox->add('红包已过期不能使用', 244)->response();
                            //     }else if($hongbao_detail['min_amount'] > ($product_price - $first_youhui - $coupon_amount - $youhui_amount)){
                            //         $this->msgbox->add('该红包不能使用', 205)->response();
                            //     }else{
                            //         $order_data['hongbao_id'] = $hongbao_id;
                            //         $order_data['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                            //     }
                            // }
                            // 结算价格 = 商品总价+打包费+配送费-首单优惠-店铺优惠券-满减优惠-红包优惠
                            $order_data['amount'] = $amount = $product_price + $package_price + $freight - $first_youhui - $coupon_amount - $youhui_amount - $hongbao_amount;
                        }
                        if($order_data['amount'] == 0){
                            $order_data['pay_status'] = 1;
                        }
                        // 创建订单
                        if($order_id = K::M('order/order')->create($order_data)){
                            $waimai_order_data['order_id'] = $order_id;
                            $waimai_order_data['product_number'] = $product_number;
                            $waimai_order_data['product_price'] = $product_price;
                            $waimai_order_data['package_price'] = $package_price;
                            $waimai_order_data['freight'] = $freight;
                            $order = K::M('order/order')->detail($order_id);
                            $waimai_order_id = K::M('waimai/order')->create($waimai_order_data);

                            if($order['online_pay'] == 1) {
                            	if($order['pay_status'] == 1) {
                            		K::M('waimai/order')->create_number($order_id);
                            	}else {
                            		K::M('waimai/order')->update($order_id, array('spend_number' => 0, 'spend_status' => 0));
                            	}
                            }

                            //写入外卖订单商品表
                            foreach($order_product_list as $k => $val){
                                $val['order_id'] = $order_id;
                                K::M('waimai/orderproduct')->create($val);
                            }

                            if($s_coupon){
                                K::M('shop/coupon')->update_count($s_coupon['coupon_id'], 'use_count', 1);
                            }

                            if($m_coupon){
                                $m_c_data = array(
                                    'use_time' => __TIME,
                                    'order_id' => $order_id,
                                    'status' => 1
                                );
                                K::M('member/coupon')->update(array('cid'=>$m_coupon['cid'],'coupon_id'=>$m_coupon['coupon_id'],'uid'=>$m_coupon['uid']), $m_c_data);
                            }
                            
                            if($youhui_detail){
                                K::M('shop/youhui')->update_count($youhui_detail['youhui_id'], 'use_count', 1);
                            }
                            // if($hongbao_detail){
                            //     K::M('hongbao/hongbao')->update($hongbao_id, array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                            // }
                            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                            $this->msgbox->add('订单提交成功');
                            $this->msgbox->set_data('data', array('order_id' => $order_id, 'pay_status' => $order['pay_status'], 'online_pay' => $order['online_pay']));
                        }
                    }
                }
            }else{
            	$this->msgbox->add('提交失败',210);
            }
        }
    }

    // 商品详情
    public function goods_detail($product_id)
    {
    	$product_id = (int)$product_id;
    	if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('商品不存在',211);
        }else if(!$shop_detail = K::M('shop/shop')->detail($detail['shop_id'])) {
            $this->msgbox->add('非法操作', 212);
        }else{
            if($spec_list = K::M('waimai/productspec')->items(array('product_id'=>$product_id),null,1,$limit,$count)){
                foreach($spec_list as $k => $v){
                    $spec_list[$k]['package_price'] = $detail['package_price'];
                    $spec_list[$k]['sale_type'] = $detail['sale_type'];
                    $spec_list[$k]['stock'] = $detail['stock'];
                    if(empty($v['spec_photo'])){
                        $spec_list[$k]['spec_photo'] = $detail['photo'];
                    }
                }
            }
            $this->pagedata['is_collect'] = (int)K::M('waimai/productcollect')->count(array('uid'=>$this->uid,'product_id'=>$product_id));
            $this->pagedata['spec_count'] = $count;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = $shop_detail;
            $this->pagedata['spec_list'] = $spec_list;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
			$this->tmpl = 'weidian/'.$this->default_weidian_theme().'/waimai/goods_detail.html';
        }
    }

    // 外卖商品收藏
    public function goods_collect($product_id)
    {
    	$product_id = (int)$product_id;
    	$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
		if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('商品不存在', 210);
        }else if($detail['shop_id'] != $shop_id){
            $this->msgbox->add('非法操作', 211);
        }else{
            if($result = K::M('waimai/productcollect')->find(array('uid'=>$this->uid,'product_id'=>$product_id))){
                if(K::M('waimai/productcollect')->del($this->uid,$product_id)){
                    $this->msgbox->add('取消收藏成功', 205);
                }
            }else{
                if(K::M('waimai/productcollect')->create(array('uid'=>$this->uid,'product_id'=>$product_id,'dateline'=>__TIME))){
                    $this->msgbox->add('收藏商品成功');
                }
            }
        }
    }

    // 用户自提地址地图
    public function ziti_map_locate()
    {
    	$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
    	$this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
    	$this->pagedata['theme_style'] = $this->default_weidian_theme();
		$this->tmpl = 'weidian/'.$this->default_weidian_theme().'/waimai/ziti_map_locate.html';
    }
}