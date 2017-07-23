<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Hongbao_Hongbao extends Ctl
{
    
    public function InitializeApp() 
    {
        parent::InitializeApp();
        $types = K::M('hongbao/hongbao')->getType();
        $this->pagedata['types'] = $types;
    }
        public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
if(is_array($SO['min_amount'])){$a = intval($SO['min_amount'][0]);$b=intval($SO['min_amount'][1]);if($a && $b){$filter['min_amount'] = $a."~".$b;}}
if(is_array($SO['amount'])){$a = intval($SO['amount'][0]);$b=intval($SO['amount'][1]);if($a && $b){$filter['amount'] = $a."~".$b;}}
if($SO['type']){$filter['type'] = $SO['type'];}
if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
if(is_array($SO['used_time'])){if($SO['used_time'][0] && $SO['used_time'][1]){$a = strtotime($SO['used_time'][0]); $b = strtotime($SO['used_time'][1])+86400;$filter['used_time'] = $a."~".$b;}}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('hongbao/hongbao')->items($filter, array('hongbao_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $uids = array();
        foreach($items as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:hongbao/hongbao/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:hongbao/hongbao/so.html';
    }
    public function detail($hongbao_id = null)
    {
        if(!$hongbao_id = (int)$hongbao_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            if($uid = $detail['uid']){
                $this->pagedata['member'] = K::M('member/member')->detail($uid);
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:hongbao/hongbao/detail.html';
        }
    }
   public function add()
    {
        if($data = $this->checksubmit('data')){            
            if($hongbao_id = K::M('hongbao/hongbao')->add($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?hongbao/hongbao-index.html');
            } 
        }else{
           $this->tmpl = 'admin:hongbao/hongbao/add.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            $data['ltime'] = strtotime($data['ltime']);
            if($hongbao_id = K::M('hongbao/hongbao')->create($data)){
                if($data['uid']){
                    if($data['uid']){
                        $title = sprintf('恭喜你获得一个%s元红包', $data['amount']);
                        $content = sprintf('恭喜你获得一个%s元红包,订单满%s可用', $data['amount'], $data['min_amount']);
                        K::M('member/member')->send($data['uid'], $title, $content, 'hongbao');
                    }
                }
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?hongbao/hongbao-index.html');
            } 
        }else{
           $this->tmpl = 'admin:hongbao/hongbao/create.html';
        }
    }
    public function edit($hongbao_id=null)
    {
        if(!($hongbao_id = (int)$hongbao_id) && !($hongbao_id = $this->GP('hongbao_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('hongbao/hongbao')->update($hongbao_id, $data)){
                $info  = K::M('hongbao/hongbao')->detail($hongbao_id);
                if($info['uid'] && ($info['uid'] != $detail['uid'])){
                    $title = sprintf('恭喜你获得一个%s元红包', $info['amount']);
                    $content = sprintf('恭喜你获得一个%s元红包,订单满%s可用', $info['amount'], $info['min_amount']);
                    K::M('member/member')->send($data['uid'], $title, $content, 'hongbao');
                }
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
                $user= K::M('member/member')->detail($detail['uid']);
                $this->pagedata['user'] = $user;
            $this->tmpl = 'admin:hongbao/hongbao/edit.html';
        }
    }
    public function doaudit($hongbao_id=null)
    {
        if($hongbao_id = (int)$hongbao_id){
            if(K::M('hongbao/hongbao')->batch($hongbao_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('hongbao_id')){
            if(K::M('hongbao/hongbao')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($hongbao_id=null)
    {
        if($hongbao_id = (int)$hongbao_id){
            if(!$detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('hongbao/hongbao')->delete($hongbao_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('hongbao_id')){
            if(K::M('hongbao/hongbao')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}