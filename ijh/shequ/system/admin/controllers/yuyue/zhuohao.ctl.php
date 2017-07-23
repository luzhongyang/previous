<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Yuyue_Zhuohao extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        
        if($items = K::M('yuyue/zhuohao')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $shop_ids = $cate_ids = array();
            foreach($items as $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $cate_ids[$v['cate_id']] = $v['cate_id'];
            }
            if($shop_ids){
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($cate_ids){
                $this->pagedata['cate_list'] = K::M('yuyue/zhuohaocate')->items_by_ids($cate_ids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:yuyue/zhuohao/items.html';
    }

    public function edit($zhuohao_id=null)
    {
        if(!($zhuohao_id = (int)$zhuohao_id) && !($zhuohao_id = $this->GP('zhuohao_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('yuyue/zhuohao')->update($zhuohao_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['cate_list'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$detail['shop_id']), null, 1, 50);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:yuyue/zhuohao/edit.html';
        }
    }

    public function delete($zhuohao_id=null)
    {
        if($zhuohao_id = (int)$zhuohao_id){
            if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('yuyue/zhuohao')->delete($zhuohao_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('zhuohao_id')){
            if(K::M('yuyue/zhuohao')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}