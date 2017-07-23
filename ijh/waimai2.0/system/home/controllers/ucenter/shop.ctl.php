<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Shop extends Ctl
{

    public function index($page=1)
    {
        if($_POST){
            $cates = K::M('shop/cate')->tree();
            echo json_encode($cates);
            exit;
        }
        $this->tmpl = 'ucenter/shop/index.html';
    }

    public function register()
    {
        if($data = $_POST){
            
            $session =K::M('system/session')->start();
            if(!$mobile = $this->GP('mobile')){
                $this->msgbox->add(L('手机号不正确').$mobile, 211);
            }elseif(!$contact = $this->GP('contact')){
                $this->msgbox->add('联系人不能为空', 211);
            }else if(!$code = $this->GP('yzm')){
                $this->msgbox->add(L('验证码不能为空'), 211);
            }else if($code != $session->get('code_'.$mobile)){
                $this->msgbox->add(L('验证码不正确'), 211);
            }else{
                $cates = explode(' ', $data[cate]);
                
                $cate = K::M('shop/cate')->items(array('title'=>$cates[1]));
                $cate = end($cate);
                $data['cate_id'] = $cate['cate_id'];
                
                if(K::M('shop/shop')->create($data)){
                    $this->msgbox->add('申请成功，等待后台审核');
                }else{
                    $this->msgbox->add('申请失败',212);
                }
            } 
        }else{
            $this->pagedata['cates'] = K::M('shop/cate')->fetch_all();
            $this->tmpl = 'ucenter/shop/register.html';
        }
    }

    // 商家入驻进地图选择地址
    public function map()
    {
        $location['lng'] = $this->request['UxLocation']['lng'];
        $location['lat'] = $this->request['UxLocation']['lat'];
        $this->pagedata['location'] = $location;
        $this->tmpl = 'ucenter/shop/map.html';
    }
    
}
