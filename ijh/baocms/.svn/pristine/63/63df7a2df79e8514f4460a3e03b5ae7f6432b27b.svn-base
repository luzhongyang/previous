<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CommonAction extends Action {

    protected $_fenzhan = array();
    protected $_CONFIG = array();

    protected function _initialize() {
        $this->_fenzhan = session('fenzhan');

        if (strtolower(MODULE_NAME) != 'login' && strtolower(MODULE_NAME) != 'public') { //public 不受权限控制
            if (empty($this->_fenzhan)) {
                header("Location: " . U('login/index'));
                die;
            }
			
			  if(strstr($this->_fenzhan['username'],'fenzhan') ){
				 if($this->isPost()){
					$this->baoError('演示站不提供数据操作!');
				 }
				 if(strtolower(ACTION_NAME) == 'delete'){
					$this->baoError('演示站不能删除数据！');
				 }
				 if(strtolower(ACTION_NAME) == 'audit'){
					$this->baoError('演示站不能审核数据');
				 }
                                if(strtolower(ACTION_NAME) == 'uninstall'){
					$this->baoError('演示站不能卸载数据');
				 }
				 $username = 'fenzhan'.date('Ymd',NOW_TIME);
			
				// print_r($this->_fenzhan);die;
				 if( trim($username) != trim($this->_fenzhan['username'])){
					$this->error('演示账号已经过期！不可以再继续操作！');
				 }
			 }
			
            if ($this->_fenzhan['role_id'] != 1) {

                $this->_fenzhan['menu_list'] = D('RoleMaps')->getMenuIdsByRoleId($this->_fenzhan['role_id']);
                if (strtolower(MODULE_NAME) != 'index') { //其他页面需要判断权限
                    $menu_action = strtolower(MODULE_NAME . '/' . ACTION_NAME);

                    $menu = D('Menu')->fetchAll();
                    $menu_id = 0;
                    foreach ($menu as $k => $v) {
                        if ($v['menu_action'] == $menu_action) {
                            $menu_id = (int) $k;
                            break;
                        }
                    }
                    if (empty($menu_id) || !isset($this->_fenzhan['menu_list'][$menu_id])) {
                        //var_dump($this->_fenzhan['menu_list']);exit;
                        $this->error('很抱歉您没有权限操作模块:' . $menu[$menu_id]['menu_name']);
                    }
                }
            }
            //权限及其他的逻辑处理
        }
        $this->_CONFIG = D('Setting')->fetchAll();
        define('__HOST__', 'http://'.$_SERVER['HTTP_HOST']);
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('admin', $this->_fenzhan);
		
        $this->assign('today', TODAY); //兼容模版的其他写法
        $this->assign('nowtime', NOW_TIME);
    }

    protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {

        parent::display($this->parseTemplate($templateFile), $charset, $contentType, $content = '', $prefix = '');
    }

    protected function parseTemplate($template = '') {
        $depr = C('TMPL_FILE_DEPR');
        $template = str_replace(':', $depr, $template);
        // 获取当前主题的模版路径
        define('THEME_PATH', BASE_PATH . '/' . APP_NAME . '/Fenzhan/');
        define('APP_TMPL_PATH', __ROOT__ . '/' . APP_NAME . '/Fenzhan/');
        // 分析模板文件规则
        if ('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
        } elseif (false === strpos($template, '/')) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower($template);
        }
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }

    protected function baoSuccess($message, $jumpUrl = '', $time = 3000) {
        $str = '<script>';
        $str .='parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str.='</script>';
        exit($str);
    }

    protected function baoError($message, $time = 3000, $yzm = false) {
        $str = '<script>';
        if ($yzm) {
            $str .='parent.error("' . $message . '",' . $time . ',"yzmCode()");';
        } else {
            $str .='parent.error("' . $message . '",' . $time . ');';
        }
        $str.='</script>';
        exit($str);
    }

    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    protected function ipToArea($_ip) {
        return IpToArea($_ip);
    }

}