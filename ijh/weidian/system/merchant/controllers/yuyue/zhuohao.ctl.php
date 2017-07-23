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
	// 桌号分类列表
	public function cate($page=1)
	{
        $this->check_paidui();
        $this->check_dingzuo();
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
		$this->tmpl = 'merchant:yuyue/zhuohao/cate_items.html';
	}

	// 添加桌号分类
	public function cate_create()
	{
        $this->check_paidui();
        $this->check_dingzuo();
		if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,orderby')) {
                $this->msgbox->add('非法的数据提交',210);
            }else {
                if(!$data['title']) {
                    $this->msgbox->add('请填写分类名称',211)->response();
                }else if(!$data['orderby']) {
                    $this->msgbox->add("请填写排序",212)->response();
                }else {
                    $data['shop_id'] = $this->shop_id;
                    if($cate_id = K::M('yuyue/zhuohaocate')->create($data)){
                        $this->msgbox->add('添加内容成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/yuyue/zhuohao/cate'));
                    } 
                }
            }
        }else{
           $this->tmpl = 'merchant:yuyue/zhuohao/cate_create.html';
        }  
	}

	// 修改桌号分类
	public function cate_edit($cate_id)
	{
        $this->check_paidui();
        $this->check_dingzuo();
		if(!$cate_id = (int)$cate_id) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/zhuohaocate')->detail($cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(K::M('yuyue/zhuohaocate')->update($cate_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/yuyue/zhuohao/cate_edit',array('args'=>$cate_id)));
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:yuyue/zhuohao/cate_edit.html';
        }
	}

	// 删除桌号分类
	public function cate_delete($cate_id)
	{
        $this->check_paidui();
        $this->check_dingzuo();
		if($cate_id = (int)$cate_id){
            if(!$detail = K::M('yuyue/zhuohaocate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else if(K::M('yuyue/zhuohao')->count(array('cate_id'=>$cate_id))){
                $this->msgbox->add('该分类下有桌号不能删除', 214);
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
        $this->check_paidui();
        $this->check_dingzuo();
		$filter = $pager = $countnum = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('cate_id'=>'desc');
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
            if($SO['number']){$filter['number'] = $SO['number'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
        }
		if($items = K::M('yuyue/zhuohao')->items($filter, $orderby, $page, $limit, $count)) {
			$pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/yuyue/zhuohao/items', array('{page}'))); 
		}
        // 订座订单 待接单   预约   完成  取消数量
        $countnum['worder'] = K::M('yuyue/dingzuo')->count(array('shop_id'=>$this->shop_id,'order_status'=>0,'closed'=>0));
		$countnum['yuyue'] = K::M('yuyue/dingzuo')->count(array('shop_id'=>$this->shop_id,'order_status'=>1,'closed'=>0));
        $countnum['over'] = K::M('yuyue/dingzuo')->count(array('shop_id'=>$this->shop_id,'order_status'=>2,'closed'=>0));
        $countnum['cansle'] = K::M('yuyue/dingzuo')->count(array('shop_id'=>$this->shop_id,'order_status'=>-1,'closed'=>0));

        
        // 排号订单 待接单   预约   完成  取消数量
        $pcountnum['worder'] = K::M('yuyue/paidui')->count(array('shop_id'=>$this->shop_id,'order_status'=>0,'closed'=>0));
        $pcountnum['yuyue'] = K::M('yuyue/paidui')->count(array('shop_id'=>$this->shop_id,'order_status'=>1,'closed'=>0));
        $pcountnum['over'] = K::M('yuyue/paidui')->count(array('shop_id'=>$this->shop_id,'order_status'=>2,'closed'=>0));
        $pcountnum['cansle'] = K::M('yuyue/paidui')->count(array('shop_id'=>$this->shop_id,'order_status'=>-1,'closed'=>0));
        //待接单   预约   完成  取消数量
        $this->pagedata['countnum'] = $countnum;
        $this->pagedata['p_countnum'] = $pcountnum;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
		$this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
		$this->tmpl = 'merchant:yuyue/zhuohao/zhuohao_items.html';
	}

	// 添加桌号
	public function zhuohao_create()
	{
        $this->check_paidui();
        $this->check_dingzuo();
		if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'cate_id,title,number')){
                $this->msgbox->add('非法的数据提交', 211);
            }else {
                if(!$data['cate_id']) {
                    $this->msgbox->add('请选择桌号分类',212)->response();
                }else if(!$data['title']) {
                    $this->msgbox->add('请填写桌号',213)->response();
                }else if(!$data['number']) {
                    $this->msgbox->add('请填写就餐人数',214)->response();
                }else {
                    $data['shop_id'] = $this->shop_id;
                    if($cate_id = K::M('yuyue/zhuohao')->create($data)){
                        $this->msgbox->add('添加内容成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/yuyue/zhuohao/items'));
                    } 
                }
            }
        }else{
        	$this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
            $this->tmpl = 'merchant:yuyue/zhuohao/zhuohao_create.html';
        }  
	}

	// 修改桌号
	public function zhuohao_edit($zhuohao_id)
	{
        $this->check_paidui();
        $this->check_dingzuo();
		if(!$zhuohao_id = (int)$zhuohao_id) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(K::M('yuyue/zhuohao')->update($zhuohao_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/yuyue/zhuohao/zhuohao_edit',array('args'=>$zhuohao_id)));
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id),array('cate_id'=>'desc'));
            $this->tmpl = 'merchant:yuyue/zhuohao/zhuohao_edit.html';
        }
	}

	//删除桌号
	public function zhuohao_delete($zhuohao_id) 
	{
        $this->check_paidui();
        $this->check_dingzuo();
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

    public function so()
    {
        $this->pagedata['cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id));
        $this->tmpl = 'merchant:yuyue/zhuohao/so.html';
    }
}