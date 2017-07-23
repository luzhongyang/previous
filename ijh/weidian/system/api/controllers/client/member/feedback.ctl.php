<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_FeedBack extends Ctl
{
    /* 反馈
     * $content, 内容
     */
    public function index($params)
    {
        //$this->check_login();
        if(!$content = $params['content']){
            $this->msgbox->add('反馈内容不能为空', 210);
        }else if(K::M('member/feedback')->create(array('uid'=>$this->uid,'content'=>$content))){
            $this->msgbox->add('反馈成功');
        }else{
            $this->msgbox->add('反馈失败,未知错误',211);
        }
    }
}
