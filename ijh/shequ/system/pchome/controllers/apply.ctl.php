<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Apply extends Ctl
{
    public function index($type)
    {
        $site = $this->system->config->get("site");;
        $qrcode = $site['weixinqr'];
        $this->pagedata['qrcode'] = $qrcode;
        if($type == 1){
            $this->tmpl = 'pchome/apply/paotui.html';
        }else if($type == 2){
            $this->tmpl = 'pchome/apply/shop.html';
        }else{
            $this->tmpl = 'pchome/apply/index.html';
        }
    }
}