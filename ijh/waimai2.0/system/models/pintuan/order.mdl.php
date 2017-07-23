<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Order extends Mdl_Table
{

    protected $_table = 'pintuan_order';

    protected $_pk = 'order_id';

    protected $_cols = 'order_id,product_name,product_number,product_price,tuan_time,money_master,money_master_paid,money_master_time,spend_number,spend_status,freight,pintuan_group_id,uid,is_money_pre,money_need_pay,money_paid';

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

            $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));
            //增加是否多次购买判断
            $filter = array(
                'uid'              => $uid,
                'pintuan_group_id' => $group_id
            );
            $arr_order = K::M('pintuan/order')->find($filter);
            if(!empty($arr_order)){
                $return['status'] = 2;
                $return['message'] = "已经购买过, 点击右上角分享给您的朋友吧!";
                return $return;
            }

            if(empty($arr_group)){
                $return['status'] = 2;
                $return['message'] = "此团不存在.";
                $return['url'] = $mdllink->mklink('/pintuan');
            }
            else{
                $pintuan_product_id = $arr_group['pintuan_product_id'];
                $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
                if(empty($arr_product)){
                    $return['status'] = 2;
                    $return['message'] = "拼团产品不存在.";
                    $return['url'] = $mdllink->mklink('/pintuan');
                }
                else if(1 == $arr_product['tuan_limit'] && 0 != $arr_group['status']){
                    $return['status'] = 2;
                    $return['message'] = "拼团已满, 需重开一团.";
                    $return['url'] = $mdllink->mklink('/pintuan/product', $arr_product['pintuan_product_id']);
                }
                else{
                    if(1 == $arr_product['tuan_type']){
                        //----------------阶梯团----------------
                        //查询阶梯最高数目,,,,,,,,,,
                        $tuan_max_num = K::M('pintuan/productlevel')->level_max_num($arr_product['pintuan_product_id']);
                        if($arr_group['order_count'] >= $tuan_max_num){
                            //order_success_count 修改为 order_count,更加合适
                            //团满状态,在订单生成后进行判断,
                            //代码逻辑,已经在模板中实现,这里只是描述一下
                            if(1 == $arr_product['tuan_limit']){
                                //需要重开一团
                                $return['status'] = 2;
                                $return['message'] = "拼团已满, 需重开一团.";
                                $return['url'] = $mdllink->mklink('/pintuan/product', $arr_product['pintuan_product_id']);
                            }
                            else{
                                //视情况,以后看是否添加商品库存限制
                                if(3 == $arr_group['status']){
                                    //商家已经提交 组团结束 的请求
                                    $return['status'] = 2;
                                    $return['message'] = "拼团已结束, 需重开一团.";
                                    $return['url'] = $mdllink->mklink('/pintuan/product', 'arg0=' . $arr_product['pintuan_product_id']);
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
                                $return['url'] = $mdllink->mklink('/pintuan/product', $arr_product['pintuan_product_id']);
                            }
                            else{
                                //视情况,以后看是否添加商品库存限制
                                if(3 == $arr_group['status']){
                                    //商家已经提交 组团结束 的请求
                                    $return['status'] = 2;
                                    $return['message'] = "拼团已结束, 需重开一团.";
                                    $return['url'] = $mdllink->mklink('/pintuan/product', $arr_product['pintuan_product_id']);
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
     * 根据pintuan_grou_id 获取订单和订单产品
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
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on b.order_id = c.order_id
            left join " . $this->table('member') . "   d on b.uid = d.uid
            WHERE b.pintuan_group_id = '{$group_id}' {$where}  ORDER BY a.order_id asc ";
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
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY a.order_id DESC $limit ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        $items = K::M('pintuan/order')->items_build($items);
        return $items; //考虑直接输出html
    }

    public function pintuan_order_list_biz($filter, $page = 1, $limit = 30)
    {
        $where = $filter;
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.lasttime,b.* FROM " . $this->table('order') . " a 
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on a.order_id = c.order_id
            WHERE {$where}  ORDER BY b.pintuan_group_id DESC $limit ";
//        echo $sql;die;
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        $items = K::M('pintuan/order')->items_build($items);
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
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on a.order_id = c.order_id
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
            left join " . $this->table('pintuan_order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . "   c on a.order_id = c.order_id
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
     * @param type $items
     */
    public function items_build($items)
    {
        $order_ids = $staff_ids = array();
        foreach($items as $k => $v){
            $items[$k]['js_price'] = $v['money'] + $v['amount'];
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $pintuanorder_arr = K::M('pintuan/order')->items(array('order_id' => $order_ids));
        $product_arr = K::M('pintuan/orderproduct')->items(array('order_id' => $order_ids));
        $new_product_arr = array();
        foreach($product_arr as $k => $v){//转一下 key, 给下面用
            $new_product_arr[$v['order_id']] = $v;
        }
        $view_params_group = K::M('pintuan/group')->view_params;
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
        $arr_pintuan_order = K::M('pintuan/order')->find(array('order_id' => $order_id));
        if(!empty($arr_pintuan_order)){
            //需要支付佣金的
            if($arr_pintuan_order['money_master'] > 0){
                $update = array(
                    'money_master_paid' => $arr_pintuan_order['money_master'],
                    'money_master_time' => time(),
                );
                if($is_update = K::M('pintuan/order')->update($order_id, $update)){
                    $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $arr_pintuan_order['pintuan_group_id']));

                    K::M('shop/shop')->update_money($arr_group['shop_id'], -$arr_pintuan_order['money_master'], sprintf(L('拼团佣金结算(ID:%s)'), $arr_group['pintuan_group_id']));
                    K::M('member/member')->update_money($arr_group['master_id'], $arr_pintuan_order['money_master'], sprintf(L('拼团佣金商家结算(ID:%s)'), $arr_group['pintuan_group_id']));
                }
            }
        }
    }

    /**
     * 获取订单id,对应的拼团状态
     */
    public function order_group_status_list($arr_order_id)
    {
        if(count($arr_order_id) > 0){
            $ids = implode(',', $arr_order_id);
        }
        else{
            return array();
        }
        $sql = "SELECT a.order_id, b.end_time,b.status FROM " . $this->table('pintuan_order') . " a 
            , " . $this->table('pintuan_group') . " b 
            WHERE  a.pintuan_group_id = b.pintuan_group_id  &&  a.order_id in ($ids) ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = array(
                    'status' => $row['status'],
                    'end_time' => $row['end_time'],
                );
            }
        }
        return $items; //考虑直接输出html
    }

    protected function _format_row($row)
    {
        if($order = K::M('order/order')->detail($row['order_id'])){
            $row['order_items'] = $order;
            if ($shop = K::M('shop/shop')->detail($order['shop_id'])) {
                $row['shop_items'] = $shop;
            }
        }
        if ($user = K::M('member/member')->detail($row['uid'])) {
            $row['nickname'] = $user['nickname'];
        }
        if ($order_product = K::M('pintuan/orderproduct')->find(array('order_id'=>$row['order_id']))) {
            $row['order_product_items'] = $order_product;
            if ($pintuan_product = K::M('pintuan/product')->detail($order_product['product_id'])) {
                $row['pintuan_product_items'] = $pintuan_product;
            }
        }

        return $row;
    }

}
