<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web extends Ctl
{
    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->msgbox->template("web/page.html");
        $city_list = K::M('data/city')->fetch_all();
        foreach($city_list as $k=>$v){
            if($v['pinyin']){
                $py = strtoupper(substr($v['pinyin'], 0, 1));
                $v['py'] = $py;
                $city[$py][] = $v;
            }
        }
        
		$c = ksort($city);
		$this->pagedata['city_list']  = $city_list;
		$this->pagedata['city'] = $city;
        
        
        $cookie_city_id = $this->system->cookie->get('UxCityId');
        if($cookie_city_id){
            $mcity = array('city_id'=>$cookie_city_id,'city_name'=>$city_list[$cookie_city_id]['city_name']);
        }else{
            $site = K::M('system/config')->get('site');
            $city_id = $site['multi_city'];
            $mcity = array('city_id'=>$city_id,'city_name'=>$city_list[$city_id]['city_name']);
        }
        $this->pagedata['mcity'] = $mcity;
        //print_r($mcity['city_name']);die;
        $addr = htmlspecialchars($this->system->cookie->get('addr')); 
        $this->pagedata['addr'] = $addr;
        
        $CONFIG = $this->system->config->load(array('site'));
        $this->pagedata['site'] = $CONFIG['site'];
        
    }
    
    
    public function check_login()
    {
        if(!$this->uid){
            if($this->request['XREQ'] || $this->request['MINI']){
                $this->msgbox->add(L('NOLOGIN'), 101);
            }else{
                $this->tmpl = 'web/passport/login2.html';
            }
            $this->msgbox->response();
            exit();
        }
        return true;
    }
    
    public function error($error)
    {
        if(is_numeric($error)){
            $this->system->response_code($error);
        }
        $this->tmpl = "web/{$error}.html";
        $this->output();
    }

}
