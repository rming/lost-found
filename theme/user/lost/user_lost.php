<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="<?php echo site_url()?>public/WdatePicker/js/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_config.js"></script>
<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_all.js"></script>
<link rel="stylesheet" href="<?php echo site_url()?>/public/ueditor/themes/default/ueditor.css"/>
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
        	<div class="lost_title font_heiti ">
            	<a href="<?php echo  site_url('user/lost')?>">发布遗失信息</a>
                <a href="<?php echo  site_url('user/found')?>" target="_blank"  class="go_another">=>发布招领信息</a>
            </div>
            
            <div class="post_form">
	           	<ul class="post">

	           		
           		<?php if (isset($error)) { ?>
				<li><span class="post_t" style="color:red;width:200px;font-size:14px;"><?php  echo $error;?></span></li>
				<?php }?>
				<?php echo  form_open("user/lost");?>
				<li><span class="post_t">物品名称：</span><span class="post_c"><?php echo form_input('title',set_value('title')); ?><?php echo form_error('title');?><font size="-1" color="red">(*)</font></span></li>
				<li><span class="post_t">物品类型：</span><span class="post_c">	<select name="type">
				<option value="0">书籍资料</option>
				<option value="1">衣物饰品</option>
				<option value="2" >交通工具</option>
				<option value="3">随身物品</option>
				<option value="4">电子数码</option>
				<option value="5">卡类证件</option>
				<option value="6">其他物品</option>
				</select><?php echo form_error('type');?><font size="-1" color="red">(*)</font>
				</span></li>
				<li><span class="post_t">遗失地点：</span><span class="post_c"><?php echo form_input('place',set_value('place')); ?><?php echo form_error('place');?><font size="-1" color="red">(*)</font></span></li>
				<li><span class="post_t">遗失时间：</span><span class="post_c"><?php echo form_input('time',set_value('time'),"onfocus=\"WdatePicker({firstDayOfWeek:1})\" style=\"background:url('/public/WdatePicker/images/datePicker.gif') right no-repeat;border-size:1px;border-width:1px;background-color:#fff;\" ");  ?><?php echo form_error('time');?><font size="-1" color="red">(*)</font></span></li>
				<li><span class="post_t">联系人：</span><span class="post_c"><?php echo form_input('link_man',set_value('link_man')); ?><?php echo form_error('link_man');?><font size="-1" color="red">(*)</font></span></li>
				<li><span class="post_t" >联系方式&nbsp;&nbsp;</span><span class="post_c"></span></li>
				<br>
				<li><span class="post_t">QQ：</span><span class="post_c"><?php echo form_input('link_qq',set_value('link_qq')); ?><?php echo form_error('link_qq');?></span></li>
				<br>
				<li><span class="post_t">TEL：</span><span class="post_c"><?php echo form_input('link_phone',set_value('link_phone')); ?><?php echo form_error('link_phone');?></span></li>
				<br>
				<li><span class="post_t">Email：</span><span class="post_c"><?php echo form_input('link_email',set_value('link_email')); ?><?php echo form_error('link_email');?></span></li>
				
				<li><span class="post_t">详情描述：</span><span class="post_c"><?php echo form_textarea('description',set_value('description')," id=\"myEditor\" ");?>
				<script type="text/javascript">
					var option = {
						    textarea: 'description' ,//设置提交时编辑器内容的名字
		    			toolbars: [
						// 这里定义的toolbars并不是对应多多行，而是在renderToolbarBoxHtml中去放到相应的位置去
						['FontFamily','FontSize','Bold','Italic','Underline','ForeColor','BackColor','|','JustifyLeft','JustifyCenter','JustifyRight','InsertOrderedList','InsertUnorderedList','Emoticon','Image','PlaceName','Link','Unlink','RemoveFormat','|','Undo','Redo',
						 '|','InsertImage','Emotion','InsertVideo','GMap','HighlightCode','|','Source','FullScreen']
						],
					};
					var editor = new baidu.editor.ui.Editor(option);
				    editor.render("myEditor");
				</script>
				</span></li>
				<?php echo form_error('description');?></p>
				<li><span class="post_t"></span><span class="post_c" style="font-size:14px;"><input type="checkbox" name="checkbox"  value="1" />我已阅读并同意<a href="#">《失物招领平台发布须知》</a><?php echo form_error('checkbox');?></span></li>
				<li><span class="post_t"></span><span class="post_c"><?php echo form_submit('submit','发布信息',"id=\"subBtn\" ");?></span></li>
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


		