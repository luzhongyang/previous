<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Order extends Mdl_Table
{
    protected $_table = 'cloud_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,goods_id,attr_id,uid,use_coin,num,order_status,microtime,dateline,clientip';
    protected $_lottery_number_count = 0;
    
    
    public function member_num_count($filter,$flag=true)
    {
        $where = $this->where($filter);
        $sql = "SELECT attr_id,uid,sum(num) as buy_num FROM ".$this->table($this->_table)." WHERE $where GROUP BY attr_id";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                if($flag){
                    $items[$row['attr_id']] = $row;
                }else{
                    $items = $row['buy_num'];
                }
            }
        }
        return $items;
    }
    
    
    public function items_by_status($filter, $orderby, $page=1, $limit=10, &$count=0)
    {
        $where = '1';
        $ext_sql = '';
        if(is_array($filter)){
            if(isset($filter['attr'])){
                if($filter['attr']['status']>=0){
                    $where = K::M('cloud/attr')->where($filter['attr'], 'ext.');
                }else{
                    unset($filter['attr']['status']);
                    $where = K::M('cloud/attr')->where($filter['attr'], 'ext.');
                }
                $ext_sql = " LEFT JOIN ".$this->table('cloud_goods_attr')." ext ON o.`attr_id`=ext.`attr_id` ";
            }
        }
        $where = $where ." AND ". $this->where($filter, 'o.');
        $orderby = $this->order($orderby);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT COUNT(*) FROM ".$this->table($this->_table) . " o " . $ext_sql . " WHERE $where";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT ext.*,o.num,o.order_status,o.order_id,o.use_coin FROM ". $this->table($this->_table)." o $ext_sql WHERE $where $orderby $limit";
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $row = $this->_format_row($row);
                    if($row[$this->_pk]){
                        $items[$row[$this->_pk]] = $row;
                    }else{
                        $items[] = $row;
                    }
                }
            }
        }
        return $items;
    }
    
    public function update_coin($order_id, $order=array(), $use_coin)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }elseif((!$order) && (!$order = $this->detail($order_id))){
            return false;
        }elseif($order['order_status'] !=0){
            return false;
        }else{ 
            $need = $order['num'] - $order['use_coin'];
            if($use_coin == $need){ //全部付完coin
                if(K::M('member/member')->update_coin($order['uid'], -$need, '支付云购订单('.$order_id.')')){
                    $this->update($order_id,array('order_status'=>1,'use_coin'=>$order['num']));
                    K::M('cloud/number')->setcode($order['uid'], $order_id, $order['attr_id'], $order['num']);
                    K::M('cloud/attr')->update_count($order['attr_id'],'join',$order['num']);
                    return true;   
                }
            }else if($use_coin < $need){
                if(K::M('member/member')->update_coin($order['uid'], -$use_coin, '支付云购订单('.$order_id.')')){
                    $this->update_count($order_id, 'use_coin', $use_coin);
                    return true;
                }
            } 
        }
        return false;
    }
    
    public function set_payed($log, $trade=array())
    { //回调时候给用户发云购码再更新云购商品参与人数       
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($res = $this->db->update($this->_table, array('order_status'=>1), "order_id='{$order_id}'", true)){
            K::M('cloud/number')->setcode($order['uid'], $order_id, $order['attr_id'], $order['num']);
            K::M('cloud/attr')->update_count($order['attr_id'],'join',$order['num']);
            $attrs = K::M('cloud/attr')->detail($order['attr_id']);
            if($attrs['price'] == $attrs['join']){
                if($attrs['win_uid']){
                    K::M('cloud/attr')->update($attrs['attr_id'],array('status'=>1,'lottery_time'=>__TIME));
                }else{
                    K::M('cloud/attr')->lottery($attrs['attr_id']);
                }
            }
        }
        return $res;
    }
    
    
    /**
     * 
     * @param type $uid
     * @param type $attr_id
     * @param type $detail
     * @param type $num
     * @return boolean
     */
    
    public function create_user_order($uid,$attr_id,$detail=array(),$num){
        if(!$uid = (int)$uid){
            return false;
        }
        if(!$attr_id = (int) $attr_id){
            return false;
        }
        if(!$detail){
            $detail = K::M('cloud/attr')->detail($attr_id);
        }
        if(!$num = (int) $num){
            return false;
        }elseif(($detail['price'] -$detail['join'])<$num){
            return false;
        }
        $data = array(
            'goods_id'=>$detail['goods_id'],
            'attr_id'=>$attr_id,
            'uid'=>$uid,
            'num'=>$num,
            'dateline'=>__TIME,
            'clientip'=>__IP,
        );
        if($detail['win_uid']>0&&$detail['is_set']==1){ //后台设置过中奖用户的情况
            if($detail['price'] - $detail['join'] - $num >0){
                $data['microtime'] = sprintf("%03d", rand(0,999));
                $order_id = $this->create($data);
            }elseif($detail['price']-$detail['join']-$num==0){
                $last_49_items = K::M('cloud/order')->items(array('attr_id'=>$attr_id),array('dateline'=>'desc'),0,49);
                $last_times = 0;
                foreach($last_49_items as $item){
                    $last_times += intval(date('His',$item['dateline']).$item['microtime']);
                }
                $if_last_times = $last_times + intval(date('His',__TIME).'000');
                $if_number = $if_last_times%$detail['price'] + 100000001;
                if($lottery_number_item = K::M('cloud/number')->find(array('number'=>'>=:'.$if_number,'uid'=>$detail['win_uid'],'attr_id'=>$attr_id),array('number'=>'asc'))){
                    $microtime = $lottery_number_item['number'] - $if_number;
                    $win_number = $lottery_number_item['number'];
                }else{
                    $lottery_number_item_2 = K::M('cloud/number')->find(array('uid'=>$detail['win_uid'],'attr_id'=>$attr_id),array('number'=>'asc'));
                    $win_number = $lottery_number_item2['number'];
                    $yushu = $lottery_number_item_2['number'] - 100000001; //余数
                    $microtime = (floor($if_last_times/$detail['price'])+1)*$detail['price'] + $yushu - $last_times - intval(date('His',__TIME).'000');
                }
                //$win_number = ($last_times + intval(date('His',__TIME).$microtime))%$detail['price'] + 100000001;
                K::M('cloud/attr')->update($attr_id,array('win_number'=>$win_number));
                $data['microtime'] = sprintf("%03d",$microtime);
                $order_id = $this->create($data);
            }
        }else{  //正常流程
            $data['microtime'] = sprintf("%03d", rand(0,999));
            $order_id = $this->create($data);
            if($detail['price']-$detail['join']-$num==0){
                $last_50_items = K::M('cloud/order')->items(array('attr_id'=>$attr_id,'order_status'=>1),array('dateline'=>'desc'),0,50);
                $last_times = 0;
                foreach($last_50_items as $item){
                    $last_times += intval(date('His',$item['dateline']).$item['microtime']);
                }
                $win_number = $last_times%$detail['price'] + 100000001;
                $lottery_number_item = K::M('cloud/number')->find(array('number'=>$win_number,'attr_id'=>$attr_id));
                K::M('cloud/attr')->update($attr_id,array('win_uid'=>$lottery_number_item['uid'],'win_number'=>$win_number,'lottery_time'=>__TIME,'status'=>1));
            }
        }
        return $order_id;
    }
    
      
    protected function create_lottery_order($uid, $attr_id, $goods_id, $total_buy_count, $dateline)
    {
        $lottery_numbers = array();
        $ma_max = 100000001 + $total_buy_count;
        $ma_jieti = ceil($total_buy_count / 1000);
        if($total_buy_count < 1000){
            $rand_max = $total_buy_count;
        }else{
            $rand_max = 999;
        }
        for($i = 1; $i<$ma_jieti; $i++){
            $number = 100000001 + rand(0, $rand_max) + ($i-1)*1000;
            if($number > $ma_max){
                $number = $ma_max;
            }
            $lottery_numbers[$number] = $number;
        }
        $_rand_number_count = rand(5, 50);
        if(($total_buy_count - $_rand_number_count - $ma_jieti +1) > 0){
            for($i=0; $i<$_rand_number_count; $i++){
                $number = 100000001 + rand(0, $total_buy_count);
                $lottery_numbers[$number] = $number;        
            }
        }
        //create order
        $this->_lottery_number_count = count($lottery_numbers);
        $data = array(
            'goods_id' => $goods_id,
            'attr_id' => $attr_id,
            'uid' => $uid,
            'num' => $this->_lottery_number_count,
            'dateline' => $dateline,
            'order_status'=>1,
            'microtime' => sprintf("%03d", rand(0,999)),
            'clientip' => __IP
        );
        if($order_id = $this->create($data, true)){ //创建订单
            //下面分配云购码
            $sql = "UPDATE ".$this->table('cloud_number')." SET `uid`=".$uid.",`order_id`=".$order_id." WHERE `number` IN (".implode(',', $lottery_numbers).") AND `uid`=0 AND `attr_id`=".$attr_id; 
            $this->db->Execute($sql);  
        }
        //print_r($this->db->SQLLOG());die;
        return $order_id;   
    }
    
    
    
    
    public function create_robot_order($uid, $attr_id, $goods_id, $limit, $dateline)
    {
        $data = array(
            'goods_id' => $goods_id,
            'attr_id' => $attr_id,
            'uid' => $uid,
            'num' => $limit,
            'order_status'=>1,
            'dateline' => $dateline,
            'microtime' => sprintf("%03d", rand(0,999)),
            'clientip' => __IP
        );
        if($order_id = $this->create($data, true)){ //创建订单
        //print_r($this->system->db->SQLLOG());die;
            //下面分配云购码
            $sql = "UPDATE ".$this->table('cloud_number')." SET `uid`=".$uid.",`order_id`=".$order_id." WHERE `uid`=0 AND `attr_id`=".$attr_id." ORDER BY id ASC LIMIT ".$limit; 
            $this->db->Execute($sql);  
        }
        return $order_id;
    }
    

    /**
     * 初始化订单
     * @param type $max
     * @param type $num
     * @param type $uid
     * @param type $filter
     * @param type $attr_id
     * @param type $goods_id
     */
    public function orderStart($max,$num,$uid=null, $filter, $attr_id,$goods_id){   //创建初始化订单
        $buy_number_count = $total_by_number_count = 0;
        //$users = K::M('member/cloud')->selectUids(intval($num/50));
        $dateline = rand($filter[0], $filter[1]);
        if($uid = (int) $uid){
            $this->create_lottery_order($uid, $attr_id, $goods_id, $max, $dateline);
        }
        $total_by_number_count = $this->_lottery_number_count;
        $this->_lottery_number_count = 0;
        //随机users
        if(($num/50)<4){
            $avg = floor($num/4);
        }else{
            $avg = 50;
        }
        $users = K::M('member/cloud')->selectUids(intval($num/$avg));
        //print_r($users);
        
        $is_last = false;
        //if($users){
            while(!$is_last){
                   foreach($users as $v){
                       $limit = rand(1,$avg);
                       //print_r($limit);
                       $total_by_number_count +=$limit;
                       if($total_by_number_count > $num){
                           $limit = $num - ($total_by_number_count - $limit);
                           $is_last = true;
                       }
                       //create order
                       //print_r($limit);
                       $dateline = rand($filter[0], $filter[1]);
                       if($limit > 0){
                           $this->create_robot_order($v, $attr_id, $goods_id, $limit, $dateline);
                       }
                       if($is_last){
                           break;
                       }
                   }
               }
               //die;
         //}else{
          //      $this->create_robot_order($uid, $attr_id, $goods_id, $num, $dateline);
        //}
    }
    public function cancel($order_id){
        if(!$order_id = (int)$order_id){
            return false;
        }elseif(!$order = K::M('cloud/order')->detail($order_id)){
            return false;
        }elseif($order['order_status'] != 0){
            return false;
        }else{
            if(K::M('cloud/order')->update($order_id,array('order_status'=>-1))){
                if($order['use_coin']){
                    K::M('member/member')->update_coin($order['uid'],$order['use_coin'],"订单取消，返还".$order['use_coin']."夺宝币");
                }
                return true;
            }else{
                return false;
            }
        }
    }



    /*
     * $order_id 订单完成取消未付款完成的订单
     */
    
    public function complete_to_cancel($order_id){ 
        if(!$order_id = (int)$order_id){
            return false;
        }elseif(!$order = K::M('cloud/order')->detail($order_id)){
            return false;
        }elseif(!$detail = K::M('cloud/attr')->detail($order['attr_id'])){
            return false;
        }elseif(!$detail['status'] !=1){
            return false;
        }else{
           
            
        }
    }
    

    
    
    
}
