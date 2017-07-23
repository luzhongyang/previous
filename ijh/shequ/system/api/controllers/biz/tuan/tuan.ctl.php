<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tuan_Tuan extends Ctl_Biz
{

    public function items($params)
    {
        $limit = 20;
        $page = max((int)$params['page'], 1);
        $count = K::M('tuan/tuan')->count(array('shop_id'=>$this->shop_id, 'closed'=>0));
        if(!in_array($params['type'],array(1,2,3))){
            $params['type'] = 1;
        }
        $filter = array(
            'shop_id' => $this->shop_id,
            'closed' => 0
        );
        $orderby = array();        
        if($params['type'] == 1){
            $filter['is_onsale'] = 0;
            //$filter['ltime'] = '>:'.time();
        }else if($params['type'] == 2){
            $filter['is_onsale'] = 1;
            //$filter['ltime'] = '>:'.time();
        }else if($params['type'] == 3){
            $filter['ltime'] = '<:'.time();
        }
        
        if($params['sales'] == 0){
            $orderby['sales'] = 'ASC';
        }else{
            $orderby['sales'] = 'DESC';
        }
        if($items = K::M('tuan/tuan')->items($filter, $orderby, $page, $limit, $count)){
            foreach($items as $k => $v){
                $items[$k] = $this->filter_fields('tuan_id,title,desc,price,market_price,stock_type,stock_num,ltime,stime,photo,sales,dateline,is_onsale', $v);
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count,'total_page'=>ceil($count / $limit)));        
    }
    
    
    public function batch_status($params)
    {
        if(!$params['ids']){
            $this->msgbox->add('没有选择删除的内容',211);
        }else{
            if(!in_array($params['status'],array(0,1))){
                $params['status'] = 1;
            }
            $ids = explode(',',$params['ids']);
            $count = 0;
            foreach($ids as $k => $v){
                if(K::M('tuan/tuan')->update($v,array('is_onsale'=>$params['status']))){
                    $count = $count + 1;
                }
            }
            $this->msgbox->add('成功设置了'.$count.'条');
        }
    }
    
        
    public function batch_time($params)
    {
        if(!$params['ids']){
            $this->msgbox->add('没有选择删除的内容',211);
        }elseif(!$params['ltime']){
            $this->msgbox->add('没有选择延期的时间',211);
        }else{
            $ids = explode(',',$params['ids']);
            $count = 0;
            foreach($ids as $k => $v){
                if(K::M('tuan/tuan')->update($v,array('ltime'=>$params['ltime']))){
                    $count = $count + 1;
                }
            }
            $this->msgbox->add('成功设置了'.$count.'条');
        }
    }
    
    
    
    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'photo,type,title,desc,min_buy,max_buy,stock_type,stock_num,orderby,price,market_price,ticket_merge,stime,ltime,notice,detail,is_onsale')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            if(!in_array($data['type'], array('tuan', 'quan'))){
                $data['type'] = 'tuan';
            }
            $data['shop_id'] = $this->shop_id;
            $data['city_id'] = $this->shop['city_id'];
            //$data['is_onsale'] = 1;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if($tuan_id = K::M('tuan/tuan')->create($data)){
                $this->msgbox->set_data('data', array('tuan_id'=>$tuan_id));
            }
        }
    }
    
    public function detail($params)
    {
        if(!$tuan_id = $params['tuan_id']){
            $this->msgbox->add('错误的产品', 212);
        }elseif(!$tuan = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('产品不存在', 213);
        }elseif($tuan['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 214);
        }else{
            $this->msgbox->set_data('data', array('tuan'=>$tuan));
        }
    }
    
    
    public function update($params)
    {
        if(!$data = $this->check_fields($params, 'tuan_id,photo,type,title,desc,min_buy,max_buy,stock_type,stock_num,orderby,price,market_price,ticket_merge,stime,ltime,notice,detail,is_onsale')){
            $this->msgbox->add('非法的数据提交', 211);
        }elseif(!$tuan_id = $params['tuan_id']){
            $this->msgbox->add('错误的产品', 212);
        }elseif(!$tuan = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('产品不存在', 213);
        }else{
            if(!in_array($data['type'], array('tuan', 'quan'))){
                $data['type'] = 'tuan';
            }
            $data['shop_id'] = $this->shop_id;
            $data['city_id'] = CITY_ID;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('tuan/tuan')->update($tuan_id, $data)){
                $this->msgbox->set_data('data', array('tuan_id'=>$tuan_id));
                $this->msgbox->add('SUCCESS');
            }
        }
    }
    
    
    
    public function delete($params)
    {
        if(!$tuan_id = $params['tuan_id']){
            $this->msgbox->add('错误的产品', 212);
        }elseif(!$tuan = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('产品不存在', 213);
        }elseif($del = K::M('tuan/tuan')->delete($tuan_id)){
            $this->msgbox->add('删除成功');
        }else{
            $this->msgbox->add('删除失败',300);
        }
    }
    
    


}