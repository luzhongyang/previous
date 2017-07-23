<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Productlevel extends Mdl_Table
{

    protected $_table = 'pintuan_product_level';
    protected $_pk = 'pintuan_level_id';
    protected $_cols = 'pintuan_level_id,pintuan_product_id,level,user_num,price';

    public function level_html($product_id, $arr_group = array())
    {
        $arr_level = K::M('pintuan/productlevel')->select(array('pintuan_product_id' => $product_id), 'level');
        $level_html = null;
        foreach($arr_level as $k => $v){
            if(!isset($level_on)){
                $level_on = $k;
            }
            if(isset($arr_group)){//参团判断组,否则,默认第一层
                if($arr_group['order_success_count'] >= $v['user_num']){
                    $level_on = $k;
                }
            }
        }
        $arr_level[$level_on]['on'] = 1;

        foreach($arr_level as $k => $v){
            $on_class = 1 == $v['on'] ? " class='on'" : '';
            $level_html .= "
                        <li{$on_class}>{$v['user_num']}人—<span class='colr'>￥{$v['price']}</span>
                            <span class='ts'>当前价格</span>
                        </li>";
        }
        return $level_html;
    }

    /**
     * 获取组团,最大的一组团成员数目, 用于判断阶梯团是否满员
     */
    public function level_max_num($product_id)
    {
        $arr_level = K::M('pintuan/productlevel')->select(array('pintuan_product_id' => $product_id), array('level' => 'desc'));
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
        if($arr_level = K::M('pintuan/productlevel')->select(array('pintuan_product_id' => $product_id), array('level' => 'desc'))){
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
