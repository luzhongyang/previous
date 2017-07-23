<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_About extends Ctl_Web
{
   public function index()
   {
       
       
       
   	   $this->tmpl = 'web/about.html';
   }
}
