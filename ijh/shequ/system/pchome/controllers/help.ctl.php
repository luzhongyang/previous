<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Help extends Ctl
{
    

    public function index()
    {

        $this->tmpl = 'pchome/help/help.html';
    }
    
    public function detail($article_id)
    {
        if(!$article_id = (int)$article_id){
            $this->error(404);
        }else if(!$detail = K::M('article/article')->detail($article_id)){
           $this->error(404);
        }else if($detail['linkurl']){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$detail['linkurl']);
            exit();
        }else{
            //print_r($detail);die;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = "pchome/help/detail.html";
        }
    }
    
    
    public function page($page)
    {
        if(!$detail = K::M('article/article')->detail_by_page($page)){
            $this->error(404);
        }else if($detail['linkurl']){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$detail['linkurl']);
            exit();
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = "pchome/help/detail.html";
        }
    }
    
    
    
    public function us(){
        $this->cate();
        $this->tmpl = 'pchome/help/us/index.html';
    }
    
    public function us_kf(){
        $this->cate();
        $this->tmpl = 'pchome/help/us/kf.html';
    }
    
    public function us_book(){
        $this->cate();
        if($data = $this->checksubmit('data')){
            //获取最后一次提交的时间
            $last_book = K::M('book/book')->find(array('clientip'=>__IP));
            
            if(!$data['content']){
                $this->msgbox->add('没有输入建议！',211);
            }else if(mb_strlen($data['content'],'UTF8') < 15){
                $this->msgbox->add('至少输入15个字！',212);
            }elseif((time() - $last_book['dateline']) <= 60){
                $this->msgbox->add('请休息一会儿再提交！',213);
            }else{
                $data['content'] = htmlspecialchars($data['content']);
                if($this->uid){
                    $data['nickname'] = $this->MEMBER['nickname'];
                    $data['uid'] = $this->uid;
                }else{
                    $data['nickname'] = '游客';
                }
                if(K::M('book/book')->create($data)){
                    $this->msgbox->add('提交成功！');
                }else{
                    $this->msgbox->add('提交失败！错误！',300);
                }
            }
        }else{
            $this->tmpl = 'pchome/help/us/book.html';
        }
    }
}