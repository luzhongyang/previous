<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Data extends Ctl
{

    public function city($params)
    {
       $page = max((int)$params['page'], 1);
       if(!$city_list = K::M('data/city')->fetch_all()){
            $city_list = array();
       }
       $this->msgbox->add('success');
       $this->msgbox->set_data('data', array('items'=>$city_list));
    }

    public function bank($params)
    {
        $this->msgbox->set_data('data', array('bank_list'=>K::M('data/data')->bank_list()));
        $this->msgbox->add('success');
    }

    //该接口不加密
    public function appver($params)
    {
        $config = $this->system->config->get('app_download');
//        if($info = $config[strtolower(CLIENT_API)]){
//            $info = array('version'=>'0','force_update'=>'0','apk_url'=>'','ios_url'=>'','apk_download'=>'','intro'=>'');
//        }
        $data = array('error'=>0, 'message'=>'success', 'data'=>$config);
        $jsondaata = K::M('utility/json')->encode($data);
        header("Content-type: application/json");
        echo $jsondaata;
        exit;
    }



    public function cashieradv(){
        $list =   $banners  = $advs = array();
        // app 启动时候的广告
        if($adv = K::M('adv/adv')->adv_by_name('收银APP启动广告')){
            if($banner_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                $banners = array();
                foreach($banner_items as $k=>$v){
                    if($v['audit']){
                        $banners[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                    }
                }
            }
        }
        // app 进入之后的广告
        if($adv = K::M('adv/adv')->adv_by_name('收银APP页面广告')){
            if($adv_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                $index = 0;
                $advs = array();
                foreach($adv_items as $k=>$v){
                    if($v['audit']){
                        if(++$index > 4){
                            break;
                        }
                        $advs[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                    }
                }
            }
        }
        $list['banner'] =$banners;
        $list['adv'] =$advs;
        $this->msgbox->set_data($list);


    }

}
