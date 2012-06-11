<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo site_url()?>theme/css/style.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/page.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/list.css"  rel="stylesheet" type="text/css"/>
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
    	<div class="list" >
        	<div class="login_title font_heiti">
            	<a href="<?php echo  site_url('search')?>">搜索信息</a>
                <a href="<?php echo  site_url('user')?>" target="_blank"  class="go_another user_a"  style="_margin-left:0px;">=>用户中心</a>
            </div>
           
            
		    	<div class="search_box">
			        <div class="search_icon"></div>
			        <form action="search" method="get" name="search_form" class="search_form">
			        <div class="search_input_box">
			            <input type="text" class="search_input" name="keyword">
			        </div>
			        
			        <div class="search_select">
			            <select name="cate" >
			                <option value="0">遗失信息</option>
			                <option value="1">招领信息</option>
			            </select>
			        </div>
			        
			        <div class="search_submit">
			            <input type="submit" class="search_btn" value="搜索" />
			        </div>
			        </form>
		    	</div>
			 <div class="align_center" style="height:20px;width:400px;margin-left:100px;float:left;"> <?php echo @$error;?></div>
			<?php if (isset($post)){?>
			<div class="list">
	        	<div class="lost_title font_heiti">
	            	<a href="<?php echo  site_url('search')?>"><?php echo "\"".$_GET['keyword']."\"&nbsp;";?>搜索结果</a>
	               
	            </div>
	            <table width="822" border="0" class="table_post" style="margin-left:5px;_margin-left:3px;">
				  <tr height="30" class="font_heiti tr_th" >
				    <th width="80" class="type">类型</th>
				    <th width="221"  class="name" style="text-indent:-120px;">物品名称</th>
				     <?php if (@$_GET['cate']==0){?>
		                <th width="100" class="place" >遗失地点</th>
				    	<th width="100"  class="time">遗失时间</th>
		                <?php }else {?>
		                <th width="100" class="place" >拾获地点</th>
				    	<th width="100"  class="time">拾获时间</th>
	                <?php } ?>
				    <th width="300"  class="info" style="text-indent:-250px;">详情</th>
				    </tr>
             <?php echo $post; ?>
             </table>
             <div class="pagenav"><?php if (isset($page_nav)) echo $page_nav; ?></div>
        	</div>
			<?php }?>
			
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
