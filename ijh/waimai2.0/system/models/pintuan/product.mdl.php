<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Product extends Mdl_Table
{

    protected $_table = 'pintuan_product';

    protected $_pk = 'pintuan_product_id';

    protected $_cols = 'pintuan_product_id,shop_id,cate_id,title,photo,price,sales,intro,item_limit,tuan_type,user_num,tuan_price,tuan_time,tuan_limit,master_is_free,master_need_buy,money_master,money_pre,address_type,ship_fee,stock,orderby,is_onsale,closed,clientip,dateline';

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

    /**
     * 规则: 选取商家产品,随即排序, 可改为按照产品排序,或先后顺序等.
     * @param type $pintuan_product_id 产品id
     * @param type $is_html 是否为html返回,0:array, 1: html
     * @return type  array | html
     */
    public function relate_pintuan_product($pintuan_product_id, $uid = 0, $is_html = 0)
    {
        //同店铺相关产品

        $mdllink = K::M('helper/link');

        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
        $sql = "select a.*,b.uid from  " . $this->table('pintuan_product') . " a left join " . $this->table('pintuan_collect') . " b on a.pintuan_product_id = b.pintuan_product_id  and b.uid = " . $uid . " where a.shop_id = '{$arr_product['shop_id']}'   order by rand() limit 6";
        $items = array();
        $html = null;
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                //$mdllink->mklink('article:detail', array($row['article_id'], 1), array(), 'www');
                $items[] = $row;
                if(1 == $is_html){
                    $class_name = $row['uid'] > 0 ? "guanzhu iconfont icon-xinshi-copy" : "guanzhu iconfont icon-kongxin";
                    $html .= "<div class='box swiper-slide swiper-slide-next' style='width: 252px; margin-right: 10px;'>
                        <div class='switch'>
                            <div class='img'><a href='" . $mdllink->mklink('pintuan:product', null, array('product_id' => $row['pintuan_product_id']), 'www') . "'><img src='/attachs/{$row['photo']}'>

                                <p>{$row['title']}</p></a>
                        </div>
                            <div class='font_size14'>
                                <div class='fl jiage'>￥{$row['tuan_price']}</div>
                                <div class='fr shoucang'><i num='{$row['pintuan_product_id']}' class='{$class_name}' style=' font-size:1rem; margin-right:0.15rem;'></i>收藏</div>
                            </div>
                        </div>
                    </div>";
                }
            }
        }
        if(1 == $is_html){
            return $html;
        }
        return $items; //考虑直接输出html
    }

    /*
     * 截取字符串显示
     */

    public function intro_short($intro)
    {
        //无法转移&nbsp;实体
        $intro = strip_tags($intro);
        $intro = str_replace("&nbsp;", " ", $intro);
        $intro = html_entity_decode($intro);
        $intro = strip_tags($intro);
        $long = mb_strlen($intro, 'utf-8');
        $leng = 60;
        $intro = mb_substr($intro, 0, $leng, 'utf-8');
        if($long > $leng){
            $intro .= '...';
        }
        return $intro;
    }

}
