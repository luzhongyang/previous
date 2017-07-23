<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Info extends Ctl_Ucenter_Shop
{

    /**
     * 店铺信息
     */
    public function index(){
        //$this->pagedata['']
        $this->tmpl = 'fenxiao/ucenter/shop/info/index.html';
    }

    public function upload_face(){
        if($attach = $_FILES['avatar']){
            $data = array();
            if($a = K::M('magic/upload')->upload($attach, 'car')){
                $data['photo'] = $a['photo'];
            }
            //修改头像
            if($up = K::M('fenxiao/fenxiao')->update(FX_SID,$data)){
                $this->msgbox->add('头像设置成功');
                $this->msgbox->set_data("forward", $this->mklink('ucenter/shop/info:index',null,null,'base'));
            }else{
                $this->msgbox->add('设置失败',211);
            }
        }
    }


    public function set_title(){
        $title = $this->GP('title');
        if(!$title){
            $this->msgbox->add('没有填写店铺名称!',211);
        }else if(strlen($title) > 18){
            $this->msgbox->add('店铺名称过长!',211);
        }else if(!$up = K::M('fenxiao/fenxiao')->update(FX_SID,array('title'=>$title))){
            $this->msgbox->add('设置失败',211);
        }else{
             $this->msgbox->add('店铺名称设置成功');
             $this->msgbox->set_data("forward", $this->mklink('ucenter/shop/info:index',null,null,'base'));
        }
    }
    
    
}
