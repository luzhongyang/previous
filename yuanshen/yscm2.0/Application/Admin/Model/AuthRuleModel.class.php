<?php
// 节点模型
namespace Admin\Model;
use Think\Model;
class AuthRuleModel extends CommonModel{
protected $_validate=array(
    array('title','require','权限路径必填'),
    array('name','','权限路径已存在',0,'unique',3),
);

public function checkNode() {
$map['title'] =$_POST['title'];
$map['pid']=isset($_POST['pid'])?$_POST['pid']:0;
$map['status'] = 1;
if(!empty($_POST['id'])) {
$map['id']	=array('neq',$_POST['id']);
}
$result=$this->where($map)->field('id')->find();
if($result) {
return false;
}else{
return true;
}
}

public function getMenu() {
//显示菜单项   
$menu = array ();
//读取数据库模块列表生成菜单项   
$node = D ("AuthRule");  
$map ['status'] =array("egt",0); 
$list = $node->where($map)->order('id')->select();  

foreach ( $list as $key => $module ) {  
//设置模块访问权限   
$menu [$key] = $module;  
}

$menu = arrToTree($menu,0);  
return $menu;
}

}