<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Staff_Staff extends Mdl_Table
{
    protected $_table = 'staff';
    protected $_pk = 'staff_id';
    protected $_cols = 'staff_id,city_id,from,name,mobile,passwd,face,sex,money,total_money,tixian_percent,tixian_money,orders,score,comments,lat,lng,lastlogin,loginip,verify_name,status,audit,closed,,updatetime,clientip,dateline,intro';
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }
    /**
     * 金额变动
     * @param $filed string,字段名称
     * @param $money int,变动金额,可正负
     */
    public function amount($filed, $money,$staff_id)
    {
        $sql = "UPDATE ". $this->table($this->_table) ." SET `{$field}`={$field}+{$money} WHERE `staff_id`={$staff_id}";
        return $this->db-Execute($sql);
    }
    
    public function staff($u, $l='staff_id')
    {
        $l = strtolower($l);
        switch ($l) {
            case 'staff_id':
                $field = 'staff_id';
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
    /**
     * 检测手机号码是否注册
     * @param $mobile
     */
    public function mobile($mobile)
    {
        return $this->detail_by_mobile($mobile);
    }
    /**
     * 检测登录密码
     * @param staff_id
     * @param $passwd
     */
    public function check_pswd($staff_id, $passwd)
    {
        $passwd = md5($passwd);
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE `staff_id`={$staff_id} AND `passwd`='{$passwd}'";
        if($row = $this->db->GetRow($sql)) return true;
        return false;
    }
    /**
     * 忘记密码
     * @param $passwd
     * @param $mobile
     */
    public function forget($passwd, $mobile)
    {   
        $passwd = md5($passwd);
        $sql = "UPDATE ".$this->table($this->_table)." SET `passwd`='{$passwd}' WHERE `mobile`={$mobile} ";
        return $this->db->Execute($sql);
    } 
    
    public function detail_by_mobile($mobile)
    {
        if(!$mobile = K::M('verify/check')->mobile($mobile)){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE ".$this->field('mobile', $mobile);
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }
        return $row;
    }
    public function update_mobile($staff_id, $mobile)
    {
        if(!$mobile = K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add(L('手机号码不正确'), 511);
            return false;
        }else if($a = $this->detail_by_mobile($mobile)){
            if($a['staff_id'] != $staff_id){
                $this->msgbox->add(L('手机号码已经存在'), 512);
                return false;
            }
        }
        return $this->update($staff_id, array('mobile'=>$mobile), true);
    }
    
    public function send($staff_id, $title, $content, $type='order', $order_id=0, $sound='newMsg.mp3')
    {
        if(in_array($type, array('newOrder', 'newOrder', 'paidan'))){
            $type = 'order';
            $sound = 'newOrder.mp3';
        }else{
            $sound = 'newMsg.mp3';
        }
        K::M('jpush/device')->send_staff($staff_id, $title, $content, array('type'=>$type, 'order_id'=>(int)$order_id, 'sound'=>$sound));
        return K::M('staff/msg')->send($staff_id, $title, $content);
    }

    protected function _format_row($row)
    {
        static $arr = array('house'=>'家政', 'weixiu'=>'维修', 'paotui'=>'骑手');
        $row['from_title'] = $arr[$row['from']];
        $row['lat'] = bcdiv($row['lat'], 1000000, 6);
        $row['lng'] = bcdiv($row['lng'], 1000000, 6);
        if(!$row['face']){
            $row['face'] = 'default/staff_face.png';
        }
        $row['avg_score'] = $row['comments'] ? round($row['score']/$row['comments'], 2) : 0;
        return $row;
    }
    protected function _check($data, $staff_id=null)
    {
        if(isset($data['passwd']) && !preg_match('/^[0-9a-f]{32}$/i', $data['passwd'])){
            if($staff_id && $data['passwd'] == '******'){
                unset($data['passwd']);
            }else{
                $data['passwd'] = md5($data['passwd']);
            }
        } 
        if(isset($data['mobile'])){
            $mobile = $data['mobile'];
            if($a = $this->staff($mobile, 'mobile')){
                if(empty($staff_id) || ($a['staff_id'] != $staff_id)){
                    $this->msgbox->add('手机号码已经存在', 511);
                }
            }
        }
        if(isset($data['lat'])){
            $data['lat'] = round(bcmul($data['lat'], 1000000));
        } 
        if(isset($data['lng'])){
            $data['lng'] = round(bcmul($data['lng'], 1000000));
        }
        return parent::_check($data, $staff_id);		
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
    
    public function update_money($staff_ids, $money, $intro)
    {
        if(!$money = (float)$money){
            $this->msgbox->add(L('更变的余额值非法'), 411);
        }else if(empty($intro)){
            $this->msgbox->add(L('余额变更日志不可为空'), 412);
        }else{
            if($staff_ids = K::M('verify/check')->ids($staff_ids)){
                foreach(explode(',', $staff_ids) as $staff_id){
                    if($money > 0){
                        // 订单结算 staff 余额增加、总收益增加
                       $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money}, `total_money`=`total_money`+{$money} WHERE staff_id='$staff_id'";
                    }else{
                        // 提现 仅减少余额值
                         $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`-{$money} WHERE staff_id='$staff_id'";
                    }
                    if($this->db->Execute($sql)){
                        K::M('staff/log')->log($staff_id, $money, $intro);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function tixian($staff_id, $money, $account=null)
    {
        if(($staff == null) && !($staff = $this->detail($staff_id))){
            return false;
        }else if(!$money = (float)$money){
            $this->msgbox->add(L('提现金额不正确'), 411);
        }else if($money > $staff['money']){
            $this->msgbox->add(L('提现金额不正确'), 412);
        }else{
            $account_info = $account['title'].'('.$account['name'].','.$account['account'].')';
            if($this->update_money($staff_id, -$money, sprintf(L('账户资金提现:%s'), $account_info))){
                $end_money = $staff['tixian_percent']*$money/100;
                return K::M('staff/tixian')->create(array('staff_id'=>$staff_id, 'money'=>$money, 'account_info'=>$account_info,'status'=>0, 'end_money'=>$end_money));
            }
        }
        return false;
    }      
    
    
    public function staff_by_ids($ids)
    {
        return $this->items_by_ids($ids);
    }
    public function staff_items($filter, $orderby, $page=1, $limit=50, &$count=0)
    {
        $where = '1';
        $ext_sql = '';
        if(is_array($filter)){
            if(isset($filter['house'])){
                $where = K::M('house/attr')->where($filter['house'], 'ext.');
                $ext_sql = " LEFT JOIN ".$this->table('house_attr')." ext ON o.`staff_id`=ext.`staff_id` ";
            }else if(isset($filter['weixiu'])){
                $where = K::M('weixiu/attr')->where($filter['weixiu'], 'ext.');
                $ext_sql = " LEFT JOIN ".$this->table('weixiu_attr')." ext ON o.`staff_id`=ext.`staff_id` ";
            }
            unset($filter['weixiu'], $filter['house']);
        }
        $where = $where ." AND ". $this->where($filter, 'o.');
        $orderby = $this->order($orderby);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT COUNT(DISTINCT o.`staff_id`) FROM ".$this->table($this->_table) . " o " . $ext_sql . " WHERE $where";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT DISTINCT o.* FROM ". $this->table($this->_table)." o $ext_sql WHERE $where $orderby $limit";
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
}
