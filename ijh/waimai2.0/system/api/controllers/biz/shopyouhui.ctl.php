<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shopyouhui extends Ctl_Biz
{

    public function get($params)
    {
        $youhui = K::M('shop/youhui')->items(array('shop_id'=>$this->shop_id,null,1,500));
        foreach($youhui as $k => $v){
            $youhui[$k] = $this->filter_fields('youhui_id,order_amount,youhui_amount',$v);
        }
        $waimai = K::M('shop/shop')->detail($this->shop_id);
        $waimai = $this->filter_fields('online_pay,is_daofu,is_ziti,first_amount',$waimai);
        $waimai['youhui'] = array_values($youhui);
        $this->msgbox->set_data('data',$waimai);
    }


    public function set($params)
    {
        $data = array();
        if(isset($params['online_pay'])){
            $data['online_pay'] = $params['online_pay'] ? 1 : 0;
        }
        if(isset($params['is_daofu'])){
            $data['is_daofu'] = $params['is_daofu'] ? 1 : 0;
            //货到付款改为1个按钮,判断
            if(0 == $data['online_pay']){
                $data['is_daofu'] = 1;
            }
            else if(1 == $data['online_pay']){
                $data['is_daofu'] = 0;
            }else{
                $data['is_daofu'] = 1;
            }
        }
        if(isset($params['first_amount'])){
            unset($params['first_amount']);
            //定制,不设置收单优惠
            //$data['first_amount'] = $params['first_amount'] ? (float)$params['first_amount'] : 0;
        }
        if(isset($params['is_ziti'])){
            $data['is_ziti'] = $params['is_ziti'] ? 1 : 0;
        }

        if(isset($params['order_youhui'])){
            $order_youhui = array();
            foreach(explode(',', $params['order_youhui']) as $v){
                if($a = explode(':', $v)){
                    if($a[0] && $a[1]){
                        $order_youhui[(float)$a[0]] = (float)$a[1];
                    }
                }
            }
            K::M('shop/youhui')->update_youhui($this->shop_id, $order_youhui);
        }
        if($data){
            K::M('shop/shop')->update($this->shop_id, $data);
        }
        $this->msgbox->add('success');
    }
    
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
        $filter = array('shop_id'=>$this->shop_id);

        $filter = array('shop_id' => $this->shop_id);
        if(!$items = K::M('shop/youhui')->items($filter, array('youhui_id'=>'ASC'), $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'order_amount,youhui_amount,use_count')){
            $this->msgbox->add(L('非法的数据提交'), 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($youhui_id = K::M('shop/youhui')->create($data)){
                $this->msgbox->set_data('data', array('youhui_id'=>$youhui_id));
            }
        }
    }

    public function update($params)
    {
        if(!$youhui_id = (int)$params['youhui_id']){
            $this->msgbox->add(L('优惠信息不存在'), 211);
        }else if(!$data = $this->check_fields($params, 'youhui_id,order_amount,youhui_amount,use_count')){
            $this->msgbox->add(L('非法的数据提交'), 212);
        }else if(!$cate = K::M('shop/youhui')->detail($youhui_id)){
            $this->msgbox->add(L('非法的数据提交'), 213);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 214);
        }else if(K::M('shop/youhui')->update($youhui_id, $data)){
            $this->msgbox->set_data('data', array('youhui_id'=>$youhui_id));
        }
    }


    public function delete($params)
    {
        if($youhui_id = (int)$params['youhui_id']){
            if(!$detail = K::M('shop/youhui')->detail($youhui_id)){
                $this->msgbox->add(L('你要删除的优惠不存在或已经删除'), 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }
            else{
                if(K::M('shop/youhui')->delete($youhui_id)){
                    K::M('shop/shop')->change_youhui($detail['shop_id']);
                    $this->msgbox->add(L('操作成功'));
                }
            }
        }
        else{
            $this->msgbox->add(L('未指定要删除的优惠ID'), 401);
        }

        $this->msgbox->add('success');

    }


}