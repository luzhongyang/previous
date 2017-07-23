<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Set extends Ctl_Cashier 
{
   

    public function package($params)
    {
        //money:give:jifen,money:give:jifen,
        $this->check_owner();
        $data = $package_data = array();
        if($params['package']){
            foreach(explode(',', $params['package']) as $v){
                list($money, $give, $jifen) = explode(':', $v);
                if(($money = (int)$money) > 0){
                    $give = (float)$give;
                    $jifen = (int)$jifen;
                    $data[$money] = "{$money}:{$give}:{$jifen}";
                    $package_data[$money] = array('money'=>$money, 'give'=>$give, 'jifen'=>$jifen);
                }
            }
        }
        if(K::M('cashier/cashier')->update($this->shop_id, array('package'=>implode(',', $data)), true)){
            $this->msgbox->set_data('data', array('package_data'=>array_values($package_data)));
        }
        
    }

    public function youhui($params)
    {
        //优惠1,优惠2,   10,20,30
        $this->check_owner();
        $youhui_data = $discount_data = array();
        if(isset($params['is_youhui'])){
            $data['is_youhui'] = $params['is_youhui'] ? 1 : 0;
        }
        if(isset($params['youhui'])){
            foreach(explode(',', $params['youhui']) as $youhui){
                if(($youhui = (int)$youhui) > 0){
                    $youhui_data[] = $youhui;
                }
            }
            $data['youhui'] = implode(',', $youhui_data);
        }
        if(isset($params['discount'])){
            foreach(explode(',', $params['discount']) as $discount){
                $discount = (float)$discount;
                if($discount > 0 && $discount < 10){
                    $discount_data[$discount] = $discount;
                }
            }
            $data['discount'] = implode(',', $discount_data);
        }
        if($data){
           K::M('cashier/cashier')->update($this->shop_id, $data, true);
           $this->msgbox->add('success'); 
        }
    }

    public function moling($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'is_moling,moling')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            if(isset($params['is_moling'])){
                $data['is_moling'] = $params['is_moling'] ? 1: 0;
            }
            if(!in_array($data['moling'], array(1,2,3,4))){
                $data['moling'] = 0;
            }
            if(K::M('cashier/cashier')->update($this->shop_id, $data, true)){
                $this->msgbox->add('success');
            }
        }
    }

    public function jifen($params)
    {
        $this->check_owner();
        if(!isset($params['xf_jifen'])){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!preg_match('/^\d+:\d+$/i', $params['xf_jifen'])){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(K::M('cashier/cashier')->update($this->shop_id, array('xf_jifen'=>$params['xf_jifen']), true)){
            $this->msgbox->set_data('data', array('xf_jifen'=>$xf_jifen));
        }
    }

    public function info($params)
    {
        $data = array();
        if($title = $params['title']){
            $data['title'] = $title;
        }
        if($attach = $_FILES['logo']){
            if($attach['error'] == UPLOAD_ERR_OK){
                if($a = K::M('magic/upload')->upload($attach, 'cashier')){
                    $data['logo'] = $a['photo'];
                }
            }
        }
        if(K::M('shop/shop')->update($this->shop_id, $data)){
            $a = array('shop_id'=>$shop_id);
            $a['title'] = $data['title'] ? $data['title'] : $this->shop['title'];
            $a['logo'] = $data['logo'] ? $data['logo'] : $this->shop['logo'];
            $this->msgbox->set_data('data', $a);
        }
    }

    public function verify($params)
    {
        $this->check_owner();
        if($this->shop['verify_name'] == 1){
            $this->msgbox->add('店铺已经通过认证,无需重复提交', 211);
        }else if(!$data = $this->check_fields($params, 'id_name,id_number,id_photo1,id_photo2,id_photo3,mentou_photo,shop_photo1,shop_photo2,shop_photo3')){
            $this->msgbox->add('参数错误', 211);
        }else{
            if($attachs = $_FILES){
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'cashier')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['updatetime'] = __TIME;
            $data['verify'] = 0;
            if(!$detail = K::M('cashier/verify')->detail($this->shop_id)){
                $data['shop_id'] = $this->shop_id;
                if(K::M('cashier/verify')->create($data)){
                    $this->msgbox->add('success');
                }
            }else if(K::M('cashier/verify')->update($this->shop_id, $data)){
                $this->msgbox->add('success');
            }
            K::M('cashier/cashier')->update($this->shop_id, array('verify_name'=>0));
            K::M('system/logs')->log('cashier.set.verify', array($data, $detail,$this->system->db->SQLLOG()));
        }
    }

    public function account($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'account_type,account_number,account_name')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if($account = K::M('shop/account')->detail($this->shop_id)){
            K::M('shop/account')->update($this->shop_id, $data);
        }else{
            $data['shop_id'] = $this->shop_id;
            K::M('shop/account')->create($data);
        }
    }
}