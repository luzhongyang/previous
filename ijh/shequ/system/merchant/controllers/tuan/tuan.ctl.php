<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Tuan extends Ctl
{
    
    public function index($page=1)
    {
        $this->check_tuan();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['type'] == 'quan'){
                $filter['type'] = 'quan';
            }else if($SO['type'] == 'tuan') {
                $filter['type'] = 'tuan';
            }else if($SO['type'] == 'notype') {
                $filter['type'] = array('tuan','quan');
            }
            if($SO['market_price']){$filter['market_price'] = $SO['market_price'];}
            if($SO['price']){$filter['price'] = $SO['price'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['stime'])){if($SO['stime'][0] && $SO['stime'][1]){$a = strtotime($SO['stime'][0]); $b = strtotime($SO['stime'][1])+86400;$filter['stime'] = $a."~".$b;}}
            if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('tuan/tuan')->items($filter, array('tuan_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/tuan/tuan/index', array('{page}')));
        }
        //待接单   预约   完成  取消数量
        $countnum['unpay'] = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'from'=>'tuan','pay_status'=>0));
        $countnum['cansle'] = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'from'=>'tuan','order_status'=>-1));
        // 今日已完成订单数
        $today = date('Ymd', __TIME);
        $countnum['tover'] = K::M('order/order')->count((array('shop_id'=>$this->shop_id,'from'=>'tuan','order_status'=>8,'day'=>$today,'closed'=>0)));
        $countnum['over'] = K::M('order/order')->count((array('shop_id'=>$this->shop_id,'from'=>'tuan','order_status'=>8,'closed'=>0)));
        //待接单   预约   完成  取消数量
        $this->pagedata['countnum'] = $countnum;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:tuan/tuan/index.html';
    }

    
    public function create()
    {
        $this->check_tuan();
        if($data = $this->checksubmit('data')){
            if($data['min_buy'] < 1 ) {
                $this->msgbox->add('最小购买数不能小于1',211);
            }else if($data['max_buy'] > 99) {
                $this->msgbox->add('最大购买数不能超过99',212);
            }else {
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'tuan')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }
                $data['city_id'] = $this->shop['city_id'];
                $data['shop_id'] = $this->shop_id;
                $data['stime'] = strtotime($data['stime']);
                $data['ltime'] = strtotime($data['ltime']);
                
                if($product_id = K::M('tuan/tuan')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward', $this->mklink('merchant/tuan/tuan/index'));
                } 
            }    
        }else{
            $this->pagedata['shop'] = $this->shop;
            $this->pagedata['start_date'] = date('Y-m-d', time());
            $this->pagedata['end_date'] = date('Y-m-d',strtotime("+1 day"));
            $this->tmpl = 'merchant:tuan/tuan/create.html';
        }   
        
    }

    public function edit($tuan_id=null)
    {
        $this->check_tuan();
        if(!($tuan_id = (int)$tuan_id) && !($tuan_id = $this->GP('tuan_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if($data['min_buy'] < 1 ) {
                $this->msgbox->add('最小购买数不能小于1',211);
            }else if($data['max_buy'] > 99) {
                $this->msgbox->add('最大购买数不能超过99',212);
            }else {
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'tuan')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }
                $data['stime'] = strtotime($data['stime']);
                $data['ltime'] = strtotime($data['ltime']);
                if(K::M('tuan/tuan')->update($tuan_id, $data)){
                    $this->msgbox->add('修改内容成功');
                }  
            } 
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:tuan/tuan/edit.html';
        }       
        
    }

    public function delete($tuan_id=null)
    {
        $this->check_tuan();
        if($tuan_id = (int)$tuan_id){
            if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('tuan/tuan')->batch($tuan_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    
    public function del($tuan_id){
        $this->check_tuan();
        if(!$tuan_id = (int)$tuan_id){
            $this->error(404);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('团购不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop['shop_id']){
            $this->msgbox->add('非法操作', 212);
        }else{
            if($delete = K::M('tuan/tuan')->delete($tuan_id)){
                $this->msgbox->add('删除成功!');
            }else{
                $this->msgbox->add('删除失败', 213);
            }
        }
        
    }

    // 上架、下架
    public function onsale($tuan_id) 
    {
        $this->check_tuan();
        if(!$tuan_id = (int)$tuan_id) {
            $this->msgbox->add('商品不存在',210);
        }else if(!$tuan = K::M('tuan/tuan')->detail($tuan_id)) {
            $this->msgbox->add('商品不存在',211);
        }else if($tuan['shop_id'] != $this->shop['shop_id']) {
            $this->msgbox->add('非法操作',212);
        }else {
            if($tuan['is_onsale'] != 1) {
                if(K::M('tuan/tuan')->update($tuan_id, array('is_onsale'=>1))) {
                    $this->msgbox->add('上架成功');
                }else {
                    $this->msgbox->add('上架失败',213);
                }
            }else {
                if(K::M('tuan/tuan')->update($tuan_id, array('is_onsale'=>0))) {
                    $this->msgbox->add('下架成功');
                }else {
                    $this->msgbox->add('下架失败',213);
                }
            } 
        }
    }
    
    public function so()
    {
        $this->tmpl = 'merchant:tuan/tuan/so.html';
    }
}