<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
Import::C('weixin/weixin');

class Ctl_Weixin_Keyword extends Ctl_Weixin
{
    
    public function index($page=1)
    {
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        if($items = K::M('weixin/keyword')->items(array('shop_id'=>$this->shop_id), null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));                
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = 'merchant:weixin/keyword/items.html';    
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'keyword,reply_id,content')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{ 
                $data['shop_id'] = $this->shop_id;
                if($res = K::M('weixin/keyword')->find(array('shop_id'=>$this->shop_id,'keyword'=>$data['keyword']))){
                    $this->msgbox->add('该关键字已存在');
                }else if($kw_id = K::M('weixin/keyword')->create($data)){
                    $this->msgbox->set_data('forward', $this->mklink('merchant/weixin/keyword:index'));
                    $this->msgbox->add('添加关键字成功');
                }
            }
        }else{
            $this->tmpl = 'merchant:weixin/keyword/create.html';
        }
    }

    public function edit($kw_id=null)
    {
        if(!($kw_id = (int)$kw_id) && !($kw_id = (int)$this->GP('kw_id'))){
            $this->error(404);
        }else if(!$detail = K::M('weixin/keyword')->detail($kw_id)){
            $this->msgbox->add('您要修改的关键字不存在或已经删除', 211);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'keyword,reply_id,content')){
                $this->msgbox->add('非法的数据提交', 212);
            }else{
                if($res = K::M('weixin/keyword')->find(array('shop_id'=>$this->shop_id,'keyword'=>$data['keyword']))){
                    $this->msgbox->add('该关键字已存在');
                }else if($kw_id = K::M('weixin/keyword')->update($kw_id, $data)){
                    $this->msgbox->add('修改关键字成功');
                }
            }
        }else{
            if($reply_id = $detail['reply_id']){
                if($reply = K::M('weixin/reply')->detail($reply_id)){
                    if($reply['shop_id'] == $this->shop_id){
                        $this->pagedata['reply'] = $reply;
                    }
                }
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weixin/keyword/edit.html';
        }
    }

    public function delete($kw_id)
    {
        if(!$kw_id = (int)$kw_id){
            $this->error(404);
        }else if(!$detail = K::M('weixin/keyword')->detail($kw_id)){
            $this->msgbox->add('你要删除的关键字不存或已经删除', 212);
        }else if($this->shop_id != $detail['shop_id']){
            $this->msgbox->add('您没有权限删除该关键字', 213);
        }else{
            K::M('weixin/keyword')->delete($kw_id);
            $this->msgbox->add('删除关键字成功');
        }   
    }
}