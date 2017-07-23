<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Search extends Ctl
{
    public function index()
    {
        if($this->checksubmit()){
            $filter = array(); 
            $lat = $this->GP('lat');
            $lng = $this->GP('lng');

            if(!$lng || !$lat){
                $lng = $this->request['UxLocation']['lng'];
                $lat = $this->request['UxLocation']['lat'];
            }
            $title = $this->GP('title');
            $from = $this->GP('from');
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $limit = 500;
            $page = max((int)$this->GP('page'), 1);
            $filter['title'] = "LIKE:%".$title."%";
            if($lng && $lat){
                $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 100);
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }
            if($from == 'tuan') {
                $filter['have_tuan'] = 1;
                $shops = K::M('shop/shop')->items($filter,$orderby,$page,$limit,$count);
            }else if($from == 'waimai') {
                $shops = K::M('waimai/waimai')->items($filter,$orderby,$page,$limit,$count);
                foreach($shops as $k=>$v) {
                    if($waimai_cate = K::M('waimai/cate')->detail($v['cate_id'])) {
                        $shops[$k]['cate_title'] = $waimai_cate['title'];
                    }
                }
            }else {
                $shops = K::M('shop/shop')->items($filter,$orderby,$page,$limit,$count);
            }
            if(!$shops){
                $tips = '抱歉,没有搜索到您想查找的商家';
            }
            $this->pagedata['shops'] = $shops;
            $this->pagedata['tips'] = $tips;
            $this->pagedata['from'] = $from;
            $this->tmpl = 'search.html';
        }else{
            $this->tmpl = 'search.html';
        }
    }

}
