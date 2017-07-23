<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Collect extends Ctl
{
    public function pintuan_collect_link(){
        $cfg = $this->system->config->get('attach');
        //各种链接返回
        $link=$this->mklink('ucenter/collect/pin_items.html',null,null,'www');
        $this->msgbox->set_data('data', array('link'=>$link));
    }

    public function items($params)
    {

        $this->check_login();
        $filter = $items = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if($collect_list = K::M('shop/collect')->items($filter, null, 1, $limit,$count)){
            $shop_ids = array();
            foreach($collect_list as $k=>$val){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
            foreach($shop_list as $k=>$val){
                if($val['youhui']){
                    $youhui = unserialize($val['youhui']);
                    $str = L('在线支付');
                    foreach ($youhui as $kk => $v) {
                        $str .= sprintf(L('满%s减%s'), (int) $val['order_amount'], (int) $val['youhui_amount']) . ',';
                    }
                    $shop_list[$k]['youhui'] = substr($str, 0, -1);
                }
                $val['avg_score'] = ($val['score_kouwei'] + $val['score_fuwu'])/2;
                $val['score'] = (round($val['avg_score'] / $val['comments'], 2) >= 5 ? 5 : round($val['avg_score'] / $val['comments'], 2));
                $val['juli'] = K::M('helper/round')->getdistance($val['lng'], $val['lat'], $params['lng'], $params['lat']);
                $shop_list[$k] = $val;
                unset($shop_list[$k]['passwd']);
             }
            $items = array_slice($shop_list,($page-1)*10,10,true);
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
    
    
    public function pintuan($params){
        $this->check_login();
        $filter = $items = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if(!$items = K::M('pintuan/collect')->items($filter, null, $page, 10)){
            $product = array();
        }else{
            $ids = array();
            foreach($items as $k => $v){
                $ids[$v['pintuan_product_id']] = $v['pintuan_product_id'];
            }
            $product = K::M('pintuan/product')->items_by_ids($ids);
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($product)));
    }


    public function add($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add(L('商家不存在'),202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'),203);
        }else if(empty($detail['audit'])) {
            $this->msgbox->add(L('商户审核中'),204);
        }else if($result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add(L('您已经收藏过该商家了'),205);
        }else {
            $data = array('uid'=>$this->uid,'shop_id'=>$shop_id);
            if(K::M('shop/collect')->create($data)){
                $this->msgbox->add('collect success');
            }
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add(L('商家不存在'),202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'),203);
        }else if($detail['audit'] !=1||$detail['closed'] !=0) {
            $this->msgbox->add(L('商家不存在或已被删除'),204);
        }else if(!$result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add(L('您还没有收藏该商家'),205);
        }else {
            if(K::M('shop/collect')->delete('shop_id='.$shop_id.' and uid='.$this->uid)){  //
                $this->msgbox->add('cancel success');
            }

        }
    }
   
    public function pintuan_add($params)
    {
        $this->check_login();
        if(!$pintuan_product_id = (int)$params['pintuan_product_id']) {
            $this->msgbox->add(L('拼团商品不存在'),202);
        }else if(!$detail = K::M('pintuan/product')->detail($pintuan_product_id)){
            $this->msgbox->add(L('拼团商品不存在'),203);
        }else if($detail['closed']) {
            $this->msgbox->add(L('该商品已删除'),204);
        }else if($result = K::M('pintuan/collect')->find(array('uid'=>$this->uid,'pintuan_product_id'=>$pintuan_product_id))){
            $this->msgbox->add(L('您已经收藏过该商品了'),205);
        }else {
            $data = array('uid'=>$this->uid,'pintuan_product_id'=>$pintuan_product_id);
            if(K::M('pintuan/collect')->create($data)){
                $this->msgbox->add('success');
            }
        }
    }

    
    public function pintuan_cancel($params)
    {
        $this->check_login();
        if(!$pintuan_product_id = (int)$params['pintuan_product_id']) {
            $this->msgbox->add(L('拼团商品不存在'),202);
        }else if(!$detail = K::M('pintuan/product')->detail($pintuan_product_id)){
            $this->msgbox->add(L('拼团商品不存在'),203);
        }else if($detail['closed']) {
            $this->msgbox->add(L('该商品已删除'),204);
        }else if(!$result = K::M('pintuan/collect')->find(array('uid'=>$this->uid,'pintuan_product_id'=>$pintuan_product_id))){
            $this->msgbox->add(L('您还没有收藏过该商品'),205);
        }else {
            if(K::M('pintuan/collect')->delete($result['pintuan_collect_id'])){
                $this->msgbox->add('success');
            }
        }
    }



}
