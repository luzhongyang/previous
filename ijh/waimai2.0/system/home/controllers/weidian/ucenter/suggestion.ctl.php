<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Ucenter_Suggestion extends Ctl_Weidian
{
	public function index()
	{
		$this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/suggestion/index.html'; 
	}

	public function submit()
	{
		$data['content'] = $this->GP('content');
		$data['uid'] = $this->uid;
		$data['shop_id'] = (int)$_SESSION['WEIDIAN_SHOP_ID'];
		$time = __TIME - 86400;  // 上一次提交时间+24小时 > 当前时间
		$clientip = __IP;
        if(1 <= K::M('member/suggestion')->count("client_ip='{$clientip}' AND create_time>$time")){
            $this->msgbox->add('同一IP24小时只能提交一次',212)->response();
        }
		if(K::M('member/suggestion')->create($data)) {
			$this->msgbox->add('提交成功');
		}else {
			$this->msgbox->add('提交失败',210);
		}
	}
}