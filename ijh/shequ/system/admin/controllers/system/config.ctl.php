<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: config.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */
class Ctl_System_Config extends Ctl
{
    public $__call = 'index';
    public function index($k='index')
    {
        if($k == 'ucenter'){
            $this->ucenter();
        }else if($this->checksubmit()){
            $this->save($k);
        }else{
            $this->setting($k);
        }
    }
    
    
    public function appcate_create(){
        if($data = $this->checksubmit('data')){
        }
    }
    public function setting($k=null)
    {
        if(empty($k)){
            $this->msgbox->add('很抱歉，您请求的页面不存在1', 201);
        }else if(($cfg = $this->system->config->get($k)) === null){
            $this->msgbox->add('很抱歉，您请求的页面不存在', 201);
        }else{
            $pager['K'] = $k;
            // 充值配置单独处理 by 夏玉峰 2016-11-24 14:05:10
            if($k == 'moneypack') {
                $cfg = $cfg['money_pack'];
            }
            $this->pagedata['pager'] = $pager;
            $this->pagedata['config'] = $cfg;
            $this->tmpl = "admin:config/{$k}.html";
        }
    }

    public function save()
    {
        if(!$pk = $this->GP('K')){
            $this->msgbox->add('非法的请求', 201);
        }else if(!$data = $this->GP('config')){
            $this->msgbox->add('非法的数据提交', 202);
        }else if(($cfg = $this->system->config->get($pk)) === null){
            $this->msgbox->add('你要保存的设置不存在', 203);
        }else{
            if($pk == 'attach'){
                if($dir = $data['dir']){
                    if(preg_match('/\.(asp|php|aspx|jsp|cgi)/i', $dir)){
                        $this->msgbox->add('目录名不能含有不安全信息', 211);
                        $this->msgbox->response();
                    }else if(preg_match('/;/i', $dir)){
                        $this->msgbox->add('目录名不能含有不安全信息', 211);
                        $this->msgbox->response();
                    }                    
                }
            }
            if($_FILES['config']){
                foreach($_FILES['config'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'config')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if($pk == 'moneypack') {
                // 充值配置 单独处理  by 夏玉峰 2016-11-24 14:05:18
                if(empty($data['money']) && empty($data['give'])) {
                    $this->msgbox->add('充值配置数据提交不能为空', 212)->response();
                }else if(is_array($data['money']) && is_array($data['give'])) {
                    $new_data = array();
                    foreach ($data['money'] as $k => $v) {
                        if(!(int)$v['money']) {
                            $this->msgbox->add('请填写充值金额',215)->response();
                        }else if(!preg_match("/^\d*$/",$v)) {
                            $this->msgbox->add('充值金额格式不正确',213)->response();
                        }if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $data['give'][$k])) {
                            $this->msgbox->add('赠送金额格式不正确',214)->response();
                        }else {
                            $new_data[] = array('money'=>(int)$v, 'give'=>(float)$data['give'][$k]);
                        }
                    }
                    if($new_data) {
                        $data = array();
                        $data = array('money_pack'=>$new_data);
                    }
                }
            }
            if($this->system->config->set($pk, $data)){
                $this->msgbox->add('保存数据成功');
            }
        }
    }
    public function ucenter()
    {
        $uc = 'APPID,KEY,CHARSET,API,IP,CONNECT,DBHOST,DBUSER,DBPW,DBNAME,DBCHARSET,DBTABLEPRE';
        if($this->checksubmit()){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                $content = "<?php \n";
                $oHtml = K::M('content/html');
                foreach(explode(',', $uc) as $v){
                    $content .= "define('UC_{$v}', '".$oHtml->encode($data[$v])."');\n";
                }
                $content .= '?>';
                file_put_contents(__CFG::DIR.'uc_config.php', $content);
            }
        }else{
            $this->system->config->ucenter();
            if(defined('UC_API')){
                foreach(explode(',', $uc) as $v){
                    $UCENTER[$v] = constant("UC_{$v}");
                }
            }
            $this->pagedata['UCENTER'] = $UCENTER;
            $this->tmpl = 'admin:config/ucenter.html';
        }
    }
}
