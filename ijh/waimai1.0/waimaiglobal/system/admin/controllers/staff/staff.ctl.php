<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Staff extends Ctl
{
    
    public function index($page=1)
    {
        
        
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $filter['closed'] = 0;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
            if(is_array($SO['lastlogin'])){if($SO['lastlogin'][0] && $SO['lastlogin'][1]){$a = strtotime($SO['lastlogin'][0]); $b = strtotime($SO['lastlogin'][1])+86400;$filter['lastlogin'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/staff')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/staff/items.html';
    }

    public function so($target=null, $multi=null)
    {
        if($target){
            $pager['multi'] = $multi == 'Y' ? 'Y' : 'N';
            $pager['target'] = $target;
        }
        $this->pagedata['pager'] = $pager; 
        $this->tmpl = 'admin:staff/staff/so.html';
    }


    public function dialog($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;
        $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
            if(is_array($SO['lastlogin'])){if($SO['lastlogin'][0] && $SO['lastlogin'][1]){$a = strtotime($SO['lastlogin'][0]); $b = strtotime($SO['lastlogin'][1])+86400;$filter['lastlogin'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/staff')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO, 'multi'=>$multi));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/staff/dialog.html';   
    }

    public function paiorder($order_id, $page=1)
    {
        $filter = $pager = array();
        if(!($order_id=(int)$order_id) && !($order_id = (int)$this->GP('order_id'))){
            $this->msgbox->set_data('未指定要派单的单号',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['staff_id']>0){
            $this->msgbox->add('该订单已经有人配送了，您可以选取消再派单',212);
        }else if(!$order['pay_status']){
            $this->msgbox->add('未支付订单不可派单', 213);
        }else if(!in_array($order['pei_type'], array(1, 2))){
            $this->msgbox->add('该订单为商家自送，不可派单', 214);
        }else if(!in_array($order['order_status'], array(0,1,2,3,4))){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else if($order['order_status']==0 && (int)$order['pei_type']!==2){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else{
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 10;
            $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
            if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
                //使用此函数计算得到结果后，带入sql查询。
                $squares = K::M('helper/round')->returnSquarePoint($order['lng'], $order['lat'], 5); //5KM以内的配送员
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }  
            if($SO = $this->GP('SO')){
                $pager['SO'] = $SO;
                if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
                if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
                if(is_array($SO['lastlogin'])){if($SO['lastlogin'][0] && $SO['lastlogin'][1]){$a = strtotime($SO['lastlogin'][0]); $b = strtotime($SO['lastlogin'][1])+86400;$filter['lastlogin'] = $a."~".$b;}}
                if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
            }else{
                //使用此函数计算得到结果后，带入sql查询。
                $squares = K::M('helper/round')->returnSquarePoint($order['lng'], $order['lat'], 5); //5KM以内的配送员
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }
            if($items = K::M('staff/staff')->items($filter, array('status'=>'DESC'), $page, $limit, $count)){
                foreach($items as $k=>$v){
                    $v['order_juli'] = K::M('helper/round')->getdistance($v['lng'], $v['lat'], $order['lng'], $order['lat']);  //距离
                    $items[$k] = $v;
                }                
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($order['order_id'], '{page}')), array('SO'=>$SO, 'multi'=>$multi));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'admin:staff/staff/paiorder.html';  
        }
        
    }

    public function paipaotui($paotui_id, $page=1)
    {
        $filter = $pager = array();
        if(!($paotui_id=(int)$paotui_id) && !($paotui_id = (int)$this->GP('paotui_id'))){
            $this->msgbox->set_data('未指定要派单的单号',211);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($paotui['staff_id']>0){
            $this->msgbox->add('该订单已经有人接单了，您可以选取消再派单',212);
        }else if(!$paotui['pay_status']){
            $this->msgbox->add('未支付订单不可派单', 213);
        }else if(!in_array($order['order_status'], array(0,1,2,3,4))){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else{
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 10;
            $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
            if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
                //使用此函数计算得到结果后，带入sql查询。
                $squares = K::M('helper/round')->returnSquarePoint($order['lng'], $order['lat'], 5); //5KM以内的配送员
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }  
            if($SO = $this->GP('SO')){
                $pager['SO'] = $SO;
                if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
                if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
                if(is_array($SO['lastlogin'])){if($SO['lastlogin'][0] && $SO['lastlogin'][1]){$a = strtotime($SO['lastlogin'][0]); $b = strtotime($SO['lastlogin'][1])+86400;$filter['lastlogin'] = $a."~".$b;}}
                if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
            }else{
                //使用此函数计算得到结果后，带入sql查询。
                $squares = K::M('helper/round')->returnSquarePoint($order['lng'], $order['lat'], 5); //5KM以内的配送员
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }
            if($items = K::M('staff/staff')->items($filter, array('status'=>'DESC'), $page, $limit, $count)){
                foreach($items as $k=>$v){
                    $v['order_juli'] = K::M('helper/round')->getdistances($v['lng'], $v['lat'], $paotui['lng'], $paotui['lat']);  //距离
                    $items[$k] = $v;
                }                
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($paotui['paotui_id'], '{page}')));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'admin:staff/staff/paipaotui.html';   

        }
        
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($staff_id = K::M('staff/staff')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?staff/staff-index.html');
            }
        }else{
           $this->tmpl = 'admin:staff/staff/create.html';
        }
    }

    public function edit($staff_id=null)
    {
        if(!($staff_id = (int)$staff_id) && !($staff_id = $this->GP('staff_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/staff')->detail($staff_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if($data['tixian_percent']<0 || $data['tixian_percent']>100) {
                $this->msgbox->add('提现比例请填写0~100之间的数字', 213);
            }else {
                if(isset($data['passwd']) && $data['passwd'] == '******'){
                    unset($data['passwd']);
                }
                if(K::M('staff/staff')->update($staff_id, $data)){
                    K::M('staff/verify')->update($staff_id,array('verify'=>0, 'refuse'=>''));
                    $this->msgbox->add('修改内容成功');
                }
            }       
        }else{
        	$this->pagedata['detail'] = $detail;
            $bank_list = K::M('data/data')->bank_list();
            $this->pagedata['bank_options'] = array_combine($bank_list, $bank_list);
        	$this->tmpl = 'admin:staff/staff/edit.html';
        }
    }

    public function audit()
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['audit'] = 0;
        if($items = K::M('staff/staff')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/staff/audit.html';
    }


    public function doaudit($staff_id=null)
    {
        if($staff_id = (int)$staff_id){
            if(K::M('staff/staff')->batch($staff_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('staff_id')){
            if(K::M('staff/staff')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($staff_id=null)
    {
        if($staff_id = (int)$staff_id){
            if(!$detail = K::M('staff/staff')->detail($staff_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('staff/staff')->delete($staff_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('staff_id')){
            if(K::M('staff/staff')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}