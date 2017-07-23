<?php
namespace Common\Model;
use Think\Model;
class SystemconfigModel extends Model{
	protected $pk = 'k';
    protected $tableName = 'system_config';


    //	获取平台费率
    public function get_rate()
    {
    	$cfg = $this->where(array('k'=>'tixian'))->find();
    	$cfg = unserialize($cfg['v']);
    	$percent = round((int)$cfg['rate']/100, 2);
    	if($percent < 1 && $percent > 0) {
    		return (1-$percent);
    	}
    	return false;
    }
}