<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/13
 * Time: 19:36
 */
import::C('cashier/cashier');
class Ctl_Cashier_Messages extends Ctl_Cashier_Cashier{
    
    public function message($page=1){
        $page = max((int)$page,1);
        $filter = array();
        $filter['shop_id'] = $this->shop['shop_id'];
        $filter['type'] = 4;
        if($items = K::M('shop/msg')->items($filter,array('msg_id'=>'DESC'),$page,1,$count)){
            foreach ($items as $v){
                $v['format_time'] = date('Y-m-d H:i',$v['deteline']);
                $msg[] = $v;

            }
            $this->pagedata['msg'] = $msg;
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, 1, $page, $this->mklink(null, array('{page}')), array('SO'=>''));
            $this->pagedata['pager'] = $pager['pagebar'];
        }
        $this->tmpl = 'biz/cashier/notice/index.html';
        
    }
    
    
    
    
    
}