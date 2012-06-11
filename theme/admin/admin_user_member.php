<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "管理面板--".$this->config->item('sitename');?></title>
<link type="text/css" rel="stylesheet"  href="<?php echo site_url()?>theme/admin/images/style.css">
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
    					<div class="cateselect">
	    					<select name="select" onchange="location.href=this.options[this.selectedIndex].value;" >
	    					<option value="<?php echo site_url('admin/user')?>" selected="selected">-用户分类-</option>
	    					<option value="<?php echo site_url('admin/user/member')."?status=2"?>" >&nbsp;管理员</option>
	    					<option value="<?php echo site_url('admin/user/member')."?status=1"?>" >&nbsp;普通会员</option>
	    					<option value="<?php echo site_url('admin/user/member')?>" >&nbsp;全部会员</option>
	    					
	    					
	    					</select>
    					</div>
    				</div>
    				<div class="right_content">
    					<table width="600" border="0" >
						  <tr style="background:#eee;">
						    <tr style="background:#eee;">
								<th width="115" scope="col">用户名</th>
								<th width="172" scope="col">邮箱</th>
								<th width="106" scope="col">注册时间</th>
								<th width="76" scope="col">权限</th>
								<th width="52" scope="col">编辑</th>
								<th width="53" scope="col">删除</th>
						  </tr>
						 <?php echo @$post; ?>
						</table>
						<div class="pagenav"><?php  echo @$page_nav; ?></div>
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
    				<li><a href="<?php echo site_url('admin/post/lost'); ?>"  >遗失信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/found'); ?>" >招领信息</a></li>
    				<li style="height:0px;"></li>
    				<span class="li_titile" >用户管理</span>
    				<li><a href="<?php echo site_url('admin/user/add'); ?>">添加用户</a></li>
    				<li><a href="<?php echo site_url('admin/user/member'); ?>" class="nav_hover" >会员管理</a></li>
    				<li><a href="<?php echo site_url('admin/user/check'); ?>">会员认证</a></li>
    			</ul>
    		</div>
        </div>
    </div>
    <div class="foot"><?php echo @$this->config->item('copyright');?></div>
</div>
</body>
</html>
