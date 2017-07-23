<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Hongbao_Hongbao extends Mdl_Table
{   
  
    protected $_table = 'hongbao';
    protected $_pk = 'hongbao_id';
    protected $_cols = 'hongbao_id,title,min_amount,amount,from,uid,hongbao_sn,stime,ltime,order_id,used_ip,used_time,clientip,dateline';
    protected $cd_key = 'hsoewocnsdl2479sdfew_12whf';
    
    public function getType()
    {
        //目前暂时仅保留全场通用红包,其他功能,以后定制开发用到时修改.
        return array(
            'all'=>'全场通用',
//            'waimai'=>'外卖专享',
            //'pintuan'=>'拼团专享',
//            'paotui'=>'派活专享',
            //'mall'=>'商城专享',
        );
    }
    
    public function create($data, $checked=false)
    {
        $num = $data['num'];
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
            for ($i = 1; $i <= $num; $i++) {
                $datas[$i]['title'] = $data['title'];
                $datas[$i]['min_amount'] = $data['min_amount'];
                $datas[$i]['amount'] = $data['amount'];
                $datas[$i]['from'] = $data['from'];
                $datas[$i]['stime'] = __TIME;
                $datas[$i]['ltime'] = $data['ltime'] + 86399;;
                $datas[$i]['dateline'] = __CFG::TIME;
                $datas[$i]['clientip'] = __IP;
            }
            
            foreach ($datas as $key => $v) {
                $hongbao_id = $this->db->insert($this->_table, $v, true);
                $keys = md5($this->cd_key.$hongbao_id);
                $keys = substr($keys,10,10);
                $this->batch($hongbao_id,array('hongbao_sn'=>$keys));
            }
        return $hongbao_id;
    }
    
    
    public function add($data, $checked=false)
    {
        $uid = intval($data['uid']);        
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['uid'] = $uid;
        $data['stime'] = __CFG::TIME;
        $data['ltime'] = $data['ltime'] + 86399;
        $data['dateline'] = __CFG::TIME;
        $data['clientip'] = __IP;        
        if($hongbao_id = $this->db->insert($this->_table, $data, true)){
            if(empty($uid)){
                $sn = substr(md5($this->cd_key.$hongbao_id),10,10);
                $this->update($hongbao_id,array('hongbao_sn'=>$sn), true);
            }
        }
        return $hongbao_id;
    }

    public function send($uid, $data)
    {
        $uid = (int)$uid;
        if(!$data = $this->_check_schema($data)){
            return false;
        }
        $data['uid'] = $uid;  
        $data['stime'] = __CFG::TIME;  
        $data['ltime'] = $data['ltime'] + 86399;
        $data['dateline'] = __CFG::TIME;
        $data['clientip'] = __IP;
        if($hongbao_id = $this->db->insert($this->_table, $data, true)){
            if(empty($uid)){
                $sn = substr(md5($this->cd_key.$hongbao_id),10,10);
                $this->update($hongbao_id,array('hongbao_sn'=>$sn), true);
            }
        }
        K::M('message/message')->create(array('uid'=>$uid,'title'=>sprintf(L('恭喜你获得一个%s元红包'), $data['amount']),'type'=>1,'content'=>sprintf(L('红包金额%s元,可用于支付时抵扣相应的金额'), $data['amount']),'type'=>1));
        return $hongbao_id;        
    }
    
    
    public function get_hongbao($uid, $amount)
    {
        $hongbao = $this->find(array('uid'=>$uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0),array('amount'=>'desc'));
        if($count = $this->count(array('uid'=>$uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0))){
            $hongbao['count'] = $count;
        }
        return $hongbao;
    }
    
    
}