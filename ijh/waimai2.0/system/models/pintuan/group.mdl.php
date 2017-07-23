<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Pintuan_Group extends Mdl_Table
{

    protected $_table = 'pintuan_group';

    protected $_pk = 'pintuan_group_id';

    protected $_cols = 'pintuan_group_id,city_id,shop_id,group_title,user_num,master_id,start_time,end_time,order_count,order_success_count,order_yongjin_count,pintuan_product_id,status,is_update_price,confirm_time,confirm_reason,money_pre,closed,clientip,dateline';

    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        if($pintuan_group_id = $this->db->insert($this->_table, $data, true)){
            return $pintuan_group_id;
        }
    }

    public $view_params = array(
        'status' => array(
            'default' => 0,
            // 3 团完成,  组团成功后,商家后台点接单, 状态改为 3.
            'select'  => array('0' => '组团中', '1' => '组团成功', '2' => '组团失败', '3' => '团完成'),
        ),
    );

    /**
     * 商家接团status=3,阶梯团7天后,回收预付款给商家
     * 1.阶梯团商家接单的, 防止周期无限大,查7天-14天, 
     * 2.每次处理30条
     */
    public function money_7_days($shop_id = 0)
    {
        $return = "list: ";
        $time_end = time() - 86400 * 7;
        $time_start = time() - 86400 * 14;
        $filter['shop_id'] = $shop_id;
        $sql = "SELECT pintuan_group_id, master_id, FROM_UNIXTIME( end_time ) 
FROM  " . $this->table('pintuan_group') . " 
WHERE status=3 && end_time > $time_start && end_time < $time_end
ORDER BY pintuan_group_id DESC 
LIMIT 0 , 30";
        $ids = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $ids[] = $row['pintuan_group_id'];
            }
        }
        //查出对应pintuan_group_id的所有状态0的订单,进行
        if(count($ids) > 0){
            $ids = implode(",", $ids);
            $sql = "select a.pintuan_group_id, a.is_money_pre, a.money_paid, b.* from 
            " . $this->table('pintuan_order') . "  a ,  " . $this->table('order') . "  b  
                    where a.pintuan_group_id in(" . $ids . ") && a.order_id = b.order_id  && b.order_status = 0
                        limit 30
            ";
            $arr_order = array();
            if($rs = $this->db->Execute($sql)){
                while($v = $rs->fetch()){
                    $arr_order[] = $v;
                    $order_id = $v['order_id'];
                    /*
                     * 未付尾款,将预付款,打入商家账户
                     */
                    if(1 == $v['pay_status'] && 1 == $v['is_money_pre'] && $v['amount'] > $v['money_paid']){
                        //没付尾款的, 7天内可以付款, 否则钱打给商家
                        K::M('order/order')->update($order_id, array('order_status' => -1, 'reason' => '拼团订单超7天未支付尾款,自动取消.', 'lasttime' => __TIME));
                        $return .= " receive: $order_id , ";
                        if($v['money_paid'] > 0){
                            //有预付款,
                            K::M('shop/shop')->update_money($v['shop_id'], $v['money_paid'], sprintf(L('拼团订单超7天未付尾款的预付款入账(GROUP:%s,ID:%s)'), $v['pintuan_group_id'], $order_id));
                            $return .= " money: " . $v['money_paid'] . " , ";
                        }
                        $return .= " | ";
//                    echo 'one time'.'<hr>';
                    }
                }//loop end
            }//fetch end
        }
        return $return;
        //finish
    }

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
            $filter .= " && pintuan_group_id = " . $group_id;
        }
        if($arr_group = K::M('pintuan/group')->select($filter)){
            foreach($arr_group as $k => $v){
                //取消订单等操作...
                if($arr_order = K::M('pintuan/order')->select(array('pintuan_group_id' => $v['pintuan_group_id']))){
                    //order_id  由 0 变为 -1
                    foreach($arr_order as $k2 => $v2){
                        K::M('order/order')->cancel($v2['order_id'], null, 'pintuan', $reason);
                    }
                    $is_update = K::M('pintuan/group')->update($v['pintuan_group_id'], array('status' => 2));
                }
            }
        }

        //多人拼团, 到结算日期后,重新计算多阶梯团价格,
        $filter = '';
        if($group_id > 0){
            $filter = "  a.group_id = " . $group_id . " &&";
        }

        //1天内的,付尾款时间内的
        $end_time = $now - 86400*2;
        $filter .= " a.status in (1,3)  &&  a.is_update_price = 0 && " . $now . " > a.end_time && " . $end_time . " < a.end_time  && b.money_pre>0 ";

        $sql = "select a.*, b.tuan_price from  " . $this->table('pintuan_group') . " a , " . $this->table('pintuan_product') . " b"
                . "   where   {$filter}  &&  a.pintuan_product_id = b.pintuan_product_id";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['pintuan_group_id']] = $row;
            }
        }
        //需要重置价格的订单,
        if(count($items) > 0){
            foreach($items as $k => $v){
                $_tuan_price = K::M('pintuan/productlevel')->level_price($v['pintuan_product_id'], $v['order_success_count']);
//####            $_tuan_price = K::M('pintuan/productlevel')->level_price($v['pintuan_product_id'], 50);//debug要注销掉
                //阶梯团超过第一阶梯更新订单价格
                if($_tuan_price < $v['tuan_price']){
                    echo 'continue......';
                    /**
                     * 更新价格,  order: total_price,  amount
                     *  pintuan_order: product_price,       pintuan_order_product: product_price, amount
                     */
                    if($arr_pintuan_order = K::M('pintuan/order')->select(array('pintuan_group_id' => $v['pintuan_group_id']))){
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
                            K::M('pintuan/order')->update($_order_id, $update_pintuan_order);
                            //更新拼团订单详情
                            $update_pintuan_product = array(
                                'product_price' => $_product_price,
                                'amount'        => $_total,
                            );
                            //查找主键
                            $_arr_order_product = K::M('pintuan/orderproduct')->find(array('order_id' => $_order_id));
                            $is_succ = K::M('pintuan/orderproduct')->update($_arr_order_product['pid'], $update_pintuan_product);
                        }
                    }
                }
                $is_update = K::M('pintuan/group')->update($v['pintuan_group_id'], array('is_update_price' => 1));
            }
        }

