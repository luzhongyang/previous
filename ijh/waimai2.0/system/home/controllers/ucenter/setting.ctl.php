<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Setting extends Ctl_Ucenter 
{
	public function index() {
		$this->check_login();
        $this->tmpl = "ucenter/setting/index.html";
		
	}
    
    public function suggestion()
    {
        $this->check_login();
        if($data = $_POST) {
            $data['uid'] = $this->uid;
            if($photo1 = $_FILES['photo1']){
                if($a1 = K::M('magic/upload')->upload($photo1)){
                    $photo[] = $a1['photo'];
                    $data['pic1'] = $a1['photo'];
                }
            }
            
            if($photo2 = $_FILES['photo2']){
                if($a2 = K::M('magic/upload')->upload($photo2)){
                    $photo[] = $a2['photo'];
                    $data['pic2'] = $a2['photo'];
                }
            }
            
            if($photo3 = $_FILES['photo3']){
                if($a3 = K::M('magic/upload')->upload($photo3)){
                    $photo[] = $a3['photo'];
                    $data['pic3'] = $a3['photo'];
                }
            }
            
            if($photo4 = $_FILES['photo4']){
                if($a4 = K::M('magic/upload')->upload($photo4)){
                    $photo[] = $a4['photo'];
                    $data['pic4'] = $a4['photo'];
                }
            }
            $time = __TIME - 86400;  // 上一次提交时间+24小时 > 当前时间
            $clientip = __IP;
            if(1 <= K::M('member/suggestion')->count("client_ip='{$clientip}' AND create_time>$time")){
                $this->msgbox->add('同一IP24小时只能提交一次',212)->response();
            }
            if(K::M('member/suggestion')->create($data)){
                $this->msgbox->add('提交成功');
                $this->msgbox->set_data('forward',$this->mklink('ucenter/setting:index'));
            }else{
                $this->msgbox->add('提交失败',212);
            }
        }else {
            // if(K::M('member/suggestion')->find(array('uid'=>$this->uid))) {
            //     $this->msgbox->add('您已经反馈过了',210);
            //     $this->msgbox->set_data('forward',$this->mklink('ucenter/setting:index'));
            // }else {
                $this->tmpl = "ucenter/setting/suggestion.html";
            // }
        }
    }
}