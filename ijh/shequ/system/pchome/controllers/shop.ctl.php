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

class Ctl_Shop extends Ctl
{
    public function index($cate_id=0,$cat_id=0,$area_id=0,$biz_id=0,$page=1)
    {
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
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('shop/index',array($cate_id,$cat_id,$area_id,$biz_id,'{page}'),null,'base'));
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
        $this->tmpl = 'pchome/shop/index.html';
    } 
    
    public function detail($shop_id,$page=1){
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('该商家不存在!',211);
        }elseif(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('该商家不存在!',212);
        }elseif($detail['audit'] != 1||$detail['closed'] != 0){
            $this->msgbox->add('该商家不存在!',213);
        }else{
            if($detail['have_maidan'] == 1) {
                $detail['maidan'] = K::M('maidan/maidan')->find(array('shop_id'=>$detail['shop_id']));
                $detail['maidan']['config'] = unserialize($detail['maidan']['config']);
            }
            $detail['quan'] = K::M('tuan/tuan')->find(array('type'=>'quan','shop_id'=>$shop_id,'closed'=>0,'is_onsale'=>1));
            if($detail['have_waimai']){
		$detail['waimai'] = K::M('waimai/waimai')->detail($detail['shop_id']);
                $this->pagedata['waimai'] = $detail['waimai'];
            }
            if($detail['have_quan']){
                $this->pagedata['quan_list'] = K::M('tuan/tuan')->items(array('type'=>'quan','shop_id'=>$detail['shop_id'],'closed'=>0,'is_onsale'=>1),null,1,2);
            }
            if($detail['have_tuan']){
                $this->pagedata['tuan_list'] = K::M('tuan/tuan')->items(array('type'=>'tuan','shop_id'=>$detail['shop_id'],'closed'=>0,'is_onsale'=>1),null,1,2);
            }
            
            //评价、分页
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 5;
            $filter['shop_id'] = $detail['shop_id'];
            $filter['closed'] = 0;
            if($items = K::M('shop/comment')->items($filter,array('comment_id'=>'DESC'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('tuan/detail',array($shop_id,'{page}'),null,'base'));
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
            $detail['collect'] = 0;
            if($this->uid) {
                if(K::M('member/collect')->count(array('uid'=>$this->uid,'type'=>1,'can_id'=>$shop_id,'status'=>1))){
                    $detail['collect'] = 1;
                }
            }
            if($detail['have_dingzuo']){
                $number = array();
                for ($i=2; $i < 51; $i++) { 
                    $number[] = $i;
                }
                $this->pagedata['yuyue_numbers'] = $number;
                
                $hours = "";
                for($i=0;$i<=23;$i++){
                    $hours .= '<option value="'.$i.':00">'.$i.':00</option>';
                    $hours .= '<option value="'.$i.':30">'.$i.':30</option>';
                }
                $this->pagedata['hours'] = $hours;
                $this->pagedata['now_date'] = date('Y-m-d',__TIME);
            }
            $this->pagedata['waimai'] = $waimai;
            $this->pagedata['cates'] = K::M('shop/cate')->tree();
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'pchome/shop/detail.html';
        }
    }

    public function create($params)
    {   //订座订单创建
        $this->check_login();
        $data['shop_id'] = (int)$this->GP('shop_id');
        $data['yuyue_time'] = strtotime($this->GP('yuyue_time'));
        $data['yuyue_number'] = $this->GP('yuyue_number');
        $data['is_baoxiang'] = (int)$this->GP('is_baoxiang');
        $data['contact'] = $this->GP('contact');
        $data['mobile'] = $this->GP('mobile');
        $data['notice'] = $this->GP('notice');
        if(!$data['shop_id']){
            $this->msgbox->add('未指定要预定的商户', 212);
        }else if(!$shop = K::M('shop/shop')->detail($data['shop_id'])){
            $this->msgbox->add('预订的商户不存在或已经删除', 213);
        }else if(/*empty($shop['verify_name']) || */empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可订座', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通订座功能', 215);
        }else if($data['yuyue_time'] < __TIME){
            $this->msgbox->add('请选择有效的预约时间',216);
        }else if(!$data['yuyue_time']){
            $this->msgbox->add('请选择预约时间',216);
        }else if(!$data['yuyue_number']){
            $this->msgbox->add('请选择预约人数',217);
        }else if(!$data['contact']){
            $this->msgbox->add('请填写您的姓名',218);
        }else if(!$data['mobile']){
            $this->msgbox->add('请填写您的手机号',219);
        }else{
            $data['uid'] = (int)$this->uid;
            $data['city_id'] = $shop['city_id'];
            $data['order_from'] = defined('IN_WEIXIN') ? 'weixin' : 'wap';
            if($dingzuo_id = K::M('yuyue/dingzuo')->create($data)){
                $this->msgbox->add('订座成功');
                $this->msgbox->set_data('dingzuo_id', $dingzuo_id);
            }
        }
    }
    
    
    
    public function get_recommend(){
        $shop_id = (int)$this->GP('shop_id');
        if(!$shop_id){
            $this->msgbox->add('该商家不存在!',211);
        }elseif(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('该商家不存在!',212);
        }elseif($detail['audit'] != 1||$detail['closed'] != 0){
            $this->msgbox->add('该商家不存在!',213);
        }else{
            $cates = K::M('shop/cate')->tree();
            $cate_lists = K::M('shop/cate')->fetch_all();
            $cate = K::M('shop/cate')->detail($detail['cate_id']);
            $cid = 0;
            if($cate['parent_id'] == 0){
                $cate_ids = $cates[$cate['cate_id']]['all'];
                $cid = $cate['cate_id'];
            }else{
                $cate_ids = $cates[$cate['parent_id']]['all'];
                $cid = $cate['parent_id'];
            }
            $this->city_id = 1; ///假数据
            $filter = array('closed'=>0,'audit'=>1,'city_id'=>$this->city_id);
            $areas = K::M('data/area')->items(array('city_id'=>$this->city_id));
            $filter['cate_id'] = $cate_ids;
            $filter['shop_id'] = "<>:".$shop_id;
            $count = K::M('shop/shop')->count();
            $page = ceil($count/4);
            $rand = rand(1, $page);
            if($items = K::M('shop/shop')->items($filter,null,$rand,4)){
                foreach($items as $k=>$val){
                     $items[$k] = $this->filter_fields('shop_id,city_id,city_name,cate_name,cate_title,title,cate_id,logo,lat,lng,addr,score,comments,avg_amount,area_id',$val);
                }
                foreach($items as $k=>$v){
                    $items[$k]['area'] = $areas[$v['area_id']]['area_name'];   
                    $items[$k]['pre'] = round(($v['score']/$v['comments'])*20,2);
                }
            }else{
                $items = array();
            }
            //print_r($items);die;
            $this->msgbox->add('success');
            $this->msgbox->set_data('items', $items);
            
        }
    }

    
}