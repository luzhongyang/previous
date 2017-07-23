<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Index extends Ctl_Cloud
{
   public function index()
   {

       K::M('system/logs')->log('ctl.cloud.index', array($_COOKIE,$_SERVER));
       //即将揭晓
       $items['rest'] = K::M('cloud/attr')->items_by_rest(array('closed'=>0,'status'=>0),4);
       //人气商品 --- cloud_num
       $items['renqi'] = K::M('cloud/attr')->items(array('closed'=>0,'status'=>0),array('cloud_num'=>'desc'),1,4);
       //新品
       $items['new'] = K::M('cloud/attr')->items(array('closed'=>0,'status'=>0),array('attr_id'=>'desc'),1,4);
       //精品
       $items['jingpin'] = K::M('cloud/attr')->items(array('closed'=>0,'status'=>0,'is_fine'=>1),array(),1,4);
       //价格
       $items['price'] = K::M('cloud/attr')->items(array('closed'=>0,'status'=>0),array('price'=>'asc'),1,4);
       
       $items_merge = $items['rest'] + $items['renqi'] + $items['new'] + $items['jingpin'] + $items['price'];
       $goods_id = array();
       foreach($items_merge as $k=>$v){
           $goods_id[$v['goods_id']] = $v['goods_id'];
       }
       if($goods_id){
           $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_id);
       }
       $last_lottery_item = K::M('cloud/attr')->find(array('status'=>1,'closed'=>0),array('lottery_time'=>'desc'));
       $last_lottery_item['goods'] = K::M('cloud/goods')->detail($last_lottery_item['goods_id']);
       $last_lottery_item['user'] = K::M('member/member')->detail($last_lottery_item['win_uid']);
       $this->pagedata['last_lottery'] = $last_lottery_item;
       $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/index.html';
   }
   
   public function detail($attr_id=null)
   {
       if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           if($detail['status'] == 1){
               $this->lottery($attr_id);
           }else{
                $photos = K::M('cloud/photo')->items(array('goods_id'=>$detail['goods_id']));
                $new_photos = array();
                foreach($photos as $photo){
                    $new_photos[] = $photo['photo'];
                }
                array_unshift($new_photos,$goods['photo']);
                $detail['photo'] = $new_photos;
                $this->pagedata['orders'] = $orders;
                $this->pagedata['detail'] = $detail;
                $this->pagedata['goods'] = $goods;
                $this->tmpl = 'cloud/detail.html'; 
           }
       }
   }

   
   
   
   public function lottery($attr_id){  //开奖商品页面详情
       if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           if($detail['status'] != 1){
               $this->detail($attr_id);
           }else{
               $photos = K::M('cloud/photo')->items(array('goods_id'=>$detail['goods_id']));
                $new_photos = array();
                foreach($photos as $photo){
                    $new_photos[] = $photo['photo'];
                }
                array_unshift($new_photos,$goods['photo']);
                $detail['photo'] = $new_photos;
                $last_attr = K::M('cloud/attr')->find(array('goods_id'=>$detail['goods_id'],'closed'=>0,'status'=>0),array('attr_id'=>'desc'));
                $detail['lottery_user'] = K::M('member/member')->detail($detail['win_uid']);
                $buy_num = K::M('cloud/order')->member_num_count(array('uid'=>$detail['win_uid'],'attr_id'=>$detail['attr_id']),false);
                
                $number_item = K::M('cloud/number')->find(array('attr_id'=>$attr_id,'uid'=>$detail['win_uid'],'number'=>$detail['win_number']));
                $lottery_order = K::M('cloud/order')->detail($number_item['order_id']);
                
                $this->pagedata['user_lottery_time'] = $lottery_order['dateline'];
                $this->pagedata['buy_num'] = $buy_num;
                $this->pagedata['last_attr_id'] = $last_attr['attr_id'];
                $this->pagedata['orders'] = $orders;
                $this->pagedata['detail'] = $detail;
                $this->pagedata['goods'] = $goods;
                $this->tmpl = 'cloud/lottery.html'; 
           }
       }
   }

   
    public function calculate($attr_id=null)
   {
       if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif($detail['status'] != 1){
           $this->msgbox->add('该云购商品还未开奖',216)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
            $last_50_items = K::M('cloud/order')->items(array('attr_id'=>$attr_id,'order_status'=>1),array('dateline'=>'desc'),0,50);
            $last_times = 0;
            $uids = array();
            foreach($last_50_items as $item){
                $uids[$item['uid']] = $item['uid'];
                $last_times += intval(date('His',$item['dateline']).$item['microtime']);
            }
            if($uids){
                $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
            }
            $this->pagedata['last_item'] = K::M('cloud/order')->find(array('attr_id'=>$attr_id,'order_status'=>1),array('dateline'=>'desc'));
            $this->pagedata['last_times'] = $last_times;
            $this->pagedata['items'] = $last_50_items;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'cloud/calculate.html'; 
       }
   }
   
   
   
   public function loaddata($page=1){  //参与记录（进行中和已揭晓）
        if(!$attr_id = $this->GP('attr_id')){
         $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           $filter = array('attr_id'=>$attr_id,'order_status'=>1);
       }
        $page = max((int)$page, 1);
        $limit = 10;
       if($items = K::M('cloud/order')->items($filter,array('dateline'=>'desc'),$page,$limit,$count)){
            $uids = array();
            foreach($items as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
            }
            if($uids){
                $users = K::M('member/member')->items_by_ids($uids);
            }
            foreach($items as $k=>$v){
                foreach($users as $k1=>$v1){
                    if($v['uid'] == $v1['uid']){
                        $items[$k]['user'] = $this->filter_fields('uid,nickname,face', $v1);
                    }
                }
            }
       }else{
           $items = array();
       }
       
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
   }

      public function items()
   {
       $this->pagedata['cates'] = K::M('cloud/cate')->fetch_all();
       if($cate_id = (int)$this->GP('cate_id')){
            $pager['cate_id'] = $cate_id;
        }
        if($kw = $this->GP('kw')){
            $pager['kw'] = $kw;
        }
        if($order = $this->GP('order')){
            $pager['order'] = $order;
        }
       $this->pagedata['pager'] = $pager;
       $this->tmpl = 'cloud/items.html';
   }

   public function loaditems($page=1)
    {
        $filter = array('closed'=>0,'status'=>0);
        $pager = array();
        if($cate_id = (int)$this->GP('cate_id')){
            $filter['cate_id'] = $cate_id;
            $pager['cate_id'] = $cate_id;
        }
        if($kw = $this->GP('kw')){
            $filter['goods']['title'] = "LIKE:%".$kw."%";
            $pager['kw'] = $kw;
        }else{
             unset($filter['goods']);
        }
        
        $orderby = array();
        if($order = $this->GP('order')){
            switch($order){
                case 'renqi':
                $orderby['join'] = 'desc';break;
                case 'new':
                $orderby['attr_id'] = 'desc';break;
                case 'price':
                $orderby['price'] = 'asc';break;
            }
        }
        $pager['order'] = $order;
        $page = max((int)$page, 1);
        if($goods_items = K::M('cloud/attr')->items_all($filter, $orderby, 1, 500, $count)){
            $goods_ids = array();
            foreach($goods_items as $k=>$v) {             
                $goods_ids[$v['goods_id']] = $v['goods_id'];
                $goods_items[$k]['avg_last'] = (($v['price']-$v['join'])/$v['price']) ? round((($v['price']-$v['join'])/$v['price']),2) : 0 ; //剩余百分比
            }
            if($this->GP('order') == 'jjjx'){ //即将揭晓
                uasort($goods_items, array($this, 'avg_last'));
            }           
            $items = array_slice($goods_items, ($page-1)*10, 10, true);
            $goods = K::M('cloud/goods')->items_by_ids($goods_ids);
            foreach($items as $k=>$v){
                foreach($goods as $k1=>$v1){
                    if($v['goods_id'] == $v1['goods_id']){
                        $items[$k]['goods'] = $v1;
                    }
                }
            }   
      }else {
          $items = array();
      }
      $count_num = K::M('cloud/attr')->count($filter);
        if($count_num <= 10){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
      $this->msgbox->set_data('loadst', $loadst);
      $this->pagedata['pager'] = $pager;
      $this->pagedata['items'] = $items;
      $this->tmpl = 'cloud/loaditems.html';
      $html = $this->output(true);
      $this->msgbox->set_data('html', $html);
      $this->msgbox->json();
    }


    protected function avg_last($a, $b)
    {
         if ($a['avg_last'] == $b['avg_last']) {
            return 0;
        }
        return ($a['avg_last'] < $b['avg_last']) ? -1 : 1;       
    }
    
    public function textdetail($attr_id=null){
        if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }else{
           $this->pagedata['detail'] = $detail;
           $this->pagedata['goods'] = $goods;
           $this->tmpl = 'cloud/textdetail.html';
       }
        
    }


}
