<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: 56dxw.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
Import::I('sms');
class Mdl_Sms_Yumsms implements Sms_Interface
{   
    protected $gateway = 'http://http.yunsms.cn/tx/?uid={uname}&pwd={passwd}&mobile={mobile}&content={content}&encode=utf8';
    protected $_cfg = array();
    public $lastmsg = '';
    public $lastcode = 1;
    public function __construct($system)
    {
        $this->_cfg = $system->config->get('sms');
    }
    
    public function send($mobile, $content)
    {
        $url = $this->gateway;
        $url = str_replace("{uname}", $this->_cfg['uname'], $url);
        $url = str_replace("{userpwd}", $this->_cfg['passwd'], $url);
        $url = str_replace("{mobile}", $mobile, $url);
        $url = str_replace("{content}", $content, $url);
         $http = K::M('net/http');
        if($ret = $http->http($url, array(), 'GET')){
            if((int)$ret == 100){
                return true;
            }else{
                $this->lastcode = $ret;
                $this->lastmsg = $this->get_error($ret);
            }
        }else{
            $this->lastmsg = '未知的错误';
        }
        return false;
    }

    private function get_error($code)
    {
        static $error_list = array('101'=>'验证失败','102'=>'短信不足','103'=>'操作失败','104'=>'非法字符','105'=>'内容过多','106'=>'号码过多','107'=>'频率过快','108'=>'号码内容空','109'=>'账号冻结','110'=>'禁止频繁单条发送','111'=>'系统暂定发送','112'=>'有错误号码','113'=>'定时时间不对','114'=>'账号被锁，10分钟后登录','115'=>'连接失败','116'=>'绑定IP不正确','120'=>'系统升级');
        if(!$err = $error_list[$code]){
            $err = '未知的错误';
        }
        return $err;
    }

    public function query()
    {
        $url = 'http://http.yunsms.cn/mm/?';
        $params = array('uid'=>$this->_cfg['uname'], 'pwd'=>md5($this->_cfg['passwd']));
        if($ret = K::M('net/http')->http($url, $params)){
            $a = explode('||', $ret);
            if($a[0] == 100){
                return $a[1];
            }else{
                $this->lastcode = $ret;
                $this->lastmsg = $this->get_error($ret);
            }
        }else{
            $this->lastmsg = '未知的错误';
        }
        return false;
    }
}