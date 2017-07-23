<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Order extends Mdl_Table
{

    protected $_table = 'order';

    protected $_pk = 'order_id';

    protected $_cols = 'order_id,city_id,shop_id,staff_id,uid,from,order_status,online_pay,pay_status,total_price,hongbao_id,hongbao,coupon_id,coupon,order_youhui,first_youhui,money,amount,contact,mobile,addr,house,lng,lat,o_lng,o_lat,pei_time,intro,pay_code,pay_time,pay_ip,pei_type,pei_amount,comment_status,cui_time,order_from,day,jd_time,ziti_time,clientip,lasttime,dateline,closed,reason';

    protected $_orderby = array('order_id' => 'DESC');

    public $view_params = array(
        'order_status' => array(
            'default' => 0,
            'select'  => array(
                '-1' => '已取消',
                '0'  => '未处理',
                '1'  => '已接单',
                '2'  => '配货中',
                '3'  => '配货开始',
                '4'  => '配送完成',
                '8'  => '订单完成',
            )
        )
    );

    public function create($data, $checked = false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['lasttime'] = $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        $data['day'] = date('Ymd', $data['dateline']);
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }

    // 支付成功
    /**
     * 支付chengg
     * @param type $order_id
     * @param type $trade
     * @return boolean
     * @author wushouhuan
     */
    public function set_payed($order_id, $trade = array())
    {
        if(!$order = $this->detail($order_id)){
            return false;
        }
        else{
            if($res = $this->db->update($this->_table, array('pay_status' => 1, 'pay_code' => $trade['code']), "order_id='{$order_id}'", true) ){
                $a = array('online_pay' => 1, 'pay_ip' => __IP, 'pay_time' => __TIME, 'lasttime' => time(), 'pay_code' => $trade['code']);
                $this->update($order_id, $a, true);

                // 订单支付成功,用户订单量、商户订单量更新
                K::M('member/member')->update_count($order['uid'],'orders',1);
                K::M('shop/shop')->update_count($order['shop_id'],'orders',1);

                K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'payment', 'log' => L('订单支付成功'), 'type' => 2));
                if(in_array($order['from'], array('waimai', 'weidian_waimai'))){
                    if($order['pei_type'] == 3){ // 自提订单 创建消费码
                        K::M('waimai/order')->create_number($order_id);
                        $addr = '客户自提';
                    }
                    else{
                        $addr = $order['addr'] . $order['house'];
                    }
                    $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                    $content = sprintf("您有新的外卖订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                    $jiguang_result = K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
                    //$jiguang_result = json_encode($jiguang_result).__FILE__.__LINE__;
                    //K::M('system/logs')->log('0920waimai',$order['shop_id'].'|'.$jiguang_result.'---'.$title.'---'.$content.'||||');
                    // 更新外卖商品库、销量
                    $waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id']));
                    foreach($waimai_order_product as $k=>$val) {
                        K::M('waimai/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        if($val['spec_id']){
                            K::M('waimai/productspec')->update_count($val['spec_id'], 'sale_count', $val['product_number']);
                            K::M('waimai/productspec')->update_count($val['spec_id'], 'sale_sku', -$val['product_number']);
                        }else{
                            K::M('waimai/product')->update_count($val['product_id'], 'sale_count', $val['product_number']);
                            K::M('waimai/product')->update_count($val['product_id'], 'stock', -$val['product_number']);
                        }
                    } 
                }else if($order['from'] == 'pintuan' || $order['from'] == 'weidian_pintuan'){
                    //预付款模式,将 pay_status = 1 更新为 0,
                    $pintuan_order = K::M('pintuan/order')->find(array('order_id' => $order_id));
                    if(0 == $pintuan_order['is_money_pre'] ||
                            (1 == $pintuan_order['is_money_pre'] && $pintuan_order['money_paid'] >= $order['amount'] )){
                        if($order['pei_type'] == 3){
                            K::M('pintuan/order')->create_number($order_id);
                        }
                    }
                    if(1 == $pintuan_order['is_money_pre']){
                        //money_paid,支付金额累加日志
                        $arr_log = K::M('payment/log')->find(array('order_id' => $order_id), array('log_id' => 'DESC'));
                        $total_pay_money = $pintuan_order['money_paid'] + $arr_log['amount'];
                        $arr_p_order = K::M('pintuan/order')->update($order_id, array('money_paid' => $total_pay_money));
                    }
                    //支付成功,更新 成功支付订单数目 order_success_count
                    K::M('pintuan/group')->group_success_order($order_id);
                    $title = sprintf("您有新的拼团订单(单号：%s)", $order_id);
                    $content = sprintf("您有新的拼团订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                    $jiguang_result = K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
                }else if($order['from'] == 'mall') {
                    // 商城订单支付成功更新库存、销量
                    if($mall_order_items = K::M('mall/order')->items(array('order_id'=>$order['order_id']))) {
                        foreach($mall_order_items as $k=>$v) {
                             K::M('mall/product')->update_count($v['product_id'], 'sku', -$v['product_number']);
                            K::M('mall/product')->update_count($v['product_id'], 'sales', $v['product_number']);
                        }  
                    }
                }

                if($m = K::M('member/member')->detail($order['uid'])){
                    if($wx_openid = $m['wx_openid']){
                        $this->payed_wxmsg($wx_openid, $order);
                    }
                }

                return $res;
            }
            else{
                return false;
            }
        }
    }

    public function set_reward_payed($log, $trade = array())
    {  //小费or打赏
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }
        else{
            if($order['order_status'] == 8){
                $type = 1;
                $money_name = '打赏';
            }
            else{
                $type = 0;
                $money_name = '小费';
            }
            if($trade['code'] == 'money'){
                $logmsg = $money_name . '支付成功';
            }
            else{
                $logmsg = $money_name . '支付成功';
            }

            if($res = K::M('paotui/reward')->create(array('order_id' => $order['order_id'], 'order_status' => $order['order_status'], 'type' => $type, 'amount' => $log['amount']))){
                //附表金额要增加
                $up_reward = K::M('paotui/order')->update_count($order['order_id'], 'reward_amount', $log['amount']);
                K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'payment', 'log' => $logmsg, 'status' => $order['order_status']));

                // 如果是打赏，则直接结算打赏金额给服务人员
                if($order['order_status'] == 8 && $type == 1) {
                    if($p_order_reward = K::M('paotui/reward')->find(array('order_id'=>$order_id,'order_status'=>8,'type'=>1))) {
                        $_reward_amount = $p_order_reward['amount'];
                        if($_reward_amount) {
                            $staff_jiesuan_log = sprintf(L('订单服务完成打赏结算(ID:%s)'), $order_id);
                            K::M('staff/staff')->update_money($order['staff_id'], $_reward_amount, $staff_jiesuan_log);
                        }
                    }
                }
                
                return true;
            }
            else{
                return false;
            }
        }
    }

    //确认订单 ，结算订单
    public function confirm($order_id = null, $order = null, $from = 'member')
    {
        $order_id = (int) $order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }
        else if(in_array($order['order_status'], array(3, 4))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            $order_id = $order['order_id'];
            if($this->update($order_id, array('order_status' => 8), true)){
                $staff_amount = $shop_amount = 0;
                if($order['online_pay']){
                    if($order['pei_type'] && $order['staff_id']){
                        if($order['pei_type'] == 2){//代购订单，全部结算给配送员
                            $staff_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                            $log = sprintf(L('订单代购完成结算(ID:%s)'), $order_id);
                        }
                        else{
                            $staff_amount = $order['pei_amount'];
                            $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'] - $staff_amount;
                            $log = sprintf(L('订单配送完成结算(ID:%s)'), $order_id);
                        }
                        if($staff_amount){
                            K::M('staff/staff')->update_money($order['staff_id'], $staff_amount, $log);
                        }
                    }
                    else{
                        $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                    }
                    //增加first_amount, 客户定制小鱼网,  first_youhui  返给商家,
                    //$shop_amount = $shop_amount + $order['first_youhui'];
                    // 订单结算金额给商户
                    if($shop_amount){
                        K::M('shop/shop')->update_money($order['shop_id'], $shop_amount, sprintf(L('订单完成结算(ID:%s)'), $order_id));
                    }
                    // 首单奖励发放
                    $cfg = K::$system->config->get('invite');
                    if(($invite_order_money = (float) $cfg['invite_order_money']) > 0){
                        if(K::M('order/order')->count(array('uid' => $order['uid'], 'order_status' => 8)) === 1){
                            if($m = K::M('member/member')->detail($order['uid'])){
                                if(preg_match('/M(\d+)/i', $m['pmid'], $a)){
                                    if($pm = K::M('member/member')->detail((int) $a[1])){
                                        K::M('member/member')->update_money($pm['uid'], $invite_order_money, sprintf(L('邀请用户(%s)首单奖励:￥%s'), $m['nickname'], $invite_order_money));
                                    }
                                }
                            }
                        }
                    }

                    // 跑腿订单结算给骑手
                    if($order['from'] == 'paotui') {
                        if($order['staff_id'] > 0) {
                            $paotui_order = K::M('paotui/order')->detail($order['order_id']);
                            // 结算起步价
                            if($paotui_order['paotui_amount'] === $order['pei_amount']) {
                                $staff_jiesuan_amount = $order['pei_amount'];
                                if($staff_jiesuan_amount) {
                                    $staff_jiesuan_log = sprintf(L('订单服务完成结算(ID:%s)'), $order_id);
                                    K::M('staff/staff')->update_money($order['staff_id'], $staff_jiesuan_amount, $staff_jiesuan_log);
                                }
                            }  
                            // 查找小费记录结算给服务人员
                            if($p_order_reward_items = K::M('paotui/reward')->items(array('type'=>0,'order_id'=>$order_id))) {
                                $_reward_amount = 0;
                                foreach ($p_order_reward_items as $k=>$v) {
                                    $_reward_amount += $v['amount'];
                                }
                                if($_reward_amount) {
                                    $staff_jiesuan_log = sprintf(L('订单服务完成小费结算(ID:%s)'), $order_id);
                                    K::M('staff/staff')->update_money($order['staff_id'], $_reward_amount, $staff_jiesuan_log);
                                }
                            }
                        }
                    }
                }
                if($from == 'admin'){
                    $log = L('管理员确认订单完成');
                }
                else if($from == 'system'){
                    $log = L('超过3小时系统自动确认订单完成');
                }
                else if($from == 'shop'){

                    $log = L('商家确认订单完成');
                }
                else if($from == 'pintuan'){
                    $log = L('商家确认拼团完成');
                }
                else{
                    $log = L('用户确认订单完成');
                }
                // 拼团订单发放佣金,
                if( 'pintuan' == $order['from']  ||   'weidian_pintuan' == $order['from']   ){
                    K::M('pintuan/order')->master_money_pay($order_id);
                }
                //自提订单核销
                if($order['pei_type'] == 3){
                    K::M('waimai/order')->update($order['order_id'], array('spend_status' => 1));
                    $log = '商家核销成功完成订单';
                }
                K::M('order/log')->create(array('order_id' => $order_id, 'type' => 6, 'from' => $from, 'log' => $log));
                return true;
            }
        }
        return false;
    }

    //取消/退单 退回余额+在线支付金额到余额，退回红包
    public function cancel($order_id = null, $order = null, $from = 'member', $reason = null)
    {
        $order_id = (int) $order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }
        else if(in_array($order['order_status'], array(0, 1, 2, 3, 4, 5))){
            //-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            if($from == 'member' && $order['order_status'] == 1){//用户可以在未接单时直接退单
                $this->msgbox->add(L('商家已接单不可取消'), 451);
                return false;
            }
            if($this->update($order['order_id'], array('order_status' => -1, 'reason' => $reason))){
                $money = $order['money'];
                if($order['pay_status']){
                    if($order['from'] == 'paotui'){
                        $money += $order['pei_amount'];
                    }else{
                        $money += $order['amount'];
                    }
                    // 订单取消,用户订单量、商户订单量回退
                    K::M('member/member')->update_count($order['uid'],'orders',-1);
                    K::M('shop/shop')->update_count($order['shop_id'],'orders',-1);
                }
                if($money > 0){ //退回到余额
                    K::M('member/member')->update_money($order['uid'], $money, sprintf(L('订单(ID:%s)取消退回到余额'), $order['order_id']));
                }
                

                if($order['from'] == 'paotui'){
                    if($reward = K::M('paotui/reward')->items(array('order_id' => $order['order_id']))){
                        $reward_money = 0;
                        foreach($reward as $k => $v){
                            $reward_money +=$v['amount'];
                        }
                    }
                }else if($order['from'] == 'mall') {  
                    // 商城订单 退回积分 退回库存、销量
                    $mall_total_jifen = 0;
                    if($mall_order_items = K::M('mall/order')->items(array('order_id'=>$order['order_id']))) {
                        foreach($mall_order_items as $k=>$v) {
                            $mall_total_jifen += $v['product_jifen']*$v['product_number'];
                            K::M('mall/product')->update_count($v['product_id'], 'sku', $v['product_number']);
                            K::M('mall/product')->update_count($v['product_id'], 'sales', -$v['product_number']);
                        }
                        K::M('member/member')->update_count($order['uid'], 'jifen', $mall_total_jifen);
                        K::M('member/log')->log($order['uid'], 'jifen', $mall_total_jifen, sprintf(L('商城订单(ID:%s)取消退回到积分'), $order['order_id']), $from);
                    }
                }else if(in_array($order['from'], array('waimai', 'weidian_waimai'))) {
                    // 外卖订单 退回外卖商品库存、销量
                    $waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id']));
                    foreach($waimai_order_product as $k=>$val) {
                        K::M('waimai/product')->update_count($val['product_id'], 'sales', -$val['product_number']);
                        if($val['spec_id']){
                            K::M('waimai/productspec')->update_count($val['spec_id'], 'sale_count', -$val['product_number']);
                            K::M('waimai/productspec')->update_count($val['spec_id'], 'sale_sku', $val['product_number']);
                        }else{
                            K::M('waimai/product')->update_count($val['product_id'], 'sale_count', -$val['product_number']);
                            K::M('waimai/product')->update_count($val['product_id'], 'stock', $val['product_number']);
                        }
                    } 
                }

                if($reward_money){ //退还小费
                    K::M('member/member')->update_money($order['uid'], $reward_money, sprintf(L('订单(ID:%s)取消，小费退回到余额'), $order['order_id']));
                }
                if($order['hongbao_id']){ //退还红包
                    K::M('hongbao/hongbao')->update($order['hongbao_id'], array('order_id' => 0, 'used_time' => 0, 'used_ip' => ''));
                }
                //退还优惠券
                if($order['coupon_id'] > 0){
                    $c_detail = K::M('member/coupon')->find(array('coupon_id'=>$order['coupon_id'],'order_id'=>$order['order_id'],'shop_id'=>$order['shop_id'],'status'=>1));
                    K::M('member/coupon')->update($c_detail['cid'], array('status'=>0,'order_id'=>0,'use_time'=>0));
                    
                }
                //商品库存放在后继版本处理
                if($from == 'system'){
                    $log = sprintf(L('订单超时系统取消(ID:%s)'), $order['order_id']);
                }
                else if($from == 'admin'){
                    $log = sprintf(L('管理员取消订单(ID:%s)'), $order['order_id']);
                }
                else if($from == 'shop'){
                    $log = sprintf(L('商家取消订单(ID:%s)'), $order['order_id']);
                }
                else if($from == 'pintuan'){
                    //用户取消订单,组团的 订单数目 减 1
                    K::M('pintuan/group')->group_cancel_order($order['order_id']);
                    $log = sprintf(L('商家取消拼团订单(ID:%s)'), $order['order_id']);
                }
                else{
                    $log = sprintf(L('用户取消订单(ID:%s)'), $order['order_id']);
                }
                K::M('order/log')->create(array('type' => -1, 'from' => $from, 'log' => $log, 'order_id' => $order['order_id']));
                return true;
            }
        }
        return false;
    }

    public function get_note()
    {
        return array(
            1 => array(
                1 => L('不要辣'),
                2 => L('少点辣'),
                3 => L('多点辣'),
            ),
            2 => L('不要香菜'),
            3 => L('不要洋葱'),
            4 => L('多点醋'),
            5 => L('多点葱'),
            6 => array(
                1 => L('去冰'),
                2 => L('少冰'),
                3 => L('多冰'),
            ),
        );
    }

    public function get_reason()
    {
        return array(
            'pintuan' => array(
                1 => '临时有事',
                2 => '选错商品',
                3 => '其他'
            ),
            'waimai'  => array(
                1 => '买错了',
                2 => '不想吃',
                3 => '其他'
            ),
            'paotui'  => array(
                1 => '买错了2',
                2 => '不想吃2',
                3 => '下了单就退，任性2'
            ),
            'mall'    => array(
                1 => '买错了3',
                2 => '不想吃3',
                3 => '下了单就退，任性3'
            ),
        );
    }

    public function get_comment()
    {
        return array(
            'shop'   => array(
                1 => '很好',
                2 => '一般',
                3 => '不行'
            ),
            'paotui' => array(
                1 => '很好2',
                2 => '一般2',
                3 => '不行2'
            ),
            'waimai' => array(
                1 => '很好3',
                2 => '一般3',
                3 => '不行3'
            ),
        );
    }

    public function get_complaint()
    {
        return array(
            'shop'  => array(
                1 => '商家资质问题',
                2 => '商家刷单问题',
                3 => '商家信息问题',
                4 => '商品质量问题',
                5 => '商家分类问题',
                6 => '我对商家的建议'
            ),
            'staff' => array(
                1 => '人员素质问题',
                2 => '人员态度问题',
                3 => '配送速度问题',
                4 => '长相问题',
                5 => '身高问题'
            ),
        );
    }

    public function get_time()
    {
        $return_array = array();
        $start_quarter = 0;
        $start = date('H', __TIME + 3600);
        $q = date('i', __TIME + 3600);
        if($q < 15){
            $start_quarter = 0;
        }
        else if($q < 30 && $q >= 15){
            $start_quarter = 1;
        }
        else if($q < 45 && $q >= 30){
            $start_quarter = 2;
        }
        else{
            $start_quarter = 3;
        }
        $return_array['start'] = $start;
        $return_array['start_quarter'] = $start_quarter;
        return $return_array;
    }

    /**
     * 根据天统计订单
     * param $filter 订单条件
     * param $limit 开始 
     */
    public function count_by_day($filter = null, $page = 1, $limit = 30)
    {
        if($day = (int) $day){
            return array();
        }
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `day`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao, SUM(`pei_amount`) as day_pei_money  FROM " . $this->table($this->_table) . " WHERE {$where} GROUP BY `day` ORDER BY day ASC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['day']] = $row;
            }
        }
        return $items;
    }

    public function count_by_shopid($filter = null, $page = 1, $limit = 30)
    {
        if($day = (int) $day){
            return array();
        }
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `shop_id`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao, SUM(`pei_amount`) as day_pei_money  FROM " . $this->table($this->_table) . " WHERE {$where} GROUP BY `shop_id` ORDER BY shop_id ASC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['shop_id']] = $row;
            }
        }
        return $items;
    }

    public function get_order_status()
    {
        return array(
            '-1' => L('已取消'),
            '0'  => L('未处理'),
            '1'  => L('已接单'),
            '3'  => L('配送开始'),
            '4'  => L('配送完成'),
            '8'  => L('订单完成'),
        );
    }

    public function get_payments()
    {
        return array(
            'wxpay'  => L('微信支付'),
            'alipay' => L('支付宝支付'),
            'money'  => L('余额支付'),
        );
    }

    // 订单来源
    public function orderfrom($filter)
    {
        $where = $this->where($filter);
        $sql = "SELECT order_from, COUNT(1) as nums FROM {$this->table($this->_table)} WHERE {$where} GROUP BY order_from ORDER BY order_from";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }

    public function customs_by_shop($filter, $page = 1, $limit = 50, $count)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $items = array();
        $sql = "SELECT uid, SUM(`amount`+`money`) as total_amount, COUNT(1) total_order FROM " . $this->table($this->_table) . " WHERE $where GROUP BY `uid` ORDER BY `uid` $limit";
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['uid']] = $row;
            }
        }
        return $items;
    }

    protected function _format_row($row)
    {

        if(in_array($row['from'], array('waimai', 'pintuan'))){
            if($row['pei_type'] == 3){  //自提单
                if($row['order_status'] == -1){
                    $label = '已取消';
                    $warning = '订单已取消';
                }
                else if(empty($row['order_status']) && empty($row['pay_status']) && $row['online_pay'] == 1){
                    $label = '待支付';
                    $warning = '订单等待支付';
                }
                else if(empty($row['order_status']) && $row['pay_status'] == 1 && $row['online_pay'] == 1){
                    $label = '待接单';
                    $warning = '订单逾期1小时内无人接单自动取消';
                }
                else if(empty($row['order_status']) && $row['pay_status'] == 0 && $row['online_pay'] == 0){
                    $label = '待接单';
                    $warning = '订单逾期1小时内无人接单自动取消';
                }
                else if($row['order_status'] == 1 || $row['order_status'] == 2){
                    $label = '等待自提';
                    $warning = '等待用户自提';
                }
                else if($row['order_status'] == 8){
                    $label = '已完成';
                    $warning = '订单已完成';
                }
                else{
                    $label = '已完成';
                    $warning = '订单已完成';
                }
            }
            else{
                if($row['order_status'] == -1){
                    $label = '已取消';
                    $warning = '订单已取消';
                }
                else if(empty($row['order_status']) && empty($row['pay_status']) && $row['online_pay'] == 1){
                    $label = '待支付';
                    $warning = '订单等待支付';
                }
                else if(empty($row['order_status']) && $row['pay_status'] == 1 && $row['online_pay'] == 1){
                    $label = '待接单';
                    $warning = '订单逾期1小时内无人接单自动取消';
                }
                else if(empty($row['order_status']) && $row['pay_status'] == 0 && $row['online_pay'] == 0){
                    $label = '待接单';
                    $warning = '订单逾期1小时内无人接单自动取消';
                }
                else if($row['order_status'] == 1 || $row['order_status'] == 2){
                    $label = '等待配送';
                    $warning = '配货完成等待配送';
                }
                else if($row['order_status'] == 3){
                    $label = '正在配送';
                    $warning = '订单正在配送中';
                }
                else if($row['order_status'] == 4){
                    $label = '配送完成';
                    $warning = '订单配送完成';
                }
                else if($row['order_status'] == 8){
                    $label = '已完成';
                    $warning = '订单已完成';
                }
                else{
                    $label = '已完成';
                    $warning = '订单已完成';
                }
            }
        }
        else if($row['from'] == 'paotui'){
            if($row['order_status'] == -1){
                $label = '已取消';
                $warning = '订单已取消';
            }
            else if(empty($row['pay_status'])){
                $label = '待支付';
                $warning = '订单等待支付';
            }
            else if(empty($row['order_status']) && $row['pay_status'] == 1){
                $label = '待接单';
                $warning = '订单逾期1小时内无人接单自动取消';
            }
            else if(($row['order_status'] == 1 && $row['pay_status'] == 1) || ($row['order_status'] == 2 && $row['pay_status'] == 1)){
                $label = '等待服务';
                $warning = '等待服务中';
            }
            else if($row['order_status'] == 3){
                $label = '正在服务';
                $warning = '正在服务中';
            }
            else if($row['order_status'] == 4){
                $label = '服务完成';
                $warning = '服务已完成';
            }
            else if($row['order_status'] == 5){
                $label = '需补差价';
                $warning = '订单需要补差价';
            }
            else if($row['order_status'] == 8){
                $label = '已完成';
                $warning = '订单已完成';
            }
            else{
                $label = '已完成';
                $warning = '订单已完成';
            }
        }
        else if($row['from'] == 'mall'){
            if($row['order_status'] == -1){
                $label = '已取消';
                $warning = '订单已取消';
            }
            else if(empty($row['pay_status'])){
                $label = '待支付';
                $warning = '订单等待支付';
            }
            else if(empty($row['order_status']) && $row['pay_status'] == 1){
                $label = '待发货';
                $warning = '订单等待发货';
            }
            else if($row['order_status'] == 1){
                $label = '已发货';
                $warning = '订单已发货';
            }
            else if($row['order_status'] == 8){
                $label = '已完成';
                $warning = '订单已完成';
            }
        }

        switch($row['from']){
            case 'waimai':
                $from_name = '外卖';
                break;
            case 'pintuan';
                $from_name = '拼团';
                break;
            case 'paotui';
                $from_name = '派活';
                break;
            case 'mall';
                $from_name = '商城';
                break;
            default:
                $from_name = '其它';
        }
        $row['order_type_name'] = $from_name;
        $row['order_status_label'] = $label;
        $row['order_status_warning'] = $warning;

        return $row;
    }

    public function yunprint($order_id, $nums)
    {
        if(!$order_id = (int) $order_id){
            $this->msgbox->add(L('订单不存在'), 210);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
            $this->msgbox->add(L('商家不存在', 212));
        }
        else{
            $products = K::M('waimai/orderproduct')->items(array('order_id' => $order['order_id']));
            $js_price = $order['amount'] + $order['money'];
            $payments = $this->get_payments();
            if($order['online_pay'] == 1){
                $pay = '线上支付';
            }
            else{
                $pay = '线下支付';
            }
            if($order['pay_status'] == 1){
                $pay_status = '[已付]';
            }
            else{
                $pay_status = '[未付]';
            }
            $youhui = $first_yh + $order_yh + $hongbao_yh;
            $content = '';
            $content .= "<MN>" . $nums . "</MN>\n";
            $content .= "<center>" . "{$shop['title']}" . "({$shop['city_name']})" . "</center>\n";
            $content .= "[下单时间]: " . date('Y-m-d H:i:s', $order['dateline']) . "\n";
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            foreach($products as $k => $v){
                $content .= "<FH>" . $v['product_name'] . "\t\t\t" . 'x' . $v['product_number'] . "\t  " . $v['amount'] . "</FH>\n";
            }
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            if($order['first_youhui'] > 0){
                $content .= "首单优惠：\t\t\t\t  " . $order['first_youhui'] . "\n";
            }
            if($order['order_youhui'] > 0){
                $content .= "下单立减：\t\t\t\t  " . $order['order_youhui'] . "\n";
            }
            if($order['hongbao'] > 0){
                $content .= "红包抵扣：\t\t\t\t  " . $order['hongbao'] . "\n";
            }
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            $content .= "<FW2><FH2><FB>总计￥" . $js_price . $pay_status . "</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>" . $order['house'] . $order['addr'] . "</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>" . $order['mobile'] . "</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>" . $order['contact'] . "</FB></FH2></FW2>\n";

            if($nums > 0 && isset($content)){
                $printer = K::M('shop/print')->find(array('shop_id' => $order['shop_id'], 'from' => 'ylyun', 'status' => 1));
                if(isset($printer)){
                    $state = K::M('printer/ylyun')->send_print($printer['partner'], $printer['apikey'], $printer['machine_code'], $printer['mkey'], $content);
                    if($state){
                        $rlt = json_decode($state);
                        if($rlt->state == 2){
                            $this->msgbox->add('提交时间超时', 210);
                            //break;
                        }
                        else if($rlt->state == 3){
                            $this->msgbox->add('参数有误', 211);
                            //break;
                        }
                        else if($rlt->state == 4){
                            $this->msgbox->add('sign加密验证失败', 212);
//                           // break;
                        }
                        else{
                            $this->msgbox->add('数据提交成功');
                        }
                    }
                }
            }
        }
    }

    // 给用户发送微信模板消息
    public function payed_wxmsg($wx_openid, $order)
    {
        return false;
        //获取模版消息配置
        $wx_config = $this->system->config->get('wx_config');
        $a = array('title' => L('恭喜您！订单支付成功！订单完成！'), 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => L('订单支付成功')), 'remark' => sprintf(L('恭喜,您的订单于%s支付成功，订单交易完成！'), date('Y-m-d H:i:s', time())));
        $url = K::M('helper/link')->mklink('order:detail', array($order['order_id']), array(), 'www');
        return K::M('weixin/wechat')->wechat_client()->sendTempMsg($wx_openid, $wx_config['tmpl_order_status'], $url, $a);
    }

    //订单变动给用户消息 $type create, payment, jiedan, qiang, startwork, fineshed, confrim, 
     public function send_member($title, $content, $order, $type = 'qiang')
    {   
        // 发送模板消息
        if($order['order_from'] == 'weixin' && $order['wx_openid']){
            $wx_config = K::$system->config->get('wx_config');
            $config = K::$system->config->get('site');
            $a = array('title' => $title, 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => $title), 'remark' => $content);
            $url = K::M('helper/link')->mklink('ucenter/order:detail', array('args' => $order['order_id']), array(), 'www');
            K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($order['wx_openid'], $wx_config['order_id'], $url, $a);
        }
        // APP通知
        return K::M('member/member')->send($order['uid'], $title, $content, 'order', $order['order_id']);
    }

    //向配送员发消息
    public function send_staff($title, $content, $order, $type = 'confirm')
    {
        if(!$staff_id = $order['staff_id']){
            return false;
        }
        return K::M('staff/staff')->send($staff_id, $title, $content, 'order', $order['order_id']);
    }

    //向商户发消息
    public function send_shop($title, $content, $order, $type = 'confirm')
    {
        if(!$shop_id = $order['shop_id']){
            return false;
        }
        return K::M('shop/shop')->send($shop_id, $title, $content, 'order', $order['order_id']);
    }

    
    public function order_format_row($row)
    {
        return $this->_format_row($row);
    }
}
