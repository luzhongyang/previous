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
            $lat = $this->GP('lat');
            $lng = $this->GP('lng');
            $title = $this->GP('title');
            $title = htmlspecialchars($title);
            $fiter = array();
            $filter['title'] = "LIKE:%".$title."%";
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $shops = K::M('shop/shop')->items($filter);
            if(!$shops){
                $tips = L('没有搜索到您想查找的商家');
            }
            $this->pagedata['shops']= $shops;
            $this->pagedata['tips']= $tips;
            $this->tmpl = 'search.html';
        }else{
            $this->tmpl = 'search.html';
        }
    }

}
