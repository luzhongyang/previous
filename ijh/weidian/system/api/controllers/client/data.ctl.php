<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Data extends Ctl
{
     /* 城市列表 */
    public function city($params)
    {
       $city_list = K::M('data/city')->fetch_all();
       if(CLIENT_OS == 'IOS'){
           $list = array();
            foreach($city_list as $k=>$val){
                $list[$val['py']][] = $val;
            }
            ksort($list);
       }
       $this->msgbox->add('success');
       if(CLIENT_OS == 'IOS'){
            $this->msgbox->set_data('data', array('items'=>$list));
       }else{
           $this->msgbox->set_data('data', array('items'=>array_values($city_list)));
       }
    }

    /* App版本 */
    public function version($params)
    {
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('datacity'=>2015117,'shopcate'=>20151127));
    }
    /* 银行列表 */
    public function bank($params)
    {
        $this->msgbox->set_data('data', array('bank_list'=>K::M('data/data')->bank_list()));
        $this->msgbox->add('success');
    }
    /* 首页服务分类 */
    public function cate()
    {
       /* $data = array(
            'waimai'=>'icon/waimai.png',//外卖
            'shangchao'=>'icon/waimai.png',//商超
            'shengxian'=>'icon/waimai.png',//生鲜
            'tuan'=>'icon/waimai.png',//团购
            'weixiu'=>'icon/waimai.png',//维修
            'maidan'=>'icon/waimai.png',//买单
            'paotui'=>'icon/waimai.png',//跑腿
            'xiyi'=>'icon/waimai.png',//洗衣
            'jiazheng'=>'icon/waimai.png',//家政
            'quan'=>'icon/waimai.png'//现金券
        );*/

        $items = K::M('adv/item')->items_by_adv(4);
        foreach($items as $k=>$v) {
            $data[] = $this->filter_fields('item_id,title,link,thumb', $v);
        }
        $this->msgbox->set_data('data', $data);
    }
    /* 搜索商家
     * @param lng
     * @param lat
     * @param title
     * @param page
     */
    public function searchshop($params)
    {
        // 推荐商家列表
        $filter = $orderby = $shop_items = $items = array();
        $u_lng = $params['lng'];
        $u_lat = $params['lat'];
        if(!$u_lng || !$u_lat){
            $this->msgbox->add('经纬度错误',211);
        }else{
            // 搜索商家
            if($title = $params['title']){
                $filter['title'] = "LIKE:%".$title."%";
            }
            // 距离用户5公里范围内周边商户
            $squares = K::M('helper/round')->returnSquarePoint($u_lng, $u_lat, 5);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $page = max((int)$params['page'], 1);
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            if(($page <= 10) && $shop_list = K::M('shop/shop')->items($filter, $orderby, 1, 500, $count)){
                foreach($shop_list as $k=>$val) {
                    $val = $this->filter_fields('shop_id,title,have_waimai,have_tuan,have_quan,have_maidan,lng,lat,score,avg_amount,comments,logo,city_name,cate_title,business_id,area_id', $val);
                    $val['juli'] = K::M('helper/round')->getdistances($val['lng'], $val['lat'], $u_lng, $u_lat);  //计算用户与商家的距离（单位米）
                    $shop_list[$k] = $val;
                }
                uasort($shop_list, array($this, 'juli_order')); // 距离由近到远排序
                $shop_items = array_slice($shop_list, ($page-1)*10, 10, true);
            }else{
                $shop_items = array();
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($shop_items)));
    }
    /**
     * 服务端app检测及安装
     * @return string 网络地址
     */
    public function staff_app()
    {
        $this->msgbox->set_data('url', '11111111111');
    }
    /**
     * 商户端app检测及安装
     * @return string 网络地址
     */
    public function shop_app()
    {
        $this->msgbox->set_data('url', '2222222222222');
    }
}
