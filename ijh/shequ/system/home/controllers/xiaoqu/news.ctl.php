<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_News extends Ctl_Xiaoqu
{
    /**
     * 新闻首页
     */
   public function index(){
       $this->tmpl = 'xiaoqu/news/index.html';
   }
   
   /**
    * 新闻详情
    * @param type $notice_id
    */
   public function detail($news_id){
       
       if(!$news_id){
           $this->msgbox->add('内容不存在',211);
       }else if(!$detail = K::M('xiaoqu/news')->detail($news_id)){
           $this->msgbox->add('内容不存在',212);
       }else{
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'xiaoqu/news/detail.html';
       }
   }
   
   
   /**
    * 加载新闻
    */
   
   public function loaddata($page = 1){
       $page = max((int)$page, 1);
       $filter = array();
       $filter['xiaoqu_id'] = $this->xiaoqu_id;
       $limit = 10;
       if(!$list = K::M('xiaoqu/news')->items($filter,null, $page, $limit,$count)){
           $list = array();
       }
       $this->pagedata['list'] = $list;
       $this->tmpl = 'xiaoqu/news/loaddata.html';
       $html = $this->output(true);
       $this->msgbox->set_data('html',trim($html));
       $this->msgbox->json();
   }
   
}
