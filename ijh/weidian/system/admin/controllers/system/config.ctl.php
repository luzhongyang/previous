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
            print_r($data);die;
        }
    }
    public function setting($k=null)
    {
        if(empty($k)){
            $this->msgbox->add('很抱歉，您请求的页面不存在', 201);
        }else if(($cfg = $this->system->config->get($k)) === null){
            $this->msgbox->add('很抱歉，您请求的页面不存在', 201);
        }else{
            $pager['K'] = $k;
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
