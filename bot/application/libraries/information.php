<?php
class information
{
 //系统判断语言
 function get_client_oslang()
 {
  $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,4);
  if (preg_match("/zh-c/i",$lang))
  {
   $oslang = "简体中文";
  } 
  elseif (preg_match("/zh/i",$lang))
  {
   $oslang = "繁體中文";
  } 
  elseif (preg_match("/en/i",$lang))
  {
   $oslang = "English";
  } 
  elseif (preg_match("/fr/i",$lang))
  {
   $oslang = "French";
  } 
  elseif (preg_match("/de/i",$lang))
  {
   $oslang = "German";
  } 
  elseif (preg_match("/jp/i",$lang))
  {
   $oslang = "Japanese";
  } 
  elseif (preg_match("/ko/i",$lang))
  {
   $oslang = "Korean";
  } 
  elseif (preg_match("/es/i",$lang))
  {
   $oslang = "Spanish";
  } 
  elseif (preg_match("/sv/i",$lang))
  {
   $oslang = "Swedish";
  } 
  else
  {
   $oslang = "Other";
  }
  return $oslang ;
 }
 //判断当前IP
 function get_client_ip()
 {
  if ($_SERVER['REMOTE_ADDR'])
  {
   $cip = $_SERVER['REMOTE_ADDR'];
  } 
  elseif (getenv("REMOTE_ADDR"))
  {
   $cip = getenv("REMOTE_ADDR");
  } 
  elseif (getenv( "HTTP_CLIENT_IP"))
  {
   $cip = getenv("HTTP_CLIENT_IP");
  } 
  else
  {
   $cip = "unknown";
  }
  return $cip ;
 }
 //判断当前操作系统
 function get_client_os($ver)
 {
    $osversion=explode(".",$ver);
	if (count($osversion)>=3) 
	{
	  $dwMajorVersion=$osversion[0];
	  $dwMinorVersion=$osversion[1];
	  $wProductType=$osversion[2];
	  if ($dwMajorVersion==4)
	  {
	     if ($dwMinorVersion==0)
		 {
		    $os = "Windows 95";
		 }
		 else if ($dwMinorVersion==1)
		 {
		    $os = "Windows 98";
		 }
		 else if ($dwMinorVersion==9)
		 {
		    $os = "Windows Me";
		 }
	  }
	  else  if ($dwMajorVersion==5)
	  {
	     if ($dwMinorVersion==0)
		 {
		    if ($wProductType==1)
			{
		      $os = "Windows 2000";
			}
			else
			{
			   $os = "Windows Server 2000";
			}
		 }
		 else if ($dwMinorVersion==1)
		 {
		    $os = "Windows XP";
		 }
		 else if ($dwMinorVersion==2)
		 {
		    $os = "Windows Server 2003";
		 }
	  }
	  else  if ($dwMajorVersion==6)
	  {
	     if ($dwMinorVersion==0)
		 {
		    if ($wProductType==1)
			{
		      $os = "Windows Vista";
			}
			else
			{
			   $os = "Windows Server 2008";
			}
		 }
		 else if ($dwMinorVersion==1)
		 {
		    if ($wProductType==1)
			{
		      $os = "Windows 7";
			}
			else
			{
			   $os = "Windows Server 2008R2";
			}
		 }
		 else if ($dwMinorVersion==2)
		 {
		    if ($wProductType==1)
			{
		      $os = "Windows 8";
			}
			else
			{
			   $os = "Windows Server 2012R2";
			}
		 }
	  }
	}
	else
	{
	  $os = "unknown";
	}
    return $os ;
 }
  
   

function GetSID ($nSize=24) { 

// Randomize 
mt_srand ((double) microtime() * 1000000); 
for ($i=1; $i<=$nSize; $i++) { 

// if you wish to add numbers in your string, 
// uncomment the two lines that are commented 
// in the if statement 
$nRandom = mt_rand(1,30); 
if ($nRandom <= 10) { 
// Uppercase letters 
$sessionID .= chr(mt_rand(65,90)); 
// } elseif ($nRandom <= 20) { 
// $sessionID .= mt_rand(0,9); 
} else { 
// Lowercase letters 
$sessionID .= chr(mt_rand(97,122)); 
} 

} 
return $sessionID; 
}    
}


?>