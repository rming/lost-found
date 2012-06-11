<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('basic');
		$this->load->model('admin_user_model');
	}
	function index(){
		$this->member();
	}
	//
   	function member(){
   		if ($this->admin_user_model->is_admin_login()){
   			if (isset($_GET['name'])){
					$name=strtolower($_GET['name']);
		   			$user=$this->admin_user_model->get_user_by_name($name);
		   			if ($user!=false){
		   				$this->load->model('admin_post_model');
		   				if (isset($_GET['page'])){
		   					if ($_GET['page']!=null){
								$page=$_GET['page'];
								$page=str_replace (".html",'',$page );
							}else {
								$page='1';
							}
						}else {
							$page='1';
						}
						if (isset($_GET['cate'])){
							if ($_GET['cate']!=null){
								$cate=$_GET['cate'];
							}else {
								$cate='1';
							}
						}else {
							$cate='1';
						}
						$limit=13;
						$offset=13*($page-1);
		   				$post=$this->admin_post_model->get_by_user($name,$cate,$limit,$offset);
			   			if (!isset($post)){
			   				$data['user']=$user;
							$data['error']="没有查询到相关数据。";
							$this->load->view('admin/admin_user_member_profile',$data);
					}else{
						//分页
						$sql="SELECT COUNT(*) AS count FROM post WHERE author='".$name."' AND category=".$cate;
		   				$result=mysql_fetch_array(mysql_query($sql));
						$count=$result['count']; 
			   			$config['page_url'] = site_url('admin/user/member').'?name='.$name.'&cate='.$cate.'&page=';
			   			$config['page_size'] = 13 ;//每页几篇
						$config['rows_num'] = $count;  //一共多少文章
						$config['page_num'] = $page; //当前页页码  
						$this->load->library('pagina');  
			   			$this->pagina->init($config);  
						$data['page_nav']=$this->pagina->create_links();
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
						$str2_1="<td align=\"center\" >"."<div style=\"font-size:14px;\">".$post[$i]['author']."</div></td>";
						$str3="<td align=\"center\"><a href=\"".site_url('admin/post/edit')."?id=".$post[$i]['id']."&from=check"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
						$str4="<td align=\"center\"><a href=\"".site_url('admin/post/del')."?id=".$post[$i]['id']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
						//得到前台代码
						@$str=$str.$str0.$str1.$str2.$str2_1.$str3.$str4;
						$i++; 
						};					
			   			if (isset($str)){
							$data['post']=$str;
							$data['user']=$user;
							//print_r($user);
							$this->load->view('admin/admin_user_member_profile',$data);
						}
					}
	   			}else {
	   				$data['error']="查无此人.";
	   				$this->load->view('admin/admin_user_member',$data);
	   			}
   			}else {
		   			if (isset($_GET['status'])){
							$status=$_GET['status'];
							if (isset($_GET['page'])){
								$page=$_GET['page'];
								$page=str_replace (".html",'',$page );
							}else {
								$page=1;
							}
				   			$user=$this->admin_user_model->get_user_by_status($status,15,15*($page-1));
				   			$sql="SELECT COUNT(*) AS count FROM user WHERE status=".$status;
				   			$config['page_url'] = site_url('admin/user/member').'?status='.$status.'&page=';  
				   			$this->load->library('pagina');  
						}else {
				   			$page = $this->uri->segment(4, 1);
				   			$status='1';
				   			$status2='2';
				   			$user=$this->admin_user_model->get_user_by_status($status,15,15*($page-1),$status2);
				   			$sql="SELECT COUNT(*) AS count FROM user WHERE status=1 OR status=2";
				   			$config['page_url'] = 'admin/user/member';  
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
					if ($user==null){
						$data['error']="没有查询到相关数据。";
						$this->load->view('admin/admin_user_member',$data);
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
						if (isset($_GET['status'])){
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
					 	//print_r($user);
						foreach ($user as $row)
						{
							$user[$i] = $row; 
							if ($user[$i]['status']==0){
								$user[$i]['statusname']="未确认";
							}elseif ($user[$i]['status']==1){
								$user[$i]['statusname']="会员";
							}elseif ($user[$i]['status']==2){
								$user[$i]['statusname']="管理员";
							}else {
								$user[$i]['statusname']="外星人";
							}
							if (isset($user[$i]['registerTime'])){
								if ($this->basic->Counti($user[$i]['registerTime'])>10){
									$user[$i]['registerTime']=$this->basic->utfSubstr($user[$i]['registerTime'],0,10);
								}
							}
							$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/user/edit')."?name=".$user[$i]['name']."&from=member"."\"style=\"color:#333;\">".$user[$i]['name']."</a></td>";
							$str1="<td >".$user[$i]['email']."</td>";
							$str2="<td align=\"center\">".$user[$i]['registerTime']."</td>";
							$str3="<td align=\"center\"><a href=\"".site_url('admin/user/member')."?status=".$user[$i]['status']."\"style=\"font-size:12px;color:#555;\">".$user[$i]['statusname']."</a></td>";
							$str4="<td align=\"center\"><a href=\"".site_url('admin/user/edit')."?name=".$user[$i]['name']."&from=member"."\"style=\"font-size:12px;color:#555;\">编辑</a></td>";
							$str5="<td align=\"center\"><a href=\"".site_url('admin/user/del')."?name=".$user[$i]['name']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
							//得到前台代码
							@$str=$str.$str0.$str1.$str2.$str3.$str4.$str5;
							$i++; 
						};					
					}
					//加载信息
					if (isset($str)){
						$data['post']=$str;
						$this->load->view('admin/admin_user_member',$data);
					}
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
	
	   	function check(){
   		if ($this->admin_user_model->is_admin_login()){
   			
   			$page = $this->uri->segment(4, 1);
   			$status='0';
   			//$status2='2';
   			$user=$this->admin_user_model->get_user_by_status($status,15,15*($page-1));
			if ($user==null){
				$data['error']="没有查询到相关数据。";
				$this->load->view('admin/admin_user_check',$data);
			}else{
				//分页
				$sql="SELECT COUNT(*) AS count FROM user WHERE status=0";
				$result=mysql_fetch_array(mysql_query($sql));
				$count=$result['count']; 
				//echo $count;
				$config['page_url'] = 'admin/user/check';  
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
			 	//print_r($user);
			 	
				foreach ($user as $row)
				{
					$user[$i] = $row; 
					if ($user[$i]['status']==0){
						$user[$i]['statusname']="未确认";
					}elseif ($user[$i]['status']==1){
						$user[$i]['statusname']="会员";
					}elseif ($user[$i]['status']==2){
						$user[$i]['statusname']="管理员";
					}else {
						$user[$i]['statusname']="外星人";
					}
					if (isset($user[$i]['registerTime'])){
						if ($this->basic->Counti($user[$i]['registerTime'])>10){
							$user[$i]['registerTime']=$this->basic->utfSubstr($user[$i]['registerTime'],0,10);
						}
					}
					$str0="<tr height=\"26\" bgcolor=\"#f8f8f8\"> <td ><a href=\"".site_url('admin/user/edit')."?name=".$user[$i]['name']."&from=check"."\"style=\"color:#333;\">".$user[$i]['name']."</a></td>";
					$str1="<td >".$user[$i]['email']."</td>";
					$str2="<td align=\"center\">".$user[$i]['registerTime']."</td>";
					$str3="<td align=\"center\"><a href=\"".site_url('admin/user/member')."?status=0\"style=\"font-size:12px;color:#555;\">".$user[$i]['statusname']."</a></td>";
					$str4="<td align=\"center\"><a href=\"".site_url('admin/user/userpass')."?name=".$user[$i]['name']."&from=check&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">认证</a></td>";
					$str5="<td align=\"center\"><a href=\"".site_url('admin/user/del')."?name=".$user[$i]['name']."&redirect=".current_url()."\"style=\"font-size:12px;color:#555;\">删除</a></td></tr>";
					//得到前台代码
					@$str=$str.$str0.$str1.$str2.$str3.$str4.$str5;
					$i++; 
				};	
						
			}
			//加载信息
			if (isset($str)){
				$data['post']=$str;
				$this->load->view('admin/admin_user_check',$data);
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
	
	function add(){
		
		if ($this->admin_user_model->is_admin_login()){
			//设置表单验证的规则
			$this->form_validation->set_rules('name','用户名','required');
			$this->form_validation->set_rules('email', '邮箱', 'required|valid_email',"邮箱格式错误。");
			$this->form_validation->set_rules('password', '密码', 'required');
			$this->form_validation->set_rules('status', '用户分类', 'required');
			if (!$this->form_validation->run()){
				@$this->load->view('admin/admin_user_add',$data);
			}else {
			//检查是否为重复提交
				if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
					
					if($this->admin_user_model->user_add_check()=='0'){
						@$status=$_POST['status'];
						if($this->admin_user_model->user_add($status)==TRUE) {
								$data['error']="添加成功！";
								$this->load->view('admin/admin_user_add',$data);
							}else {
								$data['error']="数据写入失败！";
								$this->load->view('admin/admin_user_add',$data);
							}
					}else {
			   			$data['error']=$this->admin_user_model->user_add_check();
						$this->load->view('admin/admin_user_add',$data);
					}
				}else {
					$data['error']="验证码错误，请重新填写。";
					$this->load->view('admin/admin_user_add',$data);
				}
				
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
			if (isset($_GET['name'])){
					$user_name=$_GET['name'];
				}
			if (isset($user_name)){
				$userdata=$this->admin_user_model->get_user_by_name($user_name);
			}
			if (!isset($userdata)){ 
				$data = array(
   				'error_title' =>"编辑错误",
   				'error' =>"没有权限或信息不存在。",
	   			);
	   			$this->load->view('admin/admin_error',$data);
	   			header("refresh:2;url=".site_url('admin/user/member'));
			}else {
				//设置表单验证的规则
				$this->form_validation->set_rules('name','用户名','required');
				$this->form_validation->set_rules('email', '邮箱', 'required|valid_email',"邮箱格式错误。");
				$this->form_validation->set_rules('status', '用户分类', 'required');
				if (!$this->form_validation->run()){
					@$this->load->view('admin/admin_user_edit',$userdata);
				}else {
					if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
						if (!empty($_POST['password'])){
							$userdata['password']=md5($_POST['password']);
						}
						if($this->admin_user_model->user_update($userdata)==TRUE) {
							$userdata['error']="编辑成功！";
							$this->load->view('admin/admin_user_edit',$userdata);
						}else {
							$userdata['error']="编辑失败！";
							$this->load->view('admin/admin_user_edit',$userdata);
						}
					}else {
						$userdata['error']="验证码错误，请重新填写。";
						$this->load->view('admin/admin_user_edit',$userdata);
					}
				}
				
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
				@$name=$_GET['name'];
				@$redirect=$_GET['redirect'];
			if (isset($name)){
				$userdata=$this->admin_user_model->get_user_by_name($name);
			}
			if ($userdata!=Null){
				$result=$this->db->delete('user', array('name' => $name)  );
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
	function userpass(){
		if ($this->admin_user_model->is_admin_login()){
				@$name=$_GET['name'];
				@$redirect=$_GET['redirect'];
			if (isset($name)){
				$userdata=$this->admin_user_model->get_user_by_name($name);
				
			}
			if ($userdata!=Null){
				$result=$this->db->update('user',array('status' =>'1') , array('name' => $name));
				
				if ($redirect!=null){
					header("refresh:1;url=".$redirect);
				}else {
					header("refresh:1;url=".site_url());
				}
				$data['error']="认证成功！正在返回……<br>";
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