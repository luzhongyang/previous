<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Index extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
    }

    public function index()
    {
        $filter = $pager = $orderby = array();

        //排序
        $orderby['dateline'] = 'DESC';
        $page = max((int)$this->GP('page'), 1);

        $limit = 8;
        $filter['audit'] = 1;
        if($_SERVER['SERVER_NAME'] == 'weidian.o2o.ijh.cc')
        {
            $filter[':SQL'] = "  shop_id in (506294, 506313, 506325, 506280,  506284, 506281 , 506342, 506349)  ";
        }
        if (($page <= 100) && $shop_list = K::M('weidian/weidian')->items($filter, $orderby, 1, $limit, $count)) {
            $items = array();
            foreach ($shop_list as $k => $v) {
//                $shop_list[$k]['url'] = str_replace(__CFG::C_DOMAIN,   '.weidian'.__CFG::C_DOMAIN,  $v['url']);
            }
        } else {
            $this->msgbox->add('暂无开通的微店', 211);
        }

        $this->pagedata['items'] = $shop_list;
        $this->tmpl = 'new_index.html';
    }


    public function get_addr()
    {
        $lat = $this->GP('lat');
        $lng = $this->GP('lng');
        $url = 'http://api.map.baidu.com/geocoder?location=' . $lat . ',' . $lng . '&output=json&pois=1';
        $json = file_get_contents($url);
        $json = json_decode($json, true);
        $addr = $json['result']['addressComponent']['city'];
        $this->msgbox->set_data('addr', $addr);
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