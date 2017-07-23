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

class Ctl_Index extends Ctl
{
    public function index()
    {
        
        //店铺幻灯片
        $banner = K::M('weidian/banner')->items(array('shop_id'=>$this->FENXIAO['shop_id'],'closed'=>0,'audit'=>1),array('orderby'=>'desc'),1,5);
        $this->pagedata['banner'] = $banner;

        //店铺推荐单品
        $filter = array(
            'shop_id'   =>  $this->FENXIAO['shop_id'],
            'type'      =>  'default',
            'is_onsale' =>  1,
            'is_fenxiao'=>1,
            'closed' => 0
        );
        
        if($title = strip_tags(trim($this->GP('title')))){
            $filter['title'] = "LIKE:%".$title."%";
        }
        $product = K::M('weidian/product')->items($filter,array('dateline'=>'desc'),1,4);
        //print_r($this->system->db->SQLLOG());die;
        $this->pagedata['product'] = $product;
        $this->pagedata['is_index'] = 1;
        $this->tmpl = 'fenxiao/index/index.html';
        
    }
    
    
    public function cookie()
    {
        $a = $this->cookie->get('UxLocation');
        $this->cookie->delete("UxLocation");
        $this->cookie->clear();
        $this->cookie->set('UxLocation', '{}');
        echo "<!doctype html><html><body>";
        echo "<pre>";
        print_r($a);
        print_r($_COOKIE);
        print_r($this->cookie->_COOKIE);
        //print_r($_SERVER);
        echo 'clear cookie success';
        echo "</pre>";
        echo "<script>localStorage={},localStorage.clear();</script></body></html>";
        exit();
    }
    
}