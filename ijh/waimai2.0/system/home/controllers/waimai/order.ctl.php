<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Waimai_Order extends Ctl
{
    /* 外卖订单列表 */

    public function index($comment = null)
    {
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        $filter['day'] = date('Ymd', __TIME - 31 * 86400) . '~' . date('Ymd', __TIME);      //只查询近一个月订单
        $page = max((int) $this->GP('page'), 1);


        //查找总数
        $count = array();
        $filter['order_status'] = array(0, 1, 3, 4); // 待处理
        $orders_0 = K::M('order/order')->items($filter, array('order_id' => 'desc'), $page, 1, $count['count_0']);
        $filter['order_status'] = array(-1, 8); // 已完成
        $orders_1 = K::M('order/order')->items($filter, array('order_id' => 'desc'), $page, 1, $count['count_1']);


        //status is type , change it
        if($this->GP('type')){
            $type = 1;
            $filter['order_status'] = array(-1, 8);  // 已完成
        }else{
            $type = 0;
            $filter['order_status'] = array(0, 1, 3, 4); // 待处理
        }

        $reason = K::M('order/order')->get_reason();
        $this->pagedata['reason'] = $reason['waimai'];
        $this->pagedata['page'] = $page;
        $this->pagedata['comment_mark'] = $comment;
        $this->pagedata['count'] = $count;
        $this->tmpl = 'waimai/order/index.html';
    }

    /**
     * index 获取订单数据方法
     */
    public function ajax_index()
    {
        $filter = array();
        $limit = max((int) $this->GP('limit'), 10); //接收 js 传递的翻页值
        $page = max((int) $this->GP('page'), 1);
        $comment_mark = $this->GP('comment_mark');
        $filter['uid'] = $this->uid;
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        //$filter['day'] = date('Ymd', __TIME - 31 * 86400) . '~' . date('Ymd', __TIME);      //只查询近一个月订单

        $type = (int) $this->GP('status'); //2种状态
        if($type == 1){
            $filter['order_status'] = array(-1, 8);  // 已完成
        }else{
            if($comment_mark){
                $filter['order_status'] = array(8); // 待评价
                $filter['comment_status'] = 0;
            }else{
                $filter['order_status'] = array(0, 1, 3, 4); // 待处理
            }
        }

        $arr_orders = K::M('order/order')->items($filter, array('order_id' => 'desc'), $page, $limit, $count);

        $shop_ids = $order_ids = array();
        foreach($arr_orders as $k => $val){
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        $arr_shops = K::M('shop/shop')->items_by_ids($shop_ids);
        $arr_waimai_orders = K::M('shop/shop')->items_by_ids($order_ids);
        $arr_products = K::M('waimai/orderproduct')->items(array('order_id' => $order_ids), array('pid' => 'desc'));
        $new_array_products = array();
        foreach($arr_products as $k => $val){
            foreach($arr_orders as $kk => $v){
                if($v['order_id'] == $val['order_id']){
                    $arr_orders[$kk]['count'] += $val['product_number'];
                }
            }
            $new_array_products[$val['order_id']][] = $val;
        }
        foreach($arr_orders as $k => $v){
            $v['arr_shop'] = $arr_shops[$v['shop_id']];
            $v['arr_waimai_order'] = $arr_waimai_orders[$v['order_id']];
            $v['arr_product'] = $new_array_products[$v['order_id']];
            $arr_orders[$k] = $v;
        }
        $ziti_html = '';
        $return_html = '';
        $s_label = '';
        $format_time = '';
        $btn_list = '';
        if($count > 0){
            foreach($arr_orders as $k => $v){
                if(__TIME - $v['dateline'] > 1800 && $v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 1){
                    K::M('order/order')->cancel($v['order_id'], $v, 'admin', '订单超过30分钟未付款自动取消');
                }
                if(__TIME - $v['dateline'] > 3600 && $v['order_status'] == 0 && $v['pay_status'] == 1){
                    K::M('order/order')->cancel($v['order_id'], $v, 'admin', '订单逾期1小时内无人接单自动取消');
                }
                if(in_array($v['pei_type'], array(0, 1, 2))){
                    if($v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 1){
                        $s_label = '等待支付';
                    }else if($v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 0){
                        $s_label = '等待商家接单';
                    }else if($v['order_status'] == 0 && $v['pay_status'] == 1 && $v['online_pay'] == 1){
                        $s_label = '等待商家接单';
                    }else if($v['order_status'] == 1 && $v['staff_id'] == 0){
                        $s_label = '商家已接单';
                    }else if($v['pei_type'] == 0 && in_array($v['order_status'], array(1, 2))){
                        $s_label = '商家正在配货';
                    }else if($v['pei_type'] == 0 && $v['order_status'] == 3){
                        $s_label = '商家正在送餐';
                    }else if(in_array($v['order_status'], array(1, 2)) && $v['staff_id'] > 0 && in_array($v['pei_type'], array(1, 2))){
                        $s_label = '骑手正在取餐';
                    }else if($v['order_status'] == 3 && $v['staff_id'] > 0 && in_array($v['pei_type'], array(1, 2))){
                        $s_label = '骑手正在送餐';
                    }else if($v['order_status'] == -1){
                        $s_label = '订单已取消';
                    }else if($v['order_status'] == 4){
                        $s_label = '订单已完成';
                    }else if($v['order_status'] == 8 && $v['comment_status'] == 0){
                        $s_label = '订单已完成';
                    }else if($v['order_status'] == 8 && $v['comment_status'] == 1){
                        $s_label = '订单已完成';
                    }
                }else if($v['pei_type'] == 3){
                    if($v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 1){
                        $s_label = '等待支付';
                    }else if($v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 0){
                        $s_label = '等待商家接单';
                    }else if($v['order_status'] == 0 && $v['pay_status'] == 1 && $v['online_pay'] == 1){
                        $s_label = '等待商家接单';
                    }else if($v['order_status'] == 1){
                        $s_label = '商家已接单';
                    }else if($v['order_status'] == 8){
                        $s_label = '订单已完成';
                    }else if($v['order_status'] == -1){
                        $s_label = '订单已取消';
                    }
                }

                if($v['order_status'] == -1){
                    $btn_list = "<a href='javascript:;' class='button button-cancel' id='onemore' order_id='" . $v['order_id'] . "'>再来一单</a>";
                }
                if($v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 1){
                    $btn_list = "<a href='javascript:;' class='button button-cancel open-slider-modal' id='cancel' order_id='" . $v['order_id'] . "'>取消订单</a><a href='javascript:;' class='button button-warning' id='payment' order_id='" . $v['order_id'] . "'>去支付</a>";
                }
                if($v['order_status'] == 0 && $v['pay_status'] == 1 && $v['online_pay'] == 1){
                    $btn_list = "<a href='javascript:;' class='button button-cancel open-slider-modal' id='cancel' order_id='" . $v['order_id'] . "'>取消订单</a>";
                }
                if(in_array($v['order_status'], array(1, 2, 3)) && $v['pei_type'] != 3){
                    $btn_list = "<a href='javascript:;' class='button button-cancel' id='cuidan' order_id='" . $v['order_id'] . "'>催单</a>";
                }
                if(in_array($v['order_id'], array(3, 4))){
                    $btn_list .= "<a href='javascript:;' class='button' id='arrived' order_id='" . $v['order_id'] . "'>确认送达</a>";
                }
                if(in_array($v['order_status'], array(1, 2, 3)) && $v['pei_type'] == 3){
                    $btn_list = "";
                }
                if($v['order_status'] == 8 || $v['order_status'] == 4){
                    $btn_list = "<a href='javascript:;' class='button button-cancel' id='onemore' order_id='" . $v['order_id'] . "'>再来一单</a>";
                    if($v['comment_status'] == 0){
                        $btn_list .= "<a href='javascript:;' class='button button-warning' id='comment' order_id='" . $v['order_id'] . "'>评价得积分</a>";
                    }else if($v['order_status'] == 8 && $v['comment_status'] == 1){
                        $btn_list .= "<a href='javascript:;' class='button button-cancel' id='look_comment' order_id='" . $v['order_id'] . "'>查看评价</a>";
                    }
                }

                $format_time = K::M('helper/format')->time($v['dateline']);
                $return_html .= "<div class='card one_item' order_id=" . $v['order_id'] . ">";
                $return_html .= "<div class='card-header'><p class='maincl'>" . $s_label . "<small class='black9'>-" . $format_time . "</small></p>";
                if($v['pei_type'] == 3){
                    $return_html .= "<span class='self-tidan-tit'>自提单</span>";
                }

                if($type == 1 && in_array($v['order_status'], array(-1, 8))){
                    //$return_html .= "<i class='iconfont icon-shanchu' order_id='{$v['order_id']}'></i>";
                }


                $return_html .= "</div>";
                $return_html .= "<a href='" . $this->mklink('waimai/order/detail', array($v['order_id'])) . "' class='card one_item'><div class='card-content'>";
                $return_html .= "<div class='list-block media-list'>";
                $return_html .= "<ul>";
                $return_html .= "<li class='item-content'>";
                $return_html .= "<div class='item-media'>";
                $return_html .= "<img src='/attachs/{$v['arr_shop']['logo']}' width='100%' height='100%'>";
                $return_html .= "</div>";
                $return_html .= "<div class='item-inner'>";
                $return_html .= "<div class='item-title black3'>" . $v['arr_shop']['title'] . "<i class='linkIco'></i></div>";
                foreach($v['arr_product'] as $pk => $pv){
                    $return_html .= "<div class='item-title-row'>";
                    $return_html .= "<div class='item-text'><p class='black9'>{$pv['product_name']}</p></div>";
                    $return_html .= "<div class='item-after'><p class='black9'>x{$pv['product_number']}</p></div>";
                    $return_html .= "</div>";
                }
                $return_html .= "<p class='black9 txt_right mt5'>共<span class='black3'>{$v['count']}</span>份，实付<span class='black3'>￥<big>{$v['amount']}</big></span></p>";
                $return_html .= "</div>";
                $return_html .= "</li>";
                $return_html .= "</ul>";
                $return_html .= "</div>";
                $return_html .= "</div></a>";
                $return_html .= "<div class='card-footer'>" . $btn_list . "</div></div>";
            }
        }else{
            $return_html .= "<div class='content-block biaoqian-content'>";
            $return_html .= "<div class='wushuju'>";
            $return_html .= "<img src='/themes/default/static/images/kong.png' width='30%'>";
            $return_html .= "<p class='mt10'>暂无数据，<a href='" . $this->mklink('shop?page=1') . "'><span
            class='fontcl1'>马上去逛逛~</span></a></p>";
            $return_html .= "</div>";
            $return_html .= "</div>";
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('count_num' => $count, 'html' => $return_html));
    }

    // 购物车确认订单
    public function order($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不能为空', 221)->response();
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 222)->response();
        }else{
            // 判断是否打样
            $cur_time = (float) date("H.i", __TIME);
            $yy_stime = (float) str_replace(':', '.', $shop['yy_stime']);
            $yy_ltime = (float) str_replace(':', '.', $shop['yy_ltime']);

            if($shop['yy_status'] == 0 || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                $this->msgbox->add('商家已经打烊不可下单', 223)->response();
            }
            // 获取用户购物车信息判断是否点餐
            $cart = $this->getECart($shop_id);

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
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['spec_name'] = $sp['spec_name'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $sp['price'];
                        $product_price += $sp['price'] * $product_numbers[$pk];       //商品总价
                        $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $sp['product_id'] . ":" . $product_numbers[$pk];
                        $products .= ":" . $sp['spec_id'] . ',';
                    }
                }else{
                    // 无规格商品
                    if($p['stock'] < $product_numbers[$pk]){
                        $this->msgbox->add('商品库存不足', 211)->response();
                    }else{
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $p['price'];
                        $product_price += $p['price'] * $product_numbers[$pk];       //商品总价
                        $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $v['product_id'] . ":" . $product_numbers[$pk];
                        $products .= ':0,';
                    }
                }
            }

            $products = rtrim($products, ',');

            // 购物车商品列表
            $this->pagedata['products'] = $products;
            if($product_price < $shop['min_amount']){
                K::M('system/logs')->log('waimai.order', array($cart, $_COOKIE, $product_price, $cart_product_list, $product_ids, $product_list, $spec_lists, $detail, $this->system->db->SQLLOG()));
                $this->msgbox->add('没有达到配送要求', 212)->response();
            }

            // 首单优惠
            if(!K::M('order/order')->count(array('uid' => $this->uid))){
                $first_youhui = $shop['first_amount']; // 第一单享受首单优惠
            }else{
                $first_youhui = 0; // 不是第一单不享受首单优惠
            }

            $first_price = $product_price - $first_youhui;

            // 获取满足使用条件的店铺优惠券
            $second_price = $first_price;
            if($coupon = K::M('shop/coupon')->get_coupon($this->uid, $shop_id, $first_price)){
                if($first_price >= $coupon['order_amount']){
                    $second_price = $first_price - $coupon['coupon_amount'];
                }else{
                    unset($coupon);
                }
            }


            // 获取满足使用条件的满减优惠 

            $txt_manjian = "";
            if($youhui = K::M('shop/youhui')->order_youhui($shop_id, $second_price)){
                $third_price = $second_price - $youhui['youhui_amount'];
                $txt_manjian = "满{$youhui['order_amount']}减{$youhui['youhui_amount']}";
                //<img src='/themes/default/static/images/tag2.png'>
            }else{
                $third_price = $second_price;
            }

            // 获取满足使用条件的红包优惠
            if($hongbao = K::M('hongbao/hongbao')->get_hongbao($this->uid, $third_price)){
                $hongbao_price = $third_price - $hongbao['amount'];
            }else{
                $hongbao_price = $third_price;
            }

            // 结算价格
            $total_price = $hongbao_price + $package_price + $shop['freight']; // 结算价格=优惠后价格+打包费+运费
            // 总优惠
            $total_youhui = $first_youhui + $coupon['coupon_amount'] + $youhui['youhui_amount'] + $hongbao['amount']; //总优惠= 首单优惠+优惠券+满减优惠+红包优惠

            /* 送达时间选择列表 */
            $res = K::M('order/order')->get_time();

            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'] . ":" . $res['start_quarter'] * 15;

            $rr = explode(':', $shop['yy_ltime']);
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1] / 15;
            $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;

            if($stime > $shop['yy_ltime']){
                $set_time = array();
            }
            $tomorrow_set_time = $set_time;
            $yy_stime = explode(':', $shop['yy_stime']);
            $tomorrow_set_time['start'] = $yy_stime[0];
            $this->pagedata['tomorrow_set_time'] = $tomorrow_set_time;
            //$yuji_time = "尽快送达|预计" . date('H:i', __TIME+1800);
            $yuji_time = date('H:i', __TIME + 1800);
            //$ziti_yuji = "立即自提|大约" . date('H:i', __TIME+1800);
            $ziti_yuji = date('H:i', __TIME + 1800);

            $displayValues = array('今天', '明天', '后天');
            $values = array(date('Ymd'), date("Ymd", strtotime("+1 day")), date("Ymd", strtotime("+2 day")));
            $this->pagedata['yuji_time'] = $yuji_time;
            $this->pagedata['ziti_yuji'] = $ziti_yuji;
            $this->pagedata['set_time'] = $set_time;

            /* 自提时间选择列表 */
            // 收货地址
            if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
                $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
            }
            if($member = K::M('member/member')->detail($this->uid)){
                $this->pagedata['mymoney'] = $member['money'];
            }
        }
        $this->pagedata['total'] = $total_price + $total_youhui;  // 货到付款方式不享受所有优惠
        $this->pagedata['total_price'] = $total_price;  // 结算价格
        $this->pagedata['total_youhui'] = $total_youhui;
        $this->pagedata['hongbao'] = $hongbao;
        $this->pagedata['youhui'] = $youhui;
        $this->pagedata['coupon'] = $coupon;
        $this->pagedata['yh_price'] = $yh_price;
        $this->pagedata['first_price'] = $first_price;
        $this->pagedata['third_price'] = $third_price;
        $this->pagedata['package_price'] = $package_price;
        $this->pagedata['product_list'] = array_values($product_lists);
        $this->pagedata['shop'] = $shop;
        $this->pagedata['m_addr'] = $m_addr;
        $this->pagedata['displayValues'] = $displayValues;
        $this->pagedata['values'] = $values;
        $this->pagedata['this_uid'] = $this->uid;
        $this->pagedata['first_youhui'] = $first_youhui;
        $this->pagedata['product_price'] = $product_price;
        //自定义提示
        $this->pagedata['txt_manjian'] = $txt_manjian;
        $this->pagedata['yuhui_amount'] = $youhui['youhui_amount'];
        //echo '<pre>';print_r($txt_manjian);die;
        $this->tmpl = 'waimai/order/order.html';
    }

    function ajaxorder()
    {
        $this->check_login();
        $addr_id = (int) $this->GP('addr_id');
        $shop_id = (int) $this->GP('shop_id');
        $pei_type = (int) $this->GP('pei_type');
        $coupon_id = (int) $this->GP('coupon_id');
        $hongbao_id = (int) $this->GP('hongbao_id');
        $package_price = $this->GP('package_price');
        $product_price = $this->GP('product_price');
        $online_pay = (int) $this->GP('online_pay');
        $shop = K::M('shop/shop')->detail($shop_id);
        $addr = K::M('member/addr')->detail($addr_id);
        // 首单优惠
        $member_orders = K::M('order/order')->count(array('order_status'=>'>:'.-1,'uid'=>$this->uid));
        if($shop['first_amount'] && !$this->MEMBER['orders'] && !$member_orders){
            $first_youhui = $shop['first_amount']; // 第一单享受首单优惠
        }else{
            $first_youhui = 0; // 不是第一单不享受首单优惠
        }

        $first_price = $product_price - $first_youhui;

        // 根据coupon_id查找优惠券
        $coupon['coupon_amount'] = 0;
        $second_price = $first_price;
        if(K::M('member/coupon')->find(array('coupon_id' => $coupon_id, 'uid' => $this->uid, 'shop_id' => $shop_id, 'order_id' => 0, 'use_time' => 0))){
            if($coupon = K::M('shop/coupon')->find(array('coupon_id' => $coupon_id, 'shop_id' => $shop_id, 'ltime' => '>:' . __TIME))){
                if($first_price >= $coupon['order_amount']){
                    $second_price = $first_price - $coupon['coupon_amount'];
                }else{
                    unset($coupon);
                }
            }
        }

        // 获取满足使用条件的满减优惠 
        $txt_manjian = "";
        if($youhui = K::M('shop/youhui')->order_youhui($shop_id, $second_price)){
            $third_price = $second_price - $youhui['youhui_amount'];
            $txt_manjian = "满{$youhui['order_amount']}减{$youhui['youhui_amount']}";
            //<img src='/themes/default/static/images/tag2.png'>
        }else{
            $youhui['youhui_amount'] = 0;
            $third_price = $second_price;
        }

        // 根据hongbao_id查找红包
        if($hongbao = K::M('hongbao/hongbao')->find(array('hongbao_id' => $hongbao_id, 'uid' => $this->uid, 'order_id' => 0, 'used_time' => 0, 'ltime' => '>:' . __TIME))){
            $fourth_price = $third_price - $hongbao['amount'];
        }else{
            $hongbao['amount'] = 0;
            $fourth_price = $third_price;
        };

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
                $freight = $_freight['fkm'] ? $_freight['fm'] : $_max_freight['fm'];
            }else{
                $freight = 0;
            }
        }

        if($online_pay){
            // 结算价格=优惠后价格+打包费+运费
            $jiesuan_price = $fourth_price + $package_price + $freight;
            //总优惠=首单+优惠券+满减+红包 首单优惠+优惠券+满减优惠+红包优惠
            $total_youhui = $first_youhui + $coupon['coupon_amount'] + $youhui['youhui_amount'] + $hongbao['amount'];
        }else{
            $jiesuan_price = $product_price + $package_price + $freight;
            $total_youhui = 0;
        }
        $hongbao['types'] = $hongbao['title']; //前端红包标题
        $this->msgbox->add('success');
        $data['freight'] = $freight;
        $data['coupon'] = $coupon['coupon_amount'];
        $data['total_price'] = $product_price + $freight + $package_price;
        $data['total_youhui'] = $total_youhui;
        $data['jiesuan_price'] = round($jiesuan_price,2);
        $data['hongbao_amount'] = $hongbao['amount'];
        $data['coupon_amount'] = $coupon['coupon_amount'];
        $data['youhui_amount'] = $youhui['youhui_amount'];

        $data['first_amount'] = $first_youhui;
        $data['hongbao'] = $hongbao;
        $data['txt_manjian'] = $txt_manjian;
        $this->msgbox->set_data('data', $data);
    }

    // 下单
    public function create()
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
                    }else if($params['online_pay'] == 0 && (!in_array($shop['online_pay'], array(0, 2)) || !$shop['is_daofu'])) {
                        $this->msgbox->add('该商户不支持货到付款', 225);
                    }else if($params['pei_type'] != 3 && !($addr_id = (int) $params['addr_id'])){
                        $this->msgbox->add('请选择收货地址', 226);
                    }else if($params['pei_type'] != 3 && !($addr = K::M('member/addr')->detail($addr_id))){
                        $this->msgbox->add('地址不存在', 227);
                    }else if($params['pei_type'] != 3 && K::M('helper/round')->getdistances($addr['lng'], $addr['lat'], $shop['lng'], $shop['lat']) > ($shop['pei_distance'] * 1000)){
                        $this->msgbox->add('超出配送范围', 228);
                    }else{
                        $order_data = $waimai_order_data = array();
                        $product_number = $product_price = $package_price = 0;
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
                        if(isset($params['ziti_time'])){
                            $ziti_time = strtotime($params['ziti_time']);
                        }else{
                            $ziti_time = 0;
                        }
                        $order_data = array(
                            'city_id' => $shop['city_id'],
                            'shop_id' => $shop_id,
                            'staff_id' => 0,
                            'uid' => $this->uid,
                            'from' => 'waimai',
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
                            $order_data['total_price'] = $product_price + $package_price ; // $freight;
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
                            $freight = $_freight['fkm'] ? $_freight['fm'] : $_max_freight['fm'];
                            $p_amount = $_freight['fkm'] ? $_freight['sm'] : $_max_freight['sm'];
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

                        if($params['online_pay'] == 1){
                            // 在线支付享受的优惠顺序 首单优惠 > 店铺优惠券 > 满减优惠 > 红包优惠
                            $order_data['online_pay'] = 1;
                            // 首单优惠
                            $member_orders = K::M('order/order')->count(array('order_status'=>'>:'.-1,'uid'=>$this->uid));

                            if($shop['first_amount'] && !$this->MEMBER['orders'] && !$member_orders){
                                if( $product_price >= $shop['first_amount']) {
                                    //订单金额大于首单优惠返回首单优惠
                                    $order_data['first_youhui'] = $first_youhui = $shop['first_amount'];
                                }else {
                                    //订单金额小于首单优惠返回订单金额
                                    $order_data['first_youhui'] = $first_youhui = $product_price; 
                                }
                            }

                            // 店铺优惠券优惠
                            if($coupon_id = (int) $params['coupon_id']){
                                if(!$m_coupon = K::M('member/coupon')->find(array('coupon_id' => $coupon_id, 'uid' => $this->uid))){
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
                            // 红包优惠
                            if($hongbao_id = (int) $params['hongbao_id']){
                                if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                                    $this->msgbox->add('红包不存在', 203)->response();
                                }else if($hongbao_detail['uid'] != $this->uid){
                                    $this->msgbox->add('红包信息不正确', 204)->response();
                                }else if($hongbao_detail['order_id']){
                                    $this->msgbox->add('该红包已经使用', 205)->response();
                                }else if($hongbao_detail['ltime'] < __TIME){
                                    $this->msgbox->add('红包已过期不能使用', 244)->response();
                                }else if($hongbao_detail['min_amount'] > ($product_price - $first_youhui - $coupon_amount - $youhui_amount)){
                                    $this->msgbox->add('该红包不能使用', 205)->response();
                                }else{
                                    $order_data['hongbao_id'] = $hongbao_id;
                                    $order_data['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                                }
                            }
                            // 结算价格 = 商品总价+打包费+配送费-首单优惠-店铺优惠券-满减优惠-红包优惠
                            $total_youhui_amount = round($youhui_amount + $coupon_amount + $first_youhui + $hongbao_amount, 2);
                            if($product_price > $total_youhui_amount) {
                                $order_data['amount'] = $amount = $product_price + $package_price + $freight - $first_youhui - $coupon_amount - $youhui_amount - $hongbao_amount;
                            }else {
                                $data_order['amount'] = $amount = $package_price + $freight;
                            }  
                        }
                        else{
                            // 货到付款方式支付
                            $data_order['online_pay'] = 0;
                            if( 2 == $data_order['pei_type'] || 1 == $data_order['pei_type']){
                                $data_order['pei_type'] = 0;
                            }
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
                            if($order['online_pay'] == 0 && $order['pei_type'] == 3){
                                //如果是自提单且选择了到付，直接生成消费码
                                K::M('waimai/order')->create_number($order_id);
                            }else if($order['online_pay'] == 1 && $order['pay_status'] == 0 && $order['pei_type'] == 3){
                                //如果自提单选择了在线支付且未支付，支付成功之后生成消费码
                                K::M('waimai/order')->update($order_id, array('spend_number' => 0, 'spend_status' => 0));
                            }

                            //写入外卖订单商品表,并更新库存
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
                                K::M('member/coupon')->update($m_coupon['cid'], $m_c_data);
                            }
                            if($youhui_detail){
                                K::M('shop/youhui')->update_count($youhui_detail['youhui_id'], 'use_count', 1);
                            }
                            if($hongbao_detail){
                                K::M('hongbao/hongbao')->update($hongbao_id, array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                            }
                            
                            K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                            // 如果是货到付款订单则直接推送消息给商户，在线支付则在支付成功之后推送给商户
                            if($order['online_pay']==0) {
                                $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                                $content = sprintf("您有新的外卖订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                                K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
                            }
                            $this->msgbox->add('订单提交成功');
                            $this->msgbox->set_data('order', array('order_id' => $order_id, 'pay_status' => $order['pay_status'], 'online_pay' => $order['online_pay']));
                        }
                    }
                }
            }
        }
    }

    // 解析JS购物车商品信息
    public function getECart($shop_id)
    {
        $this->check_login();
        $cart = json_decode(urldecode($_COOKIE['KT-ECart']), true);
        $cart_goods = explode(',', $cart[$shop_id]);
        foreach($cart_goods as $key => $val){
            if(preg_match('/^(\d+)-(\d+):(\d+)$/', $val, $local)){
                $pk = $local[1] . '-' . $local[2];
                $cart_product_list[$pk] = array(
                    'product_id' => $local[1],
                    'number' => $local[3],
                    'spec_id' => $local[2],
                );
            }
        }
        $items[$shop_id] = $cart_product_list;
        return $items;
    }

    // 订单备注信息
    public function note()
    {
        $this->check_login();
        $this->pagedata['notes'] = K::M('order/order')->get_note();
        $this->tmpl = 'waimai/order/note.html';
    }

    // 根据商户地址与用户收货地址距离计算配送费
    public function getfreight()
    {
        $this->check_login();
        if($addr_id = (int) $this->GP('addr_id')){
            $addr = K::M('member/addr')->detail($addr_id);
        }
        if($shop_id = (int) $this->GP('shop_id')){
            $shop = K::M('shop/shop')->detail($shop_id);
        }
        if(isset($addr) && isset($shop)){
            //计算出对应的配送费
            $juli = K::M('helper/round')->getdistances($addr['lng'], $addr['lat'], $shop['lng'], $shop['lat']);
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
            $data['freight_stage'] = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
            //计算出对应的配送费结束
        }else{
            $data['freight_stage'] = 0;
        }
        $this->msgbox->set_data('data', array('freight' => $data['freight_stage']));
    }

    // 外卖订单详情
    public function detail($order_id)
    {
        $this->check_login();
        $order = $waimai_order = $waimai_order_product = array();
        if($order_id != (int) $order_id){
            $this->msgbox->add('订单不存在', 201)->response();
        }
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 202)->response();
        }else {
            if(__TIME - $order['dateline'] > 1800 && $order['order_status'] == 0 && $order['online_pay'] == 1 && $order['pay_status'] == 0){
                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单超过30分钟未付款自动取消');
            }
            if(__TIME - $order['dateline'] > 3600 && $order['order_status'] == 0 && $order['pay_status'] == 1){
                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单逾期1小时内无人接单自动取消');
            }
            $order = K::M('order/order')->detail($order_id);
        }
        if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 203);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 204);
        }else if(!$waimai_order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单扩展信息不存在', 205);
        }else if(!$waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
            $this->msgbox->add('订单商品信息不存在', 206);
        }else{
            $order['dateline'] = K::M('helper/format')->time($order['dateline']);
            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $order['waimai_order'] = $waimai_order;
            $order['waimai_order_product'] = $waimai_order_product;
            foreach($waimai_order_product as $k => $v){
                $specids[] = $v['spec_id'];
            }
            $order['qrcode'] = $this->mklink('qrcode?data=' . $waimai_order['spend_number']);
            $order['qrcode'] = substr($order['qrcode'], 0, strlen($order['qrcode']) - 1);
            $order['specs'] = K::M('waimai/productspec')->items_by_ids($specids);
            $order['source_reason'] = $order['reason'];
            $reason = K::M('order/order')->get_reason();
            $order['reason'] = $reason['waimai'];

            if($log_list = K::M('order/log')->items(array('order_id' => $order_id, 'type' => $log_type), array('log_id' => 'desc'))){
                $order['logs'] = array_values($log_list);
            }
            $this->pagedata['order'] = $order;
            $this->tmpl = 'waimai/order/detail.html';
        }
    }

    // 外卖订单状态
    public function status($order_id)
    {
        $this->check_login();
        $order = $waimai_order = $waimai_order_product = array();
        if($order_id != (int) $order_id){
            $this->msgbox->add('订单不存在', 201)->response();
        }
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 202)->response();
        }else {
            if(__TIME - $order['dateline'] > 1800 && $order['order_status'] == 0 && $order['online_pay'] == 1 && $order['pay_status'] == 0){
                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单超过30分钟未付款自动取消');
            }
            if(__TIME - $order['dateline'] > 3600 && $order['order_status'] == 0 && $order['pay_status'] == 1){
                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单逾期1小时内无人接单自动取消');
            }
            $order = K::M('order/order')->detail($order_id);
        }
        if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 203);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 204);
        }else if(!$waimai_order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单扩展信息不存在', 205);
        }else if(!$waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
            $this->msgbox->add('订单商品信息不存在', 206);
        }else{
            $order['formatdateline'] = K::M('helper/format')->time($order['dateline']);
            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $order['waimai_order'] = $waimai_order;

            if($order['pei_type'] != 3){
                // 配送订单
                if($order['order_status'] == 0){
                    if(($order['online_pay'] == 1 && $order['pay_status'] == 0) || ($order['online_pay'] == 0)){
                        $log_type = 1;
                    }else if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2);
                    }
                }else if($order['order_status'] == 1 || (in_array($order['order_status'], array(1, 2)) && $order['staff_id'] > 0)){
                    if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2, 3);
                    }else if($order['online_pay'] == 0){
                        $log_type = array(1, 3);
                    }
                }else if($order['order_status'] == 3){
                    if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2, 3, 4);
                    }else if($order['online_pay'] == 0){
                        $log_type = array(1, 3, 4);
                    }
                }else if(in_array($order['order_status'], array(4, 8))){
                    if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2, 3, 5);
                    }else if($order['online_pay'] == 0){
                        $log_type = array(1, 3, 5);
                    }
                }else if($order['order_status'] == -1){
                    $log_type = array(1, -1);
                }
            }else{
                // 自提订单
                if($order['order_status'] == 0){
                    if(($order['online_pay'] == 1 && $order['pay_status'] == 0) || ($order['online_pay'] == 0)){
                        $log_type = 1;
                    }else if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2);
                    }
                }else if($order['order_status'] == 1){
                    if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2, 3);
                    }else if($order['online_pay'] == 0){
                        $log_type = array(1, 3);
                    }
                }else if($order['order_status'] == 8 && $waimai_order['spend_status'] == 1){
                    if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                        $log_type = array(1, 2, 3, 6);
                    }else if($order['online_pay'] == 0){
                        $log_type = array(1, 3, 6);
                    }
                }else if($order['order_status'] == -1){
                    $log_type = array(1, -1);
                }
                $order['qrcode'] = $this->mklink('qrcode?data=' . $waimai_order['spend_number']);
                $order['qrcode'] = substr($order['qrcode'], 0, strlen($order['qrcode']) - 1);
            }

            $order['log_type'] = $log_type;

            if($log_list = K::M('order/log')->items(array('order_id' => $order_id, 'type' => $log_type), array('log_id' => 'desc'))){
                $order['logs'] = array_values($log_list);
            }
            $reason = K::M('order/order')->get_reason();
            $order['reason'] = $reason['waimai'];
            $this->pagedata['order'] = $order;
