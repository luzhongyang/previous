<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_Index extends Ctl_Web
{
   public function index()
   {
       $change = $this->GP('change');
       $addr = $this->system->cookie->get('addr');
       if($addr&&empty($change)){
           $this->pagedata['cates'] = K::M('shop/cate')->fetch_all();
           $this->tmpl = 'web/shop.html';
       }else{
           $this->tmpl = 'web/index.html';
       }
   }
}