<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  type="text/css" rel="stylesheet" href="<?php echo site_url()?>theme/admin/images/login.css">
<title><?php echo @$error_title."--".$this->config->item('sitename');?></title>
</head>
<body>
<div class="login">
	<div class="login_con">
    	<div class="logo"></div>
        <div class="login_title"><?php echo @$error_title;?></div>
        <div class="form" style="text-align:center;">
        	<span style="width:100%;height:15px;margin-top:30px;color:#FFF;display:block;"><?php echo @$error;?></span>
        </div>
    </div>
</div>
</body>
</html>
