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
class Ctl_Weixin_Menu extends Ctl_Weixin
{
    
    public function index()
    {
        $this->pagedata['items'] = K::M('weixin/menu')->items_by_weixin($this->shop_id);
        $this->tmpl = 'merchant:weixin/menu/items.html';       
    }

    //同步到微信
    public function towechat()
    {
        $buttons = array();
        $buttons = K::M('weixin/menu')->wechat_buttons($this->shop_id);
        $client = K::M('weixin/wechat')->wechat_client($this->shop_id);
        K::M('system/logs')->log('wechat.buttons', $buttons);
        if($client->setMenu(array('button'=>$buttons))){
            $this->msgbox->add('同步公众号菜单成功');
        }else{
            $this->msgbox->add($client->error(), 211);
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,parent_id,type,reply_id,content,link,orderby')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$data['title']){
                $this->msgbox->add('请填写菜单名称',212);
            }else if(!$data['orderby']){
                $this->msgbox->add('请填写排序',213);
            }else if($data['type']=='link' && !$data['link']){
                $this->msgbox->add('请填写回复链接',214);
            }else if($data['type']=='text' && !$data['content']) {
                $this->msgbox->add('请填写回复文本',215);
            }else if($data['type']=='reply' && !$data['reply_id']) {
                $this->msgbox->add('请选择微信素材',216);
            }else{
                $data['shop_id'] = $this->shop_id;
                if($menu_id = K::M('weixin/menu')->create($data)){
                    $this->msgbox->set_data('forward', $this->mklink('merchant/weixin/menu:index'));
                    $this->msgbox->add('添加微信菜单成功');
                }
            }
        }else{
            $this->pagedata['wx_menu_list'] = K::M('weixin/menu')->items_by_weixin($this->shop_id);
            $this->tmpl = 'merchant:weixin/menu/create.html';
        }
    }

    public function edit($menu_id=null)
    {
        if(!($menu_id = (int)$menu_id) && !($menu_id = (int)$this->GP('menu_id'))){    
            $this->error(404);
        }else if(!$detail = K::M('weixin/menu')->detail($menu_id)){
            $this->msgbox->add('您要修改的菜单不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据提交', 212);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,shop_id,parent_id,type,reply_id,photo,content,link,orderby')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$data['title']){
                $this->msgbox->add('请填写菜单名称',212);
            }else if(!$data['orderby']){
                $this->msgbox->add('请填写排序',213);
            }else if($data['type']=='link' && !$data['link']){
                $this->msgbox->add('请填写回复链接',214);
            }else if($data['type']=='text' && !$data['content']) {
                $this->msgbox->add('请填写回复文本',215);
            }else if($data['type']=='reply' && !$data['reply_id']) {
                $this->msgbox->add('请选择微信素材',216);
            }else{
//                K::M('weixin/reply')->update($reply_id,array('photo'=>$data['photo'], 'shop_id' => $this->shop_id ));
//                unset($data['photo']);
                $data['shop_id'] = $this->shop_id;
                if(K::M('weixin/menu')->update($menu_id, $data)){
                    $this->msgbox->add('修改微信菜单成功');
                }
            }
        }else{
            if($reply_id = (int)$detail['reply_id']){
                if($reply = K::M('weixin/reply')->detail($reply_id)){
                    if($this->shop_id == $reply['shop_id']){
                        $this->pagedata['reply'] = $reply;
                    }
                }                
            }
            $this->pagedata['detail'] = $detail;
            $this->pagedata['wx_menu_list'] = K::M('weixin/menu')->items_by_weixin($this->shop_id);
            $this->tmpl = 'merchant:weixin/menu/edit.html';
        }
    }

    public function delete($menu_id)
    {
        if(!$menu_id = (int)$menu_id){
            $this->error(404);
        }else if(!$detail = K::M('weixin/menu')->detail($menu_id)){
            $this->msgbox->add('你要删除的菜单不存或已经删除', 212);
        }else if($this->shop_id != $detail['shop_id']){
            $this->msgbox->add('您没有权限删除该菜单', 213);
        }else{
            K::M('weixin/menu')->delete($menu_id);
            $this->msgbox->add('删除菜单成功');
        }        
    }
}