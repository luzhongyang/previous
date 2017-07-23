<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Pintuan_Group extends Mdl_Table
{
    protected $_table = 'weidian_pintuan_group';
    protected $_pk = 'group_id';
    protected $_cols = 'group_id,city_id,shop_id,group_title,user_num,master_id,start_time,end_time,order_count,order_success_count,order_yongjin_count,product_id,status,is_update_price,confirm_time,confirm_reason,money_pre,tuan_type,closed,clientip,dateline';
    
    
    public $view_params = array(
        'status' => array(
            'default' => 0,
            // 3 团完成,  组团成功后,商家后台点接单, 状态改为 3.
            'select'  => array('0' => '组团中', '1' => '组团成功', '2' => '组团失败', '3' => '团完成'),
        ),
    );
    
    
    /**
     * 考虑计划任务,或登录触发, 功能分2部分
     * 第一部分: 到期自动取消订单
     * 第二部分: 阶梯团,团成功,自动更新订单金额
     * 自动检测,所属用户团的状态,自动更新超出有效期的团,未付款更新为失败
     * @param type $group_id
     */
    public function group_auto_check($group_id = 0)
    {

        $now = time();
        $reason = "组团过期,自动取消订单.";
        $filter = " status = 0 && " . $now . " > end_time ";
        if($group_id > 0){
            $filter .= " && group_id = " . $group_id;
        }
        if($arr_group = K::M('weidian/pintuan/group')->select($filter)){

            foreach($arr_group as $k => $v){
                //取消订单等操作...
                if($arr_order = K::M('weidian/pintuan/order')->select(array('group_id' => $v['group_id']))){
                    //order_id  由 0 变为 -1
                    foreach($arr_order as $k2 => $v2){
                        K::M('order/order')->cancel($v2['order_id'], null, 'weidian', $reason);
                    }
                    $is_update = K::M('weidian/pintuan/group')->update($v['group_id'], array('status' => 2));
                }
            }
        }

        //多人拼团, 到结算日期后,重新计算多阶梯团价格,
        $filter = '';
        if($group_id > 0){
            $filter = "  a.group_id = " . $group_id . " &&";
        }

        //1天内的,付尾款时间内的, 状态 1, 3
        $end_time = $now - 86400*2;
        $filter .= " a.status in (1,3)  &&  a.is_update_price = 0 && " . $now . " > a.end_time && " . $end_time . " < a.end_time  && b.money_need_pay>0 ";
        $sql = "select a.*, b.product_price from  " . $this->table('weidian_pintuan_group') . " a , " . $this->table('weidian_pintuan_order') . " b"
                . "   where   {$filter}  &&  a.group_id = b.group_id";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['group_id']] = $row;
            }
        }

        //需要重置价格的订单,
        if(count($items) > 0){
            foreach($items as $k => $v){
                $_tuan_price = K::M('weidian/pintuan/productlevel')->level_price($v['product_id'], $v['order_success_count']);
//####            $_tuan_price = K::M('pintuan/productlevel')->level_price($v['pintuan_product_id'], 50);//debug要注销掉
                //阶梯团超过第一阶梯更新订单价格

                if($_tuan_price < $v['product_price']){
                    echo 'continue......';
//                    die;
                    /**
                     * 更新价格,  order: total_price,  amount
                     *  pintuan_order: product_price,       pintuan_order_product: product_price, amount
                     */
                    if($arr_pintuan_order = K::M('weidian/pintuan/order')->select(array('group_id' => $v['group_id']))){
                        foreach($arr_pintuan_order as $k2 => $v2){
                            $_feight = $v2['freight'];
                            $_product_price = $_tuan_price; //价格便宜了
                            $_total = $_feight + $_product_price;
                            $_order_id = $v2['order_id'];
                            //更新系统订单
                            //订单效验不能更新total_price 和 amount ,手动写sql
                            $sql = "update " . $this->table('order') . " set `total_price` = '{$_total}', `amount` = '{$_total}' where order_id = '{$_order_id}' "
                                    . " limit 1";
                            $this->db->Execute($sql);
                            //更新拼团订单
                            $update_pintuan_order = array(
                                'product_price' => $_product_price,
                            );
                            K::M('weidian/pintuan/order')->update($_order_id, $update_pintuan_order);
                            //更新拼团订单详情
                            $update_pintuan_product = array(
                                'product_price' => $_product_price,
                                'amount'        => $_total,
                            );
                            //查找主键
                            $_arr_order_product = K::M('weidian/pintuan/orderproduct')->find(array('order_id' => $_order_id));
                            $is_succ = K::M('weidian/pintuan/orderproduct')->update($_arr_order_product['pid'], $update_pintuan_product);
                        }
                    }
                }
                $is_update = K::M('weidian/pintuan/group')->update($v['group_id'], array('is_update_price' => 1));
            }
        }
    }
    
    
    /**
     * 支付成功,更新 成功支付订单数目 order_success_count
     * 支付成功,如果是单人团,user_num = 1, 更新组团成功状态, 其他, user_num = order_success_count 更新成功
     * @param type $order_id
     */
    public function group_success_order($order_id)
    {
        if($arr_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id))){
            $group_id = $arr_order['group_id'];
            $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $group_id));
            $new_success = $arr_group['order_success_count'] + 1;
            $update_group = array(
                'order_success_count' => $new_success,
            );
            //成功数,大于或等于团购数,组团成功
            if($new_success >= $arr_group['user_num'] && 0 == $arr_group['status']){
                $update_group['status'] = '1'; //组团成功
            }
            $is_update = K::M('weidian/pintuan/group')->update($group_id, $update_group);
        }
    }
    
    
    /**
     * 团长知否支付订单
     * @param type $group_id
     * @param type $master_id
     * @return  1/0
     */
    public function master_is_buy($group_id)
    {
        $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $group_id));
        $master_id = $arr_group['master_id'];
        $filter = array(
            'group_id' => $group_id,
            'uid'      => $master_id,
        );
        $arr_order = K::M('weidian/pintuan/order')->find($filter);
        if(!empty($arr_order)){
            if(0 == $arr_order['product_number']){
                //无需购买开团
                $return = 1;
            }
            else{
                $order_order = K::M('order/order')->find(array('order_id' => $arr_order['order_id']));
                if(1 == $order_order['pay_status']){
                    $return = 1;
                }
                else{
                    $return = 0;
                }
            }
        }
        else{
            $return = 0;
        }
        return $return;
    }
    
    /**
     * 团,统计
     * @param type $uid
     * @param type $status
     * @return type
     */
    public function user_group_count($uid, $status = 0)
    {
        if(100 == $status){
            $condition_status = " 1 ";
        }else{
            $condition_status = (1 == $status || 3 == $status) ? "a.status in (1,3)" : "a.status in ({$status})";
        }
        $where = $condition_status . "   && b.uid = $uid";
        $sql = "SELECT count(a.group_id) as count FROM " . $this->table($this->_table) . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.group_id = b.group_id 
            left join " . $this->table('weidian_pintuan_product') . "   c on a.product_id = c.product_id
            WHERE {$where}  ORDER BY a.group_id DESC ";
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
     * 我的团列表,  组团状态  0: 组团中  1:组团成功  2: 组团失败 3:团完成(商家点结束))
     * @param type $uid
     * @param type $status 0
     * @param type $page 1
     * @param type $limit  30
     */
    public function user_group_list($uid, $status = 0, $page = 1, $limit = 30)
    {
        if(100 == $status){
            $condition_status = " 1 ";
        }else{
            $condition_status = (1 == $status || 3 == $status) ? "a.status in (1,3)" : "a.status in ({$status})";
        }
        $where = $condition_status . "   && b.uid = $uid";
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.*, b.*, c.photo FROM " . $this->table($this->_table) . " a 
            left join " . $this->table('weidian_pintuan_order') . " b on a.group_id = b.group_id 
            left join " . $this->table('weidian_pintuan_product') . "   c on a.product_id = c.product_id
            WHERE {$where}  ORDER BY a.group_id DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        return $items; //考虑直接输出html
    }
    
}

