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
class Ctl_Waimai_Order extends Ctl
{
    // 确认订单
    public function order($shop_id)
    {
        $this->check_login();
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('商家不能为空',221)->response();
        }else if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商家不存在',222)->response();
        }else {
            // 判断是否打样
            $cur_time = (float)date("H.i", __TIME);
            $yy_stime = (float)str_replace(':', '.', $detail['yy_stime']);
            $yy_ltime = (float)str_replace(':', '.', $detail['yy_ltime']);
        
            if($detail['yy_status'] == 0 || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                $this->msgbox->add('商家已经打烊不可下单',223)->response();
            }

            // 获取用户购物车信息判断是否点餐
            $cart = $this->getmarketcart($shop_id);
            if(empty($cart[$shop_id])){
                $this->msgbox->add('你还没有点餐呢',223)->response();
            }

            $product_number = $package_price = $product_price = 0;
            $products = "";
            
            foreach($cart as $k=>$v){
                if($k != $shop_id){
                    $this->msgbox->add('商品不是同一家商家的',202)->response();
                }else{
                    foreach($v as $kk=>$vv) {
                        $pk = $vv['product_id'].'-'.$vv['spec_id'];
                        $product_ids[$vv['product_id']] = $vv['product_id'];
                        $spec_ids[$vv['spec_id']] = $vv['spec_id'];
                        $product_numbers[$pk] = $vv['number'];
                        $cart_product_list[$pk] = array('product_id'=>$vv['product_id'], 'number'=>$vv['number'], 'spec_id'=>$vv['spec_id']);
                    }
                }
            }

            $product_list = K::M('waimai/product')->items_by_ids($product_ids);
            $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

            foreach($cart_product_list as $pk=>$v){
                if(!$p = $product_list[$v['product_id']]){
                    //购物车的商品实际不存在
                }else if($p['is_spec']){
                    $sp = $spec_lists[$v['spec_id']];
                    if(!$v['spec_id'] && $sp){
                        //商品未选规格sku
                        $this->msgbox->add('商品未选规格sku',231)->response();
                    }else if($sp['product_id'] != $v['product_id']){
                        //选择规格与商品ID关联不符
                        $this->msgbox->add('选择规格与商品ID关联不符',232)->response();
                    }else if($p['sale_type'] == 1 && ($sp['sale_sku'] < $product_numbers[$pk])){
                        $this->msgbox->add('商品库存不足',233)->response();
                    }else{
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['spec_name'] = $sp['spec_name'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $sp['price'];
                        $product_price += $sp['price']  * $product_numbers[$pk];       //商品总价
                        $package_price += $sp['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $sp['product_id'].":".$product_numbers[$pk];
                        $products .= ":".$sp['spec_id'].',';
                    }
                }else{
                    // 无规格商品
                    if($p['sale_type'] == 1 && ($p['sale_sku'] < $product_numbers[$pk])){
                        $this->msgbox->add('商品库存不足',211)->response();
                    }else{
                        $product_lists[$pk]['title'] = $p['title'];
                        $product_lists[$pk]['num'] = $product_numbers[$pk];
                        $product_lists[$pk]['price'] = $p['price'];
                        $product_price += $p['price']  * $product_numbers[$pk];       //商品总价
                        $package_price += $p['package_price'] * $product_numbers[$pk]; //总打包费
                        $products .= $v['product_id'].":".$product_numbers[$pk];
                        $products .= ':0,';
                    }
                }
            }
            //echo '<pre>';print_r(array_values($product_lists));die;
            $products = rtrim($products,',');
            
            // 购物车商品列表
            $this->pagedata['products'] = $products;
            if($product_price < $detail['min_amount']){
               $this->msgbox->add('没有达到配送要求',212)->response();
            }
            $first_youhui = $youhui_amount = $hongbao_amount = 0;
            // 首单优惠
            if($detail['first_youhui'] && !K::M('order/order')->count(array('uid'=>$this->uid, 'shop_id'=>$shop_id, 'from'=>'waimai', 'order_status'=>'>=:0'))){
                $first_youhui = $detail['first_amount']; // 第一单享受首单优惠
            }else{
                $first_youhui = 0; // 不是第一单不享受首单优惠
            }

            $first_price = $yh_price = $product_price - $first_youhui;

            // 满减优惠 首单金额(商品价格-首单立减优惠)<=满减金额 取最近的一条
            if($youhui = K::M('waimai/youhui')->order_youhui($shop_id, $product_price - $first_youhui)){
                $youhui_amount = $youhui['youhui_amount'];
                $yh_price = $first_price - $youhui['youhui_amount'];  // 商品价格-首单优惠-满减优惠
            }

            // 红包优惠
            if($hongbao = K::M('hongbao/hongbao')->get_hongbao($this->uid, $product_price - $first_youhui - $youhui_amount)){
                $hongbao_amount = $hongbao['amount'];
                $hongbao_price = $yh_price - $hongbao['amount'];
            }else{
                $hongbao_price = $yh_price;
            }

            // 结算价格
            $total_price = $hongbao_price + $package_price ; // 结算价格=商品价格-首单优惠-满减优惠-红包优惠-余额抵扣+打包费+运费(另算)

            // 总优惠
            $total_youhui = $first_youhui + $youhui['youhui_amount'] + $hongbao['amount']; //总优惠= 首单优惠+满减优惠+红包优惠

            // 送达时间选择列表
            $res = K::M('order/order')->get_time();
            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'].":".$res['start_quarter']*15;
            $rr = explode(':',$detail['yy_ltime']);
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1]/15;
            $ltime = $res['start'].":".$res['start_quarter']*15;

            if($stime > $detail['yy_ltime']){
               $set_time = array();
            }
            $this->pagedata['set_time'] = $set_time;

            if($addr_id = (int)$this->GP('addr_id')){
                if($addr = K::M('member/addr')->detail($addr_id)){
                    if($addr['uid'] != $this->uid){
                        $addr = array();
                    }else{
                        $addr['juli'] = K::M('helper/round')->juli($detail['lng'], $detail['lat'], $addr['lng'], $addr['lat']);
                    }
                }
            }

            if(empty($addr)){
                if($addr_list = K::M('member/addr')->items(array('uid'=>$this->uid), null, 1, 10)){
                    $pei_distance = $detail['pei_distance'] ? $detail['pei_distance'] : 5;
                    $_a = array();
                    foreach($addr_list as $k=>$v){
                        $v['juli'] = K::M('helper/round')->juli($detail['lng'], $detail['lat'], $v['lng'], $v['lat']);
                        if($v['juli'] <= $pei_distance*1000){
                            if(empty($addr) || ($addr['juli'] > $v['juli'])){
                                $addr = $v;
                                $addr_id = $v['addr_id'];
                            }
                        }
                        $addr_list[$k] = $v;
                    }
                }
            }            
            if($addr){
                //计算出对应的配送费
                $juli = ceil($addr['juli']/1000);
                $_freight = array();
                $_max_freight = array('fkm'=>0, 'fm'=>0);
                foreach($detail['freight_stage'] as $k=>$v){
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
                $freight_stage = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                //计算出对应的配送费结束
            }else{
                $addr = array('addr_id'=>0, 'uid'=>'', 'contact'=>'', 'mobile'=>'', 'addr'=>'','house'=>'', 'is_default'=>'0', 'lat'=>'0', 'lng'=>'');
                $freight_stage = 0;
            }

            // 收货地址
            if(!$m_addr = K::M('member/addr')->find(array('uid'=>$this->uid,'is_default'=>1))){
                $m_addr = K::M('member/addr')->find(array('uid'=>$this->uid));
            }
            if($member = K::M('member/member')->detail($this->uid)) {
                $this->pagedata['mymoney'] = $member['money'];
            }
        }
        $this->pagedata['total'] = $total_price + $total_youhui;  // 货到付款方式不享受所有优惠
        $this->pagedata['total_price'] = $total_price;  // 结算价格
        $this->pagedata['total_youhui'] = $total_youhui;
        $this->pagedata['hongbao'] = $hongbao;
        $this->pagedata['product_price'] = $product_price;
        $this->pagedata['youhui'] = $youhui;
        $this->pagedata['yh_price'] = $yh_price;
        $this->pagedata['first_youhui'] = $first_youhui;
        $this->pagedata['package_price'] = $package_price;
        $this->pagedata['freight_stage'] = $freight_stage;
        $this->pagedata['product_list'] = array_values($product_lists);
        $this->pagedata['detail'] = $detail;
        $this->pagedata['maddr'] = $m_addr;
        $this->tmpl = 'waimai/order/order.html';

    }

    
    /*
     * @param shop_id
     * @param addr_id
     * @param amount
     */
    public function preinfo()
    {
        $this->check_login();
        if(!$shop_id = (int)$this->GP('shop_id')){
            $this->msgbox->add(L('参数非法'), 221);
        }else if(($total_price = (float)$this->GP('total_price'))<=0){
            $this->msgbox->add(L('参数非法'), 221);
        }else if(($product_price = (float)$this->GP('product_price'))<=0){
            $this->msgbox->add(L('参数非法'), 221);
        }else if(!$shop = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'), 221);
        }else{
            $addr_id = (int)$this->GP('addr_id');
            $hongbao_id = (int)$this->GP('hongbao_id');
            $freight_stage = 0;
            $addr = $hongbao = $youhui = array();
            $first_youhui = $hongbao_amount = $delivery_amount = $youhui_amount = 0;
            if($shop['first_amount'] && !K::M('order/order')->count(array('shop'=>$shop_id, 'uid'=>$this->uid, 'from'=>'waimai', 'order_status'=>'>=:0'))){
                $first_youhui = $shop['first_amount'];
            }
            if($youhui = K::M('waimai/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                $youhui_amount = $youhui['youhui_amount'];
            }
            if(!$addr_id || !($addr = K::M('member/addr')->detail($addr_id))){
                $addr_id = 0;
            }else if($addr['uid'] != $this->uid){
                $addr = array();
                $addr_id = 0;
            }else{
                if(isset($addr) && isset($shop)){
                //计算出对应的配送费
                    if(!$shop['freight_stage']){
                        $this->msgbox->add('您的地址不在配送范围', 216);
                    }else{
                        $juli = K::M('helper/round')->juli($addr['lng'],$addr['lat'],$shop['lng'],$shop['lat']);
                        $juli = ceil($juli/1000);
                        $_freight = array();
                        $_max_freight = array('fkm'=>0, 'fm'=>0);
                        foreach($shop['freight_stage'] as $k=>$v){
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
                        $freight_stage = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
                    }
                    //计算出对应的配送费结束
                }else{
                    $this->msgbox->add('您的地址不在配送范围', 210)->response();
                }
            }
            $filter = array('uid'=>$this->uid,'order_id'=>0);
            $filter['ltime'] = '>:' . __TIME;
            $filter['min_amount'] = '<=:' .($product_price-$first_youhui-$youhui_amount);
            if(!$hongbao_id){ //查出最符合条件红包
                $meet_hongbao = K::M('hongbao/hongbao')->find($filter,array('amount'=>'desc'));
                $hongbao_amount = $meet_hongbao['amount'];
                $hongbao = $meet_hongbao;
                $hongbao_id = $meet_hongbao['hongbao_id'];
            }elseif($hongbao_id && !($hongbao = K::M('hongbao/hongbao')->detail($hongbao_id))){ //红包不存在
                $hongbao = array();
                $hongbao_id = 0;
            }else if($hongbao['uid'] != $this->uid || $hongbao['ltime'] < __TIME || $hongbao['order_id']){ //已使用,过期，不是自己的红包
                $hongbao = array();
                $hongbao_id = 0;
            }else if($hongbao['min_amount'] > ($product_price-$first_youhui-$youhui_amount)){ //未达到使用条件
                $hongbao = array();
                $hongbao_id = 0;
            }else{
                $hongbao_amount = $hongbao['amount'];
            }
            $hongbao_count = K::M('hongbao/hongbao')->count($filter);
            $total_youhui = $first_youhui - $youhui_amount - $hongbao_amount;
            $data = array('hongbao_id'=>$hongbao_id, 'hongbao'=>$hongbao, 'addr_id'=>$addr_id, 'addr'=>$addr, 'freight'=>$freight_stage, 'youhui'=>$youhui, 'first_youhui'=>$first_youhui, 'youhui_amount'=>$youhui_amount, 'hongbao_amount'=>$hongbao_amount,'hongbao_count'=>$hongbao_count);
            $this->msgbox->set_data('data', $data);
        }
    }
    
    
    // 创建订单
    public function ordercreate()
    {
        $this->check_login();
        
        if(IS_AJAX){
            if($params = $this->checksubmit('params')){
                //var_dump($params);die;
                // 验证并拆分用户要求送达时间
                $pei_time = $pei_time_start =  $pei_time_last = 0;
                if($opei_time = $params['pei_time']){
                    $pei_time = explode('-',$params['pei_time']);
                    $pei_time_start = $pei_time[0];
                    $pei_time_last = $pei_time[1];
                    $pei_time = strtotime(date('Y-m-d').' '.$pei_time_start);
                }else {
                    $p_time = $opei_time = $params['pei_time'] = date('H:i', __TIME+1800).'-'.date('H:i', __TIME+2700);
                    $pei_time = explode('-',$p_time);
                    $pei_time_start = $pei_time[0];
                    $pei_time_last = $pei_time[1];
                    $pei_time = 0;
                }
                // 订单备注
                $note = $params['intro'];

                if(!$shop_id = (int) $params['shop_id']){
                    $this->msgbox->add('商家不能为空',221);
                }else if(!$shop_detail = K::M('waimai/waimai')->detail($shop_id)){
                    $this->msgbox->add('商家不存在',222);
                }else if($shop_detail['audit']!=1||$shop_detail['closed']!=0){
                    $this->msgbox->add('商家不存在或已删除',223);
                }else{
                    $cur_time = (float)date("H.i", __TIME);
                    $yy_stime = (float)str_replace(':', '.', $shop_detail['yy_stime']);
                    $yy_ltime = (float)str_replace(':', '.', $shop_detail['yy_ltime']);
                    $pei_stime = (float)str_replace(':', '.', $opei_time);

                    if(empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                        $this->msgbox->add('商家已经打烊不可下单',224);
                    }else if($opei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                        $this->msgbox->add('配送时间不在商家营业范围',225);
                    }else if(!$products = $params['products']){
                        $this->msgbox->add('您还没有订餐呢',226);
                    }else if($params['pei_type'] == 3 && !$shop_detail['is_ziti']){
                        $this->msgbox->add('该商户不支持自提',226);
                    }else if($params['online_pay'] && !$shop_detail['online_pay']){
                        $this->msgbox->add('该商户不支持在线支付',226);
                    }else if(!$params['online_pay'] && !$shop_detail['is_daofu']){
                        $this->msgbox->add('该商户不支持货到付款',226);
                    }else if($params['pei_type'] != 3 && !($addr_id = (int)$params['addr_id'])){
                        $this->msgbox->add('请选择地址',227);
                    }else if($params['pei_type'] != 3 && !($addr_detail = K::M('member/addr')->detail($addr_id))){
                        $this->msgbox->add('地址不存在',228);
                    }else if($params['pei_type'] != 3 && K::M('helper/round')->juli($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat']) > ($shop_detail['pei_distance']*1000)){
                       $this->msgbox->add('超出配送范围',229);
                    }else{
                        $data_order = $data_waimai = array();
                        // 验证订单商品信息
                        $products = explode(',',$products);
                        $product_ids = $spec_ids = $product_numbers = $product_specids = $order_product_list = array();
                        foreach ($products as $key => $val) {
                            if(preg_match('/^(\d+):(\d+):(\d+)$/', $val, $local)){
                                $pk = $local[1].'-'.$local[3];
                                $product_ids[$local[1]] = $local[1];
                                $spec_ids[$local[3]] = $local[3];
                                $product_numbers[$pk] = $local[2];
                                $cart_product_list[$pk] = array('product_id'=>$local[1], 'number'=>$local[2], 'spec_id'=>$local[3]);
                            }
                        }

                        $total_price = $product_price = $package_price = $product_number = $hongbao_amount = $first_youhui = $youhui_amount = $pei_amount  = $money = $amount = 0;
                        $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                        $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                        foreach($cart_product_list as $pk=>$v){
                            if(!$p = $product_list[$v['product_id']]){
                                //购物车的商品实际不存在
                            }if($p['shop_id'] != $shop_detail['shop_id']){
                                $this->msgbox->add('商品不是同一家商家的',230)->response();
                            }else if($p['is_spec']){
                                $sp = $spec_lists[$v['spec_id']];
                                $product_name = $p['title']."({$sp['spec_name']})";
                                if(!$v['spec_id'] && $sp){
                                    //商品未选规格sku
                                    $this->msgbox->add('商品未选规格',231)->response();
                                }else if($sp['product_id'] != $v['product_id']){
                                    //选择规格与商品ID关联不符
                                    $this->msgbox->add('选择规格与商品ID关联不符',232)->response();
                                }else if($p['sale_type'] == 1 && ($sp['sale_sku'] < $product_numbers[$pk])){
                                    $this->msgbox->add('商品【'.$product_name.'】库存不足',233)->response();
                                }else{
                                    $_pamount = ($sp['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id'      => $v['product_id'],
                                        'spec_id'         => $v['spec_id'],
                                        'sale_type'       => $p['sale_type'],
                                        'product_number'  => $product_numbers[$pk],
                                        'product_name'    => $product_name,
                                        'product_price'   => $sp['price'],
                                        'package_price'   => $p['package_price'],
                                        'amount'          => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price +=$sp['price'] * $product_numbers[$pk];
                                    $package_price +=$p['package_price'] * $product_numbers[$pk];
                                }
                            }else{
                                $product_name = $p['title']."({$sp['spec_name']})";
                                if($p['sale_type'] == 1 && ($p['sale_sku'] < $product_numbers[$pk])){
                                    $this->msgbox->add('商品【'.$product_name.'】库存不足',211)->response();
                                }else{
                                    $_pamount = ($p['price'] + $p['package_price']) * $product_numbers[$pk];
                                    $order_product_list[$pk] = array(
                                        'product_id'       => $v['product_id'],
                                        'spec_id'          => 0,
                                        'sale_type'        => $p['sale_type'],
                                        'product_number'   => $product_numbers[$pk],
                                        'product_name'     => $p['title'],
                                        'product_price'    => $p['price'],
                                        'package_price'    => $p['package_price'],
                                        'amount'           => $_pamount
                                    );
                                    $product_number += $product_numbers[$pk];
                                    $product_price +=$p['price'] * $product_numbers[$pk];
                                    $package_price +=$p['package_price'] * $product_numbers[$pk];

                                }
                            }
                        }
                
                        if($product_price < $shop_detail['min_amount']){
                           $this->msgbox->add('没有达到配送要求',212)->response();
                        }
                        $total_price = $product_price + $package_price + $freight;
                        $data_order = array(
                            'city_id'            => $shop_detail['city_id'],
                            'shop_id'            => $shop_id,
                            'staff_id'           => 0,
                            'uid'                => $this->uid,
                            'from'               => 'waimai',
                            'order_status'       => 0,
                            'total_price'        =>  $total_price,  
                            'product_number'     => $product_number,
                            'product_price'      => $product_price,
                            'package_price'      => $package_price,
                            'o_lat'              => $shop_detail['lat'],
                            'o_lng'              => $shop_detail['lng'],
                            'intro'               => $params['intro'],
                            'pay_status'         => 0,
                            'pei_time'           => $pei_time,
                            'order_from'         => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                        );
                        if($params['pei_type'] == 3){
                            $data_order['amount'] = $product_price+$package_price;
                            $data_order['freight'] = 0;
                            $data_order['contact'] = $this->MEMBER['nickname'];
                            $data_order['mobile'] = $this->MEMBER['mobile'];
                            $data_order['pei_type'] = 3;
                            $data_order['pei_amount'] = 0;
                            $data_order['total_price'] = $product_price+$package_price;
                        }else{
                            $juli = K::M('helper/round')->juli($shop_detail['lng'], $shop_detail['lat'], $addr_detail['lng'], $addr_detail['lat']);
                            $juli = ceil($juli/1000);
                            $_freight = array();
                            $_max_freight = array('fkm'=>0, 'fm'=>0,'sm'=>0);
                            foreach($shop_detail['freight_stage'] as $k=>$v){
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
                            $data_order['amount'] = $product_price+$package_price + $freight;
                            $data_order['freight'] = $freight;
                            $data_order['contact'] = $addr_detail['contact'];
                            $data_order['mobile'] = $addr_detail['mobile'];
                            $data_order['addr'] = $addr_detail['addr'];
                            $data_order['house'] = $addr_detail['house'];
                            $data_order['lng'] = $addr_detail['lng'];
                            $data_order['lat'] = $addr_detail['lat'];
                            $data_order['pei_type'] = $shop_detail['pei_type'];
                            $data_order['pei_amount'] = $p_amount;
                            $data_order['total_price'] = $product_price+$package_price+$freight;
                        }

                        
                        if($params['online_pay'] == 1){
                            // 在线支付方式支付
                            $data_order['online_pay'] = 1;
                            if($shop_detail['first_amount'] && !K::M('order/order')->count(array('shop'=>$shop_id, 'uid'=>$this->uid, 'from'=>'waimai', 'order_status'=>'>=:0'))){
                                $data_order['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                            }
                            if($youhui_detail = K::M('waimai/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                                $data_order['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                            }

                            if($hongbao_id = (int)$params['hongbao_id']){
                                if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                                    $this->msgbox->add('红包不存在',203)->response();
                                }else if($hongbao_detail['uid'] != $this->uid){
                                    $this->msgbox->add('红包信息不正确',204)->response();
                                }else if($hongbao_detail['order_id']){
                                    $this->msgbox->add('该红包已经使用',205)->response();
                                }else if($hongbao_detail['ltime'] < __TIME){
                                    $this->msgbox->add('红包已过期不能使用',244)->response();
                                }else if($hongbao_detail['min_amount'] > ($product_price-$first_youhui-$youhui_amount)){
                                    $this->msgbox->add('该红包不能使用',205)->response();
                                }else{
                                    $data_order['hongbao_id'] = $hongbao_id;
                                    $data_order['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                                }
                            }
                            $amount = $product_price - $youhui_amount - $first_youhui - $hongbao_amount;
                            if($amount < 0){
                                $amount = 0;
                            }
                            $amount = $amount + $package_price + $freight;
                            $data_order['amount'] = $amount;
                        }else{
                            $data_order['online_pay'] = 0;
                        }

                        if(!$params['online_pay']) {
                            $params['online_pay'] = 0;
                        }
                        $data_order['wx_openid'] = $this->MEMBER['wx_openid'];
                        // 创建主订单记录
                        if($order_id = K::M('order/order')->create($data_order)) {
                            $data_waimai = array(
                                'order_id'         => $order_id,
                                'product_number'   => $product_number,
                                'product_price'    => $product_price,
                                'package_price'    => $package_price,
                                'freight'          => $freight,
                                );
                            // 创建附属表订单记录
                            // 如果选择了到付
                            $order = K::M('order/order')->detail($order_id);
                            $waimai_order_id = K::M('waimai/order')->create($data_waimai);

                            if($params['online_pay']==0 && $order['pei_type']==3) { 
                                //如果是自提单且选择了到付，直接生成消费码
                                K::M('waimai/order')->create_number($order_id);
                            }else if($order['online_pay']==1 && $order['pay_status']==0 && $order['pei_type']==3) { 
                                //如果自提单选择了在线支付且未支付，支付成功之后生成消费码
                                K::M('waimai/order')->update($order_id, array('spend_number'=>0,'spend_status'=>0));
                            }

                            //写入waimai_order_product表
                            foreach ($order_product_list as $k=>$val){
                                $val['order_id'] = $order_id;
                                K::M('waimai/orderproduct')->create($val);
                                // 更新外卖商品库、销量
                               $_num = $val['product_number'];
                                if($val['spec_id']){
                                    $up_sale_count = array('sale_sku'=>'`sale_sku`-'.$_num, 'sale_count'=>'`sale_count`+'.$_num);
                                    K::M('waimai/productspec')->update($val['spec_id'], $up_sale_count, true);
                                }else{
                                    $up_sale_count = array('sales'=>'`sales`+'.$_num,'sale_sku'=>'`sale_sku`-'.$_num, 'sale_count'=>'`sale_count`+'.$_num);
                                    K::M('waimai/product')->update($val['product_id'], $up_sale_count, true);
                                }
                                // K::M('waimai/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                                // if($val['sale_type'] ==1){
                                //     if($val['spec_id']){
                                //         K::M('waimai/productspec')->update_count($val['spec_id'],'sale_count', $val['product_number']);
                                //         K::M('waimai/productspec')->update_count($val['spec_id'],'sale_sku', -$val['product_number']);
                                //     }else{
                                //         K::M('waimai/product')->update_count($val['product_id'],'sale_count', $val['product_number']);
                                //         K::M('waimai/product')->update_count($val['product_id'],'sale_sku', -$val['product_number']);
                                //     }
                                // }
                            }

                            if($youhui_detail){
                                K::M('waimai/youhui')->update_count($youhui_detail['youhui_id'],'use_count',1);
                            }

                            if($hongbao_detail){
                                K::M('hongbao/hongbao')->update($hongbao_id, array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                            }
                            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                            K::M('shop/msg')->create(array('shop_id'=>$shop_id,'title'=>'订单已提交','content'=>'订单已提交','is_read'=>0,'type'=>1,'order_id'=>$order_id));
                            /*$title = "订单创建成功";
                            $content = "恭喜您下单成功(".$order_id.")";
                            K::M('order/order')->send_member($title, $content, $order);*/
                            K::M('waimai/waimai')->update_count($shop_id, 'orders', 1);
                            K::M('member/member')->update_count($this->uid, 'orders', 1);
                            $this->msgbox->add('订单提交成功');
                            $this->msgbox->set_data('order_id',$order_id);
                            $this->msgbox->set_data('pay_status',$data_order['pay_status']);
                            $this->msgbox->set_data('online_pay',$params['online_pay']);
                            //print_r($this->system->db->SQLLOG());die;
                        }
                    }
                }
            }
        }
    }

    /**
     * market_确认订单-添加备注
     */
    public function remark($shop_id)
    {
        $notes = K::M('order/order')->get_note();
        $this->pagedata['notes'] = $notes;
        $this->pagedata['shop_id'] = (int)$shop_id;
        $this->tmpl = 'waimai/order/remark.html';
    }

    // 获取用户购物车信息
    public function getmarketcart($shop_id)
    {
        $cart = json_decode(urldecode($_COOKIE['KT-ECart']), true);
        //$cart_shop_id = array_keys($cart);
        //if($shop_id != $cart_shop_id[0]) {
        //    $this->msgbox->add('非法操作',211);
        //}else {
            $cart_goods = explode(',',$cart[$shop_id]);
            foreach ($cart_goods as $key => $val) {
                if(preg_match('/^(\d+)-(\d+):(\d+)$/', $val, $local)){
                    $pk = $local[1].'-'.$local[2];
                    $cart_product_list[$pk] = array(
                        'product_id'=>$local[1], 
                        'number'=>$local[3], 
                        'spec_id'=>$local[2],
                        );
                }
            }
            $items[$shop_id] = $cart_product_list;
            return $items;
        //}   
    }
 
    // 再来一单
    public function onemore()
    {
        $this->check_login();
        $cart = array();
        $order_id = $this->GP('order_id');
        if(!$order_id) {
            $this->msgbox->add('订单不存在',211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在',212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('非法操作',213);
        }else { 
            if($order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id))) {
                foreach($order_product as $key=>$val) {
                    $pk = $val['product_id'].'-'.$val['spec_id'];
                    $product_ids[$val['product_id']] = $val['product_id'];
                    $spec_ids[$val['spec_id']] = $val['spec_id'];
                    $product_numbers[$pk] = $val['product_number'];
                    $cart_product_list[$pk] = array('product_id'=>$val['product_id'], 'number'=>$val['product_number'], 'spec_id'=>$val['spec_id']);
                }
                $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($cart_product_list as $pk=>$v){
                    if(!$p = $product_list[$v['product_id']]){
                        
                    }else if($p['is_spec']){
                        // 带规格
                        $sp = $spec_lists[$v['spec_id']];
                        $order_product_list[$pk] = array(
                            'product_id'      => $v['product_id'],
                            'title'           => $p['title'],
                            'spec_name'       => $sp['spec_name'],
                            'price'           => $sp['price'],
                            'package'         => $p['package_price'],
                            'sale_type'       => $p['sale_type'],
                            'sale_sku'        => $sp['sale_sku'],
                            'product_number'  => $product_numbers[$pk]
                        );
                    }else{
                        // 不带规格
                        $order_product_list[$pk] = array(
                            'product_id'      => $v['product_id'],
                            'title'           => $p['title'],
                            'spec_name'       => '',
                            'price'           => $p['price'],
                            'package'         => $p['package_price'],
                            'sale_type'       => $p['sale_type'],
                            'sale_sku'        => $p['sale_sku'],
                            'product_number'  => $product_numbers[$pk]
                        );
                    }
                }   
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('product_list', $order_product_list);
        }
    }

    // 用户确认送达
    public function finish($order_id)
    {
        $this->check_login();
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add('订单不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在',211);
        }else if(!in_array($order['order_status'], array(3,4))) {
            $this->msgbox->add('订单不可确认送达',212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('非法操作',213);
        }else if(K::M('order/order')->confirm($order_id,$order,'member')){
            K::M('order/order')->send_member('订单已完成','您的订单于 '.date('Y-m-d H:i:s',__TIME).' 已完成',$order);
            $this->msgbox->add('订单确认成功');
        }else{
            $this->msgbox->add('订单确认失败',214);
        } 
    }

    // 根据用户收货地址与商家的距离计算出配送费
    public function getfreight()
    {
        $this->check_login();
        if($addr_id = (int)$this->GP('addr_id')) {
            $addr = K::M('member/addr')->detail($addr_id);
        }
        if($shop_id = (int)$this->GP('shop_id')) {
            $shop = K::M('waimai/waimai')->detail($shop_id);
        }

        if(isset($addr) && isset($shop)){
            //计算出对应的配送费
            $juli = K::M('helper/round')->juli($addr['lng'],$addr['lat'],$shop['lng'],$shop['lat']);
            $juli = ceil($juli/1000);
            $_freight = array();
            $_max_freight = array('fkm'=>0, 'fm'=>0);
            foreach($shop['freight_stage'] as $k=>$v){
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
        $this->msgbox->set_data('freight', $data['freight_stage']);
    }

    public function timeZiti() 
    {
        $time = date('H:i', __TIME+1800);
        $this->msgbox->set_data('time',$time);
    }
}
