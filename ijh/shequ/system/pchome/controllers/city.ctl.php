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

class Ctl_City extends Ctl
{
    
    public function index()
    {
        $province = K::M('data/province')->items();
        $this->pagedata['province'] = $province;

        //按字母查询城市
        $city = K::M('data/city')->items(array('province_id'=>$this->city['province_id']),array('pinyin'=>'asc'));

        $new_city = array();
        foreach($city as $k => $v){
            $new_city[$v['pinyin']][] = $v;
        }
        $url = $this->request['url'].'/'.$this->request['ctl'];
        $this->pagedata['url'] = $url;

        $this->pagedata['city_list'] = $new_city;
        $this->tmpl = 'pchome/city/index.html';
    }
    
    public function get_city(){
        $province_id = (int)$this->GP('province_id');
        if(!$city = K::M('data/city')->items(array('province_id'=>$province_id))){
            $city = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('city', $city);
        $this->msgbox->response();
    }
   
}