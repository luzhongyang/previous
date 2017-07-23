<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->city_id = $this->system->cookie->get('UxCityId');//获取当前城市ID
        $this->xiaoqu_id = $this->system->cookie->get('UxXiaoquId');//获取当前小区ID
        $this->yezhu_id = $this->system->cookie->get('UxYezhuId');//获取当前业主ID
        if($xiaoqu = K::M('xiaoqu/xiaoqu')->detail($this->xiaoqu_id)){
            $xiaoqu['wuye'] = K::M('xiaoqu/wuye')->detail($xiaoqu['wuye_id']);
            $this->xiaoqu = $xiaoqu;
        }
        
    }

}
