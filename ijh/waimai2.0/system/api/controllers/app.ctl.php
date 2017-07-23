<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_App extends Ctl
{
    

    public function index($params)
    {
        $this->msgbox->add('Api test success');
        $this->msgbox->set_data('data', array('a'=>'b', 'c'=>'d'));
    }

    public function test($params)
    {
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', $params);
    }

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
        
    public function info()
    {
        $attachCfg = K::M('system/config')->get('attach');
        $site = $this->system->config->get("site");
        $jifen = $this->system->config->get("jifen");
        $site['attachurl'] = $site['item']['attachurl'] = $attachCfg['attachurl'];
        $site['jifen'] = $jifen['jifen_ratio'];
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', $site);
    }
    
}
