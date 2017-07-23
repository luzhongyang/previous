<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Yuyue_Paidui extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array('shop_id'=>$this->shop_id, 'closed'=>0);
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('yuyue/paidui')->items($filter, array('paidui_id'=>'DESC'), $page, $limit, $count)){
            $zhuohao_ids = $zhuohao_list = array();
            foreach($items as $k=>$v){
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
                if($v['wait_time'] > __TIME) {
                    $items[$k]['wait_time'] = round(($v['wait_time']-__TIME)/60,0);
                }else {
                    $items[$k]['wait_time'] = '--';
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
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else{
            if($row = K::M('yuyue/zhuohao')->detail($detail['zhuohao_id'])){
                $detail['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
            }
            if($detail['wait_time'] > __TIME) {
                $detail['wait_time'] = round(($detail['wait_time']-__TIME)/60,0);
            }else {
                $detail['wait_time'] = '--';
            }
            $this->msgbox->set_data('data', array('paidui_detail'=>$detail));
        }
    }

    public function jiedan($params)
    {
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$params['zhuohao_id']){
            $this->msgbox->add('参数错误', 212);
        }else if(!$wait_time = (int)$params['wait_time']){
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
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('zhuohao_id'=>$zhuohao_id,'wait_time'=>$wait_time*60+__TIME,'order_status'=>1))){
            //send msg
            $title = $content = '商家['.$this->shop['title'].']确认排队信息';
            $content .= ', 桌号：('.$zhuohao['title'].')';
            K::M('member/member')->send($paidui['uid'], $title, $content);
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    public function complate($params)
    {
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$params['zhuohao_id']){
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
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>2))){
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    public function cancel($params)
    {
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$paidui = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($paidui['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($paidui['order_status'] < 0){ //接单后也可以取消，所以大于0状态不做判断
            $this->msgbox->add('订座已经取消', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('order_status'=>-1, 'reason'=>'商家取消'))){
            //send msg
            $title = $content = '排队被商家['.$this->shop['title'].']取消';
            K::M('member/member')->send($paidui['uid'], $title, $content);
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    public function delete($params)
    {
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$paidui = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($paidui['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(K::M('yuyue/paidui')->delete($paidui_id)){
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }
}

