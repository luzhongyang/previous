<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weixin_Wxpay extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['mch_id']){$filter['mch_id'] = "LIKE:%".$SO['mch_id']."%";}
if(is_array($SO['expire_time'])){if($SO['expire_time'][0] && $SO['expire_time'][1]){$a = strtotime($SO['expire_time'][0]); $b = strtotime($SO['expire_time'][1])+86400;$filter['expire_time'] = $a."~".$b;}}
        }
        if($items = K::M('weixin/wxpay')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weixin/wxpay/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:weixin/wxpay/so.html';
    }
    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('weixin/wxpay')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weixin/wxpay/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($shop_id = K::M('weixin/wxpay')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?weixin/wxpay-index.html');
            } 
        }else{
           $this->tmpl = 'admin:weixin/wxpay/create.html';
        }
    }
    public function edit($shop_id=null)
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/wxpay')->detail($shop_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('weixin/wxpay')->update($shop_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:weixin/wxpay/edit.html';
        }
    }


}