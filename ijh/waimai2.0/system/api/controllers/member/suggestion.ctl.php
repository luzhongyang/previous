<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Suggestion extends Ctl
{

    public function index($params)
    {
        $this->check_login();
        if(!$content = $params['content']){
            $this->msgbox->add(L('内容不能为空'.$content),221);
        }else{
            
            $data = array(
                'uid'=>$this->uid,
                'content'=>$content,
            );

            $pic = '';
            if($attachs = $_FILES){
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'photo')){
                            $pic = $pic.$a['photo'].',';
                        }
                    }
                }
            }
            $data['pic'] = $pic;
            if($sid = K::M('member/suggestion')->create($data)){
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add(L('意见反馈失败'),400);
            }
        }
    }

}