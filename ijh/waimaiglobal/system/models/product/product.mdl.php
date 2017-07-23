<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Product_Product extends Mdl_Table
{   
  
    protected $_table = 'product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,shop_id,cate_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,orderby,closed,clientip,dateline';
    protected $_orderby = array('orderby'=>'ASC', 'sales'=>'DESC', 'product_id'=>'DESC');
    protected $_pre_cache_key = 'product-cate-list';

    public function options()
    {
        $options = array();
        if($items = $this->fetch_all()){
            foreach($items as $k=>$v){
                $options[$k] = $v['title'];
            }
        }
        return $options;
    }
    
    protected function _format_row($row)
    {
        if(!$row['photo']){
            $row['photo'] = 'default/product.png';
        }
        return $row;
    }

    public function count_sales($shop_id, $between) {
        $table1 =  $this->table('product_cate');
        $table2 =  $this->table($this->_table);
        $sql = "SELECT a.cate_id,a.title,SUM(`sales`) as sale_cnt FROM {$table1} as a LEFT JOIN {$table2} b ON(a.cate_id=b.cate_id) WHERE a.shop_id={$shop_id} AND (b.dateline {$between}) GROUP BY a.cate_id"; 
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }
}