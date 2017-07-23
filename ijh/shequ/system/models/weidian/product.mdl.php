<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Product extends Mdl_Table
{
    protected $_table = 'weidian_product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,shop_id,cate_id,title,type,photo,price,wei_price,price_level_1,price_level_2,price_level_3,intro,sales,stock,is_onsale,closed,dateline,clientip,orderby,ship_fee,is_fenxiao,price_type';

    public function total_sale($shop_id){
        $sql = "SELECT sum(sales) FROM ".$this->table($this->_table)." where shop_id = ".$shop_id;
        $items = array();
        if($rs = $this->db->Execute($sql)){
            $row = $rs->fetch();
        }
        return $row['sum(sales)'];
    }
    
    public $view_params = array(
        'tuan_type'       => array(
            'default' => 0,
            'select'  => array('0' => '普通团', '1' => '阶梯团')
        ),
        'tuan_limit'      => array(
            'default' => 1,
            'select'  => array('0' => '否, 团满继续购买', '1' => '是, 团满需新开一团'),
        ),
        'master_is_free'  => array(
            'default' => 0,
            'select'  => array('0' => '不免单', '1' => '团长免单'),
        ),
        'master_need_buy' => array(
            'default' => 0,
            'select'  => array('0' => '无需购买', '1' => '需购买产品才能开团')
        ),
        'address_type'    => array(
            'default' => 0,
            'select'  => array('0' => '二者皆可', '1' => '仅配送', '2' => '仅自提'),
        ),
        'closed'          => array(
            'default' => 0,
            'select'  => array('0' => '待审', '1' => '发布'),
        ),
    );
}