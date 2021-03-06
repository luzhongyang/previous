<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weixin/weixin');
class Ctl_Weixin_Reply extends Ctl_Weixin 
{
    
    public function index($page=1)
    {
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        if($items = K::M('weixin/reply')->items(array('shop_id'=>$this->shop_id), array('reply_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));                
            $this->pagedata['items'] = $items;
        }
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weixin/reply/items.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'photo,title,intro,content,jumpurl')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$data['title']){
                $this->msgbox->add('请填写素材标题',212);
            }else if(!$data['photo']){
                $this->msgbox->add('请上传图片',213);
            }else if(!$data['intro']){
                $this->msgbox->add('请填写描述',214);
            }else{
                if($data['content']) {
                    if($data['jumpurl']) {
                        $this->msgbox->add('您已经填写过内容，跳转URL请留空',215)->response();
                    }
                }
                if(!$data['content'] && !$data['jumpurl']) {
                    $this->msgbox->add('请填写内容或跳转URL',216)->response();
                }
                if($data['jumpurl'] && substr($data['jumpurl'],0,7) != 'http://') {
                    $this->msgbox->add('跳转URL格式不正确',217)->response();
                }
                if($attach = $_FILES['photo']){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = K::M('magic/upload')->upload($attach, 'weixin')){
                            $data['photo'] = $a['photo'];
                        }
                    }
                }                
                $data['shop_id'] = $this->shop_id;
                $data['dateline'] = __TIME;
                if($reply_id = K::M('weixin/reply')->create($data)){
                    $this->msgbox->set_data('forward', $this->mklink('merchant/weixin/reply:index'));
                    $this->msgbox->add('添加微信素材成功');
                }
            }
        }else{
            $this->tmpl = 'merchant:weixin/reply/create.html';
        }
    }

    public function edit($reply_id=null)
    {
        if(!($reply_id = (int)$reply_id) && !($reply_id = (int)$this->GP('reply_id'))){
            $this->error(404);
        }else if(!$detail = K::M('weixin/reply')->detail($reply_id)){
            $this->msgbox->add('您要修改的素材不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限修改该素材', 212);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'photo,title,intro,content,jumpurl')){
                $this->msgbox->add('非法的数据提交', 213);
            }else if(!$data['title']){
                $this->msgbox->add('请填写素材标题',212);
            }else if(!$data['photo']){
                $this->msgbox->add('请上传图片',213);
            }else if(!$data['intro']){
                $this->msgbox->add('请填写描述',214);
            }else{
                if($data['content']) {
                    if($data['jumpurl']) {
                        $this->msgbox->add('您已经填写过内容，跳转URL请留空',215)->response();
                    }
                }
                if(!$data['content'] && !$data['jumpurl']) {
                    $this->msgbox->add('请填写内容或跳转URL',216)->response();
                }
                if($data['jumpurl'] && substr($data['jumpurl'],0,7) != 'http://') {
                    $this->msgbox->add('跳转URL格式不正确',217)->response();
                }
                $data['content'] = htmlspecialchars_decode($data['content']);
           
                if($attach = $_FILES['photo']){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = K::M('magic/upload')->upload($attach, 'weixin')){
                            $data['photo'] = $a['photo'];
                        }
                    }
                }                
                if(K::M('weixin/reply')->update($reply_id, $data)){
                    $this->msgbox->add('修改微信素材成功');
                    $this->msgbox->set_data('forward', $this->mklink('merchant/weixin/reply:edit',array('args'=>$reply_id)));
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weixin/reply/edit.html';
        }
    }

    public function delete($reply_id)
    {
        if(!$reply_id = (int)$reply_id){
            $this->error(404);
        }else if(!$detail = K::M('weixin/reply')->detail($reply_id)){
            $this->msgbox->add('你要删除的素材不存或已经删除', 212);
        }else if($this->shop_id != $detail['shop_id']){
            $this->msgbox->add('您没有权限删除该素材', 213);
        }else{
            K::M('weixin/reply')->delete($reply_id);
            $this->msgbox->add('删除素材成功');
        }   
    }

    public function dialog($page=1)
    {
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($items = K::M('weixin/reply')->items(array('shop_id'=>$this->shop_id), null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));                
            $this->pagedata['items'] = $items;
        }
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weixin/reply/dialog.html';
    }

}