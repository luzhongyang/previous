<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Account extends Ctl_Ucenter
{

    /**
     * 账户信息
     */
    public function index()
    {
        $this->tmpl = 'pchome/ucenter/account/index.html';
    }
    
    public function upload_face(){
        $attach = $_FILES['avatar'];
        $data = array();
        
        $data['nickname'] = $this->GP('nickname');
        
        if($a = K::M('magic/upload')->upload($attach,'face')){
            $data['face'] = $a['photo'];
        }
        if($up = K::M('member/member')->update($this->uid,$data)){
            $this->msgbox->add('修改成功');
        }else{
            $this->msgbox->add('修改失败',211);
        }

    }

}
