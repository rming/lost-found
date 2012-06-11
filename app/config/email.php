<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
				$config['protocol'] = MAILMOD;//sendmail or smtp
				$config['mail_from']= MAIL_FROM; //
				$config['smtp_host']= SMTP_HOST;//	无默认值	无	SMTP 服务器地址。
				$config['smtp_user']= SMTP_USER;	//无默认值	无	SMTP 用户账号。
				$config['smtp_pass']= SMTP_PASS;	//无默认值	无	SMTP 密码。
				$config['smtp_port']= SMTP_PORT;	//无	SMTP 端口。
				$config['mailtype']='html';
				$config['subject']=BIAOTI;
				$config['mailer_name']= FAJIANREN;
				//echo $config['smtp_host']."sssssssssssssssss";
	?>