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
    protected $_cols = 'shop_id,title,info,phone,logo,is_daofu,is_ziti,online_pay,products,orders,audit,clientip,dateline';
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
        if($app = __CFG::$APPS['weidian']){
            $row['url'] = sprintf($app['url'], $row['shop_id']);
        }else{
            $row['url'] = 'http://wd'.$row['shop_id'].'.'.$_cfg['domain'];
        }
        return $row;
    }
}