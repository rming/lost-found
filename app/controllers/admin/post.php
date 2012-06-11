<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('basic');
		$this->load->model('admin_post_model');
		$this->load->model('admin_user_model');
	}
	//文章列表功能
   	function index(){
   		$this->add();
	}
	function add(){
		if ($this->admin_user_model->is_admin_login()){
			//lost的cate id;
			if (isset($_REQUEST['description'])){
				$description=$_REQUEST['description'];
			}else {
				$description="没有留下详细信息。";
			}
			//设置表单验证的规则
			$this->form_validation->set_rules('title','标题','required');
			$this->form_validation->set_rules('cate', '分类', 'required');
			$this->form_validation->set_rules('type', '类别', 'required');
			$this->form_validation->set_rules('place', '地点', 'required');
			$this->form_validation->set_rules('time', '时间','required');
			$this->form_validation->set_rules('link_man', '联系人','required');
			$this->form_validation->set_rules('link_qq', '联系QQ','');
			$this->form_validation->set_rules('link_phone', '联系电话','');
			$this->form_validation->set_rules('link_email', '电子邮箱','');
			$this->form_validation->set_rules('description', '详细描述','');
			//post数据不为空时进行数据处理
			if ($this->input->post('title')!=""){
				//表单数据验证
				if ($this->form_validation->run()){
					//检查是否为重复提交
					if($this->admin_post_model->postcheck()){
						$data['error']= "请不要重复发布信息。";
					}else {
					if (@$_POST['status']=='on'){
							$_POST['status']='1';
						}else {
							$_POST['status']='0';
						}
						
					if($this->admin_post_model->postsave($description)){
							$data['error']= "信息发布成功！";
						}else {
							$data['error']= "信息发布失败，请重试。";
						}
					}
				}
			}
			@$this->load->view('admin/admin_post_add',$data);
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	function check(){
			if ($this->admin_user_model->is_admin_login()){
			//根据page参数设置获得页码
			if ($this->uri->segment(4, 1)=="lost"||$this->uri->segment(4, 1)=="found"){
				$page = $this->uri->segment(5, 1);
				if ($this->uri->segment(4, 1)=="lost"){
					$status='0';
					$cate="0";
					$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
					$config['page_url'] = 'admin/post/check/lost';  
					$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=0";
				}else {
					$status='0';
					$cate="1";
					$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
					$config['page_url'] = 'admin/post/check/found';  
					$sql="SELECT COUNT(*) AS count FROM post WHERE  category=1 AND status=0";
				}
			}else {
				$status='0';
				$page = $this->uri->segment(4, 1);
				$post=$this->admin_post_model->get_by_status($status,15,15*($page-1));
			 	$config['page_url'] = 'admin/post/check';  
			 	$sql="SELECT COUNT(*) AS count FROM post WHERE status=0";
			}
		  
			//查询验证
			//print_r($post);
			if (!isset($post)){
				$data['error']="没有查询到相关数据。";
				$this->load->view('admin/admin_post_check',$data);
			}else{
				//分页
				
				$result=mysql_fetch_array(mysql_query($sql));
				$count=$result['count']; 
				$config['page_size'] = 15 ;//每页几篇
				$config['rows_num'] = $count;  //一共多少文章
				$config['page_num'] = $page; //当前页页码
				$this->load->library('custom_pagination');  
				$this->custom_pagination->init($config);  
				$data['page_nav']=$this->custom_pagination->create_links();
			 	//从数组中转成前台代码
			 	//$str="";
			 	$i=1;
			 	//$url_1="lost/";
				foreach ($post as $row)
				{
					$post[$i] = $row; 
					$post[$i]['tname'] = $this->admin_post_model->get_type($post[$i]['type']);
					if ($post[$i]['tname']==false){
						$post[$i]['tname']="其他物品";
					}
					//截取指定长度字符串
					if (isset($post[$i]['title'])){
						if ($this->basic->Counti($post[$i]['title'])>12){
							$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,30);
						}
					}
					
					if (isset($post[$i]['post_time'])){
						if ($this->basic->Counti($post[$i]['post_time'])>10){
							$post[$i]['post_time']=$this->basic->utfSubstr($post[$i]['post_time'],0,10);
						}
					}
					$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=check"."\"style=\"color:#333;\">".$post[$i]['title']."</a></td>";
					$str1="<td align=\"center\"><a href=\"".site_url('admin/post/check')."?tid=".$post[$i]['type']."\"style=\"font-size:12px;color:#555;\">".$post[$i]['tname']."</a></td>";
					$str2="<td align=\"center\" >"."<div style=\"font-size:14px;\">".$post[$i]['post_time']."</div></td>";
					$str2_1="<td align=\"center\" >"."<div style=\"font-size:14px;\"><a href=".site_url('admin/user/member')."?name=".$post[$i]['author'].">".$post[$i]['author']."</a></div></td>";
					$str3="<td align=\"center\"><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=check"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
					$str4="<td align=\"center\"><a href=\"".site_url('admin/post/del')."?id=".$post[$i]['id']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
					//得到前台代码
					@$str=$str.$str0.$str1.$str2.$str2_1.$str3.$str4;
					$i++; 
				};					
			}
			//加载文章
			if (isset($str)){
				$data['post']=$str;
				$this->load->view('admin/admin_post_check',$data);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	function out(){
			if ($this->admin_user_model->is_admin_login()){
			//根据page参数设置获得页码
			if ($this->uri->segment(4, 1)=="lost"||$this->uri->segment(4, 1)=="found"){
				$page = $this->uri->segment(5, 1);
				if ($this->uri->segment(4, 1)=="lost"){
					$status='2';
					$cate="0";
					$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
					$config['page_url'] = 'admin/post/out/lost';  
					$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=2";
				}else {
					$status='2';
					$cate="1";
					$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
					$config['page_url'] = 'admin/post/out/found';  
					$sql="SELECT COUNT(*) AS count FROM post WHERE  category=1 AND status=2";
				}
			}else {
				$status='2';
				$page = $this->uri->segment(4, 1);
				$post=$this->admin_post_model->get_by_status($status,15,15*($page-1));
			 	$config['page_url'] = 'admin/post/out';  
			 	$sql="SELECT COUNT(*) AS count FROM post WHERE status=2";
			}
		  
			//查询验证
			//print_r($post);
			if (!isset($post)){
				$data['error']="没有查询到相关数据。";
				$this->load->view('admin/admin_post_out',$data);
			}else{
				//分页
				
				$result=mysql_fetch_array(mysql_query($sql));
				$count=$result['count']; 
				$config['page_size'] = 15 ;//每页几篇
				$config['rows_num'] = $count;  //一共多少文章
				$config['page_num'] = $page; //当前页页码
				$this->load->library('custom_pagination');  
				$this->custom_pagination->init($config);  
				$data['page_nav']=$this->custom_pagination->create_links();
			 	//从数组中转成前台代码
			 	//$str="";
			 	$i=1;
			 	//$url_1="lost/";
				foreach ($post as $row)
				{
					$post[$i] = $row; 
					$post[$i]['tname'] = $this->admin_post_model->get_type($post[$i]['type']);
					if ($post[$i]['tname']==false){
						$post[$i]['tname']="其他物品";
					}
					//截取指定长度字符串
					if (isset($post[$i]['title'])){
						if ($this->basic->Counti($post[$i]['title'])>12){
							$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,30);
						}
					}
					
					if (isset($post[$i]['post_time'])){
						if ($this->basic->Counti($post[$i]['post_time'])>10){
							$post[$i]['post_time']=$this->basic->utfSubstr($post[$i]['post_time'],0,10);
						}
					}
					$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=out"."\"style=\"color:#333;\">".$post[$i]['title']."</a></td>";
					$str1="<td align=\"center\"><a href=\"".site_url('admin/post/check')."?tid=".$post[$i]['type']."\"style=\"font-size:12px;color:#555;\">".$post[$i]['tname']."</a></td>";
					$str2="<td align=\"center\" >"."<div style=\"font-size:14px;\">".$post[$i]['post_time']."</div></td>";
					$str2_1="<td align=\"center\" >"."<div style=\"font-size:14px;\"><a href=".site_url('admin/user/member')."?name=".$post[$i]['author'].">".$post[$i]['author']."</a></div></td>";
					$str3="<td align=\"center\"><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=out"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
					$str4="<td align=\"center\"><a href=\"".site_url('admin/post/del')."?id=".$post[$i]['id']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
					//得到前台代码
					@$str=$str.$str0.$str1.$str2.$str2_1.$str3.$str4;
					$i++; 
				};					
			}
			//加载文章
			if (isset($str)){
				$data['post']=$str;
				$this->load->view('admin/admin_post_out',$data);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	function lost(){
			if ($this->admin_user_model->is_admin_login()){
			if (isset($_GET['tid'])){
					$tid=$_GET['tid'];
					if (isset($_GET['page'])){
						$page=$_GET['page'];
						$page=str_replace (".html",'',$page );
						
					}else {
						$page=1;
					}
					$cate="0";
		   			$status='1';
		   			$post=$this->admin_post_model->get_by_order_tid($cate,$status,$tid,15,15*($page-1));
		   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1 AND type=".$tid;
		   			$config['page_url'] = site_url('admin/post/lost').'?tid='.$tid.'&page=';  
		   			$this->load->library('pagina');  
				}else {
		   			$page = $this->uri->segment(4, 1);
		   			$cate="0";
		   			$status='1';
		   			$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
		   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1";
		   			$config['page_url'] = 'admin/post/lost';  
		   			$this->load->library('custom_pagination');
		   			
				}
			//根据page参数设置获得页码
		   	//$page = $this->uri->segment(4, 1);
		   
			//根据cate参数获取那个目录
			//$cate="0";
			//$status='1';
			//查询验证
			//$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
			//print_r($post);
			if (!isset($post)){
				$data['error']="没有查询到相关数据。";
				$this->load->view('admin/admin_post_lost',$data);
			}else{
				//分页
				//$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1";
				$result=mysql_fetch_array(mysql_query($sql));
				$count=$result['count']; 
				//echo $count;
				//$config['page_url'] = 'admin/post/lost';  
				$config['page_size'] = 15 ;//每页几篇
				$config['rows_num'] = $count;  //一共多少文章
				$config['page_num'] = $page; //当前页页码
				//$this->load->library('custom_pagination');  
				//$this->custom_pagination->init($config);  
				//$data['page_nav']=$this->custom_pagination->create_links();
				if (isset($_GET['tid'])){
					$this->pagina->init($config);  
					$data['page_nav']=$this->pagina->create_links();
				}else {
					$this->custom_pagination->init($config);  
					$data['page_nav']=$this->custom_pagination->create_links();
				}
				
			 	//从数组中转成前台代码
			 	//$str="";
			 	$i=1;
			 	//$url_1="lost/";
				foreach ($post as $row)
				{
					$post[$i] = $row; 
					$post[$i]['tname'] = $this->admin_post_model->get_type($post[$i]['type']);
					if ($post[$i]['tname']==false){
						$post[$i]['tname']="其他物品";
					}
					//截取指定长度字符串
					if (isset($post[$i]['title'])){
						if ($this->basic->Counti($post[$i]['title'])>18){
							$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,30);
						}
					}
					
					if (isset($post[$i]['post_time'])){
						if ($this->basic->Counti($post[$i]['post_time'])>10){
							$post[$i]['post_time']=$this->basic->utfSubstr($post[$i]['post_time'],0,10);
						}
					}
					$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=lost"."\"style=\"color:#333;\">".$post[$i]['title']."</a></td>";
					$str1="<td align=\"center\"><a href=\"".site_url('admin/post/lost')."?tid=".$post[$i]['type']."\"style=\"font-size:12px;color:#555;\">".$post[$i]['tname']."</a></td>";
					$str2="<td align=\"center\" >"."<div style=\"font-size:14px;\">".$post[$i]['post_time']."</div></td>";
					$str2_1="<td align=\"center\" >"."<div style=\"font-size:14px;\"><a href=".site_url('admin/user/member')."?name=".$post[$i]['author'].">".$post[$i]['author']."</a></div></td>";
					$str3="<td align=\"center\"><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=lost"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
					$str4="<td align=\"center\"><a href=\"".site_url('admin/post/del')."?id=".$post[$i]['id']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
					//得到前台代码
					@$str=$str.$str0.$str1.$str2.$str2_1.$str3.$str4;
					$i++; 
				};					
			}
			//加载文章
			if (isset($str)){
				$data['post']=$str;
				$this->load->view('admin/admin_post_lost',$data);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	function found(){
			if ($this->admin_user_model->is_admin_login()){
				if (isset($_GET['tid'])){
					$tid=$_GET['tid'];
					if (isset($_GET['page'])){
						$page=$_GET['page'];
						$page=str_replace (".html",'',$page );
					}else {
						$page=1;
					}
					$cate="1";
		   			$status='1';
		   			$post=$this->admin_post_model->get_by_order_tid($cate,$status,$tid,15,15*($page-1));
		   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=1 AND status=1 AND type=".$tid;
		   			$config['page_url'] = site_url('admin/post/found').'?tid='.$tid.'&page=';  
		   			$this->load->library('pagina');  
				}else {
		   			$page = $this->uri->segment(4, 1);
		   			$cate="1";
		   			$status='1';
		   			$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
		   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=1 AND status=1";
		   			$config['page_url'] = 'admin/post/found';  
		   			$this->load->library('custom_pagination');
		   			
				}
			
		   
			//根据cate参数获取那个目录
			//$cate="1";
			//$status='1';
			//查询验证
			//$post=$this->admin_post_model->get_by_order($cate,$status,15,15*($page-1));
			//print_r($post);
			if (!isset($post)){
				$data['error']="没有查询到相关数据。";
				$this->load->view('admin/admin_post_found',$data);
			}else{
				//分页
				//$sql="SELECT COUNT(*) AS count FROM post WHERE category=1 AND status=1";
				$result=mysql_fetch_array(mysql_query($sql));
				$count=$result['count']; 
				//$config['page_url'] = 'admin/post/found';  
				$config['page_size'] = 15 ;//每页几篇
				$config['rows_num'] = $count;  //一共多少文章
				$config['page_num'] = $page; //当前页页码
				//$this->load->library('custom_pagination');  
				
				if (isset($_GET['tid'])){
					$this->pagina->init($config);  
					$data['page_nav']=$this->pagina->create_links();
				}else {
					$this->custom_pagination->init($config);  
					$data['page_nav']=$this->custom_pagination->create_links();
				}
				
			 	//从数组中转成前台代码
			 	//$str="";
			 	$i=1;
			 	//$url_1="lost/";
				foreach ($post as $row)
				{
					$post[$i] = $row; 
					$post[$i]['tname'] = $this->admin_post_model->get_type($post[$i]['type']);
					if ($post[$i]['tname']==false){
						$post[$i]['tname']="其他物品";
					}
					//截取指定长度字符串
					if (isset($post[$i]['title'])){
						if ($this->basic->Counti($post[$i]['title'])>18){
							$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,30);
						}
					}
					
					if (isset($post[$i]['post_time'])){
						if ($this->basic->Counti($post[$i]['post_time'])>10){
							$post[$i]['post_time']=$this->basic->utfSubstr($post[$i]['post_time'],0,10);
						}
					}
					$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=found"."\"style=\"color:#333;\">".$post[$i]['title']."</a></td>";
					$str1="<td align=\"center\"><a href=\"".site_url('admin/post/found')."?tid=".$post[$i]['type']."\"style=\"font-size:12px;color:#555;\">".$post[$i]['tname']."</a></td>";
					$str2_1="<td align=\"center\" >"."<div style=\"font-size:14px;\"><a href=".site_url('admin/user/member')."?name=".$post[$i]['author'].">".$post[$i]['author']."</a></div></td>";
					$str2="<td align=\"center\" >"."<div style=\"font-size:14px;\">".$post[$i]['post_time']."</div></td>";
					$str3="<td align=\"center\"><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=found"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
					$str4="<td align=\"center\"><a href=\"".site_url('admin/post/del')."?id=".$post[$i]['id']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
					//得到前台代码
					@$str=$str.$str0.$str1.$str2.$str2_1.$str3.$str4;
					$i++; 
				};					
			}
			//加载文章
			if (isset($str)){
				$data['post']=$str;
				$this->load->view('admin/admin_post_found',$data);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	function edit(){
		if ($this->admin_user_model->is_admin_login()){
			//获取编辑信息id
			if (isset($_GET['id'])){
					$post_id=$_GET['id'];
				}
			if (isset($post_id)){
				$find=$this->admin_post_model->get_by_id($post_id);
			}
			if (!isset($find)){ 
				$data = array(
   				'error_title' =>"编辑错误",
   				'error' =>"没有权限或信息不存在。",
	   			);
	   			$this->load->view('admin/admin_error',$data);
	   			header("refresh:2;url=".site_url('admin/home'));
			}else {
				$_GET['cate'] = $find['category'];
				//获得信息详情
				if (isset($_REQUEST['description'])){
					$description = $_REQUEST['description'];
				}else {
					$description = "没有留下详细信息。";
				}
				//设置表单验证的规则
				$this->form_validation->set_rules('title','title','required');
				$this->form_validation->set_rules('type', 'type', 'required');
				$this->form_validation->set_rules('place', 'place', 'required');
				$this->form_validation->set_rules('time', 'time','required');
				$this->form_validation->set_rules('link_man', 'link_man','required');
				$this->form_validation->set_rules('link_qq', 'link_qq','');
				$this->form_validation->set_rules('link_phone', 'link_phone','');
				$this->form_validation->set_rules('link_email', 'link_email','');
				$this->form_validation->set_rules('description', 'description','');
				//post数据不为空时进行数据处理
				if ($this->input->post('title')!=""){
					//表单数据验证
					if ($this->form_validation->run()){
						//检查是否为重复提交
						if (@$_POST['status']=='on'){
							$_POST['status']='1';
						}else {
							$_POST['status']='0';
						}
						$_POST['author']=$find['author'];
						if($this->admin_post_model->postupdateandcheck($description)){
								$data['error']= "编辑成功！";
							}else {
								$data['error']= "编辑失败，请重试。";
							}
					}
				}
				$editdata=$this->admin_post_model->get_by_id($post_id);
				if (isset($data)){
					$editdata['error']=$data['error'];
				}
				$this->load->view('admin/admin_post_edit',$editdata);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	
	function del(){
		if ($this->admin_user_model->is_admin_login()){
				@$post_id=$_GET['id'];
				@$redirect=$_GET['redirect'];
			if (isset($post_id)){
				$find=$this->admin_post_model->get_by_id($post_id);
			}
			if ($find!=null){
				$result=$this->db->delete('post', array('id' => $post_id)  );
				if ($redirect!=null){
					header("refresh:1;url=".$redirect);
				}else {
					header("refresh:1;url=".site_url());
				}
				$data['error']="删除成功！正在返回……<br>";
				$this->load->view('admin/admin_error',$data);
			}else {
				if ($redirect!=null){
					header("refresh:1;url=".$redirect);
				}else {
					header("refresh:1;url=".site_url());
				}
				$data['error']="没有权限或信息不存在！<br>";
				$this->load->view('admin/admin_error',$data);
			}
		}else {
			$data = array(
   				'error_title' =>"重新登陆",
   				'error' =>"管理员未登陆或帐号管理权限被取消，请重新登陆。",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:2;url=".site_url('admin/login'));
		}
	}
	

}