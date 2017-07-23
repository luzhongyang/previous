<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Freight_Freight extends Ctl_Biz
{
    
    public function get(){
        if(!$waimai = K::M('waimai/waimai')->detail($this->shop_id)){
           $waimai = array('shop_id'=>0);
        }else{
           $waimai = $this->filter_fields('min_amount,pei_distance,freight_stage,pei_type',$waimai);
        }
        $this->msgbox->set_data('data',$waimai);
    }

    
    public function set($params)
    {
        $data = array();
        if(isset($params['min_amount'])){   //起送价
            $data['min_amount'] = $params['min_amount'] ? (float)$params['min_amount'] : 0;
        }
        if(isset($params['pei_distance'])){ //配送距离默认3公里
            $data['pei_distance'] = $params['pei_distance'] ? (float)$params['pei_distance'] : 3;
        }

        $data['fkm'] = $params['fkm'];
        $data['fm'] = $params['fm'];
        $data['sm'] = $params['sm'];
        $data['fkm'] = explode(',',$data['fkm']);
        $data['fm'] = explode(',',$data['fm']);
        $data['sm'] = explode(',',$data['sm']);
        if(count($data['fkm']) > 0 && count($data['fm']) > 0 && count($data['sm']) > 0){
            $freight_stage = array();
            foreach($data['fkm'] as $k => $v){
                $freight_stage[$k]['fkm'] = intval($v);
                $freight_stage[$k]['fm'] = intval($data['fm'][$k]);
                $freight_stage[$k]['sm'] = intval($data['sm'][$k]);
                if(!$data['fkm'][$k] || !$data['sm'][$k]){
                   unset($freight_stage[$k]['fkm']);
                   unset($freight_stage[$k]['fm']);
                   unset($freight_stage[$k]['sm']);
                }
            }
        }
        foreach($freight_stage as $key => $val){
            if(!$val){
                unset($freight_stage[$key]);
            }
        }
        $data['freight_stage'] = serialize($freight_stage);

        if(isset($params['pei_type'])){
            if(in_array($params['pei_type'], array(0, 1, 2))){
                $data['pei_type'] = $params['pei_type'];
            }
            if($data['pei_type'] > 0 && isset($params['pei_amount'])){   //pei_amount 商家付给配送员的费用
                $data['pei_amount'] = $params['pei_amount'] ? (float)$params['pei_amount'] : 0;
            }
        }else if($this->shop['pei_type']>0 && isset($params['pei_amount'])){
            $data['pei_amount'] = $params['pei_amount'] ? (float)$params['pei_amount'] : 0;
        }
        unset($data['fkm']);unset($data['fm']);unset($data['sm']);
        if($data && K::M('waimai/waimai')->update($this->shop_id, $data)){
            K::M('waimai/waimai')->update_pei_distance($this->shop_id,$data['fkm']);
            $this->msgbox->add('设置成功');
        }else{
            $this->msgbox->add('设置失败',300);
        }
    }

}