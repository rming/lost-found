<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo site_url()?>theme/css/style.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/page.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/list.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/ie6.css"  rel="stylesheet" type="text/css"/>
<style type="text/css">
.li .info , .li_1 .info{width:160px;}
.li .del{width:60px;color:red;}
</style>
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
    	<div class="con_top con_top_ie6_fix"></div>
    	<div class="list">
        	<div class="lost_title font_heiti">
            	<a href="<?php echo  site_url('user/lost/1')?>"><?php echo $this->session->userdata('name');?>的招领信息</a>
               	<div class="cateselect">
    				<select name="select" onchange="location.href=this.options[this.selectedIndex].value;" >
    				<option value="<?php echo site_url('user/lost/1')?>" selected="selected">-状态分类-</option>
    				<option value="<?php echo site_url('user/lost/1')."?status=0"?>" >&nbsp;正在审核</option>
    				<option value="<?php echo site_url('user/lost/1')."?status=1"?>" >&nbsp;审核通过</option>
    				<option value="<?php echo site_url('user/lost/1')."?status=2"?>" >&nbsp;已经失效</option>
    				</select>
    			</div>
            </div>
            <table width="822" border="0" class="table_post" style="margin-left:5px;_margin-left:3px;">
			  <tr height="30" class="font_heiti tr_th" >
			    <th width="80" class="type">类型</th>
			    <th width="150"  class="name" style="text-indent:-50px;">物品名称</th>
			    <th width="100" class="place" >遗失地点</th>
			    <th width="100"  class="time">遗失时间</th>
			     <th width="80"  class="info" style=" background-position: 12px 0 ;">详情</th>
			    <th width="80" >状态</th>
			    <th width="70" >关闭</th>
			    <th width="70" >编辑</th>
			    <th width="70" >删除</th>
			  </tr>
             <?php  echo @$lost_list;  ?>
              </table>
             <div class="pagenav"><?php  echo @$lost_nav; echo @$error; ?></div>
             
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
