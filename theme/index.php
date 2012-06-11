<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo site_url()?>theme/css/style.css"  rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url()?>theme/css/ie6.css"  rel="stylesheet" type="text/css"/>
<style type="text/css">
#informationbar{
 position: fixed;
 left: 0;
 width: 100%;
 text-indent: 5px;
 padding: 5px 0;
 background-color: lightyellow;
 border-bottom: 1px solid black;
 font: bold 12px Verdana;
}
* html #informationbar{
 position: absolute;
 width: expression(document.compatMode=="CSS1Compat"? document.documentElement.clientWidth+"px": body.clientWidth+"px");
}
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
    	<div class="con_left">
            <div class="lost_title lost_title_ie6_fix font_heiti">
            	<a href="<?php echo site_url('lost')?>"">遗失信息</a>
            </div>
            <table width="532" border="0" class="table_post">
			  <tr height="30" class="font_heiti tr_th" >
			    <th width="80" class="type">类型</th>
			    <th width="181"  class="name">物品名称</th>
			    <th width="100" class="place" >遗失地点</th>
			    <th width="100"  class="time">遗失时间</th>
			    <th width="50"  class="info">详情</th>
			  </tr>

            <?php  echo @$lost_list; ?>
             </table>
            <div class="find_title found_title_ie6_fix font_heiti">
            	<a href="<?php echo site_url('found')?>">招领信息</a>
            </div>
            <table width="532" border="0" class="table_post">
			  <tr height="30" class="font_heiti tr_th" >
			    <th width="80" class="type">类型</th>
			    <th width="181"  class="name">物品名称</th>
			    <th width="100" class="place" >拾获地点</th>
			    <th width="100"  class="time">拾获时间</th>
			    <th width="50"  class="info">详情</th>
			  </tr>

            <?php  echo @$found_list; ?>
             </table>
           
        </div>
        <div class="con_right font_heiti">
        	<div class="post_box">
            	<div class="submit">
                	<div class="blank_1"></div>
                	<div class="submit_title"><a href="<?php echo site_url('user/lost')?>">登记遗失信息</a></div>
                    <div class="submit_desc">告诉大家，会有更多的人帮你寻找。</div>
                </div>
                <div class="submit_find">
                	<div class="blank_1"></div>
                	<div class="submit_title"><a href="<?php echo site_url('user/found')?>">寻找失主</a></div>
                    <div class="submit_desc">第一时间发布你拾获的物品信息。</div>
                </div>
                <div class="submit_thx">
                	<div class="blank_1"></div>
                	<div class="submit_title"><a href="<?php echo site_url('thanks')?>">感谢好心人</a></div>
                    <div class="submit_desc">向帮助你的人献上鲜花。</div>
                </div>
            </div>
            <div class="banner_1">
            	<img src="<?php echo site_url()?>theme/images/banner_1.jpg" />
            </div>
            <div class="banner_2">
            	<img src="<?php echo site_url()?>theme/images/banner_2.jpg" />
            </div>
        </div>
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
<script type="text/javascript">
function informationbar(){
 this.displayfreq="always"
 this.content='<a href="javascript:informationbar.close()"><img src="theme/images/bar_close.gif" style="width:14px;height:14px;float:right;border:0;margin-right:5px;"></a>'
}
informationbar.prototype.setContent=function(data){
 this.content=this.content+data
 document.write('<div id="informationbar" style="top: -500px">'+this.content+'</div>')
}
informationbar.prototype.animatetoview=function(){
 var barinstance=this
 if (parseInt(this.barref.style.top)<0){
  this.barref.style.top=parseInt(this.barref.style.top)+5+"px"
  setTimeout(function(){barinstance.animatetoview()}, 50)
 }
 else{
  if (document.all && !window.XMLHttpRequest)
  this.barref.style.setExpression("top", 'document.compatMode=="CSS1Compat"?document.documentElement.scrollTop+"px":body.scrollTop+"px"')
 else
  this.barref.style.top=0
 }
}
informationbar.close=function(){
 document.getElementById("informationbar").style.display="none"
 if (this.displayfreq=="session")
  document.cookie="infobarshown=1;path=/"
}
informationbar.prototype.setfrequency=function(type){
 this.displayfreq=type
}
informationbar.prototype.initialize=function(){
 if (this.displayfreq=="session" && document.cookie.indexOf("infobarshown")==-1 || this.displayfreq=="always"){
  this.barref=document.getElementById("informationbar")
  this.barheight=parseInt(this.barref.offsetHeight)
  this.barref.style.top=this.barheight*(-1)+"px"
  this.animatetoview()
 }
}
window.onunload=function(){
 this.barref=null
}
//Invocation code
var infobar=new informationbar()
infobar.setContent('推荐使用chrome浏览器，以获得最佳体验，发布信息请仔细阅读<a href=\"#\">《发布须知》</a>')
infobar.initialize()
</script>

</body>
</html>
