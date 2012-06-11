<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "管理面板--".$this->config->item('sitename');?></title>
<link  type="text/css" rel="stylesheet" href="<?php echo site_url()?>theme/admin/images/style.css">
<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_config.js"></script>
<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_all.js"></script>
<link rel="stylesheet" href="<?php echo site_url()?>public/ueditor/themes/default/ueditor.css"/>
<script language="javascript" type="text/javascript" src="<?php echo site_url()?>public/WdatePicker/js/WdatePicker.js"></script>
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
</head>
<body>
<div class="main">
    <div class="head">
    	<div class="head_con">
        	<div class="logo"><a href="<?php echo site_url('admin/home')?>"></a></div>
        	<div class="my_link"><a href="<?php echo site_url();?>">首页<a href="<?php echo site_url('admin/logout')?>">退出&nbsp;|&nbsp;</a><a href=#><?php echo $this->session->userdata['name']?> &nbsp;</a></div>
        	</div>
    </div>
    <div class="content">
    	<div class="content_con" >
    		<div class="right_con" >
    			<div class="right">
    				<div class="right_title">
    				<a href=""></a></div>
    				<div class="right_content" >
    					
						<div class="post_form" style="height:auto;">
				           	<ul class="post">
			
				           		
			           		<?php if (isset($error)) { ?>
							<li><span class="post_t" style="color:red;width:250px;font-size:14px;text-align:center;"><?php  echo $error;?></span></li>
							<?php }?>
							<?php echo  form_open("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>
							<li><span class="post_t">用户名：</span><span class="post_c"><?php echo form_input('name',set_value('name')); ?><?php echo form_error('name');?><font size="-1" color="red">(*)</font></span></li>
							
							<li><span class="post_t">邮箱：</span><span class="post_c"><?php echo form_input('email',set_value('email')); ?><?php echo form_error('email');?><font size="-1" color="red">(*)</font></span></li>
							<li><span class="post_t">密码：</span><span class="post_c"><?php echo form_input('password',set_value('password')); ?><?php echo form_error('password');?><font size="-1" color="red">(*)</font></span></li>
							<li ><span class="post_t" ><script language="javascript" type="text/javascript" src="<?php echo  site_url()?>imgauthcode/show_script/"></script></span><span class="post_c" ><?php echo form_input('captcha')?><?php echo @$captcha_error; ?><font size="-1" color="red">(*)</font></span></li>
							<li><span class="post_t"></span><select name="status">
							<option value="0" selected="selected" >未认证会员</option>
							<option value="1">普通会员</option>
							<option value="2" >网站管理员</option>
							</select><?php echo form_error('status');?>
							&nbsp;<?php echo form_submit('submit','添加用户 ',"id=\"subBtn\" ");?></span></li>
							<?php echo form_close(); ?>
						</ul>
		           	</div>

    			</div>
	    		</div>
	    	</div>
    		<div class="left">
    			<ul>
    				<span class="li_titile" >信息管理</span>
    				<li><a href="<?php echo site_url('admin/post/add'); ?>" >添加信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/check'); ?>">信息审核</a></li>
    				<li><a href="<?php echo site_url('admin/post/out'); ?>" >失效信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/lost'); ?>">遗失信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/found'); ?>" >招领信息</a></li>
    				<li style="height:0px;"></li>
    				<span class="li_titile" >用户管理</span>
    				<li><a href="<?php echo site_url('admin/user/add');?>"  class="nav_hover">添加用户</a></li>
    				<li><a href="<?php echo site_url('admin/user/member'); ?>" >会员管理</a></li>
    				<li><a href="<?php echo site_url('admin/user/check'); ?>">会员认证</a></li>
    			</ul>
    		</div>
        </div>
    </div>
    <div class="foot"><?php echo @$this->config->item('copyright');?></div>
</div>
</body>
</html>
