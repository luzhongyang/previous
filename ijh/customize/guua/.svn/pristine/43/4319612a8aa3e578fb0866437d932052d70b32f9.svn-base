<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*余额*/
class Ctl_Ucenter_Integral extends Ctl_Ucenter
{
	public function index($page) 
	{
        if($mall = $this->GP('mall')){
            $this->pagedata['mall'] = $mall;
        }

        $filter = $pager = array();
        $page = max((int) $this->GP('page'), 1);
        $orderby = array('dateline'=>'desc');
        $filter['uid'] = $this->uid;
        $filter['type'] = 'jifen';

        if($items = K::M('member/log')->items($filter, $orderby, $page, 50)){
            foreach($items as $k => $v){
                $items[$k]['dateline'] = date('Y-m-d',$v['dateline']);
            }
        }

        
        $this->pagedata['items'] = $items;
        
        $this->tmpl = "ucenter/integral/index.html";
	}
    


}