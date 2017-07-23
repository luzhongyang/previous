<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Yuyue_Order extends Ctl
{
	// 排号订单待接单列表
	public function paidui($page=1)
	{
        $this->check_paidui();
		$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('paidui_id'=>'desc');
        if($keyword = $this->GP('keyword')){
            $keyword = htmlspecialchars($keyword);
            if(K::M('verify/check')->mobile($keyword)){
                $filter['mobile'] =$keyword;
            }else{
                $filter[':OR'] = array('contact'=>"LIKE:%".$keyword."%");
                if(is_numeric($keyword)){
                    $filter[':OR']['mobile'] = "LIKE:%".$keyword."%";
                    $filter[':OR']['paidui_id'] = "LIKE:%".$keyword."%";
                }
            }
            $attr = array('keyword'=>$keyword);
            $pager['keyword'] = $keyword;
        }else{
            $filter['closed'] = 0;
            $filter['order_status'] = 0;
        }
		if($items = K::M('yuyue/paidui')->items($filter, $orderby, $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'),$attr)); 
        }
		$this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        if($keyword){
            $this->tmpl = 'merchant:yuyue/order/paidui_so.html';
        }else{
            $this->tmpl = 'merchant:yuyue/order/paidui_items.html';
        }
		
	}

    // 排号订单排队中列表
    public function paidui_wait_items($page=1)
    {
        $this->check_paidui();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = 1;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/paidui')->items($filter, $orderby, $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:yuyue/order/paidui_wait_items.html';
    }

    // 排号订单已完成列表
    public function paidui_complete_items($page=1)
    {
        $this->check_paidui();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = 2;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/paidui')->items($filter, $orderby, $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:yuyue/order/paidui_complete_items.html';
    }

    // 排号订单已取消列表
    public function paidui_cancel_items($page=1)
    {
        $this->check_paidui();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = -1;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/paidui')->items($filter, $orderby, $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:yuyue/order/paidui_cancel_items.html';
    }

	// 排号订单选择桌号
	public function paidui_choose_zhuohao($paidui_id)
	{
        $this->check_paidui();
		if($paidui_id = (int)$paidui_id) {
            if($detail = K::M('yuyue/paidui')->detail($paidui_id)) {
            	$this->pagedata['zhuohao_cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id));
            	$this->pagedata['zhuohao_items'] = K::M('yuyue/zhuohao')->items(array('shop_id'=>$this->shop_id));
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'merchant:yuyue/order/paidui_choose_zhuohao_dialog.html';
	}

	// 排号订单接单
	public function paidui_jiedan()
	{
        $this->check_paidui();
		$paidui_id = (int)$this->GP('paidui_id');
		$zhuohao_id = (int)$this->GP('zhuohao_id');
		$wait_time = (int)$this->GP('wait_time') * 60 + __TIME;
		if(!$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id){
            $this->msgbox->add('参数错误', 212);
        }else if(!$paidui = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($paidui['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(!$zhuohao = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('指定的桌号不存存或已经删除', 215);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($paidui['order_status'] < 0){
            $this->msgbox->add('订座已经取消', 214);
        }else if($paidui['order_status'] > 0){
            $this->msgbox->add('已经接单成功', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>1,'wait_time'=>$wait_time,'lasttime'=>__TIME,'jd_time'=>__TIME))){
            //send msg
            $title = $content = '商家['.$this->shop['title'].']确认排队信息';
            $content .= ', 桌号：('.$zhuohao['title'].')';
            K::M('member/member')->send($paidui['uid'], $title, $content);
            $this->msgbox->add('接单成功');
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
	}

    // 排号订单取消订单
	public function paidui_cancel($paidui_id)
	{
        $this->check_paidui();
        if(!$paidui_id = (int)$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$paidui = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($paidui['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($paidui['order_status'] != 0){ 
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('order_status'=>-1, 'reason'=>'商家取消','lasttime'=>__TIME))){
            //send msg
            $title = $content = '排队被商家['.$this->shop['title'].']取消';
            K::M('member/member')->send($paidui['uid'], $title, $content);
            $this->msgbox->add('取消成功');
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
	}

    // 排号订单确认就餐
	public function paidui_complete($paidui_id,$zhuohao_id)
	{
        $this->check_paidui();
        if(!$paidui_id = (int)$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$zhuohao_id){
            $this->msgbox->add('参数错误', 212);
        }else if(!$paidui = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($paidui['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(!$zhuohao = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('指定的桌号不存存或已经删除', 215);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($paidui['order_status'] < 0){
            $this->msgbox->add('订座已经取消', 214);
        }else if($paidui['order_status'] > 1){
            $this->msgbox->add('定座已经完成', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('paidui_id'=>$zhuohao_id, 'order_status'=>2,'lasttime'=>__TIME))){
            $this->msgbox->add('确认成功');
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
	}

	public function paidui_delete()
	{

	}


    // 订座订单待接单列表
	public function dingzuo($page=1)
	{
        $this->check_dingzuo();
		$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('paidui_id'=>'desc');
        if($keyword = $this->GP('keyword')){
            $keyword = htmlspecialchars($keyword);
            if(K::M('verify/check')->mobile($keyword)){
                $filter['mobile'] =$keyword;
            }else{
                $filter[':OR'] = array('contact'=>"LIKE:%".$keyword."%");
                if(is_numeric($keyword)){
                    $filter[':OR']['mobile'] = "LIKE:%".$keyword."%";
                    $filter[':OR']['order_id'] = "LIKE:%".$keyword."%";
                }
            }
            $attr = array('keyword'=>$keyword);
            $pager['keyword'] = $keyword;
        }else{
            $filter['closed'] = 0;
            $filter['order_status'] = 0;
        }
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'DESC'), $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'),$attr)); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        if($keyword){
            $this->tmpl = 'merchant:yuyue/order/dingzuo_so.html';
        }else{
            $this->tmpl = 'merchant:yuyue/order/dingzuo_items.html';
        }
		
	}

    // 订座订单排队中列表
    public function dingzuo_wait_items($page=1)
    {
        $this->check_dingzuo();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = 1;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'DESC'), $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:yuyue/order/dingzuo_wait_items.html';
    }

    // 订座订单已完成列表
    public function dingzuo_complete_items($page=1)
    {
        $this->check_dingzuo();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = 2;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'DESC'), $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:yuyue/order/dingzuo_complete_items.html';
    }

    // 订座订单已取消列表
    public function dingzuo_cancel_items($page=1)
    {
        $this->check_dingzuo();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['order_status'] = -1;
        $orderby = array('paidui_id'=>'desc');
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'DESC'), $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
        }
        $this->pagedata['items'] = $items;
        $this->tmpl = 'merchant:yuyue/order/dingzuo_cancel_items.html';
    }

    // 订座订单选择桌号
    public function dingzuo_choose_zhuohao($dingzuo_id)
    {
        $this->check_dingzuo();
        if($dingzuo_id = (int)$dingzuo_id) {
            if($detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)) {
                $this->pagedata['zhuohao_cate_items'] = K::M('yuyue/zhuohaocate')->items(array('shop_id'=>$this->shop_id));
                $this->pagedata['zhuohao_items'] = K::M('yuyue/zhuohao')->items(array('shop_id'=>$this->shop_id));
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'merchant:yuyue/order/dingzuo_choose_zhuohao_dialog.html';
    }

    // 订座订单接单
	public function dingzuo_jiedan()
	{
        $this->check_dingzuo();
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        $zhuohao_id = (int)$this->GP('zhuohao_id');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id){
            $this->msgbox->add('参数错误', 212);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($dingzuo['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(!$zhuohao = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('指定的桌号不存存或已经删除', 215);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($dingzuo['order_status'] < 0){
            $this->msgbox->add('订座已经取消', 214);
        }else if($dingzuo['order_status'] > 0){
            $this->msgbox->add('已经接单成功', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>1,'lasttime'=>__TIME,'jd_time'=>__TIME))){
            //send msg
            $title = $content = '商家['.$this->shop['title'].']确认订做信息';
            $content .= ', 桌号：('.$zhuohao['title'].')';
            K::M('member/member')->send($dingzuo['uid'], $title, $content);
            $this->msgbox->add('接单成功');
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
	}

    // 订座订单取消
	public function dingzuo_cancel($dingzuo_id)
	{
        $this->check_dingzuo();
        if(!$dingzuo_id = (int)$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($dingzuo['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($dingzuo['order_status'] != 0){ 
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('order_status'=>-1, 'reason'=>'商家取消','lasttime'=>__TIME))){
            //send msg
            $title = $content = '订座被商家['.$this->shop['title'].']取消';
            K::M('member/member')->send($dingzuo['uid'], $title, $content);
            $this->msgbox->add('取消成功');
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
	}

    // 订座订单确认到店
	public function dingzuo_complete($dingzuo_id,$zhuohao_id)
	{
        $this->check_dingzuo();
        if(!$dingzuo_id = (int)$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$zhuohao_id){
            $this->msgbox->add('参数错误', 212);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($dingzuo['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(!$zhuohao = K::M('yuyue/zhuohao')->detail($zhuohao_id)){
            $this->msgbox->add('指定的桌号不存存或已经删除', 215);
        }else if($zhuohao['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($dingzuo['order_status'] < 0){
            $this->msgbox->add('订座已经取消', 214);
        }else if($dingzuo['order_status'] > 1){
            $this->msgbox->add('订座已经完成', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>2,'lasttime'=>__TIME))){
            $this->msgbox->add('确认成功');
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
	}

	public function dingzuo_delete()

	{

	}
}