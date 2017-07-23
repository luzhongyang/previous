<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author  shzhrui<anhuike@gmail.com>
 * $Id: controller.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl extends Factory
{
    
    public $MOD = array();
    public function __construct(&$system)
    {

		$system->objctl = $this;
        parent::__construct($system);
        $this->cookie = $system->cookie;
        $this->msgbox->template('merchant:page/notice.html');
        $this->system->auth = K::M('shop/auth');
        $this->auth = $this->system->auth;
        $request = $this->request;
        if($this->auth->token()){
            $this->shop_id = $this->auth->shop_id;
            $this->shop = $this->auth->shop;
            if(empty($this->shop['audit']) && ($this->request['ctl'] != 'biz/shop' || $this->request['act'] != 'index')) {
                $this->msgbox->add('店铺正在审核中,请耐心等待', 311);
				$this->cookie->delete('BIZ_TOKEN');
                $this->msgbox->set_data('forward', $this->mklink('merchant/account:login'));
                $this->msgbox->response();
            }
        }else{
            if('account'!=$request['ctl']){
                header("Location:".$this->mklink('merchant/account/login'));
                exit();
            }
        }
        $this->ctlmaps  = include(dirname(__FILE__) . '/controllers/ctlmaps.php');
        if('account'!=$request['ctl']) {
            $ctlmap = $this->_check_priv();
        }
        
        if (($waimai = K::M('waimai/waimai')->detail($this->shop_id)) && $waimai['audit'] == 1) {// 验证外卖
            $this->waimai = $waimai;
            $this->pagedata['waimai'] = $waimai;
            $this->pagedata['waimai_has_so'] = true;
        }
        if (($weidian = K::M('weidian/weidian')->detail($this->shop_id)) && $weidian['audit'] == 1) {// 验证微店
            if ($this->shop['have_fenxiao'] != 0 && $this->shop['have_fenxiao'] <= 3) {
                $this->pagedata['fenxiao_has_so'] = true;
            }
            $this->weidian = $weidian;
            $this->pagedata['weidian'] = $weidian;
            $this->pagedata['weidian_has_so'] = true;
        }
        if ($this->shop['have_tuan'] == 1) {// 验证团购
            $this->pagedata['tuan_has_so'] = true;
        }
        if ($this->shop['have_paidui'] == 1) {// 验证排队
            $this->pagedata['paidui_has_so'] = true;
        }
        if ($this->shop['have_dingzuo'] == 1) {// 验证订座
            $this->pagedata['dingzuo_has_so'] = true;
        }
        $this->request['ctlmap'] = $ctlmap;
        $this->pagedata['ctlgroup'] = $this->ctlgroup;
        $this->pagedata['ctlmenu'] = $this->ctlmenu;
        $this->pagedata['menu_list'] = $this->ctlmaps['index'];
        $this->InitializeApp();
    }

    protected  function menu_html($ctlmaps)
    {
        $html = '';
        $nav = '';
        $request = $this->request;

        //ul: collapse   li: class="active"
        foreach ($ctlmaps as $k=>$v){
            $k_arr = explode("|",$k);
            $link_1 = '';
            if(isset($k_arr[2])){
                $link_1 = $this->mklink($k_arr[2]);
            }
            //onclick='location_addr(\"{$link_1}\")'
            $html .= "
                    <li replace_li_1> <a href='javascript:;'><i class='{$k_arr[1]}'></i> <span class='nav-label'>{$k_arr[0]}</span> <span class='fa arrow'></span></a>
                        <ul class='nav nav-second-level replace_ul_1'>";

                foreach($v as $k1=>$v1){
                    if(1 == $v1['menu']){

//                        $html .= "
//                                <li replace_li_2> <a href='javascript:;'><i class='{$v1['icon']}'></i>{$v1['title']}<span class='fa arrow'></span></a>
//                                    <ul class='nav nav-third-level replace_ul_2'>";
                            foreach($v1['items'] as $k2=>$v2){
                                if(1 == $v2['menu']){
                                    $html .= "
                                        <li replace_li_3 menu_active='{$v2['ctl']}'> <a href='".$this->mklink($v2['ctl'])."'><i class='{$v2['icon']}'></i>{$v2['title']}</a> </li>";
                                    //定位菜单
                                    if($v2['ctl'] == 'merchant/'.$request['ctl'].':'.$request['act']){
//                                        echo 'aaaaa'.$v2['ctl'].'<hr />';
                                        $html = str_replace(" replace_ul_2"," collapse in",$html);
                                        $html = str_replace(" replace_ul_1"," collapse in",$html);
                                        $html = str_replace(" replace_li_3"," class='active'",$html);
                                        $html = str_replace(" replace_li_2"," class='active'",$html);
                                        $html = str_replace(" replace_li_1"," class='active'",$html);
                                        $nav = "<li><a href='#'>{$k_arr[0]}</a></li> 
                                                <li><a href='#'>{$v1['title']}</a></li> 
                                                <li  class='active'><a href='".$this->mklink($v2['ctl'])."'><strong>{$v2['title']}</strong></a></li>";
                                    }
                                }
                                else{
                                    //定位菜单,menu=false
                                    if($v2['ctl'] == 'merchant/'.$request['ctl'].':'.$request['act']){
                                        // nav 导航
//                                        echo 'aaaaa'.$v2['ctl'].$v2['nav'].'<hr />';
                                        $html = str_replace(" menu_active='{$v2['nav']}'","  class='active'",$html);
                                        $html = str_replace(" replace_ul_2"," collapse in",$html);
                                        $html = str_replace(" replace_ul_1"," collapse in",$html);
                                        $html = str_replace(" replace_li_3"," class='active'",$html);
                                        $html = str_replace(" replace_li_2"," class='active'",$html);
                                        $html = str_replace(" replace_li_1"," class='active'",$html);
                                        $nav = "<li><a href='#'>{$k_arr[0]}</a></li> 
                                                <li><a href='#'>{$v1['title']}</a></li> 
                                                <li  class='active'><a href='".$this->mklink($v2['ctl'])."'><strong>{$v2['title']}</strong></a></li>";
                                    }

                                }
                                $html = str_replace(" replace_li_3","",$html);
                            }
                        $html = str_replace(" replace_ul_2"," collapse",$html);
                        $html = str_replace(" replace_li_2","",$html);
//                        $html .= "
//                                    </ul>
//                                </li>";
                    }
                }
            $html = str_replace(" replace_ul_1"," collapse",$html);
            $html = str_replace(" replace_li_1","",$html);

            $html .= "
                        </ul>
                    </li>";
        }
//        die;
        return array('html'=>$html, 'nav' => $nav);
    }

    //初始化当前应用程序控制器
    protected function InitializeApp()
    {
   
        $this->system->objctl = &$this;
        //权限检测
        $this->admin = &$this->system->admin;
//        if(!$this->check_priv()){
//            $this->msgbox->add('您没有权限操作',-1);
//            $this->msgbox->response();
//        }
    }
    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['shop'] = $this->shop;
        $this->pagedata['MOD'] = $this->MOD;
        $this->pagedata['ADMIN'] = $this->admin->admin;
        $this->pagedata['OATOKEN'] = $this->system->OATOKEN;
        $this->pagedata['pager']['url'] = __APP_URL;
        $this->pagedata['pager']['res'] = __CFG::RES_URL;
        //$this->pagedata['pager']['request'] = $this->request;
        $this->pagedata['request'] = $this->request;
        $output = K::M('system/frontend');
        $output->setCompileDir(__CFG::DIR.'data/tplmerchant');
    }


    protected function _check_priv()
    {
        $ctlmap  = array();
        $request = $this->request;
        foreach($this->ctlmaps as $group=>$menu){
            foreach($menu as $k=>$v){
                foreach ($v['items'] as $kk=>$vv) {
                    if($vv['ctl'] == $request['ctl'].':'.$request['act']){
                        $this->ctlgroup = $group;
                        $this->ctlmenu = $v;
                        $this->ctlmaps[$group][$k]['active'] = true;
                        $this->ctlmaps[$group][$k]['items'][$kk]['active'] = true;
                        $ctlmap = $vv;
                    }
                }
            }
        }

        if($ctlmap){
            return $ctlmap;
        }elseif($this->request['XREQ'] || $this->request['MINI'] ){
            $this->msgbox->add('很抱歉，您没有权限访问', 201);
            $this->msgbox->response();
            exit();
        }else{
            $this->tmpl = 'merchant:nopriv.html';
        }

    }

    /*检测外卖功能是否开通*/
    public function check_waimai()
    {
        $waimai = K::M('waimai/waimai')->detail($this->shop_id);
        if($waimai['audit'] != 1){
            header("Location:".$this->mklink('waimai/shop:have'));
        }
    }

    /*检测团购是否开通*/
    public function check_tuan()
    {
        if($this->shop['have_tuan'] != 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }



    /*检测代金券是否开通*/
    public function check_quan()
    {
        if($this->shop['have_quan'] != 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }

    /*检测优惠买单是否开通*/
    public function check_maidan()
    {
        if($this->shop['have_maidan']!= 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }

    /*检测预约-排号是否开通*/
    public function check_paidui()
    {
        if($this->shop['have_paidui']!= 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }

    /*检测预约-订座是否开通*/
    public function check_dingzuo()
    {
        if($this->shop['have_dingzuo']!= 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }

    /*检测预约-排号是否开通*/
    public function check_diancan()
    {
        if($this->shop['have_diancan']!= 1) {
            header("Location:".$this->mklink('shop/open:index'));
        }
    }

    protected function logs($title='',$data=array())
    {
        return false;
        $admin_id = $this->admin->admin_id;
        $admin_name = $this->admin->admin_name;
        $action = $this->request['ctl'].':'.$this->request['act'];
        $title = $title ? $title : $this->MOD['title'];
        $data = $data ? $data : $this->request['uri'];
        $admin = $this->admin;
        return K::M('magic/logs')->write($admin_id,$admin_name,$action,'管理日志',$title,$data);
    }
    public function city_id($city_id)
    {
        if(CITY_ID && CITY_ID != $city_id){
            $city_id = CITY_ID;
        }
        return $city_id;
    }
    public function check_city($city_id)
    {
        return true;
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

    protected function filter_fields($fields, $row)
    {
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array)$row as $k=>$v){
            if(!in_array($k, $fields)){
                unset($row[$k]);
            }
        }
        return $row;
    }
}