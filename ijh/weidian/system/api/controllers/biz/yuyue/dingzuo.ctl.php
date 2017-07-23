<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Yuyue_Dingzuo extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array('shop_id'=>$this->shop_id, 'closed'=>0);
        $page = max((int)$params['page'], 1);
        $limit = 10;
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
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else{
            if($row = K::M('yuyue/zhuohao')->detail($detail['zhuohao_id'])){
                $detail['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
            }
            $this->msgbox->set_data('data', array('dingzuo_detail'=>$detail));
        }
    }

    public function jiedan($params)
    {
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$params['zhuohao_id']){
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
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>1))){
            //send msg
            $title = $content = '商家['.$this->shop['title'].']确认订做信息';
            $content .= ', 桌号：('.$zhuohao['title'].')';
            K::M('member/member')->send($dingzuo['uid'], $title, $content);
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function complate($params)
    {
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$zhuohao_id = (int)$params['zhuohao_id']){
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
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('zhuohao_id'=>$zhuohao_id, 'order_status'=>2))){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function cancel($params)
    {
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($dingzuo['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if($dingzuo['order_status'] < 0){ //接单后也可以取消，所以大于0状态不做判断
            $this->msgbox->add('订座已经取消', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('order_status'=>-1, 'reason'=>'商家取消'))){
            //send msg
            $title = $content = '订座被商家['.$this->shop['title'].']取消';
            K::M('member/member')->send($dingzuo['uid'], $title, $content);
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function delete($params)
    {
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订座信息不存在或已经删除', 213);
        }else if($dingzuo['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 214);
        }else if(K::M('yuyue/zhuohao')->delete($dingzuo_id)){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }
}

