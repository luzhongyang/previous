<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_Index extends Ctl_Web
{
   public function index()
   {
       $change = $this->GP('change');
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
       if($addr&&empty($change)){
           $this->pagedata['cates'] = K::M('shop/cate')->fetch_all();
           $this->tmpl = 'web/shop.html';
       }else{
           $this->tmpl = 'web/index.html';
       }
   }
}