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
    protected $_cols = 'shop_id,city_id,contact,cate_id,mobile,phone,title,passwd,money,total_money,tixian_money,tixian_percent,have_waimai,have_tuan,have_quan,have_maidan,have_paidui,have_dingzuo,have_diancan,have_weidian,have_fenxiao,fenxiao_type,closed,lng,lat,banner,logo,score,business_id,area_id,addr,avg_amount,comments,audit,clientip,dateline,max_youhui,intro,info,verify_name,orderby';
    protected $_orderby = array('orderby'=>'ASC', 'score'=>'DESC', 'shop_id'=>'DESC');
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($shop_id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }   
        return $shop_id;
    }
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
        $cate = K::M('shop/cate')->detail($row['cate_id']);
        if($cate['parent_id']){
            $row['parent_id'] = $cate['parent_id'];
        }
        
        if($cate = $cate_list[$row['cate_id']]){
            $row['cate_title'] = $row['cate_name'] = $cate['title'];
        }
        
        if($parent = $cate_list[$row['parent_id']]){
            $row['cate_title'] = $parent['title'].'-'.$row['cate_title'];
            $row['cate_name']  = $parent['title'].'-'.$row['cate_name'];
        }
        if($row['comments']){
            $row['avg_score'] = $row['score']/$row['comments'];
        }else{
            $row['avg_score'] = 0;
        }
        if(!$row['logo']){
            $row['logo'] = 'default/shop_logo.png';
        }
        if(!$row['banner']){
            $row['banner'] = 'default/shop_logo.png';
        }
        $row['lat'] = bcdiv($row['lat'], 1000000,6);
        $row['lng'] = bcdiv($row['lng'], 1000000,6);
        // 店铺优惠券  “惠”  更改为 满减优惠
        if($coupon_items = K::M('maidan/maidan')->find(array('shop_id'=>$row['shop_id']))) {
            $coupon_items = unserialize($coupon_items['config']);
            $coupon_title = array();
            foreach ($coupon_items as $k => $v) {
                $coupon_title[] = "每满{$v['m']}元减{$v['d']}元";
                $shop_coupon[] = array('order_amount'=>$v['m'],'coupon_amount'=>$v['d']);
            }
            if($coupon_title){
                $row['coupon_title']  = implode(', ',$coupon_title);
            }
            if($shop_coupon) {
                $row['coupon'] = $shop_coupon;
            }
        }
        // 商户团购 “团”
        if($tuan = K::M('tuan/tuan')->find(array('shop_id'=>$row['shop_id'],'type'=>'tuan','ltime'=>'>:'.__TIME,'closed'=>0,'audit'=>1,'is_onsale'=>1),array('tuan_id'=>'desc'))) {
            $row['tuan_title'] = $tuan['price'].','.$tuan['title'];
        }
        // 商户代金券 “券”
        if($quan = K::M('tuan/tuan')->find(array('shop_id'=>$row['shop_id'],'type'=>'quan','ltime'=>'>:'.__TIME,'closed'=>0,'audit'=>1,'is_onsale'=>1),array('tuan_id'=>'desc'))) {
            $row['quan_title'] = $quan['price'].','.$quan['title'];
        }
        return $row;
    }

    public function change_youhui($shop_id)
    {
        if($shop_id = (int)$shop_id){
            $res = K::M('shop/youhui')->items(array('shop_id'=>$shop_id));
            K::M('shop/shop')->update($shop_id,array('youhui'=>serialize($res)));
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
            $this->msgbox->add('提现金额不正确', 411);
        }else if($money > $shop['money']){
            $this->msgbox->add('提现金额不正确', 412);
        }else if(!$account = K::M('shop/account')->detail($shop_id)){
            $this->msgbox->add('未设置提现帐号', 413);
        }else{
            $account_info = $account['account_type'].'('.$account['account_name'].','.$account['account_number'].')';
            if($this->update_money($shop_id, -$money, '账户资金提现:'.$account_info)){
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
            $this->msgbox->add('手机号码不正确', 451);
        }else if($a = $this->shop($mobile, 'mobile')){
            if($a['shop_id'] == $shop_id){
                return true;
            }else{
                $this->msgbox->add('该手机号已经被其他商户使用', 452);
            }
        }else if($this->update($shop_id, array('mobile'=>$mobile))){
            return true;
        }
        return false;
    }
    // 恢复回收站
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
    public function send($shop_id, $title, $content, $type='order', $order_id=0, $sound='newMsg.mp3', $money='0', $name='')
    {
        if(in_array($type, array('newWaimaiOrder', 'newOrder'))){
            $type = 'order';
            $sound = 'newOrder.mp3';
        }else{
            $sound = 'newMsg.mp3';
        }
        K::M('jpush/device')->send_shop($shop_id, $title, $content, array('type'=>$type, 'order_id'=>(int)$order_id, 'sound'=>$sound, 'money'=>$money, 'name'=>$name));
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
        if(isset($row['lat'])){
            $row['lat'] = round(bcmul($row['lat'], 1000000));
        } 
        if(isset($row['lng'])){
            $row['lng'] = round(bcmul($row['lng'], 1000000));
        }     
        return parent::_check($row, $shop_id);
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
        }
        return parent::where($filter, $pre, $ANDOR);
    }
}
