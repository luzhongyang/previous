<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Verify extends Ctl_Biz
{

    protected $_allow_fields = 'shop_id,id_name,id_number,id_photo,shop_photo,verify_dianzhu,yz_number,yz_photo,verify_yyzz,cy_number,cy_photo,verify_cy,refuse,verify,verify_time,updatetime';
    
    public function index($params)
    {
        if(!$row = K::M('shop/verify')->detail($this->shop_id)){
            $row = array_fill_keys(explode(',', $this->_allow_fields), '');
            $row['shop_id'] = $this->shop_id;
        }
        $this->msgbox->set_data('data', $row);
        $this->msgbox->add('success');
    }

    // 店主身份认证
    public function dianzhu($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_dianzhua'] == 1){
            $this->msgbox->add(L('店主已经验证过了'), 211);
        }else if($row['shop_id'] && !$row['verify_dianzhua'] && $row['id_number']){
            $this->msgbox->add(L('店主资料待审中，不可更改'), 211);
        }else if(!$id_name = $params['id_name']){
            $this->msgbox->add(L('真实姓名不正确'), 212);
        }else if(!$id_number = K::M('verify/check')->id_number($params['id_number'])){
            $this->msgbox->add(L('身份证号码不正确'), 213);
        }else if((!($attach_id_photo = $_FILES['id_photo']) || $attach_id_photo['error']) && !$row['shop_id']){
            $this->msgbox->add(L('身份证图片不正确'), 214);
        }else if((!($attach_shop_photo = $_FILES['shop_photo']) || $attach_shop_photo['error']) && !$row['shop_id']){
            $this->msgbox->add(L('店铺图片不正确'), 215);
        }else{
            $data = array('id_name'=>$id_name, 'id_number'=>$id_number, 'verify_dianzhu'=>0);
            if($attach_id_photo && ($a = K::M('magic/upload')->upload($attach_id_photo))){
                $data['id_photo'] = $a['photo'];
            }
            if($attach_shop_photo && ($a = K::M('magic/upload')->upload($attach_shop_photo))){
                $data['shop_photo'] = $a['photo'];
            }
            if($row['shop_id']){
                $ret = K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            if($ret){
                $this->msgbox->add('success');
            }
        }
    }

    // 商户营业执照认证
    public function yyzz($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_yyzz'] == 1){
            $this->msgbox->add(L('营业执照已经验证过了'), 211);
        }else if($row['shop_id'] && $row['yz_number'] && !$row['verify_yyzz']){
            $this->msgbox->add(L('营业执照待审中，不可更改'), 211);
        }else if(!$yz_number = $params['yz_number']){
            $this->msgbox->add(L('营业执照号码不正确'), 214);
        }else if((!($attach_yz_photo = $_FILES['yz_photo']) || $attach_yz_photo['error']) && !$row['shop_id']){
            $this->msgbox->add(L('营业执照图片不正确'), 215);
        }else{
            $data = array('yz_number'=>$yz_number, 'verify_yyzz'=>0);
            if($attach_yz_photo && ($a = K::M('magic/upload')->upload($attach_yz_photo))){
                $data['yz_photo'] = $a['photo'];
            }
            if($row['shop_id']){
                $ret = K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            if($ret){
                $this->msgbox->add('success');
            }
        }
    }

    // 餐饮服务许可证认证
    public function canyin($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_cy'] == 1){
            $this->msgbox->add(L('餐饮执照已经验证过了'), 211);
        }else if($row['shop_id'] && !$row['verify_cy'] && $row['cy_number']){
            $this->msgbox->add(L('餐饮执照待审中，不可更改'), 211);
        }else if(!$cy_number = $params['cy_number']){
            $this->msgbox->add(L('餐饮执照号码不正确'), 214);
        }else if((!($attach_cy_photo = $_FILES['cy_photo']) || $attach_cy_photo['error']) && !$row['shop_id']){
            $this->msgbox->add(L('餐饮执照图片不正确'), 215);
        }else{
            $data = array('cy_number'=>$cy_number, 'verify_cy'=>0);
            if($attach_cy_photo && ($a = K::M('magic/upload')->upload($attach_cy_photo))){
                $data['cy_photo'] = $a['photo'];
            }
            if($row['shop_id']){
                $ret = K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            if($ret){
                $this->msgbox->add('success');
            }
        }
    }

}
