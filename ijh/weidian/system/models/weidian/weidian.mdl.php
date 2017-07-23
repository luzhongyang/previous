<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Weidian extends Mdl_Table
{   
  
    protected $_table = 'weidian';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,title,info,phone,logo,is_daofu,is_ziti,online_pay,products,orders,audit,clientip,dateline,min_amount,freight_stage,pei_type,is_local';
    public function detail($shop_id, $closed=false)
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }
        $where ="s.shop_id=w.shop_id AND w.shop_id=".$shop_id;
        if(empty($closed)){
            $where .= " AND s.closed='0'";
        }
        $sql = "SELECT s.*, w.* FROM ".$this->table('shop').' s, '.$this->table($this->_table)." w WHERE {$where}";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }
    protected function _format_row($row)
    {
        static $_cfg = null;
        if($_cfg === null){
            $_cfg = K::$system->config->get('weidian');
        }
        $row['url'] = 'http://wd'.$row['shop_id'].'.'.$_cfg['domain'];

        //处理freight_stage取最小值
        if($row['freight_stage'] = unserialize($row['freight_stage'])){
            foreach($row['freight_stage'] as $fk => $fv){
                $new_arr[$fv['fm']] = $fv['fm'];
            }
            ksort($new_arr);
            $row['freight_price'] = array_shift($new_arr);
            if(!$row['freight_price']){
                $row['freight_price'] = 0;
            }
            //处理freight_stage取最小值结束            
        }else{
            $row['freight_stage'] = array();
            $row['freight_price'] = 0;
        }
        return $row;
    }

    public function update_pei_distance($shop_id,$arr_fkm)
    {
        $arr_fkm =(int) max($arr_fkm);
        $pei_distance = round($arr_fkm)>0?round($arr_fkm):10;
        $update = array(
            'pei_distance' => $pei_distance
        );
        $is_update = K::M('weidian/weidian')->update($shop_id,$update);
    }
}