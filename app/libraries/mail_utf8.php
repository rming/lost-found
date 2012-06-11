<?php

// ------------------------------------------------------------------------



class mail_utf8
{	
	
	function email($to, $subject = '(No subject)', $message = '', $name='Nobody',$from='anonymous@name.com') { 
  		$header = 'MIME-Version: 1.0' . "\n" . 'Content-type: text/plain; charset=UTF-8'. "\n" . 'From: '.$name.' <' . $from . ">\n"; 
 	 	$result = mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);  
   		if ($result) {
   			return true;
   		}else {
   			return false;
   		}
 	} 

}
