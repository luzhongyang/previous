<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Index extends Ctl
{
    public function __construct(&$system) {
        parent::__construct($system);
    }

    public function index()
    {   
        if(!defined('IS_MOBILE') && !$this->system->cookie->get('is_view')){
            header("Location:".$this->mklink('welcome/index'));
            exit;
        }else{
           $this->pagedata['cate_tree'] = K::M('shop/cate')->items(array('parent_id'=>0));
           $this->tmpl = 'index.html';
        }
    }
    
    
    public function get_addr(){
        $lat = $this->GP('lat');
        $lng = $this->GP('lng');
        $url = 'http://api.map.baidu.com/geocoder?location='.$lat.','.$lng.'&output=xml&output=json&pois=1';
        $json = file_get_contents($url);
        $json = json_decode($json);  
        $addr= $json->{'result'}->{'addressComponent'}->{'city'};
        $this->msgbox->set_data('addr',$addr);
    }
    
    
    public function cookie()
    {
        $a = $this->cookie->get('UxLocation');
        $this->cookie->delete("UxLocation");
        $this->cookie->clear();
        $this->cookie->set('UxLocation', '{}');
        echo "<pre>";
        print_r($a);
        print_r($_COOKIE);
        print_r($this->cookie->_COOKIE);
        print_r($_SERVER);
        echo 'clear cookie success';
        echo "</pre>";
        exit();
    }

    

}