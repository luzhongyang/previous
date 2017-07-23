<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Grade extends Ctl
{
    protected $_allow_fields = 'grade_id,shop_id,title,need_money,need_jifen,discount,icon,orderby';

    public function so()
    {
        $this->tmpl = 'merchant:shop/grade/so.html';
    }

    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('card/grade')->items($filter, array('grade_id'=>'desc'), $page, $limit, $count)){
            foreach ($items as $k => $v) {
                $v = $this->filter_fields($this->_allow_fields, $v);
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/grade/index.html';
    }

    public function create()
    {
        if ($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'title,need_money,need_jifen,discount,icon,orderby')){
                $this->msgbox->add('非法的参数提交', 211);
            }else if(empty($data['title'])){
                $this->msgbox->add('名称不能为空', 212);
            }else{
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'grade')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }
                $data['shop_id'] = $this->shop_id;
                if($grade_id = K::M('card/grade')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/grade:index'));
                }
            }
        }else{
            $this->tmpl = 'merchant:shop/grade/create.html';
        }
    }

    public function edit($grade_id=null)
    {
        if(!($grade_id = (int)$grade_id) && !($grade_id = $this->GP('grade_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('card/grade')->detail($grade_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,need_money,need_jifen,discount,icon,orderby')){
                $this->msgbox->add('非法的参数提交', 214);
            }else if(empty($data['title'])){
                $this->msgbox->add('名称不能为空', 215);
            }else{
                if(K::M('card/grade')->update($detail['grade_id'], $data)){
                    $this->msgbox->add('修改内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/grade/index'));
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:shop/grade/edit.html';
        }
    }

    public function delete($grade_id=null)
    {
        if (!($grade_id = (int)$grade_id) && !($grade_id = $this->GP($grade_id))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }elseif(!$detail = K::M('card/grade')->detail($grade_id)){
            $this->msgbox->add('内容不存在',212);
        }elseif($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',213);
        }else{
            if(K::M('card/grade')->delete($detail['grade_id'])){
                $this->msgbox->add('删除内容成功');
            }
        }
    }

}