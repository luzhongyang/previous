<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_About extends Ctl_Cloud
{
    
    public function index()
    {
        $items = K::M('article/article')->items(array('from'=>'article','cat_id'=>9),array('orderby'=>'asc'));
        $article_ids = array();
        foreach($items as $k=>$v){
            $article_ids[$v['article_id']] = $v['article_id'];
        }
        if($article_ids){
            $contents = K::M('article/content')->items(array('article_id'=>$article_ids));
        }
        foreach($items as $k=>$v){
            foreach($contents as $k1=>$v1){
                if($v1['article_id'] == $v['article_id']){
                    $items[$k]['content'] = $v1['content'];
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/about/items.html';
    }

}
