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
            header("Location:".$this->mklink('web/index'));//取消第一次到 welcome/index
            exit;
        }else{
            $this->pagedata['adv_item'] = K::M('adv/item')->items(array('adv_id'=>1),array('orderby'=>'asc'),$page,$limit,$count);
            $cate = K::M('shop/cate')->items(array('parent_id'=>0), array(), 1, 7);
            $ptadv= K::M('adv/adv')->adv_by_name('拼团首页图标');
            if($ptadv){
                $ptdetail  = K::M('adv/item')->items_by_adv($ptadv['adv_id']);
            }
            foreach ($ptdetail as $k => $v) {
                if($v['audit'] == 1 && $v['closed'] == 0){
                    if($v['thumb']){
                        $ptphoto = $v['thumb'];
                    }else{
                        $ptphoto = 'photo/201606/20160629_E8C9C0B3C7379E7D1AFFAF3D88FDE439.png';
                    }
                    $_isshow =1;
                    //return $_isshow;
                }
            }
            if($_isshow == 1){
                $pt = array(
                'cate_id'=>0,
                'parent_id'=>0,
                'title'=>'拼团',
                'orderby'=>0,
                'icon'=>$ptphoto,
                'ico'=>$ptphoto,
                'childrens'=>array(),
                'link'=>'/pintuan'
                );
                $cate[] = $pt;
            }
            
            
            $this->pagedata['cate_items'] = $cate;
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