<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Gmap extends Ctl
{

    // 根据经纬度获取地址信息接口
    public function geocoder()
    {
        $lat = $this->GP('lat');
        $lng = $this->GP('lng');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key=".__CFG::GMAP_SERVER_KEY;
        $json = file_get_contents($url);
        if($json = json_decode($json, true)){
            $data = array('lat'=>$lat, 'lng'=>$lng, 'addr'=>$json['results'][0]['formatted_address']);
            $this->msgbox->set_data('data', $data);
        }else{
            $this->msgbox->add('error', 211);
        }
        $this->msgbox->json();
    }
    
    // 地址文本搜索接口
    public function search()
    {
        $text = $this->GP('text');
        $limit = (int)$this->GP('limit');
        $limit = $limit ? $limit : 5;
        $text = trim($text);
        $text = str_replace('　', '+', $text); 
        $text = str_replace(' ', '+', $text); 
        $api = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$text.'+in+Italia&key='.__CFG::GMAP_SERVER_KEY.'&language=it';
        $data = array();
        if($ret = K::M('net/http')->get($api)){
            $json = json_decode($ret, true);
            if($json['results']){
                $count = count($json['results']);
                $limit = $count > $limit ? $limit : $count;
                for($i=0; $i<$limit; $i++){
                    $data[] = array('lat'=>$json['results'][$i]['geometry']['location']['lat'], 'lng'=>$json['results'][$i]['geometry']['location']['lng'], 'addr'=>$json['results'][$i]['formatted_address']);
                }
            }
        }
        $this->msgbox->set_data('data', $data);
        $this->msgbox->add('success')->json();
    }
}