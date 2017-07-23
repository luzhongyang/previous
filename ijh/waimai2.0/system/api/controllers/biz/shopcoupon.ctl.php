<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shopcoupon extends Ctl_Biz
{

    /**
     * waimai2.0  和 shequ 不一样,注意区分功能
     * @param $params
     */
    public function items($params)
    {
        //0 全部 1环境 2商品
        $limit = 10;
		$limit = 500; //先改为一次返回取500个
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id' => $this->shop_id);
        $filter['closed'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        $filter['sku'] = '>:0';
        if(!$items = K::M('shop/coupon')->items($filter, array('coupon_id'=>'ASC'), $page, $limit, $count)){
            $items = array();
        }
        if($coupon_items = K::M('shop/coupon')->items(array('shop_id'=>$this->shop_id,'ltime'=>'>:'.__TIME,'closed'=>0,'sku'=>'>:0'))) {
            foreach($coupon_items as $k=>$v) {
                $coupon_str[] = $v['order_amount'] . ":" . $v['coupon_amount'];
            }
            K::M('shop/shop')->update($this->shop_id, array('coupon'=>implode(',', $coupon_str)));
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'order_amount,coupon_amount,sku,ltime')){
            $this->msgbox->add(L('非法的数据提交'), 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            $data['stime'] = time();
            if($coupon_id = K::M('shop/coupon')->create($data)){
                if($coupon_items = K::M('shop/coupon')->items(array('shop_id'=>$this->shop_id,'ltime'=>'>:'.__TIME,'closed'=>0,'sku'=>'>:0'))) {
                    foreach($coupon_items as $k=>$v) {
                        $coupon_str[] = $v['order_amount'] . ":" . $v['coupon_amount'];
                    }
                    K::M('shop/shop')->update($this->shop_id, array('coupon'=>implode(',', $coupon_str)));
                }
                $this->msgbox->set_data('data', array('coupon_id'=>$coupon_id));
            }
        }
    }

    public function update($params)
    {
        if(!$coupon_id = (int)$params['coupon_id']){
            $this->msgbox->add(L('优惠券信息不存在'), 211);
        }else if(!$data = $this->check_fields($params, 'order_amount,coupon_amount,sku,ltime')){
            $this->msgbox->add(L('非法的数据提交'), 212);
        }else if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add(L('非法的数据提交'), 213);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 214);
        }else {
            if(isset($data['stime'])){
                unset($data['stime']);//取消开始时间更新
            }
            if($detail['picked'] > 0){
                //使用过,无法被删除,只能更新库存
                unset($data['order_amount']);
                unset($data['coupon_amount']);
                unset($data['ltime']);
            }

            if(K::M('shop/coupon')->update($coupon_id, $data)){
                if($coupon_items = K::M('shop/coupon')->items(array('shop_id'=>$this->shop_id,'ltime'=>'>:'.__TIME,'closed'=>0,'sku'=>'>:0'))) {
                    foreach($coupon_items as $k=>$v) {
                        $coupon_str[] = $v['order_amount'] . ":" . $v['coupon_amount'];
                    }
                    K::M('shop/shop')->update($this->shop_id, array('coupon'=>implode(',', $coupon_str)));
                }
                $this->msgbox->set_data('data', array('coupon_id'=>$coupon_id));
            }
        }
    }


    public function delete($params)
    {
        if($coupon_id = (int)$params['coupon_id']){
            if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
                $this->msgbox->add(L('你要删除的优惠不存在或已经删除'), 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }
            else{
                if($detail['picked'] > 0){
                    //使用过,无法被删除,只能更新库存
                    $this->msgbox->add(L('优惠券使用过,无法被删除'), 215);
                }
                else{
                    if(K::M('shop/coupon')->delete($coupon_id)){
                        if($coupon_items = K::M('shop/coupon')->items(array('shop_id'=>$this->shop_id,'ltime'=>'>:'.__TIME,'closed'=>0,'sku'=>'>:0'))) {
                            foreach($coupon_items as $k=>$v) {
                                $coupon_str[] = $v['order_amount'] . ":" . $v['coupon_amount'];
                            }
                            K::M('shop/shop')->update($this->shop_id, array('coupon'=>implode(',', $coupon_str)));
                        }
                        $this->msgbox->add(L('操作成功'));
                    }
                }

            }
        }
        else{
            $this->msgbox->add(L('未指定要删除的优惠ID'), 401);
        }

        $this->msgbox->add('success');

    }


}