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
    	<div class="con_top" style="_background-position:0px bottom;"></div>
    	<div class="list">
        	<div class="login_title font_heiti " style="_margin-left:4px;">
            	<a href="<?php echo  site_url('user')?>">用户中心</a>
                <a href="<?php echo  site_url('thanks')?>" target="_blank"  class="go_another">=>感谢好心人</a>
            </div>
            
            <div class="user" >
	            <p><?php  echo @$error;?></p>
				<p>个人资料&nbsp;&nbsp;<?php if ($this->user_model->get_user_status()=='0') echo anchor('user/confirm','激活帐户');?></p>
				<p><?php echo "用户名：".$this->session->userdata('name'); ?>&nbsp;<?php echo anchor('user/resetpassword','修改密码');?></p>
				<p><?php echo "邮箱：".$this->session->userdata('email'); ?></p>
				<p style="font-size:16px;"><a href="<?php echo site_url('user/lost')?>">发布遗失信息</a>&nbsp;<a href="<?php echo site_url('user/found')?>">发布招领信息</a></p>
           </div>
           <!-- 以下为发表历史的前五条 -->
           <div class="lost_title font_heiti">
            	<a href="<?php echo  site_url('user/found/1')?>">我的招领信息</a>
            	<a href="<?php echo  site_url('user/found/1')?>" target="_blank"  class="go_another">=>查看更多</a>
            </div>
            <table width="822" border="0" class="table_post" style="margin-left:5px;_margin-left:3px;">
			  <tr height="30" class="font_heiti tr_th" >
			    <th width="80" class="type">类型</th>
			    <th width="150"  class="name" style="text-indent:-50px;">物品名称</th>
			    <th width="100" class="place" >拾获地点</th>
			    <th width="100"  class="time">拾获时间</th>
			    <th width="80"  class="info" style=" background-position: 12px 0 ;">详情</th>
			    <th width="80" >状态</th>
			    <th width="70" >关闭</th>
			    <th width="70" >编辑</th>
			    <th width="70" >删除</th>
			  </tr>
             <?php  echo @$found_list; ?>
              </table>
             <div class="find_title font_heiti">
            	<a href="<?php echo  site_url('user/lost/1')?>">我的遗失信息</a>
                <a href="<?php echo  site_url('user/lost/1')?>" target="_blank"  class="go_another">=>查看更多</a>
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
             <?php  echo @$lost_list; ?>
            </table>
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


		