<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Pintuan_ProductLevel extends Mdl_Table
{
    protected $_table = 'weidian_pintuan_product_level';
    protected $_pk = 'level_id';
    protected $_cols = 'level_id,product_id,level,user_num,price';
    
    
    /**
     * 获取组团,最大的一组团成员数目, 用于判断阶梯团是否满员
     */
    public function level_max_num($product_id)
    {
        $arr_level = K::M('weidian/pintuan/productlevel')->select(array('product_id' => $product_id), array('level' => 'desc'));
        $max_num = 0;
        foreach($arr_level as $k => $v){
            $max_num = $v['user_num'];
            break;
        }
        return $max_num;
    }
    /**
     * 拼团,购买人数对应价格
     * @param type $num
     */
    public function level_price($product_id, $num)
    {
        $level_price = 0;
        if($arr_level = K::M('weidian/pintuan/productlevel')->select(array('product_id' => $product_id), array('level' => 'desc'))){
            foreach($arr_level as $k => $v){
                if($num >= $v['user_num']){
                    $level_price = $v['price'];
                    break;
                }
            }
        }
        return $level_price;
    }
    
}