<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Tuan extends Ctl
{
    public function index($cate_id=0,$cat_id=0,$area_id=0,$biz_id=0,$page=1)
    { //团购商家
        $cate_id = (int)$cate_id;
        $cat_id = (int)$cat_id;
        $area_id = (int) $area_id;
        $biz_id = (int) $biz_id;
        $city_id = $this->city_id;
        $cates = K::M('shop/cate')->tree();
        $areas = K::M('data/area')->items(array('city_id'=>$city_id));
        $bizs = K::M('data/business')->items(array('city_id'=>$city_id));
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 12;
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        $filter['city_id'] = $city_id;
        $filter['have_tuan'] = 1;
        if($title = htmlspecialchars($this->GP('shop_name'))){
            $filter['title'] = "LIKE:%{$title}%";
            $this->pagedata['shop_name'] = $title;
        }
        if($cate_id && $cat_id){
            if($cate = K::M('shop/cate')->find(array('cate_id'=>$cat_id))){
                if($cate['parent_id'] != $cate_id){
                    $this->msgbox->add('参数不正确!',211);
                }
            }
            $filter['cate_id'] = $cat_id;
        }elseif($cate_id && !$cat_id){
            if(!$cate = K::M('shop/cate')->find(array('cate_id'=>$cate_id))){
                $this->msgbox->add('商家分类不存在!',212);
            }else{
                $filter['cate_id'] = $cates[$cate_id]['all'];
            }
        }
        
        $this->pagedata['cate_id'] = $cate_id;
        $this->pagedata['cat_id'] = $cat_id;

        //地区商圈
        if($area_id&&$biz_id){
            if($biz = K::M('data/business')->find(array('business_id'=>$biz_id))){
                if($biz['area_id'] != $area_id){
                    $this->msgbox->add('城市商圈不正确!',213);
                }
            }
            $filter['area_id'] = $area_id;
            $filter['business_id'] = $biz_id;
        }elseif($area_id && !$biz_id){
            if(!$area = K::M('data/area')->find(array('area_id'=>$area_id))){
                $this->msgbox->add('地区不存在!',214);
            }
            $filter['area_id'] = $area_id;
        }
        $this->pagedata['area_id'] = $area_id;
        $this->pagedata['biz_id'] = $biz_id;
        $orderby = array();
        if($order = $this->GP('order')){
            switch($order){
                case 'praise':
                //$orderby = array('`score`'.'/'.'`comments`'=>'desc');break;
                case 'price':
                $orderby['avg_amount'] = 'asc';break;
                default:
                $orderby = array('shop_id'=>'desc','avg_amount'=>'asc');break;
            }
        }
        $this->pagedata['order'] = $order;
        
        if($items = K::M('shop/shop')->items($filter, $orderby, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('tuan/index',array($cate_id,$cat_id,$area_id,$biz_id,'{page}'),null,'base'));
        }
        //print_r($this->system->db->SQLLOG());die;
        $cate_ids = array();
        foreach($items as $k => $v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        //print_r($pager);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cates'] = $cates;
        $this->pagedata['areas'] = $areas;
        $this->pagedata['bizs'] = $bizs;
        $this->pagedata['cates_list'] = K::M('shop/cate')->fetch_all();
        $this->tmpl = 'pchome/tuan/index.html';
    } 
    
    public function detail($tuan_id,$page=1){
        if(!$tuan_id = (int)$tuan_id){
            $this->msgbox->add('该团购不存在!',211);
        }elseif(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('该团购不存在!',212);
        }elseif($detail['audit'] != 1|| $detail['closed'] !=0){
            $this->msgbox->add('该团购未通过审核或已删除!',213);
        }else{
            $map = array('type'=>'tuan','shop_id'=>$detail['shop_id'],'closed'=>0,'audit'=>1,'is_onsale'=>1);
            $map['tuan_id'] = "<>:".$tuan_id;
            $tuan_list = K::M('tuan/tuan')->items($map,null,1,3);
            $this->pagedata['tuan_list'] = $tuan_list;
            $detail['collect'] = 0;
            if($this->uid) {
                if(K::M('member/collect')->count(array('uid'=>$this->uid,'type'=>1,'can_id'=>$detail['shop_id'],'status'=>1))){
                    $detail['collect'] = 1;
                }
            }
            $this->pagedata['detail'] = $detail;
            
            
            //评价、分页
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 5;
            $filter['shop_id'] = $detail['shop_id'];
            $filter['closed'] = 0;
            if($items = K::M('shop/comment')->items($filter,array('comment_id'=>'DESC'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null,array($tuan_id,'{page}'),null,'base'));
                $uids = $comment_ids = array();
                foreach($items as $k=>$v){
                    $comment_ids[$v['comment_id']] = $v['comment_id'];
                    $uids[$v['uid']] = $v['uid'];
                }
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
                if($comment_photo_list = K::M('shop/commentphoto')->items(array('comment_id'=>$comment_ids))){
                    foreach($comment_photo_list as $k=>$v){
                        $items[$v['comment_id']]['photos'][$k] = $v;
                    }
                }
                $this->pagedata['items'] = $items;
                $this->pagedata['pager'] = $pager;
            }
            
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->tmpl = 'pchome/tuan/detail.html';
        }
    }

    
    public function get_recommend(){
        $tuan_id = (int)$this->GP('tuan_id');
        if(!$tuan_id){
            $this->msgbox->add('该团购不存在!',211);
        }elseif(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('该团购不存在!',212);
        }elseif($detail['audit'] != 1||$detail['closed'] != 0){
            $this->msgbox->add('该团购不存在!',213);
        }else{
            $filter = array('closed'=>0,'audit'=>1);
            $filter['tuan_id'] = "<>:".$tuan_id;
            $count = K::M('tuan/tuan')->count($filter);
            $page = ceil($count/4);
            //print_r($page);die;
            $rand = rand(1, $page);
            if(!$items = K::M('tuan/tuan')->items($filter,null,$rand,4)){
                $items = array();
            }
            //print_r($this->system->db->SQLLOG());die;
            //print_r($items);die;
            //print_r($items);die;
            $this->msgbox->add('success');
            $this->msgbox->set_data('rand', $rand);
            $this->msgbox->set_data('items', $items);
        }
    }

    public function items($shop_id,$page=1){//团购列表
        
        
        
        
    }
    
    
    public function order($tuan_id,$num){
        $this->check_login();
        if(!$tuan_id = (int)$tuan_id){
            $this->msgbox->add('该团购不存在!',211);
        }elseif(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('该团购不存在!',212);
        }elseif($detail['audit'] != 1||$detail['closed'] != 0){
            $this->msgbox->add('该团购不存在!',213);
        }elseif($detail['stime']>__TIME||$detail['ltime']<__TIME){
            $this->msgbox->add('该团购未开始或已过期!',214);
        }elseif(!$num = (int)$num){
            $this->msgbox->add('团购数量不能为空!',215);
        }elseif($detail['sale_type'] == 1&&$num>$detail['stock_num']){
            $this->msgbox->add('团购库存不足!',216);
        }elseif($num<$detail['min_buy'] || $num>$detail['max_buy']){
            $this->msgbox->add('团购数量不正确!',217);
        }else{
            $this->pagedata['num'] = $num;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'pchome/tuan/order.html';
        }
    }
    
    
    // 团购创建订单
    public function create()
    {
        // 判断商家 判断团购商品的库存
        $this->check_login();
        $ticket_merge = null;
        $data_order = $data_tuan = $data_ticket= array();
        if(IS_AJAX){
            if(!$tuan_id = (int)$this->GP('tuan_id')) {
                $this->msgbox->add('商品不能为空',224);
            }else if(!$tuan_detail = K::M('tuan/tuan')->detail($tuan_id)) {
                $this->msgbox->add('商品不存在',225);
            // }else if($tuan_detail['audit'] !=1 || $tuan_detail['closed'] !=0) {
            //     $this->msgbox->add('商品未审核或已删除',226);
            }else if(!$numbers = (int)$this->GP('numbers')) {
                $this->msgbox->add('商品数量不正确',227);
            }else if($tuan_detail['max_buy'] < $numbers){
                $this->msgbox->add('不能超过最大购买数',230);
            }else if($tuan_detail['min_buy'] > $numbers){
                $this->msgbox->add('不能低于最小购买数',231);
            }else if($tuan_detail['stock_type'] ==1 && ($tuan_detail['stock_num'] < $numbers)){
                $this->msgbox->add('商品库存不足',229);
            }else if(__TIME < $tuan_detail['stime'] || __TIME > $tuan_detail['ltime']) {
                $this->msgbox->add('当前不在团购有效期时间内',232);
            }else {
                $prices = $tuan_detail['price'];
                $shop_detail = K::M('shop/shop')->detail($tuan_detail['shop_id']);
                $lng = $shop_detail['lng'];
                $lat = $shop_detail['lat'];
                $data_order = array(
                    'city_id'            => $shop_detail['city_id'],
                    'shop_id'            => $tuan_detail['shop_id'],
                    'staff_id'           => 0,
                    'uid'                => $this->uid,
                    'from'               => 'tuan',
                    'order_status'       => 0,
                    'pay_status'         => 0,
                    'total_price'        => $numbers * $prices,
                    'amount'             => $numbers * $prices,
                    'mobile'             => $this->MEMBER['mobile'],
                    'contact'            => $this->MEMBER['nickname'],
                    'addr'               => '',
                    'house'              => '',
                    'lng'                => $lng,
                    'lat'                => $lat,
                    'order_from'         => (defined('IN_WEIXIN') ? 'weixin' : 'wap')
                );
                $data_tuan = array(
                    'tuan_id'            => $tuan_id,
                    'tuan_title'         => $tuan_detail['title'],
                    'tuan_photo'         => $tuan_detail['photo'],
                    'tuan_price'         => $numbers * $prices,
                    'tuan_number'        => $numbers,
                    'use_time'           => 0,
                    'ltime'              => $tuan_detail['ltime'],
                    'type'               => $tuan_detail['type'],
                );
                $data_ticket = array(
                    'uid'                => $this->uid,
                    'shop_id'            => $tuan_detail['shop_id'],
                    'tuan_id'            => $tuan_id,
                    'count'              => $numbers,
                    'ltime'              => $tuan_detail['ltime'],
                    'use_time'           => 0,
                    'status'             => 0,
                    'type'               => $tuan_detail['type'],
                    'dateline'           => __TIME
                );
                if($order_id = K::M('order/order')->create($data_order)) {
                    // 创建tuan_order订单
                    $data_tuan['order_id'] = $order_id;
                    K::M('tuan/order')->create($data_tuan); 
                    // 更新商品销量
                    K::M('tuan/tuan')->update_count($tuan_id, 'sales', $numbers);
                    K::M('tuan/tuan')->update_count($tuan_id,'sale_count', $numbers);
                    K::M('tuan/tuan')->update_count($tuan_id,'stock_num', -$numbers);
                    // if($tuan_detail['stock_type'] ==1){  //启用库存机制时 更新已购数
                    //     K::M('tuan/tuan')->update_count($tuan_id,'sale_count', $numbers);
                    //     K::M('tuan/tuan')->update_count($tuan_id,'stock_num', -$numbers);
                    // }
                    // 写入订单日志
                    K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                    // 给商户发送订单消息
                    K::M('shop/msg')->create(array('shop_id'=>$tuan_detail['shop_id'],'title'=>'订单已提交','content'=>'订单已提交','is_read'=>0,'type'=>1,'order_id'=>$order_id));
                    // 更新用户订单量
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    //echo '<pre>';print_r($this->system->db->SQLLOG());die;
                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('order_id',$order_id);   
                    $this->msgbox->set_data('pay_status',$data_order['pay_status']);            
                }
            }
        }
    }


    
    


    
    
}