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
    protected $_cols = 'shop_id,cate_id,city_id,mobile,passwd,title,contact,phone,total_money,money,intro,tixian_money,tixian_percent,lat,lng,logo,banner,addr,orderby,verify_name,audit,closed,clientip,dateline';

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

    //更新商户帐户总记录，未不增加帐户余额
    public function update_total_money($shop_id, $money, $intro, $admin='')
    {
        if(($shop_id = (int)$shop_id) && ($money = (float)$money) >0){
            $sql = "UPDATE ".$this->table($this->_table)." SET  `total_money`=`total_money`+{$money} WHERE shop_id='$shop_id'";
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

    public function send($shop_id, $title, $content, $type='order', $order_id=0, $sound='newMsg.mp3')
    {
        if(in_array($type, array('newWaimaiOrder', 'newOrder'))){
            $type = 'order';
            $sound = 'newOrder.mp3';
        }else{
            $sound = 'newMsg.mp3';
        }
        K::M('jpush/device')->send_shop($shop_id, $title, $content, array('type'=>$type, 'order_id'=>(int)$order_id, 'sound'=>$sound));
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

    protected function _format_row($row)
    {
        //$row['url'] = 'http://shop'.$row['shop_id'].'.'.__CFG::SHOP_DOMAIN;
        return $row;
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