<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu extends Ctl
{

    public function index($params)
    {
        //社区按钮 
        //社区轮播
        //社区广告
        //推荐商家
        $this->check_login();
        if(!$yezhu_id = (int) $params['yezhu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您不是该小区的业主', 212);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您不是该小区的业主', 212);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id'])){
            $this->msgbox->add('小区不存在或已经删除', 213);
        }else{
            $items = $news_list = $banner_list = $adv_list = $nav_list = array();
            $filter = array('audit' => 1, 'closed' => 0);
            // {{{####
            $squares = K::M('helper/round')->returnSquarePoint($xiaoqu['lng'], $xiaoqu['lat'], 5); //使用此函数计算得到结果
            $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];
            // ####}}}
            if($items = K::M('waimai/waimai')->items($filter, null, 1, 10, $count)){
                foreach($items as $k=>$v){
                    $v = $this->filter_fields('shop_id,logo,title,addr,orders,score,avg_score,comments,mini_amount,freight,pei_time,youhui_title,online_pay,first_amount,lng,lat', $v);
                    $v['online_pay_title'] = $v['first_amount_title'] = '';
                    if($v['online_pay']){
                        $v['online_pay_title'] = '商户支持在线支付';
                    }
                    if($v['first_amount']){
                        $v['first_amount_title'] = '新用户首单立减￥'.$v['first_amount'];
                    }
                    $v['juli'] = K::M('helper/round')->juli($xiaoqu['lng'], $xiaoqu['lat'], $v['lng'], $v['lat']);
                    $v['juli_label'] = K::M('helper/format')->juli($v['juli']);
                    $items[$k] = $v;
                }
            }
            if($banner_items = K::M('xiaoqu/banner')->items(array('xiaoqu_id'=>$xiaoqu['xiaoqu_id'], 'audit'=>1))){
                foreach($banner_items  as $k=>$v){
                    $banner_list[] = $this->filter_fields('banner_id,xiaoqu_id,title,photo,link', $v);
                }
            }else{
                $banner_list[] = array('banner_id'=>0, 'xiaoqu_id'=>$xiaoqu['xiaoqu_id'], 'title'=>'banner', 'photo'=>'default/xiaoqu_banner.png', 'link'=>'###');
            }
            if($adv = K::M('adv/adv')->adv_by_name('小区首页格子广告')){
                if($adv_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                    $index = 0;
                    $adv_list = array();
                    foreach($adv_items as $k=>$v){
                        $adv_list[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                        if(++$index >= 2){
                            break;
                        }
                    }
                }
            }
            if(!$nav_list = K::M('xiaoqu/nav')->items(array('xiaoqu_id'=>$xiaoqu['xiaoqu_id']), null, 1, 7)){
                $nav_list = array();
            }
            if($news_items = K::M('xiaoqu/news')->items(array('xiaoqu_id'=>$xiaoqu_id, 'from'=>'notice'), null, 1, 3)){
                foreach($news_list as $k=>$v){
                    $link= K::M('helper/link')->mklink('xiaoqu/news:detail', array($v['xiaoqu_id']), null, 'www');
                    $news_list[] = array('news_id'=>$v['news_id'], 'title'=>$v['title'], 'link'=>$link);
                }
            }else{
                $news_list = array();
            }
            $data = array('xiaoqu'=>$xiaoqu, 'yezhu'=>$yezhu, 'items'=>array_values($items));
            $data['banner_list'] = array_values($banner_list);
            $data['adv_list'] = array_values($adv_list);
            $data['news_list'] = array_values($news_list);
            $data['nav_list'] = array_values($nav_list);
            $this->msgbox->set_data('data', $data);
        }
    }

    public function items($params)
    {
        $filter = array('closed' => 0, 'audit' => 1);
        if($city_id = (int) $params['city_id']){
            $filter['city_id'] = $city_id;
        }else if(__LNG && __LAT){
            // {{{####
            $squares = K::M('helper/round')->returnSquarePoint(__LNG, __LAT); //使用此函数计算得到结果
            $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];
            // ####}}}
        }
        if($key = htmlspecialchars($params['key'])){
            $filter['title'] = "LIKE:%{$key}%";
        }
        $page = max((int) $params['page'], 1);
        $limit = 10;
        if(!$items = K::M('xiaoqu/xiaoqu')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items' => array_values($items)));
    }

    public function apply($params)
    {
        $this->check_login();
        if(!$data = $this->check_fields($params, 'city_id,title,contact,mobile')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['uid'] = $this->uid;
            $data['city_id'] = empty($data['city_id']) ? CITY_ID : $data['city_id'];
            if($apply_id = K::M('xiaoqu/apply')->create($data)){
                $this->msgbox->set_data('data', array('apply_id'=>$apply_id));
            }
        }
    }
}
