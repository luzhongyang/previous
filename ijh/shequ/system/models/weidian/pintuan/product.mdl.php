<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Pintuan_Product extends Mdl_Table
{
    protected $_table = 'weidian_pintuan_product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,item_limit,tuan_type,user_num,tuan_time,tuan_limit,master_need_buy,money_master,money_pre,address_type';
    
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
    
    public function _detail($product_id){
        if(!$product_id){
            return false;
        }elseif(!$detail = K::M('weidian/product')->detail($product_id)){
            return false;
        }else{
            $_detail = $this->detail($product_id);
            $detail['item_limit'] = $_detail['item_limit'];
            $detail['tuan_type'] = $_detail['tuan_type'];
            $detail['user_num'] = $_detail['user_num'];
            $detail['tuan_time'] = $_detail['tuan_time'];
            $detail['tuan_limit'] = $_detail['tuan_limit'];
            $detail['master_need_buy'] = $_detail['master_need_buy'];
            $detail['money_master'] = $_detail['money_master'];
            $detail['money_pre'] = $_detail['money_pre'];
            $detail['address_type'] = $_detail['address_type'];
        }
        return $detail;
    }

    
}