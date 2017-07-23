<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Info extends Ctl_Cashier
{

    public function index($params)
    {
        $shop = $this->filter_fields('shop_id,title,phone,contact,logo,orders,total_money,money,is_youhui,discount,discount_data,youhui,youhui_data,is_moling,moling,moling_label,package,xf_jifen,sign_jifen,verify_name,dateline,url,total_cash,total_alipay,total_wxpay,total_money,total_refund', $this->shop);
        $shop['package_data'] = array_values($this->shop['package_data']);
        $shop['qr_invite_staff'] = $this->shop['url'].'/card/invite';
        $shop['qr_paycode'] = $this->shop['url'].'/trade/payment/maidan';
        $shop['qr_cardurl'] = $this->shop['url'].'/card/index';
        $shop['url_buy_printer'] = 'http://www.jhcms.com/about/contact';
        $shop['url_biz_payee'] = $this->shop['url'].'/cashier/payee';
        $staff = $this->staff;
        if(!$verify_detail = K::M('cashier/verify')->detail($this->shop_id)){
            $verify_detail = array('shop_id'=>0, 'id_name'=>'', 'id_number'=>'', 'verify'=>0);
        }else{
            $verify_detail = $this->check_fields($verify_detail, 'shop_id,id_name,id_number,verify');
            $verify_detail['id_number'] = substr_replace($verify_detail['id_number'], '****', 4, -4);
        }
        $this->msgbox->set_data('data', array('shop_detail'=>$shop, 'staff_detail'=>$staff, 'verify_detail'=>$verify_detail));
    }

	public function verify($params)
    {
        $this->check_owner();
        if(!$detail = K::M('cashier/verify')->detail($this->shop_id)){
            $detail = array('shop_id'=>0, 'id_name'=>'', 'id_number'=>'', 'id_photo1'=>'', 'id_photo2'=>'', 'id_photo3'=>'', 'mentou_photo'=>'', 'shop_photo1'=>'', 'shop_photo2'=>'', 'shop_photo3'=>'', 'verify'=>0);
        }
        $this->msgbox->set_data('data', array('verify_detail'=>$detail));
    }

    public function printer($params)
    {
        if($items = K::M('shop/printer')->items(array('shop_id'=>$this->shop_id))){
            foreach($items as $k=>$v){
                $items[$k] = $this->check_fields($v, 'printer_id,shop_id,title,type');
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data(array('items'=>array_values($items)));
    }

    public function appadv(){
      $list =   $banners  = $advs = array();
        // app 启动时候的广告
        if($adv = K::M('adv/adv')->adv_by_name('APP欢迎页广告')){
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
        if($adv = K::M('adv/adv')->adv_by_name('	APP页面广告')){
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
        $this->msgbox->json();


    /*  $adv_one=K::M('adv/adv')->adv_by_name('APP欢迎页广告');
      $adv_two=K::M('adv/adv')->adv_by_name('APP页面广告');
        $arr = array();
        if($adv_one){
            foreach ($adv_one as $item_one){
                $arr['adv_before'][$item_one['adv_id']] = K::M('adv/item')->items_by_adv($item_one['adv_id']);
            }
        }
        if($adv_two){
            foreach ($adv_two as $item_two){
                $arr['adv_before'][$item_two['adv_id']] = K::M('adv/item')->items_by_adv($item_two['adv_id']);
            }

        }
        var_dump($arr);exit;*/


        

    }

}