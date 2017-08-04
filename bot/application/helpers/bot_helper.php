<?php


function show_json_task($data,$code = 1,$info=''){
	$use_time = time();
	$result = array('code' => $code,'info'=>$info,'data' => $data);
	//header("X-Powered-By: kodExplorer.");
	header('Content-Type: application/json; charset=utf-8');
	$result =json_encode($result,JSON_UNESCAPED_UNICODE);
	$result =gzcompress($result);
	$result =td_xor_encode($result);
	
	echo $result;
	exit;
} 

function show_json_task_test($data,$code = 1,$info=''){
	$use_time = time();
	$result = array('code' => $code,'info'=>$info,'data' => $data);
	//header("X-Powered-By: kodExplorer.");
	//header('Content-Type: application/json; charset=utf-8');
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
	//exit;
} 

function show_json2($data){

	header("X-Powered-By: kodExplorer.");
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data);
	exit;
} 

function td_xor_encode($a)  //压缩后的数据，加密
{ 
  $str="";
  if($a=="")
  {
    return $a; 
  }
  while (true)
  {
    $key = chr(mt_rand(1,254));
	if ($key!="\r" && $key!="\n"  && $key!="\t" ) break;
  }
  $len=strlen($a);
  for($i=0;$i<$len;$i++)
  {
	 $c = substr($a, $i , 1);
	 $d =$c^$key;
	 $str.=$d;
  }
  return $str.$key; 
}
function td_xor_decode($a) //解压之前，先解密
{ 
  $str="";
  if($a=="")
  {
    return $a; 
  }
  $len=strlen($a);
  $xor=$a[$len-1];
  for($i=0;$i<$len-1;$i++)
  {
	 $c = substr($a, $i , 1);
	 $d =$c^$xor;
	 $str.=$d;
  }
  return $str; 
}
