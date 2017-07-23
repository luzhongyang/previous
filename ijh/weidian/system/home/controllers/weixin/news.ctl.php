<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixin_News extends Ctl
{
    
    public function index()
    {
        
    }

    public function detail($reply_id)
    {
        if(!$reply_id = (int)$reply_id){
            $this->error(404);
        }else if(!$detail = K::M('weixin/reply')->detail($reply_id)){
            $this->error(404);
        }else if($detail['jumpurl'] && strpos($detail['jumpurl'], 'http') !== false){
            K::M('weixin/reply')->update_count($reply_id, 'views');
            header("Location:".$reply['jumpurl']);
            exit();
        }else{
            K::M('weixin/reply')->update_count($reply_id, 'views');
            $this->pagedata['weixin'] = K::M('weixin/weixin')->detail($detail['shop_id']);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'weixin/news/detail.html';
        }
    }

}