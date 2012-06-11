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
        	<div class="lost_title font_heiti">
            	<a href="<?php echo  site_url('lost/')?>" <?php if (isset($link_str)){?>style="width:640px;"<?php }?>>遗失信息</a>
                 <?php if (isset($link_str)) {echo $link_str;}else {?><a href="<?php echo  site_url('found/')?>" target="_blank"  class="go_another">=>去看看招领信息</a><?php }?>
            </div>
            
           <ul class="detail">
           		<?php if (isset($post)){?>
           		<li><span class="detail_t">物品名称：</span><span class="detail_c"><?php echo $post['title']?></span></li>
           		<li><span class="detail_t">遗失地点：</span><span class="detail_c"><?php echo $post['place']?></span></li>
           		<li><span class="detail_t">遗失时间：</span><span class="detail_c"><?php echo $post['time']?></span></li>
           		<li><span class="detail_t">联系人：</span><span class="detail_c"><?php echo $post['link_man']?>(由<font color='red' size=-1><a href="<?php echo site_url('user/profile')."?name=".$post['author'] ;?>"><?php echo $post['author']; ?></a></font>发布)</span></li>
           			<?php if (isset($contact)) { ?>
			           		<?php echo $contact; if (isset($captcha_error)) if ($captcha_error){?>
			           			<?php echo  form_open(current_url());?>
				           		<li><div class="detail_t"><script language="javascript" type="text/javascript" src="<?php echo  site_url()?>imgauthcode/show_script/"></script></div><div class="detail_c" ><div style="color:red;font-size:12px;"><?php echo form_input('captcha');?>（输入验证码后回车查看联系信息.）</div></div></li>
				           		<?php echo form_close(); ?>
			           		<?php }?>
			           	<?php }else {?>
			           		<?php echo  form_open(current_url());?>
			           		<li><div class="detail_t"><script language="javascript" type="text/javascript" src="<?php echo  site_url()?>imgauthcode/show_script/"></script></div><div class="detail_c" ><div style="color:red;font-size:12px;"><?php echo form_input('captcha');?>（输入验证码后回车查看联系信息.）</div></div></li>
			           		<?php echo form_close(); ?>
		           		<?php }?>
           		<li><span class="detail_t">详情描述：</span><span class="detail_c"><?php echo $post['description']?></span></li>
           		<?php }?>
           </ul>
           <div class="comments">
	           <!-- PingLun.La Begin -->
<div id="pinglunla_here"></div><a href="http://pinglun.la/" id="logo-pinglunla">评论啦</a><script type="text/javascript" src="http://static.pinglun.la/md/pinglun.la.js" charset="utf-8"></script>
<!-- PingLun.La End -->
		   </div>

    </div>
      <div class="con_bottom"></div>
    <div class="ulink font_heiti">
    	<p><?php  echo   $this->config->item('u_link'); ?></p>
    </div>
    <div class="foot font_heiti">
    	<p><?php echo @$this->config->item('copyright');?></p>
    </div>
</div>
</div>
<div class="right_bar">
	<a class="search" href="<?php echo  site_url('search')?>">搜索</a>
	<a class="feedback" href="<?php echo  site_url('feedback')?>">意见反馈</a>
</div>
</body>
</html>
