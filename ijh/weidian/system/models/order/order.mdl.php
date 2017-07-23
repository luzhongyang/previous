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
    protected $_cols = 'order_id,city_id,shop_id,staff_id,uid,from,order_status,online_pay,pay_status,trade_no,total_price,hongbao_id,hongbao,order_youhui,first_youhui,money,amount,o_lng,o_lat,contact,mobile,addr,house,lng,lat,day,intro,order_from,clientip,dateline,cui_time,comment_status,jd_time,pay_code,pay_time,pei_time,closed,lasttime,pei_amount,pei_type,coupon_id,coupon';
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
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        $data['jd_time'] = 0;
        $data['cui_time'] = 0;
        $data['pay_time'] = 0;
        $data['lasttime'] = 0;
        $data['day'] = date('Ymd', $data['dateline']);
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }        
        return $id;        
    }
    
    public function set_payed($log, $trade=array())
    {        
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($res = $this->db->update($this->_table, array('pay_status' => 1), "order_id='{$order_id}'", true)){
            $a = array('online_pay'=>1, 'pay_time'=>__TIME,'lasttime'=>__TIME,'pay_code'=>$trade['code']);
            //如果下单时选择了服务人员更新订单order_status为1
            if(in_array($order['from'], array('house', 'weixiu', 'paotui')) && $order['order_status']==0 && $order['staff_id'] > 0){
                $a['order_status'] = 1;
            }
            $this->update($order_id, $a, true);
            if($trade['code'] == 'money') {
                $logmsg = '订单余额支付成功';
            }else {
                $logmsg = '订单支付成功';
            }
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'payment','log'=>$logmsg,'status'=>$order['order_status']));
            if($order['from'] == 'tuan') {
                $tuan_order = K::M('tuan/order')->detail($order_id);
                $this->update($order_id, array('order_status'=>5));
                K::M('tuan/ticket')->create_ticket($order_id);
                $title = sprintf("新的团购订单(单号：%s)", $order_id);
                //$content = sprintf("[%s]下了团购了%s份[%s](单号：%s)", $tuan_order['contact'], $tuan_order['tuan_number'], $tuan_order['tuan_title'], $order_id);
                $content = sprintf("用户(%s)下了团购订单(单号：%s)", $tuan_order['contact'], $order_id);
                K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
            }else if(in_array($order['from'], array('weixiu', 'house', 'paotui'))){
                if($order['order_status']==5 && $order['staff_id'] /*&& $log['pay_level'] > 0*/){ //二次支付后直接订单结算
                    $this->confirm($order_id);
                    $title = sprintf("订单付款完成(订单：%s)",  $order_id);
                    $content = sprintf("客户%s(电话：%s)补付了订单尾款￥%s(订单：%s)",  $order['contact'], $order['mobile'], $log['amount'], $order_id);
                    K::M('staff/staff')->send($order['staff_id'], $title, $content, 'order', $order_id);
                }else if($staff_id = (int)$order['staff_id']){
                    if($staff = K::M('staff/staff')->detail($staff_id)){
                        //更新师傅订单统计
                        K::M('staff/staff')->update_count($staff_id, 'orders', 1);
                        //通知师傅处理订单
                        $addr = $order['addr'].$order['house'];
                        $content = sprintf("客户%s(电话：%s)预约了您(订单号：%s),地址:%s", $order['contact'], $order['mobile'], $order_id, $addr);
                        K::M('staff/staff')->send($staff_id, '您有新的订单需要处理', $content, 'newOrder', $order_id);
                    }
                }
            }else if($order['from'] == 'maidan') {
                if($this->update($order_id, array('order_status'=>5), true)){
                    $this->confirm($order_id, $order, 'payment');
                    $title = sprintf("优惠买单成功通知(单号：%s)", $order_id);
                    $content = sprintf("优惠买单成功(单号：%s)，买单金额￥%s，优惠后支付￥%s", $order_id, $order['total_price'], $order['amount']);
                    K::M('shop/shop')->send($order['shop_id'], $title, $content, 'order', $order_id);
                }
                
            }else if($order['from'] == 'waimai') {
                if($order['pei_type'] == 3) { // 自提订单 创建消费码
                    K::M('waimai/order')->create_number($order_id);
                    $addr = '客户自提';
                }else{
                    $addr = $order['addr'].$order['house'];
                }
                $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                $content = sprintf("您有新的外卖订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newWaimaiOrder', $order_id);
            }
            else if($order['from'] == 'weidian'){
                $detail = K::M('weidian/order')->detail($log['order_id']);
                if($detail['type'] == 'default'||$detail['type'] == 'fenxiao'){
                    if($order['pei_type'] == 2){ // 自提订单 创建消费码
                        K::M('weidian/order')->create_number($order_id);
                        $addr = '客户自提';
                    }else{
                        $addr = $order['addr'] . $order['house'];
                    }
                    $title = sprintf("您有新的微店商城订单(单号：%s)", $order_id);
                    $content = sprintf("您有新的微店商城订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                    K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newWeidianOrder', $order_id);
                }
                else if($detail['type'] == 'pintuan'){
                    //预付款模式,将 pay_status = 1 更新为 0,
                    $pintuan_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id));
                    if(0 == $pintuan_order['is_money_pre'] || (1 == $pintuan_order['is_money_pre'] && $pintuan_order['money_paid'] >= $order['amount'] )){
                        if($order['pei_type'] == 3){
                            K::M('weidian/pintuan/order')->create_number($order_id);
                        }
                    }
                    if(1 == $pintuan_order['is_money_pre']){
                        //money_paid,支付金额累加日志
                        $arr_log = K::M('payment/log')->find(array('order_id' => $order_id), array('log_id' => 'DESC'));
                        $total_pay_money = $pintuan_order['money_paid'] + $arr_log['amount'];
                        $arr_p_order = K::M('weidian/pintuan/order')->update($order_id, array('money_paid' => $total_pay_money));
                    }
                    //支付成功,更新 成功支付订单数目 order_success_count
                    K::M('weidian/pintuan/group')->group_success_order($order_id);
                }
            }
        }
        return $res;
    }
    //确认订单 ，结算订单
    public function confirm($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if(!$order = K::M("{$order['from']}/order")->detail($order_id)){
            return false;
        }else if(in_array($order['order_status'], array(1,2,3,4,5))){ //-1:已取消，0：未处理，1：已接单，2：已配货，3：开始工作，4：完成工作，5：待完成/补差价，8：订单完成
            $order_id = $order['order_id'];
            if($this->update($order_id, array('order_status'=>8), true)){
                $staff_amount = $shop_amount = 0;
                if($order['online_pay']){
                    $log = $staff_log = '订单完成结算(ID:'.$order_id.')';
                    if($order['from'] == 'waimai'){
                        if($order['pei_type'] && $order['staff_id']){
                            if($order['pei_type'] == 2){//代购订单，全部结算给配送员
                                $staff_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                                $staff_log = '订单代购完成结算(ID:'.$order_id.')';
                            }else{
                                $staff_amount = $order['pei_amount'];
                                $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'] - $staff_amount;
                                $staff_log = '订单配送完成结算(ID:'.$order_id.')';
                            }
                        }else{
                            $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                        }
                    }else if($order['from'] == 'tuan'){
                        $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                    }else if($order['staff_id'] > 0 && in_array($order['from'], array('weixiu', 'house'))){
                        if($order['jiesuan_price']){
                            $staff_amount = $order['jiesuan_price'];
                        }else{
                            $staff_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                        }
                        $this->update($order_id, array('pay_status'=>1), true);
                    }else if($order['from'] == 'paotui'){
                        $staff_amount = $order['jiesuan_amount'] + $order['paotui_amount'];
                    }else if($order['from'] == 'maidan'){
                        $shop_amount = $order['amount'] + $order['money'] + $order['hongbao'];
                    }else if($order['from'] == 'weidian'){
                        // 拼团订单发放佣金,
                        K::M('weidian/pintuan/order')->master_money_pay($order_id);
                    }
                    if($staff_amount){
                        K::M('staff/staff')->update_money($order['staff_id'], $staff_amount, $log);
                    }
                    if($shop_amount){
                        K::M('shop/shop')->update_money($order['shop_id'], $shop_amount, '订单完成结算(ID:'.$order_id.')');
                    }
                    // 首单奖励发放
                    if(K::M('order/order')->count(array('uid'=>$order['uid'], 'order_status'=>8))===1){
                        if($m = K::M('member/member')->detail($order['uid'])){
                            if(preg_match('/(B|S|D|M)(\d+)/i', $m['pmid'], $a)){
                                if($a[1] == 'M'){ //会员邀请
                                    $inviteCfg = K::$system->config->get('invite');
                                    if(($invite_order_money = (float)$inviteCfg['invite_order_money'])>0){
                                        if($pm = K::M('member/member')->detail((int)$a[2])){
                                            K::M('member/member')->update_money($pm['uid'], $invite_order_money, sprintf(L('邀请用户(%s)首单奖励:￥%s'), $m['nickname'], $invite_order_money));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if($from == 'admin'){
                    $log = '管理员确认订单完成';
                }else if($from == 'system'){
                    $log = '超过3小时系统自动确认订单完成';
                }else if($from == 'shop'){
                    $log = '商家确认订单完成';
                }else{
                    $log = '用户确认订单完成';
                }

                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>$from,'log'=>$log,'status'=>8));
                return true;
            }
        }
        return false;
    }
    
    
    public function  get_payments()
    {
        return array(
            'wxpay' => '微信支付',
            'alipay' => '支付宝支付',
            'money' => '余额支付',
        );
    }
    /**
     * @function  取消/退单 退回余额+在线支付金额到余额，退回红包
     * @params  $order_id
     * @params  $order
     * @params  $from  string  由哪个角色取消的[member, staff, shop, admin]
     */
    public function cancel($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消过，不能再取消', 449);
            return false;
        }else if(in_array($order['order_status'], array(0, 1, 2, 3, 4, 5))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            if($from == 'member' && $order['from'] != 'tuan'){//用户可以在未接单时直接退单,团购订单则在使用前都可以退单
                if($order['staff_id'] > 0 && $order['pay_status'] == 1){
                    $this->msgbox->add('师傅已接单不可取消', 451);
                    return false;
                }else if($order['order_status'] > 0){
                    $this->msgbox->add('商家已接单不可取消', 451);
                }
            }
            if($this->db->update($this->_table, array('order_status'=>-1), "order_id='{$order_id}'", true)){ //防止并发多退钱
                if($order['online_pay'] && $order['from'] != 'mall'){
                    if($money = K::M("{$order['from']}/order")->get_return_amount($order_id, $order)){ //退回已付款金额到余额,这时数据库的order_status已经为-1
                        K::M('member/member')->update_money($order['uid'], $money, '订单(ID:'.$order['order_id'].')取消退回到余额');
                    }
                }
                if($order['hongbao_id']){ //退还红包
                    K::M('hongbao/hongbao')->update($order['hongbao_id'], array('order_id'=>0, 'used_time'=>0, 'used_ip'=>''));
                }
                if($order['from'] == 'tuan' && $order['pay_status'] == 1){ //团购订单团购券处理
                    $ticket_ids = array();
                    if($ticket_list = K::M('tuan/ticket')->items(array('order_id'=>$order_id))){
                        foreach($ticket_list as $k => $v){
                            $ticket_ids[$v['ticket_id']] = $v['ticket_id'];
                        }
                    }
                    if($ticket_ids){
                        K::M('tuan/ticket')->batch($ticket_ids, array('status'=>-1));
                    }
                }
                //退回商品库存
                if(in_array($order['from'], array('waimai', 'tuan'))){
                    K::M("{$order['from']}/order")->return_sku($order_id, $order);
                }
                //更新商户订单数量
                if($order['shop_id']){
                    if($order['from'] == 'waimai'){
                        K::M('waimai/waimai')->update_count($order['shop_id'], 'orders', -1);
                    }else{
                        K::M('shop/shop')->update_count($order['shop_id'], 'orders', -1);
                    }
                }
                //更新服务人员订单数量
                if($order['staff_id']){
                    K::M('staff/staff')->update_count($order['staff_id'], 'orders', -1);
                }
                //更新会员订单数量
                if($order['uid']){
                    K::M('member/member')->update_count($order['uid'], 'orders', -1);
                }
                
                if($from == 'admin'){
                    $log = '管理员取消订单(订单号:'.$order['order_id'].')';
                }else if($from == 'shop'){
                    $log = '商家取消订单(订单号:'.$order['order_id'].')';
                }else if($from == 'staff'){
                    if(in_array($order['from'], array('waimai', 'paotui'))) {
                        $log = '骑手取消订单(订单号:'.$order['order_id'].')';
                    }else{
                        $log = '师傅取消订单(订单号:'.$order['order_id'].')';
                    }
                }else if($from == 'system'){
                    $log = '超时未支付系统取消了订单(订单号:'.$order['order_id'].')';
                }else{
                    $log = '用户取消订单(订单号:'.$order['order_id'].')';
                }
                K::M('order/log')->create(array('status'=>-1, 'from'=>$from, 'log'=>$log, 'order_id'=>$order['order_id']));               
                return true;
            }
        }
        return false;
    }
    //订单变动给用户消息 $type create, payment, jiedan, qiang, startwork, fineshed, confrim, 
    public function send_member($title, $content, $order, $type='qiang')
    {
        if($order['order_from'] == 'weixin' && $order['wx_openid']){
            $wx_config = $this->system->config->get('wx_config');
            $config = $this->system->config->get('site');
            $a = array('title'=>$title, 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => $title), 'remark' =>$content);
            $url = K::M('helper/link')->mklink('ucenter/order:detail', array('args'=>$order['order_id']), array(), 'www');
            K::M('weixin/wechat')->admin_wechat_client()->sendTempMsg($this->MEMBER['wx_openid'], $wx_config['order_id'], $url, $a);
        }
        return K::M('member/member')->send($order['uid'], $title, $content, 'order', $order['order_id']);
    }
    //向配送员发消息
    public function send_staff($title, $content, $order, $type='confirm')
    {
        if(!$staff_id = $order['staff_id']){
            return false;
        }
        return K::M('staff/staff')->send($staff_id, $title, $content, 'order', $order['order_id']);
    }
    //像商户发消息
    public function send_shop($title, $content, $order, $type='confirm')
    {
        if(!$shop_id = $order['shop_id']){
            return false;
        }
        return K::M('shop/shop')->send($shop_id, $title, $content, 'order', $order['order_id']);
    }
    public function customs_by_shop($filter, $page=1, $limit=50, &$count=0)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $items = array();
        $sql = "SELECT COUNT(1) FROM ".$this->table($this->_table)." WHERE $where GROUP BY `uid`";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT uid, SUM(`amount`+`money`) as total_amount, COUNT(1) total_order FROM ".$this->table($this->_table)." WHERE $where GROUP BY `uid` ORDER BY `uid` $limit";
            if($rs = $this->db->Execute($sql)){
                $count = $this->db->GetOne("SELECT FOUND_ROWS()");
                while($row = $rs->fetch()){
                    $items[$row['uid']] = $row;
                }
            }
        }
        return $items;    
    }
    /**
     * 根据天统计订单
     * param $filter 订单条件
     * param $limit 开始 
     */
    public function count_by_day($filter=null, $page=1,$limit=30)
    {
        if($day = (int)$day){
            return array();
        }
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `day`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `day` ORDER BY day ASC $limit";      
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['day']] = $row;
            }
        }
        return $items;
    }
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
    
    
    public function ordersale($shop_id,$time){
        $sql = "SELECT sum(a.product_number) as num,(a.product_name) as name,(b.dateline) as time,a.order_id,a.product_id FROM ".$this->table('waimai_order_product')." as a left join ".$this->table($this->_table)." as b on a.order_id = b.order_id where b.from = 'waimai' AND b.order_status = 8 AND b.shop_id = ".$shop_id." AND b.dateline  BETWEEN " . $time . " AND " . time() . " group by a.product_id order by num desc limit 5";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;  
    }
    public function order_format_row($row)
    {
        return $this->_format_row($row);
    }
    protected function _format_row($row)
    {
        if($row['from'] == 'tuan'){
            if($row['order_status'] == -2){
                $label = '已退款';
                $warning = '订单已退款';
            }else if($row['order_status'] == -1){
                $label = '已取消';
                $warning = '订单已取消';
            }else if(empty($row['order_status']) && empty($row['pay_status'])){
                $label = '待支付';
                $warning = '订单等待支付';
            }else if($row['order_status'] == 5){
                $label = '待消费';
                $warning = '等待消费';
            }else if($row['order_status'] == 8){
                $label = '已完成';
                $warning = '订单已完成';
            }else{
                $label = '已完成';
                $warning = '订单已完成';
            }
        }else if($row['from'] == 'maidan'){
            if($row['order_status'] == -1){
                $label = '已取消';
                $warning = '订单已取消';
            }else if(empty($row['order_status']) && empty($row['pay_status'])){
                $label = '待支付';
                $warning = '订单等待支付';
            }else if($row['order_status'] == 8 && $row['comment_status']==0){
                $label = '待评价';
                $warning = '订单待评价';
            }else if($row['order_status'] == 8 && $row['comment_status']==1){
                $label = '已完成';
                $warning = '订单已完成';
            }else{
                $label = '已完成';
                $warning = '订单已完成';                
            }
        }else if(in_array($row['from'], array('house','weixiu','paotui'))){
            if($row['order_status'] == -1){
                $label = '已取消';
                $warning = '订单已取消';
            }else if(empty($row['pay_status'])){
                $label = '待支付';
                $warning = '订单等待支付';
            }else if(empty($row['order_status']) && $row['pay_status'] == 1){
                $label = '待接单';
                $warning = '订单逾期1小时未接单自动取消';
            }else if(($row['order_status'] == 1  && $row['pay_status'] == 1) || ($row['order_status'] == 2  && $row['pay_status'] == 1)){
                $label = '等待服务';
                $warning = '等待服务中';
            }else if($row['order_status'] == 3){
                $label = '正在服务';
                $warning = '正在服务中';
            }else if($row['order_status'] == 4){
                $label = '服务完成';
                $warning = '服务已完成';
            }else if($row['order_status'] == 5){
                $label = '需补差价';
                $warning = '订单需要补差价';
            }else if($row['order_status'] == 8){
                $label = '已完成';
                $warning = '订单已完成';
            }else{
                $label = '已完成';
                $warning = '订单已完成';                
            }
        }else if($row['from'] == 'waimai'){
            if($row['pei_type'] == 3) {
                if($row['order_status'] == -1) {
                    $label = '已取消';
                    $warning = '订单已取消';
                }else if(empty($row['order_status']) && empty($row['pay_status']) && $row['online_pay'] == 1){
                    $label = '待支付';
                    $warning = '订单等待支付';
                }else if(empty($row['order_status']) && $row['pay_status'] == 1 && $row['online_pay'] == 1){
                    $label = '待接单';
                    $warning = '订单逾期1小时未接单自动取消';
                }else if(empty($row['order_status']) && $row['pay_status'] == 0 && $row['online_pay'] == 0){
                    $label = '待接单';
                    $warning = '订单逾期1小时未接单自动取消';
                }else if($row['order_status'] == 1 || $row['order_status'] == 2){
                    $label = '等待自提';
                    $warning = '等待用户自提';                
                }else if($row['order_status'] == 8){
                    $label = '已完成';
                    $warning = '订单已完成';
                }else{
                    $label = '已完成';
                    $warning = '订单已完成';                
                }
            }
            else{
                if($row['order_status'] == -1){
                    $label = '已取消';
                    $warning = '订单已取消';
                }else if(empty($row['order_status']) && empty($row['pay_status']) && $row['online_pay'] == 1){
                    $label = '待支付';
                    $warning = '订单等待支付';
                }else if(empty($row['order_status']) && $row['pay_status'] == 1 && $row['online_pay'] == 1){
                    $label = '待接单';
                    $warning = '订单逾期1小时未接单自动取消';
                }else if(empty($row['order_status']) && $row['pay_status'] == 0 && $row['online_pay'] == 0){
                    $label = '待接单';
                    $warning = '订单逾期1小时未接单自动取消';
                }else if($row['order_status'] == 1 || $row['order_status'] == 2){
                    $label = '等待配送';
                    $warning = '配货完成等待配送';                
                }else if($row['order_status'] == 3){
                    $label = '正在配送';
                    $warning = '订单正在配送中';
                }else if($row['order_status'] == 4){
                    $label = '配送完成';
                    $warning = '订单配送完成';
                }else if($row['order_status'] == 8){
                    $label = '已完成';
                    $warning = '订单已完成';
                }else{
                    $label = '已完成';
                    $warning = '订单已完成';                
                }
            }      
        }
        switch ($row['from']){
            case 'tuan':
                $from_name = '团购';
            break;
            case 'waimai';
                $from_name = '外卖';
            break;
            case 'paotui';
                $from_name = '跑腿';
            break;
            case 'weixiu';
                $from_name = '维修';
            break;
            case 'house';
                $from_name = '家政';
            break;
            case 'maidan';
                $from_name = '买单';
            break;
            default:
                $from_name = '其它';
        }
        $row['from_name'] = $from_name;
        if($row['lat']){
            $row['lat'] = bcdiv($row['lat'], 1000000,6);
        }
        if($row['lng']){
            $row['lng'] = bcdiv($row['lng'], 1000000,6);
        }
        if($row['o_lat']){
            $row['o_lat'] = bcdiv($row['o_lat'], 1000000,6);
        }
        if($row['o_lng']){ 
            $row['o_lng'] = bcdiv($row['o_lng'], 1000000,6);
        }
        if($row['shop_id']) {
            if($shop = K::M('shop/shop')->detail($row['shop_id'])) {
                $row['shop_title'] = $shop['title'];
                $row['shop_logo'] = $shop['logo'];
            }
        }
        $row['order_status_label'] = $label;
        $row['order_status_warning'] = $warning;
        return $row;
    }

    public function get_time()
    {
        $return_array = array();
        $start_quarter = 0;
        $start = date('H',__TIME+3600);
        $q = date('i',__TIME+3600);
        if($q <15){
            $start_quarter =0;
        }else if($q <30 &&$q>=15){
            $start_quarter=1;
        }else if($q <45 &&$q>=30){
            $start_quarter=2;
        }else{
            $start_quarter=3;
        }
        $return_array['start'] = $start;
        $return_array['start_quarter'] = $start_quarter;
        return $return_array;
    }
    //  备注
    public function get_note()
    {
        return array(
            1=>array(
                1=>'不要辣',
                2=>'少点辣',
                3=>'多点辣',
            ),
            2=>'不要香菜',
            3=>'不要洋葱',
            4=>'多点醋',
            5=>'多点葱',
            6=>array(
                1=>'去冰',
                2=>'少冰',
                3=>'多冰',
            ),
        );
    }

    public function count_by_shopid($filter=null, $page=1,$limit=30)
    {
        if($day = (int)$day){
            return array();
        }
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `shop_id`,`online_pay`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao, SUM(`pei_amount`) as day_pei_money  FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `shop_id` ORDER BY shop_id ASC $limit";      
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['shop_id']] = $row;
            }
        }
        return $items;
    }
    protected function _check($data, $order_id=null)
    {
        if(isset($data['lat'])){
            $data['lat'] = round(bcmul($data['lat'], 1000000));
        }
        if(isset($data['lng'])){
            $data['lng'] = round(bcmul($data['lng'], 1000000));
        }
        if(isset($data['o_lat'])){
            $data['o_lat'] = round(bcmul($data['o_lat'], 1000000));
        }
        if(isset($data['o_lng'])){
            $data['o_lng'] = round(bcmul($data['o_lng'], 1000000));
        }
        return parent::_check($data, $order_id);
    }

    public function where($filter=null, $pre='', $ANDOR='AND')
    {
        if(is_array($filter)){
            if(isset($filter['lat'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['lat'], $m)){
                    $filter['lat'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['lat'] = bcmul($filter['lat'], 1000000);
                }                
            }
            if(isset($filter['lng'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['lng'], $m)){
                    $filter['lng'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['lng'] = bcmul($filter['lng'], 1000000);
                }                
            }
            if(isset($filter['o_lat'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['o_lat'], $m)){
                    $filter['o_lat'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['o_lat'] = bcmul($filter['o_lat'], 1000000);
                }
            }
            if(isset($filter['o_lng'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['o_lng'], $m)){
                    $filter['o_lng'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['o_lng'] = bcmul($filter['o_lng'], 1000000);
                }
            }                       
        }
        return parent::where($filter, $pre, $ANDOR);
    }
    /**
     * 云打印接口
     * param $order_id int  订单号
     * param $num     int  需要打印的份数
     */
    public function yunprint($order_id, $num=null)
    {
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add('订单不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在',211);
        }else if(!$shop = K::M('shop/shop')->detail($order['shop_id'])) {
            $this->msgbox->add('商家不存在',212);
        }else if($order['from'] != 'waimai') {
            $this->msgbox->add('目前只支持外卖订单打印',213);
        }else if(!$printer = K::M('shop/print')->find(array('shop_id'=>$order['shop_id'],'from'=>'ylyun','status'=>1))){
            $this->msgbox->add('未设置或启用打印机',213);
        }else{
            if(!$num = (int)$num){
                $num = $printer['num'];
            }            
            $products = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id'])); 
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
            $content .= "<MN>".$nums."</MN>\n";
            $content .= "<center>"."{$shop['title']}"."({$shop['city_name']})"."</center>\n";
            $content .= "[下单时间]: ".date('Y-m-d H:i:s', $order['dateline'])."\n";
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            foreach($products as $k=>$v) {
                $content .= "<FH>".$v['product_name']."\t\t\t".'x'.$v['product_number']."\t  ".$v['amount']."</FH>\n";
            }
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            if($order['first_youhui'] > 0) {
                $content .= "首单优惠：\t\t\t\t  ".$order['first_youhui']."\n";
            }
            if($order['order_youhui'] > 0) {
                $content .= "下单立减：\t\t\t\t  ".$order['order_youhui']."\n";
            }
            if($order['hongbao'] > 0) {
                $content .= "红包抵扣：\t\t\t\t  ".$order['hongbao']."\n";
            }
            $content .= "<FH2><FB>- - - - - - - - - - - - - - - -</FB></FH2>\n";
            $content .= "<FW2><FH2><FB>总计￥".$js_price.$pay_status."</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>".$order['house'].$order['addr']."</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>".$order['mobile']."</FB></FH2></FW2>\n";
            $content .= "<FW2><FH2><FB>".$order['contact']."</FB></FH2></FW2>\n";
            if($num > 0 && isset($content)) {               
                $state = K::M('printer/ylyun')->send_print($printer['partner'],$printer['apikey'],$printer['machine_code'],$printer['mkey'],$content);
                if($state) {
                    $rlt = json_decode($state,true);
                    if($rlt->state == 2){
                        $this->msgbox->add('提交时间超时', 210);
                        break;
                    }
                    else if($rlt->state == 3){
                        $this->msgbox->add('参数有误', 211);
                        break;
                    }
                    else if($rlt->state == 4){
                        $this->msgbox->add('sign加密验证失败', 212);
                        break;
                    }
                    else{
                        $this->msgbox->add('数据提交成功');
                        return true;
                    }
                }  
            }
        }
        return false;
    }

    public function shop_members_count($shop_id)
    {
        $sql = "SELECT COUNT(distinct uid) as nums FROM {$this->table($this->_table)} WHERE `shop_id`={$shop_id} AND `order_status` IN (4,8)";   
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }
        return $row['nums'];
    }
}