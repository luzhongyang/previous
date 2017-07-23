<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Youhui_Youhui extends Ctl_Biz
{

    public function get($params)
    {
        $youhui = K::M('waimai/youhui')->items(array('shop_id'=>$this->shop_id,null,1,500));
        foreach($youhui as $k => $v){
            $youhui[$k] = $this->filter_fields('youhui_id,order_amount,youhui_amount',$v);
        }
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        $waimai = $this->filter_fields('online_pay,is_daofu,is_ziti,first_amount',$waimai);
        $waimai['youhui'] = array_values($youhui);
        $this->msgbox->set_data('data',$waimai);
    }
    

    public function set($params)
    {
        $data = array();
        if(isset($params['online_pay'])){
            $data['online_pay'] = $params['online_pay'] ? 1 : 0;
        }
        if(isset($params['is_daofu'])){
            $data['is_daofu'] = $params['is_daofu'] ? 1 : 0;
        }
        if(isset($params['first_amount'])){
            $data['first_amount'] = $params['first_amount'] ? (float)$params['first_amount'] : 0;
        }
        if(isset($params['is_ziti'])){
            $data['is_ziti'] = $params['is_ziti'] ? 1 : 0;
        }

        if(isset($params['order_youhui'])){
            $order_youhui = array();
            foreach(explode(',', $params['order_youhui']) as $v){
                if($a = explode(':', $v)){
                    if($a[0] && $a[1]){
                        $order_youhui[$a[0]] = (int)$a[1];
                    }
                }
            }
            K::M('waimai/youhui')->update_youhui($this->shop_id, $order_youhui);
        }
        if($data){
            K::M('waimai/waimai')->update($this->shop_id, $data);
        }
        $this->msgbox->add('success');
    }
    

}