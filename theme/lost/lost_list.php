<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo site_url()?>theme/css/style.css"  rel="stylesheet" type="text/css"/>
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
    	<div class="con_top con_top_ie6_fix"></div>
    	<div class="list">
        	<div class="find_title font_heiti">
            	<a href="<?php echo  site_url('lost/')?>">遗失信息</a>
                <div class="cateselect">
    				<select name="select" onchange="location.href=this.options[this.selectedIndex].value;" >
    				<option value="<?php echo site_url('lost')?>" selected="selected">-物品分类-</option>
    				<option value="<?php echo site_url('lost')."?tid=0"?>" >&nbsp;书籍资料</option>
    				<option value="<?php echo site_url('lost')."?tid=1"?>" >&nbsp;衣服饰品</option>
    				<option value="<?php echo site_url('lost')."?tid=2"?>" >&nbsp;交通工具</option>
    				<option value="<?php echo site_url('lost')."?tid=3"?>" >&nbsp;随身物品</option>
    				<option value="<?php echo site_url('lost')."?tid=4"?>" >&nbsp;电子数码</option>
    				<option value="<?php echo site_url('lost')."?tid=5"?>" >&nbsp;卡类证件</option>
    				<option value="<?php echo site_url('lost')."?tid=6"?>" >&nbsp;其他物品</option>
    				</select>
    			</div>
            </div>
            <table width="822" border="0" class="table_post" style="margin-left:5px;_margin-left:3px;">
			  <tr height="30" class="font_heiti tr_th" >
			    <th width="80" class="type">类型</th>
			    <th width="221"  class="name" style="text-indent:-120px;">物品名称</th>
			    <th width="100" class="place" >遗失地点</th>
			    <th width="100"  class="time">遗失时间</th>
			    <th width="300"  class="info" style="text-indent:-250px;">详情</th>
			  </tr>
             <?php echo @$post;  ?>
             </table>
             <div class="pagenav"><?php echo @$page_nav;  echo @$error; ?></div>
             
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
