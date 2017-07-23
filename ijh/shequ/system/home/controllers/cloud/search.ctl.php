<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Search extends Ctl_Cloud
{
    
    public function index()
    {
        $cfg = $this->system->config->get('hotsearch');
        $cfg = str_replace('，', ',', $cfg['hotsearch']);
        $this->pagedata['hotsearch'] = explode(',', $cfg);
        $this->tmpl = 'cloud/search.html';
    }

}
