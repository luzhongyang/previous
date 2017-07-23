<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Pintuan_Order extends Mdl_Table
{
    protected $_table = 'weidian_pintuan_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,product_name,product_number,product_price,tuan_time,money_master,money_master_paid,money_master_time,spend_number,freight,spend_status,group_id,uid,is_money_pre,money_need_pay,money_paid';
    
    /**
     * 参团合法性验证,
     * @param type $group_id
     * @return type
     */
    public function check_tuan_join($group_id, $uid)
    {
        $mdllink = K::M('helper/link');
        $return = array('status' => 1, 'message' => null, 'url' => null,);
        if(!isset($uid) || $uid < 1){
            $return['status'] = 2;
            $return['message'] = "请先登录";
            $return['url'] = $mdllink->mklink('/passport/loginout');
        }
        else{
            $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $group_id));
            //增加是否多次购买判断
            $filter = array(
                'uid'              => $uid,
                'group_id' => $group_id
            );
            $arr_order = K::M('weidian/pintuan/order')->find($filter);
            if(!empty($arr_order)){
                $return['status'] = 2;
                $return['message'] = "已经购买过, 点击右上角分享给您的朋友吧!";
                return $return;
            }
            if(empty($arr_group)){
                $return['status'] = 2;
                $return['message'] = "此团不存在.";
                $return['url'] = $mdllink->mklink('weidian/pintuan');
            }
            else{
                $product_id = $arr_group['product_id'];
                $arr_product = K::M('weidian/pintuan/product')->find(array('product_id' => $product_id));
                if(empty($arr_product)){
                    $return['status'] = 2;
                    $return['message'] = "拼团产品不存在.";
                    $return['url'] = $mdllink->mklink('weidian/pintuan');
                }
                else if(1 == $arr_product['tuan_limit'] && 0 != $arr_group['status']){
                    $return['status'] = 2;
                    $return['message'] = "拼团已满, 需重开一团.";
                    $return['url'] = $mdllink->mklink('weidian/pintuan/product', $arr_product['product_id']);
                }
                else{
                    if(1 == $arr_product['tuan_type']){
                        //----------------阶梯团----------------
                        //查询阶梯最高数目,,,,,,,,,,
                        $tuan_max_num = K::M('weidian/pintuan/productlevel')->level_max_num($arr_product['product_id']);
                        if($arr_group['order_count'] >= $tuan_max_num){
                            //order_success_count 修改为 order_count,更加合适
                            //团满状态,在订单生成后进行判断,
                            //代码逻辑,已经在模板中实现,这里只是描述一下
                            if(1 == $arr_product['tuan_limit']){
                                //需要重开一团
                                $return['status'] = 2;
                                $return['message'] = "拼团已满, 需重开一团.";
                                $return['url'] = $mdllink->mklink('weidian/pintuan/product', $arr_product['product_id']);
                            }
                            else{
                                //视情况,以后看是否添加商品库存限制
                                if(3 == $arr_group['status']){
                                    //商家已经提交 组团结束 的请求
                                    $return['status'] = 2;
                                    $return['message'] = "拼团已结束, 需重开一团.";
                                    $return['url'] = $mdllink->mklink('weidian/pintuan/product', 'arg0=' . $arr_product['product_id']);
                                }
                                else{
                                    //团满可以接着继续买,参团
                                    $return['message'] = "无限制的阶梯团, 可以继续购买.";
                                }
                            }
                        }
                        else{
                            //团未满,参团
                            $return['message'] = "阶梯团, 可以继续购买.";
                        }
                        //----------------阶梯团----------------
                    }
                    else{
                        //----------------普通团----------------
                        //团满,查库存
                        $tuan_max_num = $arr_group['user_num'];
                        if($arr_group['order_count'] >= $tuan_max_num){
                            //order_success_count 修改为 order_count,更加合适
                            if(1 == $arr_product['tuan_limit']){
                                //需要重开一团
                                $return['status'] = 2;
                                $return['message'] = "拼团已满, 需重开一团.";
                                $return['url'] = $mdllink->mklink('weidian/pintuan/product', $arr_product['product_id']);
                            }
                            else{
                                //视情况,以后看是否添加商品库存限制
                                if(3 == $arr_group['status']){
                                    //商家已经提交 组团结束 的请求
                                    $return['status'] = 2;
                                    $return['message'] = "拼团已结束, 需重开一团.";
                                    $return['url'] = $mdllink->mklink('weidian/pintuan/product', $arr_product['product_id']);
                                }
                                else{
                                    //团满可以接着继续买,参团
                                    $page['new_tuan'] = '无限制的普通团, 可以参团';
                                }
                            }
                        }
                        else{
                            //团未满,参团
                            $page['new_tuan'] = '普通团, 可以参团';
                        }
                        //----------------普通团----------------
                    }
                }
            }
        }
        return $return;
    }
    /**
     * （拼团用）根据group_id 获取订单和订单产品
     */
    public function order_from_group_id($group_id, $all_user = 0)
    {
        if($all_user > 0){
            $where = '';
        }
        else{
            //踢出的不参与, 改为让他看..
//            $where = " && a.order_status != '-1' ";
        }
        $sql = "SELECT a.*, b.uid, c.product_id, d.nickname, d.face FROM " . $this->table('order') . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('weidian_pintuan_order_product') . "   c on b.order_id = c.order_id
            left join " . $this->table('member') . "   d on b.uid = d.uid
            WHERE b.group_id = '{$group_id}' {$where}  ORDER BY a.order_id asc ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }
    /**
     * 团订单列表, 仅显示金额大于0 的,  组团状态  0: 组团中  1:组团成功  2: 组团失败 3:团完成(商家点结束))
     * @param type $uid
     * @param type $status 0
     * @param type $page 1
     * @param type $limit  30
     */
    public function pintuan_order_list($filter, $page = 1, $limit = 30)
    {
        $where = $this->where_build($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.*, b.product_price,b.product_name, b.order_id FROM " . $this->table('order') . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('weidian_pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY a.order_id DESC $limit ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        $items = K::M('weidian/pintuan/order')->items_build($items);
        return $items; //考虑直接输出html
    }

    public function pintuan_order_list_biz($filter, $page = 1, $limit = 30)
    {
        $where = $filter;
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.lasttime,b.* FROM " . $this->table('order') . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('weidian_pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY a.order_id DESC $limit ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        $items = K::M('weidian/pintuan/order')->items_build($items);
        return $items; //考虑直接输出html
    }
    /**
     * 团订单统计,仅显示金额大于0 的
     * @param type $uid
     * @param type $status
     * @return type
     */
    public function pintuan_order_count($filter)
    {
        $where = $this->where_build($filter);
        $sql = "SELECT count(a.order_id) as count FROM " . $this->table('order') . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('weidian_pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY a.order_id DESC ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        $count = $items[0]['count'];
        return $count; //考虑直接输出html
    }
    public function pintuan_order_count_biz($filter)
    {
        $where = $filter;
        $sql = "SELECT count(a.order_id) as count FROM " . $this->table('order') . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('weidian_pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY a.order_id DESC ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        $count = $items[0]['count'];
        return $count; //考虑直接输出html
    }
    /**
     * 重建查询条件
     * @param type $filter
     */
    public function where_build($filter)
    {
        $where = " 1 ";
        foreach($filter as $k => $v){
            if("a.order_status" != $k){
                $where .= " && {$k} = '{$v}' ";
            }
            else{
                $where .= " &&  {$k}  in ( " . implode(',', $v) . " ) ";
            }
        }
        $where .= "  &&  b.product_number != 0";
        return $where;
    }
    /**
     * 重组 items 数据,
     * @param $items
     */
    public function items_build($items)
    {
        $order_ids = $staff_ids = array();
        foreach($items as $k => $v){
            $items[$k]['js_price'] = $v['money'] + $v['amount'];
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $pintuanorder_arr = K::M('weidian/pintuan/order')->items(array('order_id' => $order_ids));
        $product_arr = K::M('weidian/pintuan/orderproduct')->items(array('order_id' => $order_ids));
        $new_product_arr = array();
        foreach($product_arr as $k => $v){//转一下 key, 给下面用
            $new_product_arr[$v['order_id']] = $v;
        }
        $view_params_group = K::M('weidian/pintuan/group')->view_params;
        foreach($items as $k => $v){
            $items[$k]['arr_order'] = $pintuanorder_arr[$k]; //唯一对应
            $items[$k]['products'][] = $new_product_arr[$k]; //唯一对应
        }
        return $items;
    }
    // 自提订单创建消费码
    public function create_number($order_id)
    {
        do{
            $no = '2' . substr(date('Ymd'), 1, 7) . rand(10000000, 99999999);
            $number = $this->db->GetRow("SELECT spend_number FROM " . $this->table($this->_table) . " WHERE spend_number='{$no}'");
        }
        while($number);
        if(isset($no)){
            $this->update($order_id, array('spend_number' => $no, 'spend_status' => 0));
        }
    }
    /**
     * 订单结算,支付佣金给团长,
     * @param type $order_id
     */
    public function master_money_pay($order_id)
    {
        $arr_pintuan_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id));
        if(!empty($arr_pintuan_order)){
            //需要支付佣金的
            if($arr_pintuan_order['money_master'] > 0){
                $update = array(
                    'money_master_paid' => $arr_pintuan_order['money_master'],
                    'money_master_time' => time(),
                );
                if($is_update = K::M('weidian/pintuan/order')->update($order_id, $update)){
                    $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $arr_pintuan_order['group_id']));
                    K::M('shop/shop')->update_money($arr_group['shop_id'], -$arr_pintuan_order['money_master'], sprintf(L('拼团佣金结算(ID:%s)'), $arr_group['pintuan_group_id']));
                    K::M('member/member')->update_money($arr_group['master_id'], $arr_pintuan_order['money_master'], sprintf(L('拼团佣金商家结算(ID:%s)'), $arr_group['pintuan_group_id']));
                    
                }
            }
        }
    }

    /**
     * @param $order_id
     * @param int $level
     * @return bool
     */
    public function get_payment_amount($order_id, &$level=0)
    {
        if(!$order = K::M('order/order')->detail($order_id)){
            return false;
        }else if($order['pay_status']){
            return false;
        }else if($order['order_status']<0 || $order['order_status']==8){
            return false;
        }else{
            //加入多级别支付....
            $worder = K::M('weidian/order')->detail($order['order_id']);
            if('weidian' == $order['from'] || 'pintuan' == $worder['type'] ){
                $type = 1;
                $arr_p_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order['order_id']));
                if(1 == $arr_p_order['is_money_pre']){
                    if(0 == $arr_p_order['money_paid']){
                        //1.预付款

                        $order['amount'] = $arr_p_order['money_need_pay'];
                        $is_write_log = 1;
                    }
                    elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                        //2.付尾款
                        $order['amount'] = abs(($arr_p_order['product_price']*$arr_p_order['product_number']) - $arr_p_order['money_paid']);
                        $is_write_log = 1;
                    }
                }

            }
            $level = 0;
            $amount = $order['amount'];
        }
        return $amount;
    }

    //返回订单需要退回的金额
    public function get_return_amount($order_id, $order=null)
    {
        $amount = 0;
        if($order === null && !($order = K::M('order/order')->detail($order_id))){
            return false;
        }else if($order['order_status'] < 0 || $order['order_status'] == 8){
            return false;
        }else if($order['pay_status']){
            $amount = $order['amount'] + $order['money'];
        }else{
            $amount = $order['money'];
        }
        return $amount;
    }

    public function return_sku($order_id, $order=null)
    {
        if(empty($order) && !($order = $this->detail($order_id))){
            return false;
        }
        if($produt_list = K::M('weidian/pintuan/orderproduct')->items(array('order_id'=>$order_id))){
            foreach($produt_list as $v){
                if($v['stock_name']){
                    $a = array('sales'=>'`sales`-'.$v['product_number'], 'stock'=>'`stock`+'.$v['product_number']);
                    $arr_stock = K::M('weidian/product/attrstock')->find(array('stock_name'=>$v['stock_name']));
                    K::M('weidian/product/attrstock')->update($arr_stock['attr_stock_id'],  $a, true);
                }
                $b = array('stock'=>'`stock`+'.$v['product_number'], 'sales'=>'`sales`-'.$v['product_number']);
                K::M('weidian/product')->update($v['product_id'], $b, true);
            }
        }
        return true;
    }

    /**
     * 阶梯团,多次支付,重制支付状态
     * @param $order
     */
    public function pay_status_reset($order)
    {
        if($order['from'] == 'weidian'){
            $order_id = $order['order_id'];
            $worder = K::M('weidian/order')->detail($order['order_id']);
            if($worder['type'] == 'pintuan'){
                $arr_p_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order['order_id']));
                if(1 == $arr_p_order['is_money_pre']){
                    if(0 == $arr_p_order['money_paid']){
                        //1.预付款
                        //无需更新状态
                    }elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                        //2.付尾款 //如果商家已经接单,状态更新为1
                        $arr_pintuan_order = K::M('weidian/pintuan/order')->detail($order_id);
                        $arr_pintuan_group = K::M('weidian/pintuan/group')->detail($arr_pintuan_order['group_id']);
                        $_pintuan_update = array();
                        if( 3 == $arr_pintuan_group['status'] ){
                            $_pintuan_update['order_status'] = 1;
                            $_pintuan_update['pay_status'] = 0;
                        }
                        K::M('order/order')->update($order_id, $_pintuan_update);
                    }else{
                        //3.付尾款,多次付款兼容  //如果商家已经接单,状态更新为1
                        $arr_pintuan_order = K::M('weidian/pintuan/order')->detail($order_id);
                        $arr_pintuan_group = K::M('weidian/pintuan/group')->detail($arr_pintuan_order['group_id']);
                        $_pintuan_update = array();
                        if( 3 == $arr_pintuan_group['status'] ){
                            $_pintuan_update['order_status'] = 1;
                            $_pintuan_update['pay_status'] = 0;
                        }
                        K::M('order/order')->update($order_id, $_pintuan_update);
                    }
                }
            }
        }
    }
    
}