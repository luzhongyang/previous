<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Productattr extends Mdl_Table
{

    protected $_table = 'pintuan_product_attr';

    protected $_pk = 'pintuan_attr_id';

    protected $_cols = 'pintuan_attr_id,pintuan_product_id,attr_name,attr_value,dateline';

    /**
     * 将购物车提交的产品属性,拼接为字符串,传递到订单生成页面
     */
    public function attr_get_to_string()
    {
        $attr_html = null;
        if(isset($_GET['attr']) && is_array($_GET['attr']) && count($_GET) > 0){
            $i = 0;
            foreach($_GET['attr'] as $k => $v){
                if($i > 0){
                    $attr_html .= ". ";
                }
                $attr_html .= $v;
                $i++;
            }
        }

        return $attr_html;
    }

    public function attr_html($product_id)
    {
        $arr_attr = K::M('pintuan/productattr')->select(array('pintuan_product_id' => $product_id));
        $attr_html = null;
        foreach($arr_attr as $k => $v){
            //属性input data['pintuan_attr_id'] = 名称:值.
            $attr_html .= "
                            <div class='resou-box' style='height:95px;'>
                              <div class='border_t border_b'>
                                <h2>{$v['attr_name']}</h2>
                                <div class='row' >";
            $_tmp = explode(',', $v['attr_value']);
            foreach($_tmp as $kkk => $vvv){
                $vvv = trim($vvv);
                if(strlen($vvv) < 1){
                    continue;
                }
                $attr_html .="
                                  <div class='col-33 resou-name'>{$vvv}<input name='attr[{$v['pintuan_attr_id']}]' value='{$v['attr_name']}:{$vvv}' type='radio' class='guige-xuanze'></div>";
            }
            $attr_html .="
                                </div>
                              </div>
                            </div> ";
        }
        return $attr_html;
    }

}
