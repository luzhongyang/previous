<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class IndexAction extends CommonAction {
    
    public function index() {
        $this->mobile_title = '首页';
        $nav = D('Function')->where('is_index = 1')->order('orderby asc')->cache(true)->select();
        //var_dump($nav);exit;
        $nav_new = array();
        foreach($nav as $k=>$v){
            if(false !== strpos($v['url'], 'http://') || false !== strpos($v['url'], 'https://') ){
                $v['url'] = $v['url'];
            }else{
                if(strpos($v['url'], '/mobile')=== 0){ // /mobile/xxx
                    $v['url'] = $this->_CONFIG['site']['host'].$v['url'] ;
                }else if(strpos($v['url'], '/')=== 0 && strpos($v['url'], '/mobile')=== false){ // /ding/index
                    $v['url'] = $this->_CONFIG['site']['host'].'/mobile'.$v['url'] ;
                }else if(strpos($v['url'], 'mobile')=== 0){ // mobile/ding/index
                    $v['url'] = $this->_CONFIG['site']['host'].'/'.$v['url'] ;
                }else{ 
                    $v['url'] = $this->_CONFIG['site']['host'].'/mobile/'.$v['url'] ;
                }
                //$v['url'] = $this->_CONFIG['site']['host'].'/'.$v['url'] ;
            }
            $nav_new[$k] = $v;
        }
        $this->assign('nav',$nav_new);
        $this->display();
    }

    public function dingwei() {
        $lat = $this->_get('lat', 'htmlspecialchars');
        $lng = $this->_get('lng', 'htmlspecialchars');
        cookie('lat', $lat);
        cookie('lng', $lng);
        echo NOW_TIME;
    }

    public function search() {
        $keys = D('Keyword')->fetchAll();
        $keytype = D('Keyword')->getKeyType();
        $this->assign('keys',$keys);
        $this->mobile_title = '搜索';
        $this->display();
    }
	
	 public function more() {
        $this->mobile_title = '更多'; 
        $this->display();
    }


    public function qrcode()
    {
        require_cache(APP_PATH . 'Lib/phpqrcode/phpqrcode.php');
        $data = I('data');
        if(!$size = I('size')){
            $size = 6;
        }
        echo QRcode::png($data, false, QR_ECLEVEL_M, $size, 2);
        exit;
    }

}
