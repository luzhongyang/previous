<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Card_Log extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['card_id']){$filter['card_id'] = $SO['card_id'];}
if($SO['type']){$filter['type'] = $SO['type'];}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('card/log')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $card_id = array();
        foreach ($items as $v){
            $card_id[] = $v['card_id'];

        }
        $filter_1=array();
        $filter_1[':SQL'] = 'card_id in '.$card_id;
        if($card_name = K::M('card/card')->items($filter)){
            $items_user = array();
            foreach ($items as $v1){
                foreach ($card_name as $v2){
                    if($v1['card_id'] =$v2['card_id'] ){
                        $v1['card_id'] = $v2['name']."(".$v2['mobile'].")";
                        $items_user[]=$v1;
                    }

                }

            }
        }



        $this->pagedata['items'] = $items_user;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:card/log/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:card/log/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($log_id = K::M('card/log')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?card/log-index.html');
            } 
        }else{
           $this->tmpl = 'admin:card/log/create.html';
        }
    }



}