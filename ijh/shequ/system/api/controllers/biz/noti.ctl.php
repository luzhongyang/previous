<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Noti extends Ctl_Biz
{
 
    public function get($params)
    {
       if(!$noti = K::M('app/noti')->detail($this->shop_id)){
           $noti = array('shop_id'=>0);
       }       
       $this->msgbox->set_data('data', array('noti'=>$noti));
    }

    public  function set($params)
    {
       if(!$data = $this->check_fields($params, 'order_msg,comment_msg,complaint_msg,system_msg')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            if(!$noti = K::M('app/noti')->detail($this->shop_id)){
                $data['shop_id'] = $this->shop_id;
                if($create = K::M('app/noti')->create($data)){
                    $this->msgbox->add('设置成功');
                }else{
                    $this->msgbox->add('设置失败',300);
                }
            }else{
                //修改
                if($update = K::M('app/noti')->update($this->shop_id, $data)){
                    $this->msgbox->add('设置成功');
                }else{
                    $this->msgbox->add('设置失败',301);
                }
            }
            
        }
    }


}