<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Photo extends Ctl_Biz
{
 
    public function upload($params)
    {
        if(($attach = $_FILES['photo']) && ($attach['error'] == UPLOAD_ERR_OK)){
            if($a = K::M('magic/upload')->upload($attach, 'shop')){
                $data['photo'] = $a['photo'];
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('photo'=>$a['photo']));
            }else {
                $this->msgbox->add('上传失败',301);
            }
        }else {
            $this->msgbox->add('图片未上传',300);
        }
    }
}