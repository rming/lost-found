<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/* db config */
	define('DBHOST', 'localhost');  //数据库服务器地址	  | Address String
	define('DBNAME', 'find'); //数据库名	  | String
	define('DBUSER', 'root'); //数据库用户名	 | String
	define('DBPASSWORD', 'vertrigo'); //数据库密码	| String
	define('DB_DEBUG', FALSE);		//是否显示数据库错误信息 | bool    TRUE/FALSE 	leave blank with default option  FALSE
	
	/* Url config */
	// define('URLFIX', '');  //地址后缀 伪静态	| String	 	leave blank with default null			 
	//define('URLFIX', '.html');	 // 
	define('URLFIX', '.html');	 //	
	/*Post Config*/
	define('CHECK', TRUE);//是否需要审核	 | bool  	 TRUE/FALSE

	//SMTP邮件设置  暂时不支持QQ邮箱  亲测 163邮箱可用 
	define('MAILMOD', 'smtp');//sendmail or smtp  设置为sendmail 或其他时 以下设置无效  请配置邮件服务器 
	define('MAIL_FROM', 'sdutfind@163.com');//
	define('SMTP_HOST', 'ssl://smtp.163.com'); //无默认值	无	SMTP 服务器地址。
	define('SMTP_USER', 'sdutfind@163.com'); //无默认值	无	SMTP 用户账号。
	define('SMTP_PASS', 'password');	//无默认值	无	SMTP 密码。
	define('SMTP_PORT', '465');	//	SMTP 端口。
	define('BIAOTI', "山东理工大学失物招领平台邮件通知 ");	//	邮件主题 可以留空 
	define('FAJIANREN', "失物招领平台");	//	 发件人名称
	
	
	$config['u_link']="友情链接：<a href=\"http://youthol.cn/dxsswzx/dxsswzx.aspx\" target=\"_blank\">大学生事务中心</a><a href=\"http://youthol.cn\" target=\"_blank\">青春在线网站</a><a href=\"http://doc.youthol.cn\" target=\"_blank\">试题文库</a><a href=\"http://bbs.youthol.cn\" target=\"_blank\">绿岛论坛</a>";
	/*String Config*/
	$config['sitename']="山东理工大学失物招领平台";
	$config['copyright']="Copyallright&nbsp;&copy;&nbsp;2012&nbsp;山东理工大学青春在线网站&nbsp版权所有<a href=\"admin\">后台管理</a>";
	/*
	 * 
	 *VERSION:20120307
	 *基本完成
	 *VERSION:20120307
	 *修改css错误一处 list.css 第六行 margin-left:60px;
	 */

?>