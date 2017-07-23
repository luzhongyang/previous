<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class RedirectAction extends CommonAction {

    public function index() {
        if($func_id = $this->_param('func_id')){
            $function = D('Function')->find($func_id);
            if(false !== strpos($function['url'], 'http://') || false !== strpos($function['url'], 'https://') ){
                header("Location:" . htmlspecialchars_decode($function['url']));die;
            }else{
                header("Location:" . U($function['url']));die;
            }
        }else{
            $this->error(404);
        }
    }

}
