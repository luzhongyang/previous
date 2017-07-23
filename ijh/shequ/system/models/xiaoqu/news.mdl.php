<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_News extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_news';
    protected $_pk = 'news_id';
    protected $_cols = 'news_id,xiaoqu_id,from,title,intro,photo,content,views,closed,clientip,dateline';
    protected $_orderby = array('news_id'=>'DESC');
}