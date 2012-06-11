<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  type="text/css" rel="stylesheet" href="<?php echo site_url()?>theme/admin/images/login.css">
<!--[if IE 6]>
<script src="<?php echo site_url() ?>theme/admin/images/DD_belatedPNG.js" language="javascript" type="text/javascript">
</script>
<script language="javascript" type="text/javascript">
  DD_belatedPNG.fix('*');
  function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<![endif]-->
<title><?php echo @"后台登陆--".$this->config->item('sitename');?></title>
</head>
<body>
<div class="login">
	<div class="login_con">
    	<div class="logo"><a href="<?php echo site_url();?> " ></a></div>
        <div class="login_title">后台登陆</div>
        <div class="form">
        	<div class="blank_1"></div>
        	<div class="login_form">
        	<?php echo  form_open('admin/login');?>
            	<ul>
                	<li><span>用户名</span><input type="text" name="username" /></li>
                    <li><span>&nbsp;&nbsp;密码</span><input type="password" name=password /></li>
                    <li><span><script language="javascript" type="text/javascript" src="<?php echo  site_url()?>imgauthcode/show_script/"></script></span><?php echo form_input('captcha',"",'style="height:20px;"');?></li>
                    <li class="buttons"><input type="submit" value="登陆"  /><input type="reset" value="清空"  /></li>
                </ul>
           	<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
