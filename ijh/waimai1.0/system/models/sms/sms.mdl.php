<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: sms.mdl.php 10216 2015-05-13 12:44:44Z maoge $
 */

class Mdl_Sms_Sms extends Model
{   
    
    protected $sms = null;
    protected   $_sitetitle = null;
    protected   $_sitephone = null;
    protected   $_cityname = null;
    protected   $_dateline = null;
    protected   $_adminmobile = null;

    protected $_tmpl = array(
            'sms_login'=>'您的短信验证码是{code}，该验证码3分钟有效。【{site_title}】',
            'sms_verify'=>'您的短信验证码是{code}，该验证码3分钟有效。【{site_title}】',
        );
    
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->sms = K::M('sms/56dxw');
        $this->_config = $system->config->get('smsconfig');
        $this->_cfg = K::$system->config->get('site');
        $this->_sitetitle = $this->_cfg['title'];
        $this->_sitephone = $this->_cfg['phone'];
        $this->_cityname = $system->request['city']['city_name'];
        if(K::M('verify/check')->mobile($system->request['city']['mobile'])){
            $this->_cfg['mobile'] = $system->request['city']['mobile'];
        }
        $this->_dateline = date('Y-m-d H:i:s',__TIME);
        
    }
    
    //通知管理员的短信接口
    public function admin($key, $data=array())
    {
        if(empty($this->_config['mobile'])){
            $this->_config = K::$system->config->get('sms');
        }
        //一般接口都支持 ,分割的多个手机号 如果不支持的请在做逻辑处理！
        $mobiles = explode(',',$this->_config['mobile']);
        foreach($mobiles  as $mobile){
            $this->send($mobile, $key, $data, true);
        }
        return  true;
    }

    protected function _send($mobile, $content)
    {
        if(!$this->sms->send($mobile, $content)){
            //$msg = $this->sms->lastmsg;
            //$this->msgbox->add($msg, 450);
            if(__CFG::DEBUG){
                $this->msgbox->add(sprintf(L('短信接口错误:[%s:%s]'), $this->sms->lastcode, $this->lastmsg), 450);
            }else{
                $this->msgbox->add(sprintf(L('发送短信失败[%s]'), $this->sms->lastcode), 450);
            }
            K::M('sms/log')->create(array('mobile'=>$mobile, 'content'=>$content, 'sms'=>'56dx', 'status'=>0));
            return false;
        }
        K::M('sms/log')->create(array('mobile'=>$mobile, 'content'=>$content, 'sms'=>'56dx', 'status'=>1));
        return true;        
    }
    
    public function send($mobile, $tmpl, $data=array(), $checked=false)
    {   
        if(!$content = $this->_parse($tmpl, $data)){
            return false;
        }
        if(!$checked && !defined('IN_ADMIN')){
            if(!$this->check_sms(__IP, $title)){
                $this->msgbox->add($title, 451);
                return false;
            }
        }
        $status = $this->_send($mobile, $content);
        return $status;
    }

    public function check_sms($clientip=null, &$title='')
    {
        $clientip = $clientip ? $clientip : __IP;
        $access = K::$system->config->get('access');
        if($mobile_time = (int)$access['mobile_time']){
            if((__TIME - $mobile_time*60) < K::M('sms/log')->lasttime_by_ip($clienip)){
                $title = sprintf(L('两次短信间隔不能少于%s分钟'), $mobile_time);
                return false;
            }
        }
        if($mobile_count = (int)$access['mobile_count']){
            $time = __TIME - 86400;
            if($mobile_count <= K::M('sms/log')->count("clientip='{$clientip}' AND dateline>$time")){
                $title = sprintf(L('同一IP24小时只能发送%s短信'), $mobile_count);
                return false;
            }
        }
        return true;
    }

 
    protected function _parse($tmpl, $data=array())
    {
        if(preg_match('/^[\w\-\:]+$/i', $tmpl)){
            $ident = $tmpl;
            if(strpos($ident, 'sms_') === false){
                $ident = 'sms_'.$tmpl;
            }
            if($a = $this->_tmpl[$ident]){
                $tmpl = $a;
            }
        }
        $a = $b = array();
        foreach((array)$data as $k=>$v){
            $a[] = '{'.$k.'}';
            $b[] = $v;
        }
        $a[] = '{site_title}'; $a[] = '{site_phone}'; $a[] = '{city_name}'; $a[] = '{dateline}';$a[]='{site_name}';
        $b[] = $this->_sitetitle; $b[] = $this->_sitephone; $b[] = $this->_cityname; $b[] = $this->_dateline; $b[] = $this->_sitetitle;
        $content = str_replace($a, $b, $tmpl);
        return $content;
    }
}
