<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Yuyue_Zhuohao extends Ctl_Biz
{
	// 桌号分类列表
	public function cate($page=1)
	{
		$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('cate_id'=>'desc');
		if($items = K::M('yuyue/zhuohaocate')->items($filter, $orderby, $page, $limit, $count)) {
			$pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
		}
		$this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
		$this->tmpl = 'biz/yuyue/zhuohao/cate_items.html';
	}

	// 添加桌号分类
	public function cate_create()
	{
		if($data = $this->checksubmit('data')){
			$data['shop_id'] = $this->shop_id;
            if($cate_id = K::M('yuyue/zhuohaocate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/yuyue/zhuohao/cate'));
            } 
        }else{
           $this->tmpl = 'biz/yuyue/zhuohao/cate_create.html';
        }  
	}

	// 修改桌号分类
	public function cate_edit($cate_id)
	{
		if(!$cate_id = (int)$cate_id) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/zhuohaocate')->detail($cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(K::M('yuyue/zhuohaocate')->update($cate_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/yuyue/zhuohao/cate'));
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/yuyue/zhuohao/cate_edit.html';
        }
	}

	// 删除桌号分类
	public function cate_delete($cate_id)
	{
		if($cate_id = (int)$cate_id){
            if(!$detail = K::M('yuyue/zhuohaocate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('yuyue/zhuohaocate')->delete($cate_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
	}

	// 桌号列表
	public function items($page=1)
	{
		$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('cate_id'=>'desc');
		if($items = K::M('yuyue/zhuohao')->items($filter, $orderby, $page, $limit, $count)) {
			$pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
		}
		$this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
		$this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
		$this->tmpl = 'biz/yuyue/zhuohao/zhuohao_items.html';
	}

	// 添加桌号
	public function zhuohao_create()
	{
		if($data = $this->checksubmit('data')){
			$data['shop_id'] = $this->shop_id;
            if($cate_id = K::M('yuyue/zhuohao')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/yuyue/zhuohao/items'));
            } 
        }else{
        	$this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
            $this->tmpl = 'biz/yuyue/zhuohao/zhuohao_create.html';
        }  
	}

	// 修改桌号
	public function zhuohao_edit($zhuohao_id)
	{
		if(!$zhuohao_id = (int)$zhuohao_id) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(K::M('yuyue/zhuohao')->update($zhuohao_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('biz/yuyue/zhuohao/items'));
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
            $this->tmpl = 'biz/yuyue/zhuohao/zhuohao_edit.html';
        }
	}

	//删除桌号
	public function zhuohao_delete($zhuohao_id) 
	{
		if($zhuohao_id = (int)$zhuohao_id){
            if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('yuyue/zhuohao')->delete($zhuohao_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
	}
}