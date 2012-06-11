<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="UYId" content="<?php echo current_url()?>" />
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
        	<div class="login_title font_heiti thanks_title ">
            	<a href="<?php echo  site_url('thanks')?>">感谢好心人</a>
                <a href="<?php echo  site_url('')?>" target="_blank"  class="go_another">=>返回首页</a>
            </div>
            
           <div class="comments">
	           <!-- PingLun.La Begin -->
<div id="pinglunla_here"></div><a href="http://pinglun.la/" id="logo-pinglunla"></a><script type="text/javascript" src="http://static.pinglun.la/md/pinglun.la.js" charset="utf-8"></script>
<!-- PingLun.La End -->
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
