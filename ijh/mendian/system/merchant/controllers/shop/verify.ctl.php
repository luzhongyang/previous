<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Verify extends Ctl
{
    

    public function index()
    {
        $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
        $this->tmpl = 'merchant:shop/verify/index.html';
    }

    public function dianzhu()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'id_name,id_number,id_photo,shop_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(!$data['id_name']) {
                    $this->msgbox->add('请输入真实姓名',212)->response();
                }
                if(!$data['id_number']) {
                    $this->msgbox->add('请输入身份证号码',213)->response();
                }
                if(!$data['id_photo']) {
                    $this->msgbox->add('请上传身份证正面照',212)->response();
                }
                if(!$data['shop_photo']) {
                    $this->msgbox->add('请上传店面图',213)->response();
                }
                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    if($detail['verify_dianzhu'] == 1 && $detail['verify_yyzz'] == 1 && $detail['verify_cy'] == 1 && $detail['verify'] == 1) {
                        $this->msgbox->add('您的店铺已经认证通过了',210)->response();
                    }
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('店主认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('店主认证提交成功');
                }
                K::M('shop/verify')->update($this->shop_id,array('verify'=>0));
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/verify/dianzhu.html';
        }       
    }
    
    public function yyzz()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'yz_number,yz_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(!$data['yz_number']) {
                    $this->msgbox->add('请输入营业执照注册号',212)->response();
                }
                if(!$data['yz_photo']) {
                    $this->msgbox->add('请上传营业执照图片',213)->response();
                }

                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    if($detail['verify_dianzhu'] == 1 && $detail['verify_yyzz'] == 1 && $detail['verify_cy'] == 1 && $detail['verify'] == 1) {
                        $this->msgbox->add('您的店铺已经认证通过了',210)->response();
                    }
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('企业认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('企业认证提交成功');
                }
                K::M('shop/verify')->update($this->shop_id,array('verify'=>0));
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/verify/yyzz.html';
        }       
    }

    public function canyin()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'cy_number,cy_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(!$data['cy_number']) {
                    $this->msgbox->add('请输入营业许可证编号',212)->response();
                }
                if(!$data['cy_photo']) {
                    $this->msgbox->add('请上传营业许可证图片',213)->response();
                }
                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    if($detail['verify_dianzhu'] == 1 && $detail['verify_yyzz'] == 1 && $detail['verify_cy'] == 1 && $detail['verify'] == 1) {
                        $this->msgbox->add('您的店铺已经认证通过了',210)->response();
                    }
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('餐饮认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('餐饮认证提交成功');
                }
                K::M('shop/verify')->update($this->shop_id,array('verify'=>0));
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/verify/canyin.html';
        }
    }
    
    
}