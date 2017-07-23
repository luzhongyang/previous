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
    protected $_cols = 'order_id,city_id,shop_id,uid,product_number,product_price,package_price,freight,money,amount,order_youhui,first_youhui,hongbao,hongbao_id,contact,mobile,addr,house,lat,lng,note,order_status,pay_status,pay_code,comment_status,pay_ip,pei_amount,pay_time,staff_id,online_pay,pei_type,pei_time,order_from,cui_time,day,closed,clientip,dateline,lasttime';
    protected $_orderby = array('order_id'=>'DESC');

    public function create($data, $checked=false)
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

    public function set_payed($order_id, $trade=array())
    {        
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($res = $this->db->update($this->_table, array('pay_status'=>1), "order_id='{$order_id}'", true)){
            $a = array('online_pay'=>1, 'pay_ip'=>__IP,'pay_time'=>__TIME,'lasttime'=>__TIME,'pay_code'=>$trade['code']);
            $this->update($order_id, $a, true);
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'payment','log'=>L('订单支付成功'),'type'=>2));
            if($m = K::M('member/member')->detail($order['uid'])){
                if($wx_openid = $m['wx_openid']){
                    $this->payed_wxmsg($wx_openid, $order);
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
        }else if(in_array($order['order_status'], array(3,4))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            $order_id = $order['order_id'];
            if($this->update($order_id, array('order_status'=>8), true)){
                $staff_amount = $shop_amount = 0;
                if($order['online_pay']){
                    if($order['pei_type'] && $order['staff_id']){
                        if($order['pei_type'] == 2){//代购订单，全部结算给配送员
                            $staff_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                            $log = sprintf(L('订单代购完成结算(ID:%s)'), $order_id);
                        }else{
                            $staff_amount = $order['pei_amount'];
                            $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'] - $staff_amount;
                            $log = sprintf(L('订单配送完成结算(ID:%s)'), $order_id);
                        }
                        if($staff_amount){
                            K::M('staff/staff')->update_money($order['staff_id'], $staff_amount, $log);
                        }
                    }else{
                        $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                    }
                    if($shop_amount){
                        K::M('shop/shop')->update_money($order['shop_id'], $shop_amount, sprintf(L('订单完成结算(ID:%s)'), $order_id));
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
                                }else if($a[1] == 'D'){ //递推邀请
                                    $dituiCfg = K::$system->config->get('ditui');
                                    if(($invite_member_amount = (float)$dituiCfg['invite_member_amount'])>0){
                                        if($ditui = K::M('ditui/ditui')->detail((int)$a[2])){
                                            if($dm = K::M('ditui/member')->detail_by_uid($order['uid'])){
                                                if($dm['signup_amount'] == 0){
                                                    K::M('ditui/member')->update($dm['mid'], array('signup_amount'=>$invite_member_amount));
                                                    $log = sprintf(L('邀请用户(%s)首单奖励:￥%s'), $m['nickname'], $invite_member_amount);
                                                    K::M('ditui/ditui')->update_money($ditui['ditui_id'], $invite_member_amount, $log);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
                if($from == 'admin'){
                    $log = L('管理员确认订单完成');
                }else if($from == 'system'){
                    $log = L('超过3小时系统自动确认订单完成');
                }else if($from == 'shop'){
                    $log = L('商家确认订单完成');
                }else{
                    $log = L('用户确认订单完成');
                }
                K::M('order/log')->create(array('order_id'=>$order_id, 'type'=>6, 'from'=>$from, 'log'=>$log));
                return true;
            }
        }
        return false;
    }


    //取消/退单 退回余额+在线支付金额到余额，退回红包
    public function cancel($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if(in_array($order['order_status'], array(0, 1, 2, 3, 4, 5))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            if($from == 'member' && $order['order_status'] == 1){//用户可以在未接单时直接退单
                $this->msgbox->add(L('商家已接单不可取消'), 451);
                return false;
            }
            if($this->update($order['order_id'], array('order_status'=>-1))){
                $money = $order['money'];
                if($order['pay_status']){
                    $money += $order['amount'];
                }
                if($money > 0){ //退回到余额
                    K::M('member/member')->update_money($order['uid'], $money, sprintf(L('订单(ID:%s)取消退回到余额'), $order['order_id']));
                }
                if($order['hongbao_id']){ //退还红包
                    K::M('hongbao/hongbao')->update($order['hongbao_id'], array('order_id'=>0, 'used_time'=>0, 'used_ip'=>''));
                }
                //商品库存放在后继版本处理
                if($from == 'system'){
                    $log = sprintf(L('订单超时系统取消(ID:%s)'), $order['order_id']);
                }else if($from == 'admin'){
                    $log = sprintf(L('管理员取消订单(ID:%s)'), $order['order_id']);
                }else if($from == 'shop'){
                    $log = sprintf(L('商家取消订单(ID:%s)'), $order['order_id']);
                }else{
                    $log = sprintf(L('用户取消订单(ID:%s)'), $order['order_id']);
                }
                K::M('order/log')->create(array('type'=>-1, 'from'=>$from, 'log'=>$log, 'order_id'=>$order['order_id']));
                return true;
            }
        }
        return false;
    }

    public function get_note()
    {
        return array(
            1=>array(
                1=>L('不要辣'),
                2=>L('少点辣'),
                3=>L('多点辣'),
            ),
            2=>L('不要香菜'),
            3=>L('不要洋葱'),
            4=>L('多点醋'),
            5=>L('多点葱'),
            6=>array(
                1=>L('去冰'),
                2=>L('少冰'),
                3=>L('多冰'),
            ),
        );
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
        $sql = "SELECT `day`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao, SUM(`pei_amount`) as day_pei_money  FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `day` ORDER BY day ASC $limit";      
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['day']] = $row;
            }
        }
        return $items;
    }

    public function count_by_shopid($filter=null, $page=1,$limit=30)
    {
        if($day = (int)$day){
            return array();
        }
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT `shop_id`, COUNT(1) as day_order, SUM(`amount`) as day_amount, SUM(`money`) as day_money, SUM(`hongbao`) as day_hongbao, SUM(`pei_amount`) as day_pei_money  FROM ".$this->table($this->_table)." WHERE {$where} GROUP BY `shop_id` ORDER BY shop_id ASC $limit";      
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['shop_id']] = $row;
            }
        }
        return $items;
    }
    public function get_order_status(){
        return array(
            '-1' => L('已取消'),
            '0' => L('未处理'),
            '1' => L('已接单'),
            '3' => L('配送开始'),
            '4' => L('配送完成'),
            '8' => L('订单完成'),
        );
    }
	
	public function  get_payments(){
        return array(
            'wxpay' => L('微信支付'),
            'alipay' => L('支付宝支付'),
            'money' => L('余额支付'),
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

    public function customs_by_shop($filter, $page=1, $limit=50, $count)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $items = array();
        $sql = "SELECT uid, SUM(`amount`+`money`) as total_amount, COUNT(1) total_order FROM ".$this->table($this->_table)." WHERE $where GROUP BY `uid` ORDER BY `uid` $limit";
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['uid']] = $row;
            }
        }
        return $items;    
    }

    protected function _format_row($row)
    {

        if($row['order_status'] < 0){
            $label = L('已取消');
        }else if(empty($row['order_status']) && ($row['online_pay'] && !$row['pay_status'])){
            $label = L('待支付');
        }else if(empty($row['order_status'])){
            $label = L('待接单');
        }else if($row['order_status']<2){
            $label = L('待配货');
        }else if($row['order_status']<3){
            $label = L('待配送');
        }else if($row['order_status']<4){
            $label = L('配送中');
        }else if($row['order_status']<5){
            $label = L('已送达');
        }else if($row['order_status'] < 8){
            $label = L('待完成');
        }else{
            $label = L('已完成');
        }
        $row['order_status_label'] = $label;
        $row['total_order_price'] = $row['product_price'] + $row['package_price'] + $row['freight'];

        return $row;
        
    }

    public function yunprint($order_id, $nums)
    {
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$shop = K::M('shop/shop')->detail($order['shop_id'])) {
            $this->msgbox->add(L('商家不存在',212));
        }else {
            $products = K::M('order/product')->items(array('order_id'=>$order['order_id'])); 
            $js_price = $order['amount'] + $order['money'];
            $payments = $this->get_payments();
            
            
            if($order['online_pay'] == 1) {$pay = '线上支付';}else {$pay = '线下支付';}
            if($order['pay_status'] == 1){$pay_status = '[已付]';}else {$pay_status = '[未付]';}
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

            if($nums > 0 && isset($content)) {
                $printer = K::M('shop/print')->find(array('shop_id'=>$order['shop_id'],'from'=>'ylyun','status'=>1));
                if(isset($printer)) {                 
                    $state = K::M('printer/ylyun')->send_print($printer['partner'],$printer['apikey'],$printer['machine_code'],$printer['mkey'],$content);
                    if($state) {
                        $rlt = json_decode($state);
                        if($rlt->state == 2){
                            $this->msgbox->add('提交时间超时',210);break;
                        }else if($rlt->state == 3){
                            $this->msgbox->add('参数有误',211);break;
                        }else if($rlt->state == 4){
                            $this->msgbox->add('sign加密验证失败',212);break;
                        }else {
                            $this->msgbox->add('数据提交成功');
                        }
                    }  
                }
            }
        }
    }


    public function payed_wxmsg($wx_openid, $order)
    {
        //获取模版消息配置
        $wx_config = $this->system->config->get('wx_config');
        $a = array('title'=>L('恭喜您！订单支付成功！订单完成！'), 'items' => array('OrderSn' => $order['order_id'], 'OrderStatus' => L('订单支付成功')), 'remark' =>sprintf(L('恭喜,您的订单于%s支付成功，订单交易完成！'), date('Y-m-d H:i:s',time())));
        $url = K::M('helper/link')->mklink('order:detail',array($order['order_id']), array(), 'www');
        return K::M('weixin/wechat')->wechat_client()->sendTempMsg($wx_openid, $wx_config['tmpl_order_status'], $url, $a);
    }
}