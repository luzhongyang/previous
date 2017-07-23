<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_App extends Ctl
{
	// 安卓三端版本更新检查
    public function checkupgrade($params)
    {
        $items = array();
        $appcfg = $this->system->config->get('app_download');

        if(CLIENT_OS == 'ANDROID') {
            if(CLIENT_API == 'STAFF'){
                $items = array(
                    'staff_version'  => $appcfg['staff_version'],
                    'staff_download' => $appcfg['staff_download'],
                    'staff_intro'    => $appcfg['staff_intro'],
                    );
            }else if(CLIENT_API == 'BIZ'){
                $items = array(
                    'biz_version'    => $appcfg['biz_version'],
                    'biz_download'   => $appcfg['biz_download'],
                    'biz_intro'      => $appcfg['biz_intro'],
                    );
            }else{
               $items = array(
                    'waimai_version'  => $appcfg['waimai_version'],
                    'waimai_download' => $appcfg['waimai_download'],
                    'waimai_intro'    => $appcfg['waimai_intro'],
                    );
            }
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', $items);
    }

    // 获取后台网站基本设置
    public function info()
    {
        $attachCfg = K::M('system/config')->get('attach');
        $site = $this->system->config->get("site");
        $site['attachurl'] = $attachCfg['attachurl'];
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', $site);
    }
    //极光开发配置
    public function jpushCfg()
    {
        $cfg = K::M('system/config')->get('apppush');
        $this->msgbox->set_data('data', $cfg);
    }
    //关于我们
    public function about()
    {
        $config = $this->system->config->get("site");
        $this->msgbox->set_data('data', array('url'=>$config['siteurl'] . '/about/about-1.html'));
    }

    //使用协议
    public function protocol()
    {
        $config = $this->system->config->get("site");
        $this->msgbox->set_data('data', array('url'=> $config['siteurl'] . '/about/protocol-1.html'));
    }
}
