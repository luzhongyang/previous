<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_City extends Ctl_Xiaoqu
{
   public function index($from)
   {    
        if($from){
            $this->pagedata['from'] = $from;
        }
        $city = K::M('data/city')->items();
        $city_list = array();
        foreach($city as $k => $v){
            $city_list[$v['py']][] = $v;
        }
        ksort($city_list);
        $this->pagedata['city_list']= $city_list;
        $this->pagedata['city']= 1;
        $this->tmpl = 'xiaoqu/city.html';
   }
}
