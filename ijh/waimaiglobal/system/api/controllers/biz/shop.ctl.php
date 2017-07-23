<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop extends Ctl_Biz
{

    public function base($params)
    {
        if(!$data = $this->check_fields($params, 'cate_id,phone,title,addr,lng,lat')){
            $this->err->add(L('非法的数据提交'));
        }else{
            if(($attach = $_FILES['logo']) && ($attach['error'] == UPLOAD_ERR_OK)){
                if($a = K::M('magic/upload')->upload($attach, 'shop')){
                    $data['logo'] = $a['photo'];
                }
            }
            if(K::M('shop/shop')->update($this->shop_id, $data)){
                $this->msgbox->add('success');
            }
        }
    }

    public function yingye($params)
    {
 
        if(isset($params['yy_status'])){
            $data['yy_status'] = $params['yy_status'] ? 1 : 0;
        }
        if(preg_match('/^\d{2}\:\d{2}$/i', $params['stime'])){
            $data['yy_stime'] = $params['stime'];
        }
        if(preg_match('/^\d{2}\:\d{2}$/i', $params['ltime'])){
            $data['yy_ltime'] = $params['ltime'];
        }
        if($data && K::M('shop/shop')->update($this->shop_id, $data)){
            $this->msgbox->add('success');
        }
        
    }

    public function info($params)
    {
        if(!$info = $params['info']){
            $info = '';
        }
        if(K::M('shop/shop')->update($this->shop_id, array('info'=>$info))){
            $this->msgbox->add('success');
        }
    }

    public function pei($params)
    {
        $data = array();
        if(isset($params['min_amount'])){
            $data['min_amount'] = $params['min_amount'] ? (float)$params['min_amount'] : 0;
        }
        if(isset($params['pei_distance'])){ //默认配送3公里
            $data['pei_distance'] = $params['pei_distance'] ? (float)$params['pei_distance'] : 3;
        }
        if(isset($params['freight'])){
            $data['freight'] = $params['freight'] ? (float)$params['freight'] : 0;
        }
        if(isset($params['pei_type'])){
            if(in_array($params['pei_type'], array(0, 1, 2))){
                $data['pei_type'] = $params['pei_type'];
            }
            if($data['pei_type'] > 0 && isset($params['pei_amount'])){
                $data['pei_amount'] = $params['pei_amount'] ? (float)$params['pei_amount'] : 0;
            }
        }else if($this->shop['pei_type']>0 && isset($params['pei_amount'])){
            $data['pei_amount'] = $params['pei_amount'] ? (float)$params['pei_amount'] : 0;
        }
        
        if($data && K::M('shop/shop')->update($this->shop_id, $data)){
            $this->msgbox->add('success');
        }
    }

    public function youhui($params)
    {
        $data = array();
        if(isset($params['online_pay'])){
            $data['online_pay'] = $params['online_pay'] ? 1 : 0;
        }
        if(isset($params['first_amount'])){
            $data['first_amount'] = $params['first_amount'] ? (float)$params['first_amount'] : 0;
        }
        if(isset($params['order_youhui'])){
            $order_youhui = array();
            foreach(explode(',', $params['order_youhui']) as $v){
                if($a = explode(':', $v)){
                    if($a[0] && $a[1]){
                        $order_youhui[$a[0]] = (int)$a[1];
                    }
                }
            }
            K::M('shop/youhui')->update_youhui($this->shop_id, $order_youhui);
        }
        if($data){
            K::M('shop/shop')->update($this->shop_id, $data);
        }
        $this->msgbox->add('success');
    }

    public function account($params)
    {
        $account = K::M('shop/account')->detail($this->shop_id);
        if(!$account_type = $params['account_type']){
            $this->msgbox->add(L('开户行不正确'), 211);
        }else if(!$account_name = $params['account_name']){
            $this->msgbox->add(L('开户人不正确'), 212);
        }else if(!$account_number = $params['account_number']){
            $this->msgbox->add(L('提现帐号不正确'), 212);
        }else{
            $data = array('account_name'=>$account_name, 'account_type'=>$account_type, 'account_number'=>$account_number);
            if($account){
                $ret = K::M('shop/account')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/account')->create($data);
            }
            if($ret){
                $this->msgbox->add('success');
            }
        }
    }

}
