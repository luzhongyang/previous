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
    protected $_cols = 'order_id,city_id,shop_id,uid,product_number,product_price,package_price,freight,money,amount,order_youhui,first_youhui,hongbao,hongbao_id,contact,mobile,addr,house,lat,lng,note,order_status,pay_status,pay_code,comment_status,pay_ip,pei_amount,pay_time,staff_id,online_pay,pei_type,ordered_time,order_from,cui_time,day,closed,clientip,dateline,lasttime,spend_number,spend_status';
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
            $a = array('online_pay'=>1, 'pay_ip'=>__IP,'pay_time'=>__TIME,'lasttime'=>time(),'pay_code'=>$trade['pay_code']);
            $this->update($order_id, $a, true);
            K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'payment','log'=>'订单支付成功','type'=>2));
        }
        return $res;
    }

    
    //确认订单 ，结算订单
    public function confirm($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if(in_array($order['order_status'], array(1,2,3,4))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            $order_id = $order['order_id'];
            if($this->update($order_id, array('order_status'=>8), true)){
                $staff_amount = $shop_amount = 0;
                if($order['online_pay']){
                    if($order['pei_type'] && $order['staff_id']){
                        if($order['pei_type'] == 2){//代购订单，全部结算给配送员
                            $staff_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                            $log = '订单代购完成结算(ID:'.$order_id.')';
                        }else{
                            $staff_amount = $order['pei_amount'];
                            $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'] - $staff_amount;
                            $log = '订单配送完成结算(ID:'.$order_id.')';
                        }
                        if($staff_amount){
                            K::M('staff/staff')->update_money($order['staff_id'], $staff_amount, $log);
                        }
                    }else{
                        $shop_amount = $order['amount'] + $order['hongbao'] + $order['money'];
                    }
                    if($shop_amount){
                        K::M('shop/shop')->update_money($order['shop_id'], $shop_amount, '订单完成结算(ID:'.$order_id.')');
                    }
                    // 首单奖励发放
                    $cfg = K::$system->config->get('invite');
                    if(($invite_order_money = (float)$cfg['invite_order_money'])>0){
                        if(K::M('order/order')->count(array('uid'=>$order['uid'], 'order_status'=>8))===1){
                            if($m = K::M('member/member')->detail($order['uid'])){
                                if(preg_match('/M(\d+)/i', $m['pmid'], $a)){
                                    if($pm = K::M('member/member')->detail((int)$a[1])){
                                        K::M('member/member')->update_money($pm['uid'], $invite_order_money, sprintf(L('邀请用户(%s)首单奖励:￥%s'), $m['nickname'], $invite_order_money));
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
        }else if(in_array($order['order_status'], array(0, 1, 2, 3, 4, 5))){ 
            ////-1:已取消，0：待支付，5：待消费，8：已完成
            if($from == 'member' && $order['order_status'] == 8){
                $this->msgbox->add('订单已完成不可取消', 451);
                return false;
            }
            if($this->update($order['order_id'], array('order_status'=>-1,'lasttime'=>__TIME))){
                $money = $order['money']; //余额抵扣
                if($order['pay_status']){
                    $money += $order['amount'];
                }
                if($money > 0){ //退回到余额
                    K::M('member/member')->update_money($order['uid'], $money, '预约服务订单(ID:'.$order['order_id'].')取消退回到余额');
                }
                if($order['hongbao_id']){ //退还红包
                    K::M('hongbao/hongbao')->update($order['hongbao_id'], array('order_id'=>0, 'used_time'=>0, 'used_ip'=>''));
                }
                //商品库存放在后继版本处理
                if($from == 'admin'){
                    $log = '管理员取消预约服务订单(ID:'.$order['order_id'].')';
                }else if($from == 'shop'){
                    $log = '商家取消预约服务订单(ID:'.$order['order_id'].')';
                }else{
                    $log = '用户取消预约服务订单(ID:'.$order['order_id'].')';
                }
                K::M('order/log')->create(array('type'=>-1, 'from'=>$from, 'log'=>$log, 'order_id'=>$order['order_id'], 'kind'=>'ordered'));
                return true;
            }
        }
        return false;
    }

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
            '-1' => '已取消',
            '0' => '未处理',
            '1' => '已接单',
            '3' => '配送开始',
            '4' => '配送完成',
            '8' => '订单完成',
        );
    }
	
	public function  get_payments(){
        return array(
            'wxpay' => '微信支付',
            'alipay' => '支付宝支付',
            'money' => '余额支付',
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
            $label = '已取消';
        }else if(empty($row['order_status']) && ($row['online_pay'] && !$row['pay_status'])){
            $label = '待支付';
        }else if(empty($row['order_status'])){
            $label = '待接单';
        }else if($row['order_status']<2){
            $label = '待配货';
        }else if($row['order_status']<3){
            $label = '待配送';
        }else if($row['order_status']<4){
            $label = '配送中';
        }else if($row['order_status']<5){
            $label = '已送达';
        }else if($row['order_status'] < 8){
            $label = '待完成';
        }else{
            $label = '已完成';
        }
        $row['order_status_label'] = $label;
        $row['total_order_price'] = $row['product_price'] + $row['package_price'] + $row['freight'];

        return $row;
        
    }

    
     public function get_last_dateline()
     {
         return (int)$this->db->GetOne("SELECT lasttime FROM ".$this->table($this->_table)." ORDER BY order_id DESC LIMIT 1");
     }
    

    /**
     * 生成订单消费密码
     */
    public function create_number()
    {    
        do{
            $no = date('Ymd') . rand(10000000, 99999999);
            $number = $this->db->GetRow("SELECT number FROM ".$this->table($this->_table)." WHERE number='{$no}'");
        } while ($number);
        return $no;
    }
}