<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: auth.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Wuye_Auth extends Model
{   
    public $wuye_id = 0;
    public $wuye = array();
    public $token =  null;
    public function token($token=null)
    {
        $token = $token !== null ? $token : $this->cookie->get('WUYE_TOKEN');
        if($token){
            if($this->_check_token($token)){
                $a = array('WUYE_TOKEN'=>$token,'AGENT'=>$_SERVER['HTTP_USER_AGENT']);
                K::$system->OTOKEN = K::M('secure/crypt')->arrhex($a);
                return true;
            }
            $this->cookie->delete('WUYE_TOKEN');
        }
        return false;
    }
    /**
     * 用户登录
     * @param   $u  wuye_id/手机号
     * @param   $p  密码{明文密码}
     */
    public function login($u, $p, $l=null, $ismd5=false, $keep=false)
    {
        $passwd =$ismd5 ? $p : md5($p);
        if($l === null){
            if(K::M('verify/check')->mobile($u)){
                $l = 'mobile';
            }else{
                $l = 'wuye_id';
            }
        }
        if(!$wuye = K::M('xiaoqu/wuye')->wuye($u, $l)){
            $this->msgbox->add('手机号不存在!!',111);
        }else if($wuye['passwd'] != $passwd){
            $this->msgbox->add('登录密码不正确!!',112);
        }else if($wuye['closed']){
            $this->msgbox->add('很抱歉,该物业已锁定不能登录',113);
        }else{
            $this->wuye_id = $wuye['wuye_id'];
            $this->wuye = $wuye;
            $expire = $keep ? 2592000 : 0;
            $token = $this->create_token($this->wuye_id, $passwd);
            $this->cookie->delete('WUYE_TOKEN');
            $this->cookie->set('WUYE_TOKEN', $token, $expire);
            $this->token = $token;
            return $wuye;
        }
        return false;       
    }
    public function loginout()
    {
        $this->cookie->delete('WUYE_TOKEN');
        return true;            
    }
    
    public function manager($wuye_id){
        $wuye_id = (int)$wuye_id;
        if(!$wuye = K::M('xiaoqu/wuye')->detail($wuye_id)){
           return false;
        }else{
            $token = $this->create_token($wuye_id, $wuye['passwd']);
            $this->cookie->delete('WUYE_TOKEN');
            $this->cookie->set('WUYE_TOKEN', $token);
            return true;
        }
    }
    
    //生成TOKEN
    public function create_token($wuye_id, $pwd)
    {
        $s = strtoupper(md5($_SERVER['HTTP_USER_AGENT'].$wuye_id.md5(__CFG::SECRET_KEY.$pwd,true)));
        $token = "{$wuye_id}-KT{$s}";
        return $token;
    }
    public function update_passwd($pwd, $ismd5=true)
    {
        $pwd = trim($pwd);
        if(!$this->wuye_id){
             $this->msgbox->add("你没有权限修改密码",401);
        }else if($ismd5 && !preg_match("/^[0-9a-f]{32}$/i", $pwd)){
            $this->msgbox->add("密码的格式不正确",402);
        }else if(!$ismd5 && !preg_match('/^[\x20-\x7E]{6,16}$/',$pwd)){
            $this->msgbox->add("密码的格式不正确",403);
        }else{
            $this->passwd = $ismd5 ? $pwd : md5($pwd);
            if(K::M('xiaoqu/wuye')->update($this->wuye_id, array('passwd'=>$this->passwd))){
                $this->passwd = md5($pwd);
                $cookie = self::$system->cookie;
                $expire = $cookie->get('TOKEN-KEEP') ? NULL : 86400;
                $token = $this->create_token($this->wuye_id, $this->passwd);
                $this->cookie->delete('WUYE_TOKEN');
                $cookie->set('WUYE_TOKEN', $token, $expire);  
                return true;
            }            
        } 
        return false;
    }
    protected function _check_token($token)
    {
        $a = explode('-',$token);
        if(!$wuye_id = intval($a[0])){
            return false;
        }
        if(!$wuye = K::M('xiaoqu/wuye')->wuye($wuye_id)){
            return false;
        }else if($this->create_token($wuye['wuye_id'], $wuye['passwd']) != $token){
            return false;
        }else if($wuye['closed']){
            return false;
        }
        $this->wuye_id = $wuye['wuye_id'];
        $this->wuye = $wuye;
        $this->token = $token;
        return true;    
    }
}