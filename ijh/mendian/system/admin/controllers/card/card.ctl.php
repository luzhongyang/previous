<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Card_Card extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['card_id']){$filter['card_id'] = $SO['card_id'];}
if($SO['number']){$filter['number'] = "LIKE:%".$SO['number']."%";}
if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['uid']){$filter['uid'] = $SO['uid'];}
if($SO['grade_id']){$filter['grade_id'] = $SO['grade_id'];}
if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('card/card')->items($filter, array('card_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));

        }
        $uids = $shop_ids = array();
        foreach ($items as $k => $v) {
            $shop_ids[$v['shop_id']] = $v['shop_id'];
            $uids[$v['uid']] = $v['uid'];
        }
        $this->pagedata['uids'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:card/card/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:card/card/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($card_id = K::M('card/card')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?card/card-index.html');
            } 
        }else{
           $this->tmpl = 'admin:card/card/create.html';
        }
    }
    public function edit($card_id=null)
    {
        if(!($card_id = (int)$card_id) && !($card_id = $this->GP('card_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('card/card')->update($card_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:card/card/edit.html';
        }
    }

    public function delete($card_id=null)
    {
        if($card_id = (int)$card_id){
            if(!$detail = K::M('card/card')->detail(card_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('card/card')->delete($card_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('card_id')){
            if(K::M('card/card')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}