<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Mall_Order extends Ctl
{
	// 插入兑换记录
	public function create($params) 
	{
        $this->check_login();
        if(!$product_id = (int)$params['product_id']) {
            $this->msgbox->add(L('兑换商品不存在'),202);
        }else if(!$detail = K::M('mall/product')->detail($product_id)) {
            $this->msgbox->add(L('兑换商品不存在'),203);
        }else if(!$product_number = (int)$params['product_number']) {
            $this->msgbox->add(L('兑换数量不正确'),204);
        }else if(!$addr_id = (int)$params['addr_id']){
            $this->msgbox->add(L('兑换地址不存在'),205);
        }else if(!$addr_detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('兑换地址不存在'),206);
        }else if($addr_detail['uid'] != $this->uid){
            $this->msgbox->add(L('兑换地址不正确'),207);
        }else if($this->MEMBER['jifen'] < $detail['jifen']*$product_number){
            $this->msgbox->add(L('积分不足'),208);
        }else{
            $data = array(
                'uid' => $this->uid,
                'product_id' =>$product_id,
                'product_name' =>$detail['title'],
                'product_number' =>$product_number,
                'product_jifen' =>$detail['jifen']*$product_number,
                'contact' =>$addr_detail['contact'],
                'mobile' =>$addr_detail['mobile'],
                'addr' =>$addr_detail['addr'],
            );
            if($order_id = K::M('mall/order')->create($data)){
                K::M('mall/product')->update_count($product_id,'sales',$product_number);
                if(K::M('member/member')->update_account($this->uid,'jifen',-$detail['jifen']*$product_number,$intro=sprintf(L('兑换积分商品%s%s份，扣除积分'), $detail['title'], $product_number))){
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id'=>$order_id));
                }
            }
        }
	}

    // 积分商城订单列表
	public function items($params)
	{
		$this->check_login();
		$filter = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if($items = K::M('mall/order')->items($filter, array('order_id'=>'DESC'), $page, 10, $count)) {
            foreach($items as $k=>$v) {
                $pro_ids[$v['product_id']] = $v['product_id'];
                $items[$k]['photo'] = '';
            }
            if($product_list = K::M('mall/product')->items(array('product_id'=>$pro_ids))) {
                foreach($items as $k=>$v) {
                    if($row = $product_list[$v['product_id']]){
                        $v['photo'] = $row['photo'];
                    }
                    $items[$k] = $v;
                }
            }
        	
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
	}

}