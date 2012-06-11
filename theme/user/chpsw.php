<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo site_url()?>theme/css/style.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/page.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/ie6.css"  rel="stylesheet" type="text/css"/>
<title>失物招领平台——大学生事务中心携手青春在线网站共同搭建失物招领平台</title>
</head>
<body>
<div class="main">
	<div class="head">
    	<div class="logo">
        	<a href="<?php echo  site_url('')?>">失物招领平台</a>
        	<div class="logo_title font_heiti">还在为丢了东西发愁？捡到东西找不到失主？<br /> 大学生事务中心携手青春在线网站共同搭建失物招领平台。				</div>
        </div>
        <div class="right_c">
	        <div class="right">
	        		<a href="http://youthol.cn" target="_blank" >青春在线网站|</a><a href="http://youthol.cn/dxsswzx/dxsswzx.aspx" target="_blank" >大学生事务中心</a>
	        </div>
	        <div class="login_a font_heiti">
	        	<?php if ($this->basic->is_login()){?>
	        		<a href="<?php echo  site_url('user'); ?>"><?php echo $this->session->userdata('name');?></a>
	        		<a href="<?php echo  site_url('user/logout'); ?>">退出</a>  
	        	<?php }else {?>
	        	<a href="<?php echo  site_url('user/signup')?>">注册</a><a href="<?php echo  site_url('user/login')?>">登陆</a>
	        	<?php }?>
	        </div>
        </div>
    </div>
    <div class="content">
    	<div class="con_top"></div>
    	<div class="list">
        	<div class="login_title font_heiti ">
            	<a href="<?php echo  site_url('user/resetpassword')?>">修改密码</a>
                <a href="<?php echo  site_url('user/logout')?>" target="_blank"  class="go_another">=>重新登陆</a>
            </div>
            <div class="sign_form">
	           <ul class="detail">
	           <div class="align_center"><?php  echo @$error;?></div>
				<?php echo form_open(current_url()."?".$_SERVER['QUERY_STRING']);?>
				<li><span class="detail_t">&nbsp;新密码：</span><span class="detail_c sign_input"><?php echo form_password('new_password');?><?php echo form_error('new_password');?></span></li>
				<li><span class="detail_t">重新输入：</span><span class="detail_c sign_input"><?php echo form_password('new_passconf');?><?php echo form_error('new_passconf');?></span></li>
				<li><span class="detail_t" ><script language="javascript" type="text/javascript" src="<?php echo  site_url()?>imgauthcode/show_script/"></script></span><span class="detail_c sign_input" ><?php echo form_input('captcha')?><?php  echo @$captcha_error; ?></span></li>
				<li style="width:280px;"><?php echo form_submit('submit','确定','class="login_submit"');?></li>
				<?php echo form_close(); ?>
	           </ul>
           </div>
		    </div>
		    <div class="con_bottom"></div>
   	</div>
    <div class="ulink font_heiti">
    	<p><?php  echo   $this->config->item('u_link'); ?></p>
    </div>
    <div class="foot font_heiti">
    	<p><?php echo @$this->config->item('copyright');?></p>
    </div>
</div>
<div class="right_bar">
	<a class="search" href="<?php echo  site_url('search')?>">搜索</a>
	<a class="feedback" href="<?php echo  site_url('feedback')?>">意见反馈</a>
</div>
</body>
</html>