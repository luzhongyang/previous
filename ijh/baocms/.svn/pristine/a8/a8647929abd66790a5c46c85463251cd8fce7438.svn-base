<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class PassportAction extends CommonAction {

    private $create_fields = array('account', 'password', 'nickname');

 

    public function login() {
        if ($this->isPost()) {
        
            $account = $this->_post('account');
            if (empty($account)) {
            
                $this->error('请输入用户名!');
            }

            $password = $this->_post('password');
            if (empty($password)) {
             
                $this->error('请输入登录密码!');
            }
            $backurl = $this->_post('backurl', 'htmlspecialchars');
            if (empty($backurl))
                $backurl = U('index/index');
            if (true == D('Passport')->login($account, $password)) {
                $this->success('恭喜您登录成功！', $backurl);
            }
            $this->error(D('Passport')->getError());
        } else {
            if (!empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) && !strstr($_SERVER['HTTP_REFERER'], 'passport')) {
                $backurl = $_SERVER['HTTP_REFERER'];
            } else {
                $backurl = U('index/index');
            }
            $this->assign('backurl', $backurl);
            $this->display();
        }
    }
    


    public function logout() {

        D('Passport')->logout();
        $this->success('退出登录成功！', U('passport/login'));
    }

}
