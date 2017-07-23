<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Productcate extends Mdl_Table
{

    protected $_table = 'pintuan_product_cate';
    protected $_pk = 'pintuan_cate_id';
    protected $_pre_cache_key = 'pintuan-cate-list';
    protected $_cols = 'pintuan_cate_id,parent_id,shop_id,title,icon,orderby,closed,dateline';

    /**
     * 获取分类列表, 
     * @param type $type  0:获取所有  1:获取一级分类
     * @param type $exclude  排除id,  $type = 1时候,此有效
     * @return type
     */
    public function options($type = 0, $exclude = 0)
    {
        $options = array();
        if($items = $this->fetch_all()){
            foreach($items as $k => $v){
                if(1 == $type){
                    if(0 == $v['parent_id'] && $exclude != $v['pintuan_cate_id']){
                        $options[$v['pintuan_cate_id']] = $v['title'];
                    }
                }else{
                    $options[$v['pintuan_cate_id']] = $v['title'];
                }
            }
        }
        return $options;
    }

    /**
     * 分类调用数据,模板视图写法参照, pintuan/product/edit
     * @param type $type
     * @param type $exclude
     * @return string
     */
    public function options_all()
    {
        $options = array();
        if($items = $this->fetch_all()){
            $temp_array = array();
            foreach($items as $k => $v){
                $temp_array[$v['parent_id']][$v['pintuan_cate_id']] = $v;
            }
            //只有二级目录,所以就不用循环其他数组了,仅仅循环 parent_id = 0
            foreach($temp_array[0] as $k => $v){
                $options[$v['pintuan_cate_id']] = $v['title'];
                if(isset($temp_array[$v['pintuan_cate_id']])){
                    foreach($temp_array[$v['pintuan_cate_id']] as $t_k => $t_v){
                        $pre_letter = '|--';
                        $options[$t_v['pintuan_cate_id']] = $pre_letter . $t_v['title'];
                    }
                }
            }
        }

        return $options;
    }

}
