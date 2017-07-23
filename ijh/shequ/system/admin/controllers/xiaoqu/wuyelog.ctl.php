<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Xiaoqu_WuyeLog extends Ctl
{

    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
      if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['log_id']){$filter['log_id'] = $SO['log_id'];}
            if($SO['wuye_id']){$filter['wuye_id'] = $SO['wuye_id'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('xiaoqu/wuye/log')->items($filter, array('log_id'=>'desc'), $page, $limit, $count)){
			$pager['count'] = $count;
			$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
			$wuye_ids = array();
			foreach($items as $k=>$v){
				$wuye_ids[$v['wuye_id']] = $v['wuye_id'];
			}
			$wuye_list = K::M('xiaoqu/wuye')->items_by_ids($wuye_ids);
			$this->pagedata['items'] = $items;
			$this->pagedata['wuye_list'] = $wuye_list;
        }
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/wuye/log/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/wuye/log/so.html';
    }
}
