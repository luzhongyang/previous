<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Maidan extends Ctl
{
    public function index()
    {
        $this->check_maidan();
        if($maidan = K::M('maidan/maidan')->find(array('shop_id'=>$this->shop_id))){
            $maidan['config'] = unserialize($maidan['config']);
            $this->pagedata['maidan'] = $maidan;  
        }
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'm,d,type,max_youhui,discount')){
                $this->msgbox->add('非法的数据提交', 211);
            }else {
                
                if($data['type'] == 1) {
                    if($data['discount'] <= 0 || $data['discount'] >= 10) {
                        $this->msgbox->add('请填写合法的折扣',212)->response();
                    }
                }else if($data['type']==0){
                    $config = array();
                    foreach($data['m'] as $k => $v){
                        if(!$v && $data['type'] == 0) {
                            $this->msgbox->add('请填写每满金额',214)->response();
                        }
                        if(!$data['d'][$k] && $data['type'] == 0) {
                            $this->msgbox->add('请填写满减金额',215)->response();
                        }
                        $config[$k]['m'] = intval($v);
                        $config[$k]['d'] = intval($data['d'][$k]);
                        if(!$data['d'][$k]){
                           unset($config[$k]['m']);
                           unset($config[$k]['d']);
                        }
                    }
                    foreach($config as $key => $val){
                        if(!$val){
                            unset($config[$key]);
                        }
                    }
                    $data['config'] = serialize($config);
                    unset($data['m']);unset($data['d']);
                }
 
                $data['discount'] = $data['discount']*10;
                if($maidan){
                    if(K::M('maidan/maidan')->update($this->shop_id,$data)){
                        $this->msgbox->add('买单设置修改成功!');
                    }else{
                        $this->msgbox->add('买单设置修改失败!');
                    }
                }else{
                    $data['shop_id'] = $this->shop_id;
                    if(K::M('maidan/maidan')->create($data)){
                        $this->msgbox->add('买单设置成功!');
                    }else{
                        $this->msgbox->add('买单设置失败!');
                    }
                } 
            }
        }else{
   
            $this->pagedata['type'] = $maidan['type'];  
            $this->tmpl = 'merchant:tuan/maidan/index.html';
        }
    }

    public function order($page=1)
    {
        $this->check_maidan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'maidan';
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/tuan/maidan/order', array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,dateline,clientip,order_status_label',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $this->pagedata['orders'] = K::M('maidan/order')->items_by_ids($order_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:tuan/maidan/order.html';
    }
    
    public function delete()
    {
        $this->check_maidan();
        if($maidan_id = (int)$this->GP('maidan_id')){
            if(!$detail = K::M('maidan/maidan')->detail($maidan_id)){
                $this->msgbox->add('你要删除的优惠不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('maidan/maidan')->delete($maidan_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的优惠ID', 401);
        }
    }  

}