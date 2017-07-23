<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_Shop extends Ctl_Web
{
    public function index(){
        $this->pagedata['cates'] = K::M('shop/cate')->fetch_all();
        if($kw = $this->GP('kw')){
            $pager['kw'] = $kw;
            $this->pagedata['pager'] = $pager;
        }
        $addr = $this->system->cookie->get('addr');
        $lat = $this->system->cookie->get('lat');
        $lng = $this->system->cookie->get('lng');
        $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);
        $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
        $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        $filter['is_new'] = 1;
        $filter['audit'] = 1;
        $filter['closed'] = 0;
       $this->pagedata['shop_count'] = K::M('shop/shop')->count($filter);
       if(empty($addr)){
           $this->tmpl = 'web/index.html';
       }else{
           $this->tmpl = 'web/shop.html';
       }
    }

    protected function juli_order($a, $b)
    {
        if($a['juli'] == $b['juli']){
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    public function loaddata($page=1)
    {
        $filter = array('audit'=>1, 'closed'=>0);
        $pager = array();
        if($cate_id = (int)$this->GP('cate_id')){
            $filter['cate_id'] = K::M('shop/cate')->children_ids($cate_id);
            $pager['cate_id'] = $cate_id;
        }
        if($kw = $this->GP('kw')){
            $filter['title'] = "LIKE:%".$kw."%";
            $pager['kw'] = $kw;
        }
        if($is_new = $this->GP('is_new')){
            $filter['is_new'] = 1;
            $pager['is_new'] = $is_new;
        }
        if($first_youhui = $this->GP('first_youhui')){
            $filter['first_amount'] = ">:0";
            $pager['first_youhui'] = $first_youhui;
        }
        if($is_pay = $this->GP('is_pay')){
            $filter['online_pay'] = 1;
            $pager['is_pay'] = $is_pay;
        }
        if($is_youhui = $this->GP('is_youhui')){
            $filter['youhui'] = "<>:''";
            $pager['is_youhui'] = $is_youhui;
        }
        $pei_type = (int)$this->GP('pei_type');
        if($pei_type == 1){
            $filter['pei_type'] = "0";
        }else if((int)$this->GP('pei_type')==2){
            $filter['pei_type'] = "IN:1,2";
        }

        if($this->GP('sort') == 'dateline_desc') {
            $orderby['dateline'] = 'desc';
        }else if($this->GP('sort') == 'orders_desc') {
            $orderby['orders'] = 'desc';
        }else if($this->GP('sort') == 'score_desc') {
            $orderby['score'] = 'desc';
        }else if($this->GP('sort') == 'pei_time_asc') {
            $orderby['pei_time'] = 'asc';
        }else if($this->GP('sort') == 'first_amount_asc') {
            $orderby['first_amount'] = 'asc';
        }else if($this->GP('sort') == 'first_amount_15_asc') {
            $orderby['first_amount'] = 'asc';
            $filter['min_amount'] = '<:15';
        }else if($this->GP('sort') == 'first_amount_20_asc') {
            $orderby['first_amount'] = 'asc';
            $filter['min_amount'] = '<:20';
        }else if($this->GP('sort') == 'first_amount_30_asc') {
            $orderby['first_amount'] = 'asc';
            $filter['min_amount'] = '<:30';
        }else if($this->GP('sort') == 'first_amount_40_asc') {
            $orderby['first_amount'] = 'asc';
            $filter['min_amount'] = '<:40';
        }       


        $pager['pei_type'] = $pei_type;
        $lng = $this->system->cookie->get('lng');
        $lat = $this->system->cookie->get('lat');        
        $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);
        $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
        $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        $page = max((int)$page, 1);
        $limit = 20;
        if($items = K::M('shop/shop')->items($filter, $orderby, $page, $limit, $count)){
            $shop_ids = array();
            foreach($items as $k=>$val) {             
                $val['collect'] = 0;
                $val['juli'] = K::M('helper/round')->getdistances($val['lng'], $val['lat'], $lng, $lat);  //距离
                $items[$k] = $val;
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $youhuis = K::M('shop/youhui')->items(array('shop_id'=>$shop_ids));
            foreach($items as $kk => $vv){
              $items[$kk]['first_amount_title'] = sprintf(L("首次下单立减%s元"), $vv['first_amount']);
              $str = '';
              foreach($youhuis as $kkk => $vvv){
                  if($kk == $vvv['shop_id']){
                      $str .= sprintf(L("满%s减%s；"), $vvv['order_amount'], $vvv['youhui_amount']);
                  }
              }
              $items[$kk]['youhui_str'] = $str;
            }
            if($this->GP('sort') == 'juli_asc'){
                uasort($items, array($this, 'juli_order'));
            }
      }else {
          $items = array();
      }

      $this->pagedata['pager'] = $pager;
      $this->pagedata['items'] = $items;
      $this->tmpl = 'web/loaddata.html';
      $html = $this->output(true);
      $this->msgbox->set_data('html', $html);
      $this->msgbox->json();
    }

    public function collect($shop_id=null)
  {
    $shop_id = (int)$shop_id;
    $uid = $this->uid;
    $filter = array();
    if(!$uid){
      $this->msgbox->add('请先登录！', 300);
    }else if($shop_id && $uid){
      $filter['shop_id'] = $shop_id;
      $filter['uid'] = $uid;
      $detail = K::M('shop/collect')->items($filter);
      if($detail){
        if(K::M('shop/collect')->del($uid, $shop_id)){
          $this->msgbox->add('取消收藏成功！');
        }else{
          $this->msgbox->add('取消收藏失败！', 302);
        }
      }else{
        $data = array();
        $data = array('shop_id'=>$shop_id,'uid'=>$uid);
        if(false !== K::M('shop/collect')->create($data)){
            $this->msgbox->add('收藏成功！');
        }else{
            $this->msgbox->add('收藏失败！', 302);
        }
      }
    }else{
        $this->msgbox->add('参数错误！', 305);
    }
  }
   
   

}