//            echo '<pre>';print_r($order);die;
            $this->tmpl = 'waimai/order/status.html';
        }
    }

    // 用户取消订单
    public function cancel()
    {
        $this->check_login();
        $reason = $this->GP('reason');
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消', 214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态', 215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'member', $reason)){
            $this->msgbox->add('订单取消成功');
        }else{
            $this->msgbox->add('订单取消失败', 216);
        }
    }

    // 用户删除订单
    public function delete()
    {
        $this->check_login();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 211);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 212);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 213);
        }else if(($order['order_status'] == -1) || ($order['order_status'] == 8)){
            if(K::M('order/order')->delete($order_id, false)){
                $this->msgbox->add('删除订单成功');
            }else{
                $this->msgbox->add('删除订单失败', 213);
            }
        }else{
            $this->msgbox->add('当前状态不可删除', 214);
        }
    }

    // 催单
    public function cuidan()
    {
        $this->check_login();
        $order_id = $this->GP('order_id');
        if(!$order_id = (int) $order_id){
            $this->msgbox->add('订单不存在', 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else if((__TIME - $order['jd_time']) < 1800){
            $this->msgbox->add('请在30分钟后催单', 216);
        }else if((__TIME - $order['cui_time']) < 600){
            $this->msgbox->add('已经催过，请稍后再试', 217);
        }else if(K::M('order/order')->update($order_id, array('cui_time' => __TIME))){
            $cuilog['uid'] = $order['uid'];
            $cuilog['shop_id'] = $order['shop_id'];
            $cuilog['staff_id'] = $order['staff_id'];
            $cuilog['order_id'] = $order['order_id'];
            if($log_id = K::M('order/cuilog')->find($cuilog)){
                K::M('order/cuilog')->update($log_id, array('cui_time' => __TIME));
            }else{
                $cuilog['cui_time'] = __TIME;
                K::M('order/cuilog')->create($cuilog);
            }
            $this->msgbox->add('催单成功,请耐心等待');
        }else{
            $this->msgbox->add('催单失败', 214);
        }
    }

    // 评价页面 
    public function comment($order_id)
    {
        $this->check_login();
        if($order_id != (int) $order_id){
            $this->msgbox->add('订单不存在', 201);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 202);
        }else if($order['order_status'] != 8){
            $this->msgbox->add('订单不可评价', 203);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 204);
        }else if($order['comment_status'] != 0){
            $this->msgbox->add('订单已经评价过了', 205);
        }else{
            $comment['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $comment['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $comment['timestr'] = K::M('shop/comment')->peitime();
            $jifen = K::M('system/config')->get('jifen');
            $comment['jifen'] = intval($order['amount'] * $jifen['jifen_ratio']);
            $comment['order'] = $order;
            $this->pagedata['comment'] = $comment;
            $this->tmpl = 'waimai/order/comment.html';
        }
    }

    // 提交评价
    public function subcomment()
    {
        $this->check_login();
        if(isset($_POST['data'])){
            $data = $_POST['data'];
            // 判断订单状态
            if(!$order = K::M('order/order')->detail($data['order_id'])){
                $this->msgbox->add('订单不存在', 210)->response();
            }else if($order['from'] != 'waimai'){
                $this->msgbox->add('非法操作', 211)->response();
            }else if($order['uid'] != $this->uid){
                $this->msgbox->add('非法操作', 212)->response();
            }else if($order['order_status'] != 8){
                $this->msgbox->add('订单状态不可评价', 213)->response();
            }else if($order['comment_status'] != 0){
                $this->msgbox->add('订单已经评价过了', 214)->response();
            }else{
                // 判断配送类型
                if($order['pei_type'] == 3){
                    // 自提订单 无配送时间
                    if(!$data['score_fuwu']){
                        $this->msgbox->add('请给服务打分', 215)->response();
                    }else if(!$data['score_kouwei']){
                        $this->msgbox->add('请给商品打分', 216)->response();
                    }
//                    else if(!$data['content']){
//                        $this->msgbox->add('请写下您对商家的评价', 217)->response();
//                    }
                }else if(in_array($order['pei_type'], array(0, 1, 2))){
                    // 配送订单
                    if($order['staff_id'] == 0 && $order['pei_type'] == 0){  // 商家配送
                        if(!$data['pei_time']){
                            $this->msgbox->add('请选择送达时间', 220)->response();
                        }else if(!$data['score_fuwu']){
                            $this->msgbox->add('请给服务打分', 221)->response();
                        }else if(!$data['score_kouwei']){
                            $this->msgbox->add('请给商品打分', 223)->response();
                        }
//                        else if(!$data['content']){
//                            $this->msgbox->add('请写下您对商家的评价', 204)->response();
//                        }
                    }else{
                        if(!$data['staff_score'] && $order['staff_id'] > 0){   //配送员配送
                            $this->msgbox->add('请为配送打分', 218)->response();
                        }else if(!$data['staff_content'] && $order['staff_id'] > 0){
                            $this->msgbox->add('请写下您对骑手的评价', 219)->response();
                        }else if(!$data['pei_time']){
                            $this->msgbox->add('请选择送达时间', 220)->response();
                        }else if(!$data['score_fuwu']){
                            $this->msgbox->add('请给服务打分', 221)->response();
                        }else if(!$data['score_kouwei']){
                            $this->msgbox->add('请给商品打分', 223)->response();
                        }
//                        else if(!$data['content']){
//                            $this->msgbox->add('请写下您对商家的评价', 204)->response();
//                        }
                    }
                }
                $data_staff = $data_shop = array();
                $order_id = $data['order_id'];
                $data_staff['staff_id'] = $order['staff_id'];
                $data_staff['uid'] = $data_shop['uid'] = $this->uid;
                $data_staff['order_id'] = $data_shop['order_id'] = $order_id;
                $data_staff['content'] = $data['staff_content'];
                $data_staff['mark'] = $data['staff_mark'];
                $data_shop['shop_id'] = $order['shop_id'];
                $data_shop['score_fuwu'] = $data['score_fuwu'];
                $data_shop['score_kouwei'] = $data['score_kouwei'];
                $data_shop['pei_time'] = $data['pei_time'];
                $data_shop['content'] = $data['content'];
                $data_shop['mark'] = $data['mark'];
                $comment_id1 = K::M('shop/comment')->create($data_shop);
                $comment_id2 = K::M('staff/comment')->create($data_staff);
                if($comment_id1 && $comment_id2){
                    if($_FILES['data']){
                        foreach($_FILES['data'] as $k => $v){
                            foreach($v as $kk => $vv){
                                $attachs[$kk][$k] = $vv;
                            }
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k => $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'comment')){
                                K::M('shop/photo')->create(array('comment_id' => $comment_id1, 'photo' => $a['photo']));
                            }
                        }
                    }
                    // 更新商家订单量、订单状态、用户获得积分
                    $shop = K::M('shop/shop')->detail($order['shop_id']);
                    $is_up_succ = K::M('order/order')->update($order_id, array('comment_status' => 1));


                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int) ($order['amount'] * $jifen['jifen_ratio']);
                    K::M('member/member')->update_jifen($this->uid, $jifen_total, '订单' . $order_id . '评价完成，获得积分');
                    K::M('shop/msg')->create(array('shop_id' => $order['shop_id'], 'title' => '订单已评价', 'content' => '用户(' . $order['contact'] . ')已评价订单(ID:' . $order_id . ')', 'is_read' => 0, 'type' => 2, 'order_id' => $order_id));

                    // 计算商家平均等待时间
                    $order_items = K::M('shop/comment')->items(array('shop_id' => $order['shop_id']), array(), 0, 9999999, $count);
                    foreach($order_items as $key => $val){
                        $pei_times += $val['pei_time'];
                    }
                    $pei_times = intval($pei_times / $count);


                    //计算平均分
                    $filter = array();
                    $filter['shop_id'] = $order['shop_id'];
                    $count_comment = K::M('shop/comment')->count($filter);
                    $comment_list = K::M('shop/comment')->items($filter);
                    $score_fuwu = 0;
                    $score_kouwei = 0;
                    $haoping_count = 0;
                    foreach ($comment_list as $k => $v){
                        if( ($v['score_fuwu']+$v['score_kouwei'])/2 >3 ){
                            $haoping_count++;
                        }
                        $score_fuwu += $v['score_fuwu'];
                        $score_kouwei += $v['score_kouwei'];
                    }
                    $avg_fuwu = round($score_fuwu/$count_comment);
                    $avg_kouwei = round($score_kouwei/$count_comment);
                    //平均分 结束

                    if($data_shop['score_fuwu'] > 3 && $data_shop['score_kouwei'] > 3){
                        $update_data = array('comments' => $count_comment, 'praise_num' => $haoping_count,
                            'score_fuwu' => $score_fuwu, 'score_kouwei' => $score_kouwei, 'pei_time' => $pei_times);
                    }else{
                        $update_data = array('comments' => $count_comment,
                            'score_fuwu' => $score_fuwu, 'score_kouwei' => $score_kouwei, 'pei_time' => $pei_times);
                    }
                    if($order['from'] == 'waimai'){
                        K::M('shop/shop')->update($order['shop_id'], $update_data, true);
                    }
                    $this->msgbox->add('评价成功');
                    $this->msgbox->set_data('forward', $this->mklink('waimai/order:detail', array($order_id)));
                }else{
                    $this->msgbox->add('评价失败');
                    $this->msgbox->set_data('forward', $this->mklink('waimai/order:comment', array($order_id)));
                }
            }
        }
    }

    // 查看评价
    public function lookcomment($order_id)
    {
        $this->check_login();
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 201);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 203);
        }else if($order['comment_status'] != 1){
            $this->msgbox->add('订单还未评价', 204);
        }else{
            if($shop_comment = K::M('shop/comment')->find(array('shop_id' => $order['shop_id'], 'uid' => $this->uid, 'order_id' => $order['order_id']))){
                $pei_time = $shop_comment['pei_time'];
                if($pei_time < 60){
                    $song_time = $pei_time . '分钟';
                }else if($pei_time == 60){
                    $song_time = '1小时';
                }else if($pei_time > 60 && $pei_time < 120){
                    $song_time = $pei_time . '分钟';
                }else if($pei_time == 120){
                    $song_time = '2小时';
                }else if($pei_time > 120 && $pei_time < 180){
                    $song_time = $pei_time . '分钟';
                }else if($pei_time == 180){
                    $song_time = '3小时';
                }else{
                    $song_time = '3小时以上';
                }
                $shop_comment['song_time'] = $song_time;
                $shop_comment['marklist'] = explode(',', $shop_comment['mark']);
                $shop_comment['photos'] = K::M('shop/photo')->items(array('comment_id' => $shop_comment['comment_id'], 'order_id' => $order['order_id']));
                $this->pagedata['shop_comment'] = $shop_comment;
            }
            if($staff_comment = K::M('staff/comment')->find(array('staff_id' => $order['staff_id'], 'uid' => $this->uid, 'order_id' => $order['order_id']))){
                $staff_comment['marklist'] = explode(',', $staff_comment['mark']);
                $this->pagedata['staff_comment'] = $staff_comment;
            }

            $this->pagedata['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $this->pagedata['order'] = $order;
            $this->tmpl = 'waimai/order/mycomment.html';
        }
    }

    // 再来一单
    public function onemore()
    {
        $this->check_login();
        $cart = array();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else{
            if($order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
                foreach($order_product as $key => $val){
                    $pk = $val['product_id'] . '-' . $val['spec_id'];
                    $product_ids[$val['product_id']] = $val['product_id'];
                    $spec_ids[$val['spec_id']] = $val['spec_id'];
                    $product_numbers[$pk] = $val['product_number'];
                    $cart_product_list[$pk] = array('product_id' => $val['product_id'], 'number' => $val['product_number'], 'spec_id' => $val['spec_id']);
                }
                $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($cart_product_list as $pk => $v){
                    if(!$p = $product_list[$v['product_id']]){
                        
                    }else if($p['is_spec']){
                        // 带规格
                        $sp = $spec_lists[$v['spec_id']];
                        $order_product_list[$pk] = array(
                            'product_id' => $v['product_id'],
                            'title' => $p['title'],
                            'spec_name' => $sp['spec_name'],
                            'price' => $sp['price'],
                            'package' => $p['package_price'],
                            'sale_type' => $p['sale_type'],
                            'sale_sku' => $sp['sale_sku'],
                            'product_number' => $product_numbers[$pk]
                        );
                    }else{
                        // 不带规格
                        $order_product_list[$pk] = array(
                            'product_id' => $v['product_id'],
                            'title' => $p['title'],
                            'spec_name' => '',
                            'price' => $p['price'],
                            'package' => $p['package_price'],
                            'sale_type' => $p['sale_type'],
                            'sale_sku' => $p['sale_sku'],
                            'product_number' => $product_numbers[$pk]
                        );
                    }
                }
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('shop_id', $order['shop_id']);
            $this->msgbox->set_data('product_list', $order_product_list);
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

    // 骑手地图
    public function ridermap($order_id)
    {
        $this->check_login();
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 201);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作', 203);
        }else{
            $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $this->pagedata['order'] = $order;
            $this->tmpl = 'waimai/order/ridermap.html';
        }
    }

    // 实时获取骑手地理位置
    public function staffpos()
    {
        $staff_id = (int) $this->GP('staff_id');
        $staff = K::M('staff/staff')->detail($staff_id);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('lng' => $staff['lng'], 'lat' => $staff['lat']));
    }

    // 订单投诉
    public function complaint($order_id)
    {
        $this->check_login();
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 201);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂不可投诉', 203);
        }else if(K::M('order/complaint')->find(array('order_id' => $order_id, 'uid' => $this->uid))){
            $this->msgbox->add('该订单已经投诉过了', 204);
        }else{
            $remarks = K::M('order/order')->get_complaint();
            $order['remarks'] = $remarks['shop'];
            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $this->pagedata['order'] = $order;
            $this->tmpl = 'waimai/order/complaint.html';
        }
    }

    // 订单投诉提交
    public function subcomplaint()
    {
        $this->check_login();
        if(!$data['order_id'] = $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 201);
        }else if(!$order = K::M('order/order')->detail($data['order_id'])){
            $this->msgbox->add('订单不存在', 201);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂不可投诉', 203);
        }else if(!$data['title'] = $this->GP('title')){
            $this->msgbox->add('请选择投诉理由', 204);
        }else if(!$data['content'] = $this->GP('content')){
            $this->msgbox->add('请填写描述详情', 205);
        }else if(K::M('order/complaint')->find(array('order_id' => $data['order_id'], 'uid' => $this->uid))){
            $this->msgbox->add('该订单已经投诉过了', 206);
        }else{
            $data['uid'] = $this->uid;
            $data['shop_id'] = $order['shop_id'];
            $data['staff_id'] = $order['staff_id'];
            $m = K::M('member/member')->detail($order['uid']);
            if(K::M('order/complaint')->create($data)){
                $msg['shop_id'] = $order['shop_id'];
                $msg['title'] = '用户(' . $m['nickname'] . ')投诉了订单(ID:' . $order['order_id'] . ')';
                $msg['content'] = $data['content'];
                $msg['is_read'] = 0;
                $msg['type'] = 3;
                $msg['order_id'] = $order['order_id'];
                K::M('shop/msg')->create($msg);
                $this->msgbox->add('投诉成功');
            }else{
                $this->msgbox->add('投诉失败', 207);
            }
        }
    }

    public function locate($shop_id)
    {
        $shop_id = (int) $shop_id;
        if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 210);
        }else if($shop['audit'] != 1 || $shop['closed'] != 0){
            $this->msgbox->add('商家未审核或已被删除', 211);
        }else if($shop['pintuan'] != 1){
            $this->msgbox->add('商家未开通拼团功能', 212);
        }else{
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'waimai/order/locate.html';
        }
    }

    public function waitcomment()
    {
        $reason = K::M('order/order')->get_reason();
        $this->pagedata['reason'] = $reason['waimai'];
        $this->pagedata['comment_mark'] = 'mark';
        $this->tmpl = 'waimai/order/waitcomment.html';
    }
}
