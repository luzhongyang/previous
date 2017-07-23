<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Data extends Ctl
{

    public function city($params)
    {
       $page = max((int)$params['page'], 1);
       if(!$city_list = K::M('data/city')->fetch_all()){
            $city_list = array();
       }
       $this->msgbox->add('success');
       $this->msgbox->set_data('data', array('items'=>array_values($city_list)));
    }

    public function version($params)
    {
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('datacity'=>20160823,'shopcate'=>20160823));
    }

    public function bank($params)
    {
        $this->msgbox->set_data('data', array('bank_list'=>K::M('data/data')->bank_list()));
        $this->msgbox->add('success');
    }

}
