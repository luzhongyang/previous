<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Ucenter_Service extends Ctl_Weidian
{
	public function index()
	{
		$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
		$this->pagedata['items'] = K::M('article/article')->items(array('from'=>'weidian','closed'=>0));
		$this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
		$this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/service/index.html';  
	}

	public function detail($article_id)
	{
		$this->pagedata['detail'] = K::M('article/article')->detail($article_id);
		$this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/service/detail.html';  
	}
}