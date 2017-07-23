<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Product extends Ctl
{

    public function index(){
        if($cate_id = (int)$this->GP('cate_id')){
            $pager['cate_id'] = $cate_id;
        }
        if($title = $this->GP('title')){
            $pager['title'] = $title;
        }
        if($order = $this->GP('order')){
            $pager['order'] = $order;
        }
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->FENXIAO['shop_id']));
        $this->tmpl = 'fenxiao/product/index.html';
    }


    public function loaditems($page=1)
    {
        $filter = array('shop_id'=>$this->FENXIAO['shop_id'],'is_onsale'=>1,'closed'=>0,'type'=>'default','is_fenxiao'=>1);
        //print_r($filter);die;
        if($title = strip_tags(trim($this->GP('title')))){
            $filter['title'] = "LIKE:%".$title."%";
        }
        if($cate_id = (int)$this->GP('cate_id')){
            $res = K::M('weidian/productcate')->getChildren($cate_id);
            $filter['cate_id'] = $res;
        }
        $page = max((int)$page, 1);
        $limit = 10;
        $orderby = array();
        if($order = $this->GP('order')){
            switch($order){
                case 'sales':
                $orderby['sales'] = 'desc';break;
                case 'new':
                $orderby['product_id'] = 'desc';break;
                case 'price_a':
                $orderby['wei_price'] = 'asc';break;
                case 'price_b':
                $orderby['wei_price'] = 'desc';break;
                default:
                $orderby = array('sales'=>'desc','wei_price'=>'asc');    
            }
        }
        if(!$items = K::M('weidian/product')->items($filter,$orderby,$page, $limit, $count)){
            $items = array();
        }
        //print_r($this->system->db->SQLLOG());die;
        $count_num = K::M('weidian/product')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'fenxiao/product/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }


    /**
    * 普通商品详情
    */
    public function detail($product_id){
        
        if(!(int)$product_id || !$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('产品不存在!',211);
        }else if($detail['shop_id'] != $this->FENXIAO['shop_id']){
            $this->msgbox->add('产品错误!',212);
        }else if($detail['type'] != 'default'){
            $this->msgbox->add('产品错误!',213);
        }else{
            $group_ids = array();
            $attrgroups = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id),array('attr_group_id'=>'asc')); 
            foreach($attrgroups as $k=>$v){
                $group_ids[$v['attr_group_id']] = $v['attr_group_id'];
            }
            $values = K::M('weidian/product/attrvalue')->items(array('attr_group_id'=>$group_ids),array('attr_value_id'=>'asc'));
            foreach($attrgroups as $k=>$v){
                foreach($values as $k1=>$v1){
                    if($v['attr_group_id'] == $v1['attr_group_id']){
                        $attrgroups[$k]['values'][] = $v1; 
                    }
                }
            }

            $detail['intro'] = html_entity_decode($detail['intro']);

            //商家评价
            $items = K::M('weidian/comment')->items(array('shop_id'=>$this->FENXIAO['shop_id'],'closed'=>0));
            $comment_ids = $uids = $order_ids = array();
            foreach($items as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $comment_ids[$v['comment_id']] = $v['comment_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            //$photos = K::M('weidian/commentphoto')->items(array('comment_id'=>$comment_ids));
            $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
            $this->pagedata['photos'] = K::M('weidian/commentphoto')->items(array('comment_id'=>$comment_ids));
            $this->pagedata['products'] = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
            $this->pagedata['items'] = $items;
            
            //print_r($attrgroups);die;
            $is_collect = K::M('weidian/collect')->items(array('product_id' => $product_id, 'uid' => $this->uid));
            $this->pagedata['is_collect'] = $is_collect;
            $this->pagedata['attrgroups'] = $attrgroups;
            $this->pagedata['length'] = count($attrgroups);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'fenxiao/product/detail.html';
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
    
    
    public function change_size($product_id){
        if(!(int)$product_id || !$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('产品不存在!',211);
        }else if($detail['shop_id'] != $this->FENXIAO['shop_id']){
            $this->msgbox->add('产品错误!',212);
        }else if($detail['type'] != 'default'){
            $this->msgbox->add('产品错误!',213);
        }elseif(!$stock_name = $this->GP('stock_name')){
            $this->msgbox->add('规格不存在!',214);
        }else{
            if($res = K::M('weidian/product/attrstock')->find(array('product_id'=>$product_id,'stock_name'=>$stock_name))){
                $this->msgbox->add('success');
                $this->msgbox->set_data('wei_price', $res['wei_price']);
                $this->msgbox->set_data('stock', $res['stock']);
            }else{
                $this->msgbox->add('商品不存在',215);
            }
        }
    }

    

    public function cart(){
        $products = $this->getcart($this->FENXIAO['shop_id']);
        if(!$products){
            $this->msgbox->add('您的购物车空空如也',211);
            $url = 'http://'.$this->FENXIAO['url'].'/product/index';
            $this->msgbox->set_data("forward", $url);
        }else{
            $this->pagedata['shop_id'] = $this->FENXIAO['shop_id'];
            $this->pagedata['products'] = $products;
            $this->tmpl = 'fenxiao/product/cart.html';
        }
        
    }

    public function order(){
        $this->check_login();
        $stock_names = $this->GP("stock_names");
        $this->pagedata['stock_names'] = $stock_names;
        $stock_names = explode(",", $stock_names);
        $products = $this->getcart($this->FENXIAO['shop_id'],array_values($stock_names));
        if(!$products){
            $this->msgbox->add('您的购物车空空如也',211);
            $url = 'http://'.$this->FENXIAO['url'].'/product/index';
            $this->msgbox->set_data("forward", $url);
        }else{
            $nums = $total_price = $ship_fee = 0;
            foreach($products as $k=>$v){
                if($v['ship_fee'] > $ship_fee){
                    $ship_fee = $v['ship_fee'];
                }
                $nums += $v['num'];
                $total_price += round($v['num']*$v['price'],2);
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
            
             //查询可使用的优惠券
            $coupon = K::M('member/coupon')->items(array('shop_id'=>$this->FENXIAO['shop_id'],'uid'=>$this->uid,'ltime'=>'>:'.time(),'status'=>0,'order_amount'=>'<=:'.$total_price));
            $new_coupon = array();
            foreach($coupon as $k => $v){
                $new_coupon[$v['coupon_amount']] = $v;
            }
            $new_coupon = max($new_coupon);

            $this->pagedata['coupon'] = $new_coupon;
            //print_r($this->FENXIAO);die;
            $this->pagedata['default_addr'] = $default_addr;
            $this->pagedata['products'] = $products;
            $this->pagedata['nums'] = $nums;
            $this->pagedata['total_price'] = $total_price;
            $this->pagedata['ship_fee'] = $ship_fee;
            $this->pagedata['shop_id'] = $this->FENXIAO['shop_id'];
            $this->pagedata['weidian'] = K::M('shop/shop')->detail($this->FENXIAO['shop_id']);
            $this->tmpl = 'fenxiao/product/order.html';
        }
    }

    

    public function order_create(){
        $this->check_login();
        $stock_names = $this->GP("stock_names");
        $stock_names = explode(",", $stock_names);
        $products = $this->getcart($this->FENXIAO['shop_id'],array_values($stock_names));
        
        if(!$products){
            $this->msgbox->add('您还没有购买商品',211)->response();
        }else{
            $total_price = $num = 0;
            $product_ids = array();
            foreach($products as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];  
                $total_price += round($v['num']*$v['price'],2);
                $num += $v['num'];
                if($v['stock'] < $v['num']){
                    $this->msgbox->add('商品库存不足',212)->response();
                }
            }
        }
        if($product_ids){
            $product_items = K::M('weidian/product')->items_by_ids($product_ids);
        }
        $_cfg = $this->system->config->get('fenxiao');
        $shop_ = K::M('shop/shop')->detail($this->FENXIAO['shop_id']);
        $_cfg['level'] = min($_cfg['level'],$shop_['have_fenxiao']);
        foreach($products as $k=>$v){
            foreach($product_items as $k1=>$v1){
                if($v['product_id'] == $v1['product_id']){
                    $products[$k]['is_fenxiao'] = $v1['is_fenxiao'];
                    $products[$k]['price_type'] = $v1['price_type'];
                    if($_cfg['level'] == 1){
                        $products[$k]['price_level_1'] = $v1['price_level_1'];
                    }elseif($_cfg['level'] == 2){
                        $products[$k]['price_level_1'] = $v1['price_level_1'];
                        $products[$k]['price_level_2'] = $v1['price_level_2'];
                    }elseif($_cfg['level'] == 3){
                        $products[$k]['price_level_1'] = $v1['price_level_1'];
                        $products[$k]['price_level_2'] = $v1['price_level_2'];
                        $products[$k]['price_level_3'] = $v1['price_level_3'];
                    } 
                }
            }
        }
        foreach($products as $k=>$v){
            if($v['is_fenxiao']){
                if($v['price_type'] == 1){
                    $products[$k]['price_level_1'] = round(($v['price_level_1']*$v['price'])/100,2);
                    $products[$k]['price_level_2'] = round(($v['price_level_2']*$v['price'])/100,2);
                    $products[$k]['price_level_3'] = round(($v['price_level_3']*$v['price'])/100,2);
                }
            }else{
                $products[$k]['price_level_1'] = 0;
                $products[$k]['price_level_2'] = 0;
                $products[$k]['price_level_3'] = 0; 
            }
        }
        $amount_1 = $amount_2 = $amount_3 = 0;
        foreach($products as $k=>$v){
            $amount_1 += round($v['num']*$v['price_level_1'],2);
            $amount_2 += round($v['num']*$v['price_level_2'],2);
            $amount_3 += round($v['num']*$v['price_level_3'],2);
        }
        if(!$pei_type = $this->GP('pei_type')){
            $this->msgbox->add('请选择配送方式',213)->response();
        }elseif($pei_type == 2){
            $ziti_time = $this->GP('ziti_time');
            $pei_time = strtotime($ziti_time);
            if(!$ziti_time){
                $this->msgbox->add('自提时间不能为空',214)->response();
            }elseif($pei_time&&$pei_time < __TIME){
                $this->msgbox->add('自提时间不正确',215)->response();
            }
            $addr['contact'] = $this->MEMBER['nickname'];
            $addr['mobile'] = $this->MEMBER['mobile'];
        }elseif($pei_type == 1){
            if(!$addr_id = $this->GP('addr_id')){
                $this->msgbox->add('地址不能为空',216)->response();
            }elseif(!$addr = K::M('member/addr')->detail($addr_id)){
                $this->msgbox->add('地址不能为空',217)->response();
            }elseif($addr['uid'] != $this->uid){
                $this->msgbox->add('地址不合法',218)->response();
            }
            $ship_fee = $this->GP('ship_fee');
        }
        $note = $this->GP('note');
        $weidian = K::M('shop/shop')->detail($this->FENXIAO['shop_id']);
        $data = array(
            'city_id' => $weidian['city_id'],
            'shop_id' => $this->FENXIAO['shop_id'],
            'uid' => $this->uid,
            'from'  => 'weidian',
            'order_status'=> 0,
            'online_pay' => 1,
            'total_price' => $total_price,
            'coupon_id' => $coupon_id,
            'coupon' => $coupon_amount,
            'pei_type'=>$pei_type,
            'amount' => $total_price+$ship_fee,
            'pei_time' => $pei_time,
            'intro' =>$note,
            'contact' => $addr['contact'],
            'mobile'=>$addr['mobile'],
            'addr'=>$addr['addr'],
            'house' => $addr['house'],
        );
        if($order_id = K::M('order/order')->create($data,true)){  //jh_order
            $data1 = array(
                'order_id' => $order_id,
                'product_price' => $total_price,
                'product_number'  => $num,
                'freight' => $ship_fee,
                'type' => 'fenxiao',
            );
            $fenxiao_set = $this->system->config->get('fenxiao');
            $fenxiao = K::M('fenxiao/member')->find(array('sid'=>FX_SID));
            if($fenxiao_set['other'] == 1){
                $shop_amount = $total_price;
                if($_cfg['level']>=1){
                    if($fenxiao['invite1']){
                        $data1['sid'] = FX_SID;
                        $data1['invite1'] = $fenxiao['invite1'];
                        $data1['amount_1'] = $amount_1;
                        $shop_amount -= $amount_1;
                    };
                }
                if($_cfg['level']>=2){
                    if($fenxiao['invite2']){
                        $data1['invite2'] = $fenxiao['invite2'];
                        $data1['amount_2'] = $amount_2;
                        $shop_amount -= $amount_2;
                    };
                }
                if($_cfg['level']>=3){
                    if($fenxiao['invite3']){
                        $data1['invite3'] = $fenxiao['invite3'];
                        $data1['amount_3'] = $amount_3;
                        $shop_amount -= $amount_3;
                    };
                }
                $data1['shop_amount'] = $shop_amount;
            }else{
                $data1['shop_amount'] = $total_price - $amount_1 - $amount_2 - $amount_3;
                if($_cfg['level']>=1){
                    if($fenxiao['invite1']){
                        $data1['sid'] = FX_SID;
                        $data1['invite1'] = $fenxiao['invite1'];
                        $data1['amount_1'] = $amount_1;
                    };
                }
                if($_cfg['level']>=2){
                    if($fenxiao['invite2']){
                        $data1['invite2'] = $fenxiao['invite2'];
                        $data1['amount_2'] = $amount_2;
                    };
                }
                if($_cfg['level']>=3){
                    if($fenxiao['invite3']){
                        $data1['invite3'] = $fenxiao['invite3'];
                        $data1['amount_3'] = $amount_3;
                    };
                }
            }
            K::M('weidian/order')->create($data1,false); //jh_weidian_order
            foreach($products as $k=>$v){ //jh_weidian_product_attr_stock
                $attr_stock = K::M('weidian/product/attrstock')->find(array('stock_name'=>$v['stock_name']));
                $a = array('sales'=>'`sales`+'.$v['num'], 'stock'=>'`stock`-'.$v['num']);
                K::M('weidian/product/attrstock')->update($attr_stock['attr_stock_id'],$a,true);
                K::M('weidian/product')->update($v['product_id'],$a,true);  //jh_weidian_product
                $data2 = array(
                    'order_id' => $order_id,
                    'product_id' => $v['product_id'],
                    'product_name' => $v['title'],
                    'product_price' => $v['price'],
                    'product_number' => $v['num'],
                    'amount' => $v['num']*$v['price'],
                    'stock_name' => $v['stock_name'],
                    'stock_real_name' => $v['stock_real_name'],
                );
                K::M('weidian/orderproduct')->create($data2); //jh_weidian_order_product
            }
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
            //print_r($this->system->db->SQLLOG());die;
            $this->msgbox->add('订单创建成功');
            $this->msgbox->set_data('order_id',$order_id);
        }else{
            $this->msgbox->add('订单创建失败',225)->response();
        }
        
    }

    

}
