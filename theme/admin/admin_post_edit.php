<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "管理面板--".$this->config->item('sitename');?></title>
<link  type="text/css" rel="stylesheet" href="<?php echo site_url()?>theme/admin/images/style.css">

<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_config.js"></script>
<script type="text/javascript" src="<?php echo site_url()?>public/ueditor/editor_all.js"></script>
<link rel="stylesheet" href="<?php echo site_url()?>public/ueditor/themes/default/ueditor.css"/>
<script language="javascript" type="text/javascript" src="<?php echo site_url()?>public/WdatePicker/js/WdatePicker.js"></script>
<!--[if IE 6]>
<script src="<?php echo site_url() ?>theme/admin/images/DD_belatedPNG.js" language="javascript" type="text/javascript">
</script>
<script language="javascript" type="text/javascript">
  DD_belatedPNG.fix('*');
  function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<![endif]-->
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
    	<div class="content_con"  style="height:600px;_height:500px;">
    	<div style="height:auto;float:left;_height:100%;">
    		<div class="right_con" >
    			<div class="right">
    				<div class="right_title">
    				<a href=""></a></div>
    				<div class="right_content" >
    					
						<div class="post_form" style="height:auto;">
			           	<ul class="post" ">
		           		<?php if (isset($error)) { ?>
						<li><span class="post_t" style="color:red;width:200px;font-size:14px;"><?php  echo $error;?></span></li>
						<?php }?>
						<?php echo  form_open("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>
						<li><span class="post_t">物品名称：</span><span class="post_c"><?php echo form_input('title',$title); ?><?php echo form_error('title');?><font size="-1" color="red">(*)</font></span></li>
						<li><span class="post_t">物品类型：</span><span class="post_c">	<select name="type" value="<?php echo $type;?>">
						<option value="0">书籍资料</option>
						<option value="1">衣物饰品</option>
						<option value="2" >交通工具</option>
						<option value="3">随身物品</option>
						<option value="4">电子数码</option>
						<option value="5">卡类证件</option>
						<option value="6">其他物品</option>
						</select><?php echo form_error('type');?><font size="-1" color="red">(*)</font>
						</span></li>
						<li><span class="post_t">拾获地点：</span><span class="post_c"><?php echo form_input('place',$place); ?><?php echo form_error('place');?><font size="-1" color="red">(*)</font></span></li>
						<li><span class="post_t">拾获时间：</span><span class="post_c"><?php echo form_input('time',$time,"onfocus=\"WdatePicker({firstDayOfWeek:1})\" style=\"background:url('/public/WdatePicker/images/datePicker.gif') right no-repeat;border-size:1px;border-width:1px;background-color:#fff;\" ");  ?><?php echo form_error('time');?><font size="-1" color="red">(*)</font></span></li>
						<li><span class="post_t">联系人：</span><span class="post_c"><?php echo form_input('link_man',$link_man); ?><?php echo form_error('link_man');?><font size="-1" color="red">(*)</font></span></li>
						<li><span class="post_t" >联系方式&nbsp;&nbsp;</span><span class="post_c"></span></li>
						<br>
						<li><span class="post_t">QQ：</span><span class="post_c"><?php echo form_input('link_qq',$link_qq); ?><?php echo form_error('link_qq');?></span></li>
						<br>
						<li><span class="post_t">TEL：</span><span class="post_c"><?php echo form_input('link_phone',$link_phone); ?><?php echo form_error('link_phone');?></span></li>
						<br>
						<li><span class="post_t">Email：</span><span class="post_c"><?php echo form_input('link_email',$link_email); ?><?php echo form_error('link_email');?></span></li>
						
						<li><span class="post_t">详情描述：</span><span class="post_c"><?php echo form_textarea('description',$description," id=\"myEditor\"  ");?>
						<script type="text/javascript">
							var option = {
								    textarea: 'description' ,//设置提交时编辑器内容的名字
				    			toolbars: [['FontFamily','FontSize','Bold','Italic','Underline','ForeColor','BackColor','|','JustifyLeft','JustifyCenter','JustifyRight','InsertOrderedList','InsertUnorderedList','Emoticon','Image','PlaceName','Link','Unlink','RemoveFormat','|','Undo','Redo','|','InsertImage','Emotion','InsertVideo','GMap','HighlightCode','|','Source','FullScreen']],
							};
							var editor = new baidu.editor.ui.Editor(option);
						    editor.render("myEditor");
						</script>
						</span></li>
						<?php echo form_error('description');?></p>
						<li><span class="post_t"></span><span class="post_c"  style="margin-top:5px;"><input type="checkbox" name="status"  <?php  if ($status=='1'||$status=='2') {?> checked="checked"<?php } ?>/>是否审核&nbsp;<?php echo form_submit('submit','编辑信息',"id=\"subBtn\" ");?></span></li>
						<?php echo form_close(); ?>
					</ul>
		           	</div>

    			</div>
	    		</div>
	    	</div>
    		<div class="left">
    			<ul>
    				<span class="li_titile" >信息管理</span>
    				<li><a href="<?php echo site_url('admin/post/add'); ?>">添加信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/check'); ?>"<?php if (@$_GET['from']=='check'){?>class="nav_hover" <?php }?>>信息审核</a></li>
    				<li><a href="<?php echo site_url('admin/post/out'); ?>"  <?php if (@$_GET['from']=='out'){?>class="nav_hover" <?php }?>>失效信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/lost'); ?>"  <?php if (@$_GET['from']=='lost'){?>class="nav_hover"<?php }?>>遗失信息</a></li>
    				<li><a href="<?php echo site_url('admin/post/found'); ?>" <?php if (@$_GET['from']=='found'){?>class="nav_hover"<?php }?>>招领信息</a></li>
    				<li style="height:0px;"></li>
    				<span class="li_titile" >用户管理</span>
    				<li><a href="<?php echo site_url('admin/user/add');?>" >添加用户</a></li>
    				<li><a href="<?php echo site_url('admin/user/member'); ?>" >会员管理</a></li>
    				<li><a href="<?php echo site_url('admin/user/check'); ?>">会员认证</a></li>
    			</ul>
    		</div>
        </div>
        </div>
    </div>
    <div class="foot"><?php echo @$this->config->item('copyright');?></div>
</div>
</body>
</html>
