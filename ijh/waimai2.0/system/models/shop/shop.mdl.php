<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Shop extends Mdl_Table
{

    protected $_table = 'shop';
    protected $_pk = 'shop_id';
    protected $_cols = 'yy_status_type,shop_id,city_id,cate_id,mobile,passwd,phone,title,money,total_money,banner,logo,lat,lng,addr,views,orders,comments,praise_num,score,score_kouwei,score_fuwu,first_amount,min_amount,freight,pei_amount,pei_time,pei_type,pei_distance,yy_stime,yy_ltime,yy_status,is_new,yy_xiuxi,youhui,coupon,online_pay,is_daofu,is_ziti,info,pmid,audit,closed,clientip,dateline,tixian_percent,verify_name,orderby,freight_stage,weidian,pintuan';
    protected $_orderby = array('orderby'=>'ASC', 'praise_num'=>'DESC');


    public function shop($u, $l='shop_id')
    {
        $l = strtolower($l);
        switch ($l) {
            case 'shop_id':
                $field = 'shop_id';
                break;
            case 'mobile':
                $field = 'mobile';
                break;
            default:
                return false;
        }
        $sql = "SELECT * FROM " . $this->table($this->_table) . " WHERE " . $this->field($field, $u);
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }

        return $row;
    }

    protected function _format_row($row)
    {
        static $cate_list = null;
        if($cate_list === null){
            $cate_list = K::M('shop/cate')->fetch_all();
        }
        if($city = K::M('data/city')->city($row['city_id'])){
            $row['city_name'] = $city['city_name'];
        }
        if($cate = $cate_list[$row['cate_id']]){
            $row['cate_title'] = $row['cate_name'] = $cate['title'];
        }
        if(!$row['logo']){
            $row['logo'] = 'default/shop_logo.png';
        }
        if($row['yy_stime']){
            $row['yy_stime_line'] = strtotime($row['yy_stime']);
        }
        if($row['yy_ltime']){
            $row['yy_ltime_line'] = strtotime($row['yy_ltime']);
        }
        /*满减优惠开始*/
        $youhui = $order_youhui = $youhui_title =  $coupon_title = array();
        if($row['youhui']){
            foreach(explode(',', $row['youhui']) as $v){
                if($a = explode(':', $v)){
                    if($a[0] && $a[1]){
                        $order_youhui[$a[0]] = (int)$a[1];
                        $youhui_title[] = sprintf(L('满%s减%s'), $a[0], $a[1]);
                    }
                }
            }
            if($order_youhui){
                ksort($order_youhui);
                foreach($order_youhui as $k=>$v){
                    $youhui[] = array('order_amount'=>$k, 'youhui_amount'=>$v);
                }
            }
        }
        if($youhui_title){
            $row['youhui_title'] = implode(', ', $youhui_title);
        }
        if(empty($row['youhui_title'])){
            $row['youhui_title'] = '';
        }
        $row['order_youhui'] = $youhui;
        /*满减优惠结束*/

        /*店铺优惠券开始*/
        if($row['coupon']) {
            foreach(explode(',', $row['coupon']) as $v){
                if($b = explode(':', $v)){
                    if($b[0] && $b[1]) {
                        $shop_coupon[$b[0]] = (int)$b[1];
                        $coupon_title[] = sprintf(L('%s元'),$b[1]);
                    }
                }
            }
            if($shop_coupon) {
                ksort($shop_coupon);
                foreach($shop_coupon as $k=>$v) {
                    $coupon[] = array('order_amount'=>$k, 'coupon_amount'=>$v);
                }
            }
        }
        if($coupon_title){
            $row['coupon_title'] = implode(', ', $coupon_title);
        }
        if(empty($row['coupon_title'])){
            $row['coupon_title'] = '';
        }
        $row['order_coupon'] = $coupon;
        $row['pid'] = sprintf("S%05d", $row['shop_id']);
        if(preg_match('/(\d{1,2}):(\d{1,2})/', $row['yy_stime'], $m)){
            $row['yy_stime'] = sprintf("%02d:%02d", $m[1], $m[2]);
        }else{
            $row['yy_stime'] = '09:00';
        }
        if(preg_match('/(\d{1,2}):(\d{1,2})/', $row['yy_ltime'], $m)){
            $row['yy_ltime'] = sprintf("%02d:%02d", $m[1], $m[2]);
        }else{
            $row['yy_ltime'] = '23:00';
        }

        //增加营业时间状态
        if(1 == $row['yy_status']) {
            $row['yy_status_type'] = 1;
            $start_time = strtotime(date('Y-m-d ') . $row['yy_stime']);
            $end_time = strtotime(date('Y-m-d ') . $row['yy_ltime']);
            $now = time();
            if ($now >= $start_time && $start_time && $now <= $end_time) {
                //营业中
                $row['yy_status_type'] = 1;
            } else {
                $row['yy_status_type'] = 0;
            }
        }
        else if(2 == $row['yy_status']) {
            $row['yy_status_type'] = 2;
        }
        else{
            $row['yy_status_type'] = 0;
        }

        /*处理freight_stage取最小值开始*/
        $row['freight_stage'] = unserialize($row['freight_stage']);
        foreach($row['freight_stage'] as $fk => $fv){
            $new_arr[$fv['fm']] = $fv['fm'];
        }
        ksort($new_arr);
        $row['freight_price'] = array_shift($new_arr);
        if(!$row['freight_price']){
            $row['freight_price'] = 0;
        }
        /*处理freight_stage取最小值结束*/

        if(!$row['pei_time']) {
            $row['pei_time'] = 30;
        }
        return $row;


    }

    public function change_youhui($shop_id)
    {
        if($shop_id = (int)$shop_id){
            if($items = K::M('shop/youhui')->items(array('shop_id'=>$shop_id))){
                $youhui_array = array();
                foreach($items as $k=>$v){
                    $youhui_array[$v['order_amount']] = $v['youhui_amount'];
                }
                K::M('shop/youhui')->update_youhui($shop_id, $youhui_array);
            }
            return true;
        }else{
            return false;
        }
    }

    public function update_money($shop_id, $money, $intro, $admin='')
    {
        if(($shop_id = (int)$shop_id) && ($money = (float)$money)){
            if($money > 0){
                $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money}, `total_money`=`total_money`+{$money} WHERE shop_id='$shop_id'";
            }else{
                $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE shop_id='$shop_id'";
            }
            if($this->db->Execute($sql)){
                return K::M('shop/log')->create(array('shop_id'=>$shop_id, 'money'=>$money, 'intro'=>$intro, 'admin'=>$admin));
            }
        }
        return false;
    }

    public function tixian($shop_id, $money, $shop=null)
    {
        if(($shop == null) && !($shop = $this->detail($shop_id))){
            return false;
        }else if(!$money = (float)$money){
            $this->msgbox->add(L('提现金额不正确'), 411);
        }else if($money > $shop['money']){
            $this->msgbox->add(L('提现金额不正确'), 412);
        }else if(!$account = K::M('shop/account')->detail($shop_id)){
            $this->msgbox->add(L('未设置提现帐号'), 413);
        }else{
            $account_info = $account['account_type'].'('.$account['account_name'].','.$account['account_number'].')';
            if($this->update_money($shop_id, -$money, sprintf(L('账户资金提现:%s'), $account_info))){
                $end_money = $shop['tixian_percent']*$money/100;
                return K::M('shop/tixian')->create(array('shop_id'=>$shop_id, 'money'=>$money, 'account_info'=>$account_info,'status'=>0, 'end_money'=>$end_money));
            }
        }
        return false;
    }

    public function addMoney($shop_id, $money, $intro='', $admin='')
    {
        return $this->update_money($shop_id, $money, $intro, $admin);
    }

    public function update_mobile($shop_id, $mobile)
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }else if(!$mobile = K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add(L('手机号码不正确'), 451);
        }else if($a = $this->shop($mobile, 'mobile')){
            if($a['shop_id'] == $shop_id){
                return true;
            }else{
                $this->msgbox->add(L('该手机号已经被其他商户使用'), 452);
            }
        }else if($this->update($shop_id, array('mobile'=>$mobile))){
            return true;
        }
        return false;
    }

    protected function _check($row, $shop_id=null)
    {

        if(isset($row['passwd']) && !preg_match('/^[0-9a-f]{32}$/i', $row['passwd'])){
            if($shop_id && $row['passwd'] == '******'){
                unset($row['passwd']);
            }else{
                $row['passwd'] = md5($row['passwd']);
            }
        }


        if(isset($row['mobile'])){
            $mobile = $row['mobile'];
            if($a = $this->shop($mobile, 'mobile')){
                if(empty($shop_id) || ($a['shop_id'] != $shop_id)){
                    $this->msgbox->add(L('手机号码已经存在'), 511);
                }
            }
        }
        return parent::_check($row, $shop_id);
    }

    public function regain($val)
    {
        $ret = false;
        if(!empty($val)) {
            if(is_array($val)){
                $val = implode(',', $val);
            }
            if(!K::M('verify/check')->ids($val)){
                return false;
            }
            $val = explode(',', $val);
            $ret = $this->db->update($this->_table, array('closed'=>0), self::field($this->_pk, $val));
            $this->clear_cache($val);
        }
        return $ret;
    }

    public function send($shop_id, $title, $content, $type='order', $order_id=0, $sound='newMsg.mp3')
    {
        if(in_array($type, array('newWaimaiOrder', 'newOrder'))){
            //$type = 'order';
            $sound = 'newOrder.mp3';
        }else{
            $sound = 'newMsg.mp3';
        }
        $extras = array('type'=>$type, 'order_id'=>(int)$order_id, 'sound'=>$sound, 'print_order_id'=>0);
        if($type == 'newOrder'){
            $extras['print_order_id'] = $order_id;
        }
        K::M('jpush/device')->send_shop($shop_id, $title, $content, $extras);
        $a = array('shop_id'=>$shop_id, 'title'=>$title, 'content'=>$content);
        //0:所有消息 1:订单消息, 2:评价消息,3:投诉消息,4:系统消息 
        switch ($type) {
            case 'order': case 1:
                $a['order_id'] = (int)$order_id;
                $a['type'] = 1; break;
            case 'comment': case 2:
                $a['type'] = 2; break;
            case 'complaint': case 3:
                $a['type'] = 3; break;
            case 4:
                $a['type'] = 4; break;
            default:
                $a['type'] = 0; break;
        }
        return K::M('shop/msg')->create($a);
    }

    public function update_pei_distance($shop_id,$arr_fkm)
    {
        $arr_fkm =(int) max($arr_fkm);
        $pei_distance = round($arr_fkm)>0?round($arr_fkm):3;
        $update = array(
            'pei_distance' => $pei_distance
        );
        $is_update = K::M('shop/shop')->update($shop_id,$update);
    }
}
