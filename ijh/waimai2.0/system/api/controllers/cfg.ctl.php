<?php

/**

 * Copy Right IJH.CC

 * Each engineer has a duty to keep the code elegant

 * $Id$

 */

if(!defined('__CORE_DIR')){

    exit("Access Denied");

}

class Ctl_Cfg extends Ctl

{

    public function hotsearch()

    {
       
       $cfg = K::M('system/config')->get('hotsearch');
       $cfg = str_replace("，",',',$cfg['hotsearch']);
       $cfg = explode(",",$cfg);
       $this->msgbox->add('success');
       $this->msgbox->set_data('data', array('cfgs'=>$cfg));

    }

    public function reason(){
        $cfg = K::M('order/order')->get_reason();
        $cfg['waimai'] = array_values($cfg['waimai']);
        $cfg['paotui'] = array_values($cfg['paotui']);
        $cfg['mall'] = array_values($cfg['mall']);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('reason'=>$cfg));
    }
    
    public function comment(){
        $cfg = K::M('order/order')->get_comment();
        $cfg['shop'] = array_values($cfg['shop']);
        $cfg['paotui'] = array_values($cfg['paotui']);
        $cfg['waimai'] = array_values($cfg['waimai']);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('comment'=>$cfg));
    }
    
    public function complaint(){
        $cfg = K::M('order/order')->get_complaint();
        $cfg['shop'] = array_values($cfg['shop']);
        $cfg['staff'] = array_values($cfg['staff']);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('complaint'=>$cfg));
    }



}