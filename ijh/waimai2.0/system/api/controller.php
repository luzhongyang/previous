<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: controller.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl extends Factory
{
    protected $_allow_fields = '';
    
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->cookie = $system->cookie;
        $this->InitializeApp();
        register_shutdown_function(array(&$this,'shutdown'));
    }

    //初始化当前应用程序控制器
    protected function InitializeApp()
    {   
        $this->msgbox->template('view:page/notice.html');
        $this->system->objctl = &$this;
        $this->auth = &$this->system->auth;
        if(CLIENT_API == 'STAFF'){
            $this->staff = &$this->system->staff;
            $this->staff_id = $this->staff['staff_id'];            
        }else if(CLIENT_API == 'BIZ'){
            $this->shop = &$this->system->shop;
            $this->biz = &$this->shop;
             $this->shop_id = $this->shop['shop_id'];
        }else{
            $this->MEMBER = &$this->system->MEMBER;
            $this->uid = $this->MEMBER['uid'];
            $this->uname = $this->MEMBER['uname'];
        }
    }    


    //数组键值过滤。通常用户过滤不允许前台修改的表字段
    public function check_fields($data, $fields=null)
    {
        if($fields === null){
            $fields = $this->_allow_fields;
        }
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array)$data as $k=>$v){
            if(!in_array($k, $fields)){
                unset($data[$k]);
            }
        }       
        return $data;
    }

    /**
     * $halt true:未登录直接停止程序运行，false:未登录返回false
     **/
    public function check_login($halt=true)
    {
        if(CLIENT_API == 'STAFF'){            
            $uid = $this->staff_id;
            $a = $this->staff;
        }else if(CLIENT_API == 'BIZ'){
            $uid = $this->shop_id;
            $a = $this->shop; 
        }else{
            $uid = $this->uid;
            $a = $this->MEMBER;
        }
        if(!$uid){
            $this->msgbox->add(L('NOLOGIN'),101);
            $this->msgbox->json();
            exit();
            /*if($halt){
                return false;
            }else{
                $this->msgbox->add('很抱歉，你还没有登录不能访问', 101);
                $this->msgbox->json();
                exit();
            }*/
        }
        return $a;
    }

    protected function filter_fields($fields,$row,$type=1)
    {
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array)$row as $k=>$v){
            if($type == 1){//如果不在fields里，则unset
                if(!in_array($k, $fields)){
                    unset($row[$k]);
                }
            }else{
               if(in_array($k, $fields)){
                    unset($row[$k]);
               } 
            }
            
        }       
        return $row;
    }
    

   
    public function error($error)
    {
        if($e == 404){
            exit('{"error":"404","message":"Api NotFund"}');
        }else if(is_numeric($e)){
            exit('{"error":"'.$e.'","message":"Api Error"}');
        }else{
            exit('{"error":"-1","message":"'.$e.'"}');
        }
    }

    public function shutdown()
    {
        if(__DEBUG){
            $api =  str_replace('/', '.', 'api.'.$_REQUEST['API']);
            K::M('system/logs')->log($api, array('GET'=>$_GET, 'POST'=>$_POST, 'COOKIE'=>$_COOKIE,'FILE'=>$_FILES,'result'=>$this->msgbox->outputdata)); 
        }       
    }

}