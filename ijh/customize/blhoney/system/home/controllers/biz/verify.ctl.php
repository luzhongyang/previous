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
    

    public function index()
    {
        $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
        $this->tmpl = 'biz/verify/index.html';
    }

    public function dianzhu()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'id_name,id_number,id_photo,shop_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if($attach = $_FILES['id_photo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'verify')){
                            $data['id_photo'] = $a['photo'];
                        }
                    }
                }
                if($attachs = $_FILES['shop_photo']){
                    if(UPLOAD_ERR_OK == $attachs['error']){
                        if($aa = K::M('magic/upload')->upload($attachs, 'verify')){
                            $data['shop_photo'] = $aa['photo'];
                        }
                    }
                } 
                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('店主认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('店主认证提交成功');
                }
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'biz/verify/dianzhu.html';
        }       
    }
    
    public function yyzz()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'yz_number,yz_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if($attach = $_FILES['yz_photo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'verify')){
                            $data['yz_photo'] = $a['photo'];
                        }
                    }
                } 
                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('企业认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('企业认证提交成功');
                }
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'biz/verify/yyzz.html';
        }       
    }

    public function canyin()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'cy_number,cy_photo')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if($attach = $_FILES['cy_photo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'verify')){
                            $data['cy_photo'] = $a['photo'];
                        }
                    }
                } 
                if($detail = K::M('shop/verify')->detail($this->shop_id)){
                    K::M('shop/verify')->update($this->shop_id, $data);
                    $this->msgbox->add('餐饮认证提交成功');
                }else{
                    $data['shop_id'] = $this->shop_id;
                    K::M('shop/verify')->create($data);
                    $this->msgbox->add('餐饮认证提交成功');
                }
            }
        }else{
            $this->pagedata['detail'] = K::M('shop/verify')->detail($this->shop_id);
            $this->tmpl = 'biz/verify/canyin.html';
        }
    }
    
    
}