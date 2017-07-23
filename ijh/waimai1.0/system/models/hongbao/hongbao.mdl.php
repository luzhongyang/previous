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
    protected $_cols = 'hongbao_id,title,min_amount,amount,type,uid,hongbao_sn,stime,ltime,order_id,used_ip,used_time,clientip,dateline';
    protected $cd_key = 'hsoewocnsdl2479sdfew_12whf';
    
    public function getType()
    {
        return array(
            1=>L('普通红包'),
            2=>L('彩头红包'),
            3=>L('天降红包'),
            4=>L('超级红包'),
            5=>L('新人红包'),
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
                $datas[$i]['type'] = $data['type'];
                $datas[$i]['stime'] = $data['stime'];
                $datas[$i]['ltime'] = $data['ltime'];
                $datas[$i]['dateline'] = __CFG::TIME;
                $datas[$i]['clientip'] = __IP;
            }
            
            foreach ($datas as $key => $v) {
                $hongbao_id = $this->db->update($this->_table, $v, true);
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
    
    
    public function get_hongbao($uid, $amount)
    {
        $hongbao = $this->find(array('uid'=>$uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0),array('amount'=>'desc'));
        if($count = $this->count(array('uid'=>$uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0))){
            $hongbao['count'] = $count;
        }
        return $hongbao;
    }
    
    
}