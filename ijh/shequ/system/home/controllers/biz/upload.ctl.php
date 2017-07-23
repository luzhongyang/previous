<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Upload extends Ctl_Biz
{
    

    public function photo()
    {
        if(!$attach = $_FILES['imgFile']){
            $this->msgbox->add('上传文件失败', 211);
        }else if(UPLOAD_ERR_OK != $attach['error']){
            $this->msgbox->add('上传文件失败', 212);
        }else if($data = K::M('magic/upload')->upload($attach, 'photo')){
            $cfg = $this->system->config->get('attach');
            $this->msgbox->set_data('photo', $data['photo']);
        }
        $this->msgbox->json();
    }

    public function editor()
    {
        if(!$attach = $_FILES['imgFile']){
            $this->msgbox->add('上传文件失败', 211);
        }else if(UPLOAD_ERR_OK != $attach['error']){
            $this->msgbox->add('上传文件失败', 212);
        }else if($data = K::M('magic/upload')->xheditor($attach)){
            $cfg = $this->system->config->get('attach');
            $this->msgbox->set_data('url', $cfg['attachurl'].'/'.$data['photo'].'?PID'.$data['photo_id']);
        }
        $this->msgbox->json();       
    }
}