<?php
namespace Admin\Controller;
use \Think\Controller;

class CountController extends controller{
	public function index(){
		$this->display();
	}

	/**
	 * 区间统计,默认是一周的用户注册
	 */
	public function count(){
		$table = I('table','User');
		if(!in_array($table, array('User','Article','Question','Answer','Comment','Exchange','Goods','Message','Professor'))){
			$this->ajaxReturn('非法操作');
		}
		$start_time = I('start_date',strtotime(date('Y-m-d'))-6*24*3600);
		$end_time = I('end_date',strtotime(date('Y-m-d')));
		$map['created_time'] = array(array('gt',$start_time),array('lt',$end_time+ 24*3600));
		$data = M($table)->where($map)->getField('created_time',true);

		$timeline = range($start_time,$end_time,24*3600);//获取时间数组
		$count = array(0,0,0,0,0,0,0);//统计数值
		foreach($data as $value){
			$date = strtotime(date('Y-m-d',$value));
			foreach($timeline as $key=>$value){
				if($date == $value){
					$count[$key]++;
				}
			}
		}
		$func = function($value) {
   			 return date('m-d',$value);
		};
		$result['timeline'] = array_map($func,$timeline);
		$result['count'] = $count;
		$this->ajaxReturn($result);
	}
}