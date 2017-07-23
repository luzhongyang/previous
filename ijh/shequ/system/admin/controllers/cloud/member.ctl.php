<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cloud_Member extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['nickname']){$filter['nickname'] = "LIKE:%".$SO['nickname']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
        }
        if($items = K::M('member/cloud')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cloud/member/items.html';
    }
    
    public function so()
    {
        $this->tmpl = 'admin:cloud/member/so.html';
    }
    
    
    public function dialog($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['from'] = 'all';
        $pager['limit'] = $limit = 10;
        $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
            if($SO['nickname']){$filter['nickname'] = "LIKE:%".$SO['nickname']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
        }
        if($items = K::M('member/cloud')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO, 'multi'=>$multi));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cloud/member/dialog.html';
    }
    
    
    public function create()
    {
        if($nicks = $this->GP('nicks')){
            $nicknames = explode("\n", $nicks);
            $mobile_array = array('138','158','177','155','159','137','134','135','139','147','150','157','187','188','186','156','185','133','153','180','189');
            foreach($nicknames as $item){
                $data = array('nickname'=>$item,'passwd'=>md5(rand(100000, 999999)),'mobile'=>$mobile_array[rand(0, 20)].rand(11111111,99999999));
                 if($uid = K::M('member/member')->create($data)){
                     $data['uid'] = $uid;
                     K::M('member/cloud')->create($data,false);
                 }
            }
            $this->msgbox->add('添加内容成功');
            $this->msgbox->set_data('forward',$this->mklink('cloud/member:index'));
        }else{
           $this->tmpl = 'admin:cloud/member/create.html';
        }
    }
    
    public function edit($uid=null)
    {
        if(!($uid = (int)$uid) && !($uid = (int)$this->GP('uid'))){
            $this->msgbox->add('未指定要修改的用户ID', 211);
        }else if(!$detail = K::M('member/member')->detail($uid)){
            $this->msgbox->add('指定的用户不存在或已经删除', 212);
        }else if($this->checksubmit()){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 201);
            }else{
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k => $v){
                        foreach($v as $kk => $vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k => $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'product')){
                                $data['face'] = $a['photo'];
                            }
                        }
                    }
                }
                
                if($data['passwd'] == '******'){
                    unset($data['passwd']);
                }else{
                    $passwd = trim($data['passwd']);
                    if(K::M('member/account')->update_passwd($uid, $passwd)){
                        $data['passwd'] = md5($passwd);
                    }
                }
                if(K::M('member/member')->update($uid, $data)){
                    K::M('member/cloud')->update($uid,$data);
                    $this->msgbox->add('修改内容成功');
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cloud/member/edit.html';
        }
    }

    public function delete($uid=null)
    {
        if($uid = (int)$uid){
            if(!$detail = K::M('member/cloud')->detail($uid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('member/cloud')->delete($uid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('uid')){
            if(K::M('member/cloud')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}