<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Printer extends Ctl_Biz
{
    

    public function items($params)
    {
        $page = max(intval($params['page']), 1);
        $limit = 10;
        $filter = array('shop_id'=>$this->shop_id);
        $orderby = array('plat_id'=>'desc');
        if(!$items = K::M('shop/print')->items($filter, $orderby, $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function create($params)
    {
        if($data = $this->check_fields($params, 'title,partner,apikey,machine_code,mkey,num,status')){
            $data['shop_id'] = $this->shop_id;
            if($plat_id = K::M('shop/print')->create($data)){
                $this->msgbox->add('添加打印机成功');
                $this->msgbox->set_data('data', array('plat_id'=>$plat_id));
            }
        }else{
            $this->msgbox->add('参数提交错误', 211);
        }   
    }

    public function edit($params)
    {
        if(!$plat_id = (int)$params['plat_id']){
            $this->msgbox->add('参数提交错误', 211);
        }else if(!$detail = K::M('shop/print')->detail($plat_id)){
            $this->msgbox->add('打印机不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if(!$data = $this->check_fields($params, 'title,partner,apikey,machine_code,mkey,num,status')) {
            $this->msgbox->add('非法的数据提交',214);
        }else if(K::M('shop/print')->update($plat_id, $data)){
            $this->msgbox->add('修改打印机配置成功'); 
        }
    }

    public function delete($params)
    {
        if(!$plat_id = (int)$params['plat_id']){
            $this->msgbox->add('参数提交错误', 211);
        }else if(!$detail = K::M('shop/print')->detail($plat_id)){
            $this->msgbox->add('打印机不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if(K::M('shop/print')->delete($plat_id)){
            $this->msgbox->add('删除打印机成功');
        }
    }

    public function setstatus($params)
    {
        $status = $params['status'] ? 1 : 0;
        if(!$plat_id = (int)$params['plat_id']){
            $this->msgbox->add('参数提交错误', 211);
        }else if(!$detail = K::M('shop/print')->detail($plat_id)){
            $this->msgbox->add('打印机不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if(K::M('shop/print')->set_status($this->shop_id, $plat_id, $status)){
            $this->msgbox->add('设置打印机成功');
        }
    }

    public function printorder($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数提交错误', 211);
        }else{
            $num = max((int)$params['num'], 1);
            if(K::M('order/order')->yunprint($order_id, $num)){
                $this->msgbox->set_data('data', array('order_id'=>$order_id, 'num'=>$num));
                $this->msgbox->add("SUCCESS");
            }
        }      
    }
}