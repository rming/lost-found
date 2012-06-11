<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "管理面板--".$this->config->item('sitename');?></title>
<link  type="text/css" rel="stylesheet" href="<?php echo site_url()?>theme/admin/images/style.css">
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
    	<div class="content_con">
    		
    		<div class="right_con">
    			<div class="right">
    				<div class="right_title">
    				<a href=""></a></div>
    				<div class="right_content">
    					<P style="line-height:28px;"><?php if ($uncheck_num!=0){?><span style="font-size:20px;">友情提示：</span>有 <?php echo "<font color=red >".$uncheck_num."</font>";?> 条信息等待您的审核，<?php if ($uncheck_found_num!=0){?>其中招领信息 <?php echo "<font color=red >".$uncheck_found_num."</font>" ;?> 条.<?php } if ($uncheck_lost_num==0){}else{?>遗失信息 <?php echo  "<font color=red >".$uncheck_lost_num."</font>";?> 条.<?php }}?></P>
    					<P style="line-height:28px;"><span style="font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if ($check_found_num!=0){?>其中已审核招领信息 <?php echo "<font color=red >".$check_found_num."</font>" ;?> 条.<?php } if ($check_lost_num==0){}else{?>已审核遗失信息 <?php echo  "<font color=red >".$check_lost_num."</font>";?> 条.<?php }?> </p>
    					<p style="line-height:28px;"><span style="font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if ($drop_found_num!=0){?>失效招领信息 <?php echo "<font color=red >".$drop_found_num."</font>" ;?> 条.<?php }?><?php  if ($drop_lost_num==0){}else{?>失效遗失信息 <?php echo  "<font color=red >".$drop_lost_num."</font>";?> 条.<?php }?></P>
    					<P style="line-height:28px;"><span style="font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if ($check_user_num!=0){?>有 <?php echo "<font color=red >".$check_user_num."</font>"; ?> 个认证用户.<?php }?> <?php if ($check_admin_num!=0){?>其中  <?php echo "<font color=red >".$check_admin_num."</font>"; ?> 个管理员用户.<?php }?></P>
    					<P style="line-height:28px;"><span style="font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if ($uncheck_user_num!=0){?>有 <?php echo "<font color=red >".$uncheck_user_num."</font>"; ?> 个用户尚未认证.<?php }?></P>
						<div class="pagenav"><?php if (isset($page_nav)) echo $page_nav; ?></div>
    					<div class="admin_error"><?php echo  @$error;?></div>
    				</div>
    			</div>
    		</div>
    		<div class="left">
    			<ul>
    				<span class="li_titile" >信息管理</span>
    				<li><a href="<?php echo site_url('admin/post/add'); ?>">添加信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/check'); ?>">信息审核</a></li>
    				<li><a href="<?php echo site_url('admin/post/out'); ?>" >失效信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/lost'); ?>" >遗失信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/found'); ?>">招领信息</a></li>
    				<li style="height:0px;"></li>
    				<span class="li_titile" >用户管理</span>
    				<li><a href="<?php echo site_url('admin/user/add');?>" >添加用户</a></li>
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
