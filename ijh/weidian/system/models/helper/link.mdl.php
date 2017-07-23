<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: link.mdl.php 10478 2015-05-26 02:53:58Z xiaorui $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Helper_Link extends Model
{
    public function mklink($ctl, $args=array(), $params=array(), $http=false, $rewrite=true, $ext='.html')
    {
        static $_CFG = null;
        if($_CFG === null){
            $_CFG = K::$system->_CFG;
        }
        $link = '';
        $request = K::$system->request;
        if(strpos($ctl,':')){
            $a = explode(':',$ctl);
            $ctl = $a[0];
            $act = $a[1];
        }else{
            $act = null;
        }
        $rewrite = $rewrite && $_CFG['site']['rewrite'];
        //ctl add shop session id start
        if(isset($_SESSION['WEIDIAN_SHOP_ID'])){
            $is_exist_ship_id= stripos($ctl, "_".$_SESSION['WEIDIAN_SHOP_ID']);
            //add session id
            if ($is_exist_ship_id === false && substr($ctl, 0, 7) == 'weidian') {
                $ctl = str_replace("weidian", 'weidian_'.$_SESSION['WEIDIAN_SHOP_ID'], $ctl);
    //        echo '----'.$is_exist_ship_id.'///'; //test link
            }
        }
        //ctl add shop session id end
        $link = $this->_parse_rewrite($ctl, $act, $args, $rewrite, $ext);
        if($link == 'index/'){
            $link = '';
        }
        if(is_array($params)){
            $params = http_build_query($params);
        }else if(!is_string($params)){
            $params = '';
        }
        if(empty($rewrite) || 'ajax' === $http || defined('IN_ADMIN')){
            if(!defined('IN_MERCHANT')){
                $link = "index.php?{$link}";
            }
        }
        if($params){
            if(strpos($link, '?') === false){
                $link .= '?'.$params;
            }else{
                $link .= '&'.$params;
            }
        }
        if($link == 'index.php' || $link == 'index.php?'){
            $link = '';
        }




        if(defined('IN_MERCHANT')){
            if(strpos($link, 'merchant') === false && 1 == $http ){
                $link = "merchant/".$link;
            }
            $link = str_replace('merchant/','merchant/?',$link);
        }

        $prefix = '';
        if($http){
            $prefix = '';
            if(strpos((string)$http, 'http://') === 0){
                $prefix = $http;
            }else if('www' == $http){
                $prefix = $_CFG['site']['siteurl'];
            }else if('base' === $http || 'empty' === $http || 'ajax' === $http){
                $prefix = '';
            }
            $link = $prefix.'/'.$link;
        }


        return $link;
    }
    public function mkctl($ctl, $type='button', $args=null, $extname='.html', $attrs=array())
    {
        if(strpos($ctl,':')){
            $a = explode(':',$ctl);
            $ctl = $a[0];
            $act = $a[1];
        }else{
            $act = 'index';
        }
        $link = 'javascript:;'; $attr = ''; $nopriv = false;
        if($type == 'button' || $type == 'submit'){
            $attrs['class'] =  $attrs['class'] ? $attrs['class'] : 'bt-big';
        }
        if(!$mod =K::M('module/view')->ctlmap($ctl,$act)){
            $nopriv = true;
            $attrs['tips'] = '模块不存在';
            $attrs['disabled'] = 'disabled';
            $attrs["class"] = $attrs['class'] ? ($attrs['class'].' disabled') : 'disabled';
        }else if(!$this->check_priv($mod['mod_id'])){
            $nopriv = true;
            $attrs['tips'] = '没有权限';
            $attrs['disabled'] = 'disabled';
            $attrs["class"] = $attrs['class'] ? ($attrs['class'].' disabled') : 'disabled';
        }else{
            if($args === null){
                $args = '';
            }else if(is_array($args)){
                $a = '';
                foreach($args as $k=>$v){
                    $a .= "-{$v}";
                }
                $args = $a;
            }else if(!$args){
                $args = '';
            }
            $args = trim($args,'-');
            $args = $args ? "-{$args}" : '';
            $link = "?{$ctl}-{$act}{$args}{$extname}";
            if($type == 'submit'){
                $attr = 'action="'.$link.'" '.$attr;
            }else if($type == 'button'){
                $attr = 'action="'.$link.'" '.$attr;
            }else{
                $attr = 'href="'.$link.'" '.$attr;
            }
        }
        foreach((array)$attrs as $k=>$v){
            if(strlen($v)>5 && substr($v, 0, 5) == 'none:'){ //不显示的属性
                $attrs[$k] = substr($v, 5);
                continue;
            }else if(strlen($v)>5 && substr($v, 0, 5) == 'mini:'){
                if($nopriv){ //没有权限指令忽略
                    continue;
                }
                $k = "mini-{$k}";
                $v = substr($v,5);
            }else if(strlen($v)>4 && substr($v, 0, 4) == 'win:'){
                if($nopriv){ //没有权限指令忽略
                    continue;
                }
                $k = "win-{$k}";
                $v = substr($v,4);
            }
            $attr .= $k.'="'.$v.'" ';
        }
        $title = $attrs['title'] ? $attrs['title'] : $mod['title'];
        if($nopriv && $attrs['priv'] == 'hide'){
            return '';
        }else if($type == 'submit'){
            $title = isset($attrs['value']) ? $attrs['value'] : $title;
            $attr = $value.' '.$attr;
            $attr = $nopriv ? "type='submit' {$attr}" : $attr;
            //$attr =  $attrs['class'] ? $attr : "{$attr} class='bt-big'";
            return "<button {$attr}>{$title}</button>";
        }else if($type == 'button'){
            $title = isset($attrs['value']) ? $attrs['value'] : $title;
            $attr = $value.' '.$attr;
            $attr = $nopriv ? "type='button' {$attr}" : $attr;
            //$attr =  $attrs['class'] ? $attr : "{$attr} class='bt-big'";
            return "<button {$attr}>{$title}</button>";
        }else if($nopriv){
            return "<label {$attr}>{$title}</label>";
        }else{
            return "<a {$attr}>{$title}</a>";
        }
    }
    protected function check_priv($mod_id)
    {
        if(defined('IN_FENZHAN')){
            return K::$system->fenzhan->check_priv($mod_id);
        }else{
            return K::$system->admin->check_priv($mod_id);
        }
    }
    protected function _parse_rewrite($ctl, $act=null, $args=array(), $rewrite=true, $ext='.html')
    {
        if(defined('IN_ADMIN')){
            $link = "{$ctl}";
            $link .= $act ? "-{$act}" : '';
        }else{
            $link = $ctl ? $ctl.'/' : '';
            if((!empty($act) && $act != 'index') || !empty($args)){
                $link .= $act;
            }
        }
        if(!empty($args)){
            if(is_array($args)){
                $link .= '-'.implode('-', $args);
            }else if(is_string($args)){
                $link .= '-'.trim($args, '-');
                if(strpos($link, '.html')){
                    $ext = '';
                }
            }
        }
        if(empty($route_type) || !empty($args)){
            $link .= $ext;
        }
        return str_replace('/.html', '/', str_replace('/-', '-', $link));
    }
}
