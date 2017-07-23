<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Collect extends Mdl_Table
{

    protected $_table = 'pintuan_collect';

    protected $_pk = 'pintuan_collect_id';

    protected $_cols = 'pintuan_collect_id,pintuan_product_id,uid,dateline';

    /**
     * 获取商家html
     * @param type $shop_id
     * @return type
     */
    public function shop_html($shop_id)
    {

        $shop_count = $this->cache->get('pintuan_shop_' . $shop_id);

        if(empty($shop_count) || count($shop_count) < 3){

            $sql = "SELECT count(a.pintuan_collect_id) as count FROM " . $this->table('pintuan_collect') . " a  
                                            left join " . $this->table('pintuan_product') . " b on a.pintuan_product_id = b.pintuan_product_id 
                                            WHERE  b.shop_id  = $shop_id ";//收藏,不判断是否产品上架/删除, b.closed=0 &&  b.is_onsale=1 && 
            $items = array();
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $items[] = $row;
                }
            }
            $choucang = $items[0]['count'];

            $sql = "SELECT count(a.pintuan_product_id) as count FROM " . $this->table('pintuan_product') . " a
                                            WHERE  a.closed=0 &&  a.is_onsale=1 &&   a.shop_id  = $shop_id ";
            $items = array();
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $items[] = $row;
                }
            }
            $chanpin = $items[0]['count'];


            if($choucang <= 0)
                $choucang = 0;
            if($chanpin <= 0)
                $chanpin = 0;
            $shop_count = array(
                'shoucang' => $choucang,
                'chanpin'  => $chanpin,
                'pingjia'  => 0
            );

            $this->cache->set('pintuan_shop_' . $shop_id, $shop_count, 10000);
        }
        //追加上shop_name信息.
        $arr_shop = K::M('shop/shop')->find(array('shop_id' => $shop_id));
        $shop_count['title'] = $arr_shop['title'];
        $shop_count['logo'] = $arr_shop['logo'];
        $shop_count['info'] = $arr_shop['info'];
        $shop_count['shop_id'] = $arr_shop['shop_id'];
        return $shop_count;
    }

    /**
     * 清理缓存
     */
    public function shop_cache_clear($shop_id)
    {
        $this->cache->set('pintuan_shop_' . $shop_id, '', 0);
    }

}
