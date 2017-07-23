<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_ProductCate extends Mdl_Table
{
    protected $_table = 'weidian_product_cate';
    protected $_pk = 'cate_id';
    protected $_pre_cache_key = 'weidian-cate-list';
    protected $_cols = 'cate_id,parent_id,shop_id,title,icon,orderby,dateline';
    
    /**
     * 获取分类列表, 
     * @param type $type  0:获取所有  1:获取一级分类
     * @param type $exclude  排除id,  $type = 1时候,此有效
     * @return type
     */
    public function options($shop_id,$type = 0, $exclude = 0)
    {
        $options = array();
        if($items = $this->items(array('shop_id'=>$shop_id))){
            foreach($items as $k => $v){
                if(1 == $type){
                    if(0 == $v['parent_id'] && $exclude != $v['cate_id']){
                        $options[$v['cate_id']] = $v['title'];
                    }
                }else{
                    $options[$v['cate_id']] = $v['title'];
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
    public function options_all($shop_id)
    {
        $options = array();
        if($items = $this->items(array('shop_id'=>$shop_id))){
            $temp_array = array();
            foreach($items as $k => $v){
                $temp_array[$v['parent_id']][$v['cate_id']] = $v;
            }
            //只有二级目录,所以就不用循环其他数组了,仅仅循环 parent_id = 0
            foreach($temp_array[0] as $k => $v){
                $options[$v['cate_id']] = $v['title'];
                if(isset($temp_array[$v['cate_id']])){
                    foreach($temp_array[$v['cate_id']] as $t_k => $t_v){
                        $pre_letter = '|--';
                        $options[$t_v['cate_id']] = $pre_letter . $t_v['title'];
                    }
                }
            }
        }
        return $options;
    }
    
    public function getChildren($cate_id ,$ty= true) {
        $local = array();
        //暂时 只支持 2级分类
        $detail = $this->detail($cate_id);
        $data = $this->items(array('shop_id'=>$detail['shop_id']));
        if($ty) $local[] = $cate_id;
        foreach ($data as $val) {
            if ($val['parent_id'] == $cate_id) {
                $local[] = $val['cate_id'];
            }
        }
        return $local;
    }
    
    
    public function tree($shop_id)
    {
        $tree = array();
        if($shop_id = (int)$shop_id){
            if($items = $this->items(array('shop_id'=>$shop_id), array('parent_id'=>'ASC', 'orderby'=>'ASC'), 1, 500)){
                foreach($items as $k=>$v){
                    if($v['parent_id'] == 0){
                        $tree[$k] = $v;
                    }else if($v['parent_id'] > 0){
                        $tree[$v['parent_id']]['childrens'][] = $v;
                    }
                }
            }
        }
        return $tree;
    }
    
 
}