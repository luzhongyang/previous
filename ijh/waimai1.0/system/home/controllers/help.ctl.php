<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Help extends Ctl
{

    public function __construct($system)
    {
        parent::__construct($system);
        if(!in_array($this->system->request['act'], array('index', 'items','detail'))){            
            $this->system->request['args'] = array($this->system->request['act']);
            $this->system->request['act'] = 'page';
        }
    }

    public function index($page=1) 
    {
        $this->items($page);
    }
    
    public function items($page=1)
    {
        $filter = array();
        $filter['from'] = 'help';
        $filter['closed'] = 0;
        $filter['audit'] = 1; 
        $page= max(intval($page), 1);
        $count = 0;
        $items = K::M('article/article')->items($filter, array('article_id'=>'desc'), $page, 20, $count);
        $this->pagedata['items'] = $items;
        $this->pagedata['count'] = $count;
        $this->tmpl = "help/index.html";
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
            $this->pagedata['detail'] = $detail;
            $this->tmpl = "help/detail.html";
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
            $this->tmpl = "help/detail.html";
        }
    }    
}
