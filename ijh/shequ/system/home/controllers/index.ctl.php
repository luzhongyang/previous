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
        if(false && !defined('IS_MOBILE') && !$this->system->cookie->get('is_view')){
            header("Location:".$this->mklink('welcome/index'));
            exit;
        }else{
            if($this->checksubmit()){
                //查询首页推荐商家
                
                $lng = $this->GP('lng');
                $lat = $this->GP('lat');
                if(!$lng || !$lat){
                    $lng = $this->request['UxLocation']['lng'];
                    $lat = $this->request['UxLocation']['lat'];
                } 
                
                if($lng && $lat){
                    
                    $filter = $pager = array();
                    $page = max((int) $this->GP('page'), 1);
                    $filter['audit'] = 1;
                    $filter['closed'] = 0;
                    //使用此函数计算得到结果后，带入sql查询。
                    $site_config = K::M('system/config')->get('site');
                    $squares = K::M('helper/round')->returnSquarePoint($lng, $lat,$site_config['pei_range']);
                    $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                    $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];

                    if($page<=100 && $items = K::M('shop/shop')->items($filter, null, 1, $limit, $count)) {
                        foreach($items as $k => $v){
                            $items[$k]['dateline'] = date('Y-m-d',$v['dateline']);
                            $items[$k]['url'] = $this->mklink('shop/detail', array($v['shop_id']));
                            $items[$k]['juli'] = K::M('helper/round')->juli($v['lng'], $v['lat'], $lng, $lat);
                            $items[$k]['juli_label'] = K::M('helper/format')->juli($items[$k]['juli']);
                            $items[$k]['score'] = ($v['score']/$v['comments']) ? round($v['score']/$v['comments'],2) : 0 ;
                            $items[$k]['verify'] = 0;
                            $ids[$v['shop_id']] = $v['shop_id'];
                            unset($items[$k]['passwd']);
                        }
                        if($shop_verify_items = K::M('shop/verify')->items(array('shop_id'=>$ids))) {
                            foreach($shop_verify_items as $k=>$v) {
                                $items[$v['shop_id']]['verify'] = $v['verify'];
                            }
                        }
                        uasort($items, array($this, 'juli_order'));
                        $shop_list = array_slice($items, ($page-1)*10, 10, true);
                    }else {
                        $shop_list = array();
                    }

                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('items'=>array_values($shop_list)));
                    
                }else{
                    $this->msgbox->add('没有指定经纬度', 211);
                }

            }else{
                $this->tmpl = 'index.html';
            }           
        }
    }

    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }
    
    
    public function get_addr(){
        $lat = $this->GP('lat');
        $lng = $this->GP('lng');
        $url = 'http://api.map.baidu.com/geocoder?location='.$lat.','.$lng.'&output=json&pois=1';
        $json = file_get_contents($url);
        $json = json_decode($json, true);  
        $addr= $json['result']['addressComponent']['city'];
        $this->msgbox->set_data('addr',$addr);
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