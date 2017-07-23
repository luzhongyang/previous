<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Bmap extends Ctl
{

    public function getpois() 
    {
    	$lng = $this->GP('lng');
    	$lat = $this->GP('lat');
    	$url = 'http://api.map.baidu.com/geocoder/v2/?ak=824a595f958e444b737a5bc6325ad44f&location='.$lat.','.$lng.'&output=json&pois=1';
        $json = (array)json_decode(file_get_contents($url), true); 
        $this->msgbox->set_data('data',array_values($json['result']['pois']));
    }

    public function placeapi()
    {
        $key = $this->GP('key');
        $city = $this->GP('cityname');
//        $url = 'http://api.map.baidu.com/place/v2/search?ak=824a595f958e444b737a5bc6325ad44f&output=json&query='.$key.'&page_size=10&page_num=0&scope=1&region='.$city;
        $url = 'http://api.map.baidu.com/place/search?ak=824a595f958e444b737a5bc6325ad44f&query='.$key.'&radius=3000&output=json&region='.$city;
        $json = (array)json_decode(file_get_contents($url), true);  
        $this->msgbox->set_data('data',array_values($json['results']));
    }
}