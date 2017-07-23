<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Attr extends Mdl_Table
{   
  
    protected $_table = 'cloud_goods_attr';
    protected $_pk = 'attr_id';
    protected $_cols = 'attr_id,goods_id,cate_id,cloud_num,is_set,is_fine,price,join,win_uid,win_number,closed,status,share_status,lottery_time,lottery_ip,addr,clientip,dateline';
    
      public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data,true);
    }
    
    
    public function items_all($filter, $orderby, $page=1, $limit=10, &$count=0)
    {//可匹配商品名称
        $where = '1';
        $ext_sql = '';
        if(is_array($filter)){
            if(isset($filter['goods'])){
                $where = K::M('cloud/goods')->where($filter['goods'], 'ext.');
            }
            unset($filter['goods']);
            $ext_sql = " LEFT JOIN ".$this->table('cloud_goods')." ext ON o.`goods_id`=ext.`goods_id` ";
        }
        $where = $where ." AND ". $this->where($filter, 'o.');
        $orderby = $this->order($orderby);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT COUNT(*) FROM ".$this->table($this->_table) . " o " . $ext_sql . " WHERE $where";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT ext.title,o.* FROM ". $this->table($this->_table)." o $ext_sql WHERE $where $orderby $limit";
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $row = $this->_format_row($row);
                    if($row[$this->_pk]){
                        $items[$row[$this->_pk]] = $row;
                    }else{
                        $items[] = $row;
                    }
                }
            }
        }
        return $items;
    }
    
    
    public function lottery($attr_id)
    {
        if(!$attr_id = (int) $attr_id){
            return false;
        }elseif(!$attrs = $this->detail($attr_id)){
            return false;
        }elseif($attrs['join'] < $attrs['price']){
            return false;
        }else{
            $last_50_items = K::M('cloud/order')->items(array('attr_id'=>$attr_id,'order_status'=>1),array('dateline'=>'desc'),0,50);
            $last_times = 0;
            foreach($last_50_items as $item){
                $last_times += intval(date('His',$item['dateline']).$item['microtime']);
            }
            $lottery_number = ($last_times%$attrs['price']) + 100000001;
            $lottery_number_item = K::M('cloud/number')->find(array('attr_id'=>$attr_id,'number'=>$lottery_number)); //中奖码记录
            $lottery_order_item = K::M('cloud/order')->detail($lottery_number_item['order_id']);
            $data = array('win_uid'=>$lottery_order_item['uid'],'win_number'=>$lottery_number,'lottery_time'=>__TIME,'status'=>1);
            $this->update($attr_id, $data);
        }
        return true;
    }
    
    
    public function items_by_rest($filter,$limit)
    { //根据剩余排序
        $where = $this->where($filter);
        $sql = "SELECT *,`price`-`join` as rest FROM ".$this->table($this->_table)." WHERE ".$where." ORDER by rest DESC LIMIT ".$limit;
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['attr_id']] = $row;
            }
        }
        return $items;
    }

}