//        echo "<Pre>---------11111<hr />";
//        print_r($items);
//        die("</Pre>");
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
            left join " . $this->table('pintuan_order') . " b on a.pintuan_group_id = b.pintuan_group_id 
            left join " . $this->table('pintuan_product') . "   c on a.pintuan_product_id = c.pintuan_product_id
            WHERE {$where}  ORDER BY a.pintuan_group_id DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        return $items; //考虑直接输出html
    }

    public function user_group_list_weidian($uid, $status = 0, $page = 1, $limit = 30)
    {
        $condition_status = " d.from='weidian_pintuan' ";
        if(100 != $status){
            $condition_status .= (1 == $status || 3 == $status) ? " && a.status in (1,3)" : " && a.status in ({$status})";
        }
        $where = $condition_status . "   && b.uid = $uid";
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.*, b.*, c.photo FROM " . $this->table($this->_table) . " a 
            left join " . $this->table('pintuan_order') . " b on a.pintuan_group_id = b.pintuan_group_id
             left join " . $this->table('order') . " d on d.order_id = b.order_id 
            left join " . $this->table('pintuan_product') . "   c on a.pintuan_product_id = c.pintuan_product_id
            WHERE {$where}  ORDER BY a.pintuan_group_id DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $row;
            }
        }
        return $items; //考虑直接输出html
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
        $sql = "SELECT count(a.pintuan_group_id) as count FROM " . $this->table($this->_table) . " a 
            left join " . $this->table('pintuan_order') . " b on a.pintuan_group_id = b.pintuan_group_id 
            left join " . $this->table('pintuan_product') . "   c on a.pintuan_product_id = c.pintuan_product_id
            WHERE {$where}  ORDER BY a.pintuan_group_id DESC ";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        $count = $items[0]['count'];
        return $count; //考虑直接输出html
    }

    public function user_group_count_weidian($uid, $status = 0)
    {
        $condition_status = " d.from='weidian_pintuan' ";
        if(100 != $status){
            $condition_status .= (1 == $status || 3 == $status) ? " && a.status in (1,3)" : " && a.status in ({$status})";
        }
        $where = $condition_status . "   && b.uid = $uid";
        $sql = "SELECT count(a.pintuan_group_id) as count FROM " . $this->table($this->_table) . " a 
            left join " . $this->table('pintuan_order') . " b on a.pintuan_group_id = b.pintuan_group_id 
            left join " . $this->table('order') . " d on d.order_id = b.order_id
            left join " . $this->table('pintuan_product') . "   c on a.pintuan_product_id = c.pintuan_product_id
            WHERE {$where}  ORDER BY a.pintuan_group_id DESC ";
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
     * 团订单统计, 分已完成, 和 进行中, 两种状态
     * @param type $uid
     * @param type $status 0:待处理, 1:已完成( -1, 8),
     * @param type $page 1
     * @param type $limit  30
     */
    public function user_order_list($uid, $status = 0, $page = 1, $limit = 30)
    {
        $status_finish = implode(',', array('-1', '8')); //已完成状态
        $condition_status = ( 1 == $status ) ? " b.order_status in ({$status_finish}) " : " b.order_status not in ({$status_finish})  ";
        $where = "  a.uid = $uid && " . $condition_status . ' && a.product_number > 0';
        $limit = $this->limit($page, $limit);
        $sql = "SELECT a.*, b.order_status, b.pay_status,b.amount, b.shop_id, b.pei_type, b.dateline,  c.product_id  FROM " . $this->table('pintuan_order') . " a 
            left join " . $this->table('order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . " c on a.order_id = c.order_id 
            WHERE {$where}  ORDER BY a.order_id DESC $limit";
//        echo $sql;
        $arr_shop = $arr_product = $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
                $arr_shop[] = $row['shop_id'];
                $arr_product[] = $row['product_id'];
            }
        }
        //单独搜索出,店铺名称, 和 产品图片
        $arr_shop = array_unique($arr_shop);
        $arr_product = array_unique($arr_product);

        $condition = "shop_id in (" . implode(',', $arr_shop) . ")";
        $arr_shop = K::M('shop/shop')->select($condition);

        $condition = "pintuan_product_id in (" . implode(',', $arr_product) . ")";
        $arr_product = K::M('pintuan/product')->select($condition);

        foreach($items as $k => $v){
            $v['shop_name'] = $arr_shop[$v['shop_id']]['title'];
            $v['photo'] = $arr_product[$v['product_id']]['photo'];
            $items[$k] = $v;
        }

        return $items; //考虑直接输出html
    }

    /**
     * 订单统计(团的)
     * @param type $uid
     * @param type $status 0:待处理, 1:已完成( -1, 8),
     * @return type
     */
    public function user_order_count($uid, $status = 0)
    {
        $status_finish = implode(',', array('-1', '8')); //已完成状态
        $condition_status = ( 1 == $status ) ? " b.order_status in ({$status_finish}) " : " b.order_status not in ({$status_finish})  ";
        $where = "  a.uid = $uid && " . $condition_status . ' && a.product_number > 0';
        $limit = $this->limit($page, $limit);
        $sql = "SELECT count(a.order_id) as count  FROM " . $this->table('pintuan_order') . " a 
            left join " . $this->table('order') . " b on a.order_id = b.order_id 
            left join " . $this->table('pintuan_order_product') . " c on a.order_id = c.order_id 
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
     * 自动变更团状态, 每用户支付,触发一下
     * 注意,如果 status  为 3, 可以购买的人,也不能买了,前台注意判断
     */
    public function status_auto_change($group_id)
    {
        return false;
        //自动变更, 成功,失败,组团中,这三种状态
        $arr_group = $this->find(array('pintuan_group_id' => $group_id));
        if($arr_group['order_success_count'] >= $arr_group['user_num']){
            if(0 == $arr_group['status']){
                //人满,立即更新团状态成功,  如果设置了团满允许购买, 也可以接着买, 对业务流程无影响
                $update_data = array('status' => 1);
                $is_update = $this->update($arr_group['pintuan_group_id'], $update_data);
            }
        }
        else{
            $now = time();
            if($arr_group['end_time'] >= $now){
                //超期,为达到组团人数,更新失败
                if(2 != $arr_group['status']){
                    $update_data = array('status' => 2);
                    $is_update = $this->update($arr_group['pintuan_group_id'], $update_data);
                }
            }
        }
    }

    /**
     * 踢走团成员  
     * 1.更新订单状态为  -1 ,已取消,    
     * 2.更新group下单数目,  order_count - 1
     * @param type $uid
     * @param type $group_id
     * @param type $order_id
     */
    public function group_kick($uid, $group_id, $order_id)
    {
        $arr_group = K::M('pintuan/group')->find(array('pintuan_group-id' => $group_id));
        if(0 == $arr_group['status']){
            $arr_order = K::M('order/order')->find(array('order_id' => $order_id));
            if(empty($arr_order)){
                $return['message'] = '参团订单不存在.';
            }
            else if(0 != $arr_order['order_status']){
                $return['message'] = '订单状态不能取消.';
            }
            else{
                $update_order = array(
                    'order_status' => -1
                );
                $is_update = K::M('order/order')->update($order_id, $update_order);

                $update_group = array(
                    'order_count' => $arr_group['order_count'] - 1,
                );
                $is_update_group = K::M('pintuan/group')->update($group_id, $update_group);

                $return['message'] = $is_update . '/' . $is_update_group;
            }
        }
        else{
            $return['message'] = '团状态不是组团中,不能踢人.';
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
        $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));
        $master_id = $arr_group['master_id'];
        $filter = array(
            'pintuan_group_id' => $group_id,
            'uid'              => $master_id,
//            'product_number' => '>:0',
        );
        $arr_order = K::M('pintuan/order')->find($filter);
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
     * 支付成功,更新 成功支付订单数目 order_success_count
     * 支付成功,如果是单人团,user_num = 1, 更新组团成功状态, 其他, user_num = order_success_count 更新成功
     * @param type $order_id
     */
    public function group_success_order($order_id)
    {
        if($arr_order = K::M('pintuan/order')->find(array('order_id' => $order_id))){
            $group_id = $arr_order['pintuan_group_id'];
            $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));
            $new_success = $arr_group['order_success_count'] + 1;
            $update_group = array(
                'order_success_count' => $new_success,
            );
            //成功数,大于或等于团购数,组团成功
            if($new_success >= $arr_group['user_num'] && 0 == $arr_group['status']){
                $update_group['status'] = '1'; //组团成功
            }
            $is_update = K::M('pintuan/group')->update($group_id, $update_group);
        }
    }

    /**
     * 用户取消订单,组团的 订单数目 减 1
     * @param type $order_id
     */
    public function group_cancel_order($order_id)
    {
        if($arr_order = K::M('pintuan/order')->find(array('order_id' => $order_id))){
            $group_id = $arr_order['pintuan_group_id'];
            $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id));
            $update_group = array(
                'order_count' => $arr_group['order_count'] - 1, //总订单不变,成功订单减少
            );
            $is_update = K::M('pintuan/group')->update($group_id, $update_group);
        }
    }

    /**
     * 商户确认拼团时间, 团状态, 
     * a, 由 1 变为 3, 记录时间
     * a, 由 1 变为 2, 记录时间
     * @param type $group_id
     * @param type $status
     * @param type $confirm_reasion
     */
    public function tuan_confirm($group_id, $status = 3, $confirm_reasion = '')
    {
        $update_data = array(
            'status'          => $status,
            'confirm_reasion' => $confirm_reasion
        );
        $is_update = K::M('pintuan/group')->update($group_id, $update_data);
    }

    /**
     * 商户确认后, 支付尾款倒计时, 需要加上,,固定时间还是??
     */

}
