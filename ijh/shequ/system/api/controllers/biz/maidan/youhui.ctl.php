<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Maidan_Youhui extends Ctl_Biz
{
    
    /*优惠买单读取*/
    public function get_youhui()
    {
        if($maidan = K::M('maidan/maidan')->find(array('shop_id'=>$this->shop_id))){
            $maidan['config'] = (array)unserialize($maidan['config']);
            $this->msgbox->set_data('data', array('maidan'=>$maidan)); 
        }
    }
    
    /*优惠买单设置*/
    public function set_youhui($params)
    {
        $maidan = K::M('maidan/maidan')->detail($this->shop_id);
        if(isset($params['max_youhui'])){
            $data = array('max_youhui'=>(int)$params['max_youhui']);
        }
        if(!in_array($data['type'],array(0, 1))){
            $data['type'] = 1;  //0满减、1折扣
        } 
        if($params['type'] == 1){
            $data['type'] = 1;
            if($params['discount'] < 1 || $params['discount'] > 100){
                $this->msgbox->add('折扣范围为1~100', 213)->response();
            }
            $data['discount'] = $params['discount'];
        }else{
            $data['type'] = 0;
            if(!$youhui_str = $params['youhui_str']){
                $this->msgbox->add('没有设置满减优惠', 213)->response();
            }else{
                $config = array();
                foreach(explode(',', $youhui_str) as $k => $v){
                    if($a = explode(':', $v)){
                        if($a[0] && $a[1]){
                            $config[$k][m] = (int)$a[0];
                            $config[$k][d] = (int)$a[1];
                        }
                    }
                }
                $data['config'] = serialize($config);
            }
        }
        if($maidan){
            K::M('maidan/maidan')->update($this->shop_id, $data);
        }else{
            $data['shop_id'] = $this->shop_id;
            K::M('maidan/maidan')->create($data);
        }
    }

}