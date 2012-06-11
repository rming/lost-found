<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basic extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	/*
	//获取地址前缀
	public function user_url()
	{
		$host = $_SERVER['HTTP_HOST'];
		$user_url = substr($host, 0, strpos($host, '.'));
		return $user_url;
	}
	function now(){
		return  date("Y-m-d G:i:s",time()+8*3600);
	}
	public  function get_time($time) {
	    $ntime=time()- strtotime($time);
	    if ($ntime<60) {
	        return("刚才");
	    } elseif ($ntime<3600) {
	        return(intval($ntime/60)."分钟前");
	    } elseif ($ntime<3600*24) {
	        return(intval($ntime/3600)."小时前");
	    } else {
	        return(gmdate('Y-m-d H:i',$time));
    	}         
	}
	*/
	public function is_login(){
	
		if ($this->session->userdata('is_login')==FALSE){
			
			return FALSE;
			}else {
				/*
				//清除匿名登录的影响
				if ($this->session->userdata('anonymous')){
					return FALSE;
				}else {
					*/
				return TRUE;
			}
		}
		
	public function Counti($string){
		$ch_amont = 0;
		$en_amont = 0;
		$string = preg_replace("/(　| ){1,}/", " ", $string);
		for($i=0;$i<strlen($string);$i++)
		{
			$ord = ord($string{$i});    
			if($ord > 128)
				$ch_amont++;
			else
				$en_amont++;
		}
		return ($ch_amont/3) + $en_amont;
	}
	/********************************** 
	  * 截取字符串(UTF-8)
	  *
	  * @param string $str 原始字符串
	  * @param $position 开始截取位置
	  * @param $length 需要截取的偏移量
	  * @return string 截取的字符串
	  * $type=1 等于1时末尾加'...'不然不加
	 *********************************/ 
	 function utfSubstr($str, $position, $length,$type=1){
	  $startPos = strlen($str);
	  $startByte = 0;
	  $endPos = strlen($str);
	  $count = 0;
	  for($i=0; $i<strlen($str); $i++){
	   if($count>=$position && $startPos>$i){
	    $startPos = $i;
	    $startByte = $count;
	   }
	   if(($count-$startByte) >= $length) {
	    $endPos = $i;
	    break;
	   }    
	   $value = ord($str[$i]);
	   if($value > 127){
	    $count++;
	    if($value>=192 && $value<=223) $i++;
	    elseif($value>=224 && $value<=239) $i = $i + 2;
	    elseif($value>=240 && $value<=247) $i = $i + 3;
	    else return self::raiseError("\"$str\" Not a UTF-8 compatible string", 0, __CLASS__, __METHOD__, __FILE__, __LINE__);
	   }
	   $count++;
	
	  }
	  if($type==1 && ($endPos-6)>$length){
	   return substr($str, $startPos, $endPos-$startPos)."…"; 
	       }else{
	   return substr($str, $startPos, $endPos-$startPos);     
	    }
	  
	 }
}

