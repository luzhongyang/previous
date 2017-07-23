<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Mdl_Member_Member extends Mdl_Table {

    protected $_table = 'member';
    protected $_pk = 'uid';
    protected $_cols = 'uid,mobile,passwd,nickname,money,total_money,orders,jifen,face,wx_openid,wx_unionid,loginip,lastlogin,pmid,regip,closed,dateline';
    protected $_orderby = array('lastlogin'=>'DESC', 'uid'=>'DESC');

    public function member($u, $l = 'uid')
    {
        
        $l = strtolower($l);
        
        switch ($l) {
            case 'uid':
                $field = 'uid';
                break;
            case 'mobile':
                $field = 'mobile';
                break;
            case 'wx_unionid': case 'unionid':
                $field = 'wx_unionid';
                break;
            case 'wx': case 'wx_openid': case 'openid':
                $field = 'wx_openid';
                break;
            default:
                return false;
        }
        $sql = "SELECT * FROM " . $this->table($this->_table) . " WHERE " . $this->field($field, $u);
        
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
            return $row;
        }else{
            return false;
        }
        

        
    }

    public function guest()
    {
        static $guest = array('uid' => 0, 'mobile' => '', 'nickname' => '游客');
        return $this->_format_row($guest);
    }

    public function create($data, $checked = false)
    {
        if (!$checked && !($data = $this->_check($data))) {
            return false;
        }
        $data['regip'] = $data['regip'] ? $data['regip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        return $this->db->insert($this->_table, $data, true);

    }

    public function getPaynum()
    {
        return array(
            '1' => '1',
            '500'  => '50',
            '2000' => '250',
            '5000' => '600',
        );
    }

    public function update_money($uid, $money, $intro='')
    {
        return K::M('member/money')->update($uid, $money, $intro);
    }

    public function update_total_money($uid, $money)
    {
        if($uid = (int)$uid){
            $sql = "UPDATE ".$this->table($this->_table)." SET `total_money`=`total_money`+{$money} WHERE uid='$uid'";
            return $this->db->Execute($sql);
        }
        return false;
    }

    public function update_jifen($uids, $jifen, $intro='', $admin='')
    {
        if(!$jifen = (int)$jifen){
            $this->msgbox->add('更变的美币值非法', 411);
        }else if(empty($intro)){
            $this->msgbox->add('变更日志不可为空', 412);
        }else{
            if($uids = K::M('verify/check')->ids($uids)){
                foreach(explode(',', $uids) as $uid){
                    $sql = "UPDATE ".$this->table($this->_table)." SET `jifen`=`jifen`+{$jifen} WHERE uid='$uid'";
                    if($this->db->Execute($sql)){
                        K::M('member/log')->log($uid, $money, $jifen, $intro, $admin);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function update_account($uid, $type, $num, $intro='', $admin='')
    {
        if($type == 'money'){
            return $this->update_money($uid, $num, $intro);
        }else{
            return $this->update_jifen($uid, $num, $intro);
        }
    }

    public function update_face($uid, $file='', $data=null)
    {
        $cfg = K::$system->config->get('attach');
        $D = $cfg['attachdir'];
        $a = strtoupper(md5($uid));
        $b = substr($a,0,3);
        $face = "face/{$b}/{$a}.jpg";
        if($data !== null){
            if(preg_match("/\<(\?php|\<\? )/is", $data)){
                $this->err->add('不是安全的图片', 999);
                return false;
            }
            K::M('io/dir')->create(dirname($D.$face));
            if(!file_put_contents($D.$face,$data)){
                $this->err->add('保存图片数据失败',501);
                return false;
            }
        }else if($file != $D.$face){
            if(!K::M('image/gd')->thumb($file, $D.$face,180,180,true)){
                $this->err->add('图片处理失败',502);
                return false;
            }
        }
        $face = $face."?".rand(100,999);
        $a = array('face'=>$face);
        $this->update($uid, array('face'=>$face), true);
        //刷新用户缓存
        return $face;
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

    public function check_mobile($mobile)
    {
        if(!K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add('手机号码格式不正确', 511);
            return false;
        }else if($member = K::M('member/member')->member($mobile, 'mobile')){
            $this->msgbox->add('此手机号已被占用', 512);
            return false;
        }
        return $mobile;
    }

    protected function _format_row($row)
    {
        if(!$row['face']){
            $row['face'] = 'default/face.png';
        }
        if(!$row['nickname']) {
            $row['nickname'] = '匿名';
        }
        $row['pid'] = sprintf("M%05d", $row['uid']);
        return $row;
    }


    protected function _check($row, $uid=null)
    {
        if($row['passwd'] && !preg_match('/[0-9a-f]{32}/', $row['passwd'])){
            if($uid && $row['passwd'] == '******'){
                unset($row['passwd']);
            }else{
                $row['passwd'] = md5($row['passwd']);
            }
        }
        if(isset($row['mobile'])){
            if($a = $this->member($row['mobile'], 'mobile')){
                if(empty($uid) || ($a['uid'] != $uid)){
                    $this->msgbox->add('手机号码已经存在', 511);
                }
            }
        }
        return parent::_check($row, $uid);
    }

    public function check_passwd($passwd)
    {
        
       if(!preg_match('/^[\x21-\x7E]{6,32}$/', $passwd)){
            $this->msgbox->add('用户密码只包含(数字,大小写字母,特殊符号,不含空格)长度6~32字符', 401);
            return false;
        }
        
        return $passwd;
    }

    public function up_passwd($uid, $passwd)
    {
       
        if(!$uid = (int)$uid){
            return false;
        }else if(!$passwd = $this->check_passwd($passwd)){
            return false;
        }else if(!$member = K::M('member/member')->detail($uid)){
            return false;
        }else {
            $passwd = md5($passwd);
            $sql = "UPDATE ".$this->table($this->_table)." SET `passwd`='{$passwd}',`paypasswd`='{$passwd}' WHERE uid='$uid'";
            return $this->db->Execute($sql);
        }
        //return K::M('member/member')->update($uid, array('passwd'=>md5($passwd),'paypasswd'=>md5($passwd))), true);
    }
}
