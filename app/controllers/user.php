<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('basic');
		$this->load->model('post_model');
		$this->load->model('user_model');
		$this->load->library('authcode');
	}
	function Index(){
		if ($this->basic->is_login()){
			//如果已经登陆了，那么查询会员的发表记录
			$username=$this->session->userdata('name');
			 $lost=$this->post_model->get_by_user($username,0,5, 0);
			 $found=$this->post_model->get_by_user($username,1,5, 0);
			 //数组转换
			 $a=0;
			 $str_a="";
			 $str_b="";
			 while ($a<2){
			 	//根据lost和found 分情况讨论
			 	if ($a==0){
			 		$post=$lost;
			 		$url_1="lost/";
			 	}elseif ($a==1){
			 		$post=$found;
			 		$url_1="found/";
			 	}
			 	//从数组中转成前台代码
			 	if(isset($post)){
					$i=1; 
					foreach ($post as $row)
						{
							$post[$i] = $row; 
							if ($i%2==1){
								$str1= "<tr class=\"table_post_tr\">";
							}else {
								$str1= "<tr class=\"table_post_tr_1\">";
							}
							
							$post[$i]['type'] = $this->post_model->get_type($post[$i]['type']);
							if ($post[$i]['type']==false){
								$post[$i]['type']="其他物品";
							}
							if ($post[$i]['status']=='0'){
								$post[$i]['statusname']="等待审核";
							}elseif ($post[$i]['status']=='1'){
								$post[$i]['statusname']="已审核";
							}elseif ($post[$i]['status']=='2'){
								$post[$i]['statusname']="已失效";
							}else {
								$post[$i]['statusname']="未知";
							}
							//截取指定长度字符串
							if (isset($post[$i]['title'])){
								if ($this->basic->Counti($post[$i]['title'])>10){
									$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,18);
								}
							}
							if (isset($post[$i]['place'])){
								if ($this->basic->Counti($post[$i]['place'])>10){
									$post[$i]['place']=$this->basic->utfSubstr($post[$i]['place'],0,10);
								}
							}
							if (isset($post[$i]['time'])){
								if ($this->basic->Counti($post[$i]['time'])>10){
									$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
								}
							}
							if ($post[$i]['status']=='2'){
								$close_url="&mod=reset \">激活</a>";
							}else {
								$close_url="\">关闭</a>";
							}
							$str2= "<td align=\"center\" >".$post[$i]['type']."</td>";
							$str3= "<td class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['title']."</a>"."</td>";
							$str4= "<td align=\"center\">".$post[$i]['place']."</td>";
							$str5= "<td align=\"center\">".$post[$i]['time']."</td>";
							$str6= "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">详情</a>"."</td>";
							$str7= "<td align=\"center\">".$post[$i]['statusname']."</td>";
							if ($this->session->userdata['anonymous']||$this->user_model->get_user_status()=='0'){
								$str8="<td  class=\"td_a\">&nbsp;</td>";
								$str9=  "<td  class=\"td_a\">&nbsp;</td>";
								$str10=  "<td  class=\"td_a\">&nbsp;</td>";
							}else {
								$str8="<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."drop")."?id=".$post[$i]['id']."&redirect=".current_url().$close_url."</td>";
								$str9=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."edit")."?id=".$post[$i]['id']."\">编辑</a>"."</td>";
								$str10=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."del")."?id=".$post[$i]['id']."&redirect=".current_url()."\">删除</a>"."</td>";
								
							}
							$str11="</tr>";
							//得到前台代码
							if ($a==1){
								$str_a=$str_a.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
								$found_list=$str_a;
							}elseif ($a==0){
								$str_b=$str_b.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
								$lost_list=$str_b;
							}
							$i++; 
						};					
					}
					$a++;
			 } 
			 //传入视图
			 if (isset($found_list))
			 $data['found_list']=$found_list;
			 if (isset($lost_list))
			 $data['lost_list']=$lost_list;

			if (isset($data)){
				//载入登陆用户的视图。
			$this->load->view('user/user_index',$data);
			}else {
				$this->load->view('user/user_index');
			}
			
		}
		else {
			//如果用户没有登陆
			$data['error'] ="请先 ".anchor('user/login','登陆')." 后访问。";
			$this->load->view('error',$data);
		}
		
	}
	function signup(){
		//设置表单验证的规则
		$this->form_validation->set_rules('name','用户名','required');
		$this->form_validation->set_rules('password', '密码', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', '确认密码', 'required');
		$this->form_validation->set_rules('email', '邮箱','required|valid_email',"邮箱格式错误。");
		//登陆验证，如果已经登陆，则跳转到用户中心页面。
			if ($this->basic->is_login()){
				header("refresh:2;url=".site_url('user'));
				$data['error']="用户已登陆，正在跳转到用户中心,请稍等……<br>";
				$this->load->view('error',$data);
				
			}else{
			//post数据不为空时进行注册的数据处理
			if ($this->input->post('name')!=""){
				//表单数据验证
				 if (!$this->form_validation->run()){
				 	$data['error']= "注册失败！";
					$this->load->view('user/user_signup',$data);
				 }
				 elseif ($this->input->post('captcha')==$this->session->userdata('auth_code')){
				 	if ($this->user_model->user_reg_check()=='0'){
					 	//判断数据写入数据库，并跳转
						if($this->user_model->user_reg()!=TRUE) {
							$data['error']="数据写入失败！";
							$this->load->view('user/user_signup',$data);
						} else {
							//使用CI自己的session
							$session= array(
								'name'=>strtolower($this->input->post('name')),
						 		'password'=>md5($this->input->post('password')),
						 		'email'=>strtolower($this->input->post('email')),
						 		'registerTime'=>date("Y-m-d G:i:s"),
						 		'ip'=>$_SERVER['REMOTE_ADDR'],
						 		'status'=>0,
								'is_login'=> TRUE,
								'anonymous'=> FALSE,
							);
							$this->session->set_userdata($session);
							$data['error']=$this->make_key_and_mail();
							if (isset($data)){
								$this->load->view('error',$data);
							}
							//注册成功，跳转到登陆界面
							/*
							header("refresh:2;url=".site_url('user/login'));
							$data['error']="注册成功，正在跳转到登陆页……<br>";
							$this->load->view('user/user_signup',$data);
							*/
						}
					 }else {
					 	$data['error']=$this->user_model->user_reg_check();
					 	$this->load->view('user/user_signup',$data);
					 }
				 }
					else {
						$data['captcha_error']="<p>验证码错误！</p>";
						$this->load->view('user/user_signup',$data);
					}
			}
			//加载注册视图
			if (!isset($data)){
				$this->load->view('user/user_signup');
			}
		}
	}
	function login(){
		if ($this->basic->is_login()){
			header("refresh:1;url=".site_url('user'));
			$data['error']="用户已登陆，正在跳转到用户中心,请稍等……<br>";
			$this->load->view('error',$data);
		}else{
			//设置表单验证的规则
			$this->form_validation->set_rules('name','用户名','required');
			$this->form_validation->set_rules('password', '密码', 'required');
			//表单数据验证
			 if (!$this->form_validation->run()){
			 }elseif ($this->input->post('captcha')==$this->session->userdata('auth_code')){
				 //数据库查询验证
				if($this->user_model->user_login_check()=='1') {
					//保存用户信息设置ci的session
					$l_name=strtolower($this->input->post('name'));
					$userdata=$this->user_model->get_user_by_name($l_name);
					$userdata['is_login']= TRUE;
					$userdata['anonymous']=FALSE;
					$userdata['name']=$this->input->post('name');
					//设置session
					$this->session->set_userdata($userdata);
					//刷新后确认登陆
					redirect(site_url('user/login'));
					} else{
						$data['error'] =  '用户名或密码错误.';
					}
				}else {
					$data['error']="验证码错误！";
				}
			//加载login视图
			if (isset($data)){
				$this->load->view('user/user_login',$data);
			}else {
				$this->load->view('user/user_login');
			}
			
		}
	}
	
	//退出登陆，消除session
	function  logout(){
		$this->session->sess_destroy();
		redirect('user');
	}

	//登陆后发表信息
	//post用户登录后的发表丢失的信息。
	function lists(){
		if (!$this->basic->is_login()){
			$data['error'] ="请先 ".anchor('user/login','登陆')." 后访问。";
			$this->load->view('error',$data);
		}else {
			//获取uri中得page
			if ($this->uri->segment(2, 0)=="lost"){
				$cate_url="lost";
				$cate = "0";
				
			}else {
				$cate_url="found";
				$cate = "1";
				
			}
			$username = strtolower($this->session->userdata('name'));
			//判断是哪一种读取方式
			if (isset($_GET['status'])){
				$status=$_GET['status'];
				if (isset($_GET['page'])){
					$page=$_GET['page'];
				}else {
					$page=1;
				}
		   		$post=$this->post_model->get_by_order_status($username,$cate,$status,10,10*($page-1));
		   		$sql="SELECT COUNT(*) AS count FROM post WHERE author='".$username."' AND category=".$cate." AND status=".$status;
		   		$config['page_url'] = site_url('user/'.$cate_url.'/0').'?status='.$status.'&page=';  
		   		$this->load->library('pagina');  
			}else {
		   		$page = $this->uri->segment(3, 1);
		   		$post=$this->post_model->get_by_user($username,$cate,10, ($page-1)*10);
		   		$sql="SELECT COUNT(*) AS count FROM post WHERE category=".$cate." AND author='".$username."'";
		   		$config['page_url'] = 'user/'.$cate_url;  
		   		$this->load->library('custom_pagination');
		   		
			}
			
			 //数组转换
			 $str_a="";
			 $str_b="";
		 	//根据lost和found 分情况讨论
		 	$url_1=$cate_url."/";
			//$sql="SELECT COUNT(*) AS count FROM post WHERE category=".$cate." AND author='".$username."'";
			$result=@mysql_fetch_array(mysql_query($sql));
			
			$count=$result['count'];
			$config['page_size'] = 10 ;//每页几篇
			$config['rows_num'] = $count;  //一共多少文章
			$config['page_num'] = $page; //当前页页码
			
			if (isset($_GET['status'])){
				$this->pagina->init($config);  
				if ($cate==0){
					$data['lost_nav']=$this->pagina->create_links();
				} else {
					$data['found_nav']=$this->pagina->create_links();
				}
			}else {
				$this->load->library('custom_pagination');  
				$this->custom_pagination->init($config); 
				if ($cate==0){
					$data['lost_nav']=$this->custom_pagination->create_links();
				} else {
					$data['found_nav']=$this->custom_pagination->create_links();
				}
			}
			
			
		 	//从数组中转成前台代码
		 	if(isset($post)){
				$i=1; 
				foreach ($post as $row)
					{
						$post[$i] = $row; 
						if ($i%2==1){
							$str1= "<tr class=\"table_post_tr\">";
						}else {
							$str1= "<tr class=\"table_post_tr_1\">";
						}
						
						$post[$i]['type'] = $this->post_model->get_type($post[$i]['type']);
						if ($post[$i]['type']==false){
							$post[$i]['type']="其他物品";
						}
						
						if ($post[$i]['status']=='0'){
							$post[$i]['statusname']="等待审核";
						}elseif ($post[$i]['status']=='1'){
							$post[$i]['statusname']="已审核";
						}elseif ($post[$i]['status']=='2'){
							$post[$i]['statusname']="已失效";
						}else {
							$post[$i]['statusname']="未知";
						}
						//截取指定长度字符串
						if (isset($post[$i]['title'])){
							if ($this->basic->Counti($post[$i]['title'])>10){
								$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,18);
							}
						}
						if (isset($post[$i]['place'])){
							if ($this->basic->Counti($post[$i]['place'])>10){
								$post[$i]['place']=$this->basic->utfSubstr($post[$i]['place'],0,10);
							}
						}
						if (isset($post[$i]['time'])){
							if ($this->basic->Counti($post[$i]['time'])>10){
								$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
							}
						}
						if ($post[$i]['status']=='2'){
							$close_url="&mod=reset \">激活</a>";
						}else {
							$close_url="\">关闭</a>";
						}
						$str2= "<td align=\"center\" >".$post[$i]['type']."</td>";
						$str3= "<td class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['title']."</a>"."</td>";
						$str4= "<td align=\"center\">".$post[$i]['place']."</td>";
						$str5= "<td align=\"center\">".$post[$i]['time']."</td>";
						$str6= "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">详情</a>"."</td>";
						$str7= "<td align=\"center\">".$post[$i]['statusname']."</td>";
						if ($this->session->userdata['anonymous']||$this->user_model->get_user_status()=='0'){
							$str8="<td  class=\"td_a\">&nbsp;</td>";
							$str9=  "<td  class=\"td_a\">&nbsp;</td>";
							$str10=  "<td  class=\"td_a\">&nbsp;</td>";
						}else {
							$str8="<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."drop")."?id=".$post[$i]['id']."&redirect=".current_url().$close_url."</td>";
							$str9=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."edit")."?id=".$post[$i]['id']."\">编辑</a>"."</td>";
							$str10=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."del")."?id=".$post[$i]['id']."&redirect=".current_url()."\">删除</a>"."</td>";
							
						}
						$str11="</tr>";
						//得到前台代码
						if ($cate==1){
							$str_a=$str_a.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
							$found_list=$str_a;
						}elseif ($cate==0){
							$str_b=$str_b.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
							$lost_list=$str_b;
						}
						$i++; 
					};					
			 	}			 
			 //传入视图
			 if (isset($found_list))
			 $data['found_list']=$found_list;
			 if (isset($lost_list))
			 $data['lost_list']=$lost_list;
				 
			if (!isset($post)){
				$data['error']="没有查询到相关记录。";
				$this->load->view('user/'.$cate_url.'/user_'.$cate_url."_list",$data);
			}else{
				if ($cate==0){
					$this->load->view('user/lost/user_lost_list',$data);
				}else {
					$this->load->view('user/found/user_found_list',$data);
				}
				
			}
		}
	}
	//发布遗失信息
	function lost(){
			//lost的cate id;
			$_GET['cate'] = "0";
			$data['title']= "发布遗失信息-失物招领平台";
			if (isset($_REQUEST['description'])){
				$description=$_REQUEST['description'];
			}else {
				$description="没有留下详细信息。";
			}
			
			//权限验证
			if (!$this->session->userdata('is_login')){
				$data['error']= "请先".anchor('user/login','登陆')."后发布信息或"."<a href=\"".site_url('user/anonymous')."?redirect=".site_url('user/lost')."\">"."匿名发布"."</a><font color=red size=-1>(无法再次编辑或删除)</font>";
				$this->load->view('error',$data);
			}
			else {
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
				$this->form_validation->set_rules('checkbox', 'checkbox','TRUE');
				//post数据不为空时进行数据处理
				if ($this->input->post('title')!=""){
					//表单数据验证
					if ($this->form_validation->run()){
						//是否同意了协议
						if ($this->input->post('checkbox')==1){
							//检查是否为重复提交
							if($this->post_model->postcheck()){
								$data['error']= "请不要重复发布信息。";
							}else {
								if($this->post_model->postsave($description)){
										$data['error']= "信息发布成功！";
									}else {
										$data['error']= "信息发布失败，请重试。";
									}
							}
						}else {
							$data['error']="请仔细阅读《网站协议》";
						}
					}
				}
				$this->load->view('user/lost/user_lost',$data);
			}
	}
	//发布招领信息
	function found(){
			//found的cate id;
			$_GET['cate'] = "1";
			$data['title']= "发布招领信息-失物招领平台";
			if (isset($_REQUEST['description'])){
				$description=$_REQUEST['description'];
			}else {
				$description="没有留下详细信息。";
			}
			
			//权限验证
			if (!$this->session->userdata('is_login')){
				$data['error']= "请先".anchor('user/login','登陆')."后发布信息或"."<a href=\"".site_url('user/anonymous')."?redirect=".site_url('user/found')."\">"."匿名发布"."</a>"."</a><font color=red size=-1>(无法再次编辑或删除)</font>";
				$this->load->view('error',$data);
				
			}
			else {
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
				$this->form_validation->set_rules('checkbox', 'checkbox','TRUE');
				//post数据不为空时进行数据处理
				if ($this->input->post('title')!=""){
					//表单数据验证
					if ($this->form_validation->run()){
						//是否同意了协议
						if ($this->input->post('checkbox')==1){
							//检查是否为重复提交
							if($this->post_model->postcheck()){
								$data['error']= "请不要重复发布信息。";
							}else {
								if($this->post_model->postsave($description)){
										$data['error']= "信息发布成功！";
									}else {
										$data['error']= "信息发布失败，请重试。";
									}
								}
							}else {
								$data['error']="请仔细阅读《网站协议》";
							}
						}
					}
					$this->load->view('user/found/user_found',$data);
				}
		}
	//匿名登陆 
	function anonymous(){
		$session['name']= "anonymous";
		$session['email']= "anonymous@name.com";
		$session['is_login']= TRUE;
		$session['anonymous']= TRUE;
		//匿名登录  写入session
		$this->session->set_userdata($session);	
		if (isset($_GET['redirect']	)){
			$redirect=$_GET['redirect']	;
		}else {
			$redirect=site_url();
		}
		redirect($redirect);
	}
	//修改密码
	function resetpassword(){
		if ($this->basic->is_login()){
			$username=$this->session->userdata('name');
			if ($username!=""&&$username!="anonymous"){
				//设置表单验证的规则
				$this->form_validation->set_rules('old_password','原密码','required');
				$this->form_validation->set_rules('new_password', '密码', 'required|matches[new_passconf]');
				$this->form_validation->set_rules('new_passconf', '确认密码', 'required');
				if ($this->form_validation->run()){
					if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
						if ($this->input->post('old_password')!=''){
							if ($this->user_model->user_psw_check($username,$this->input->post('old_password'))){
								$new_password = $this->input->post('new_password');
								$result = $this->user_model->user_psw_update($username,$new_password);
								if (!$result){
									$data['error']= "修改密码失败,请重试.";
									$this->load->view('user/user_resetpassword',$data);
								}else {
									$data['error']= "密码修改成功.";
									$this->load->view('user/user_resetpassword',$data);
								}
							}else {
								$data['error']= "原密码错误!";
								$this->load->view('user/user_resetpassword',$data);
							}
						}else {
							$data['error']= "原密码为空!";
							$this->load->view('user/user_resetpassword',$data);
						}
					}else {
						$data['error']= "验证码错误.";
						$this->load->view('user/user_resetpassword',$data);
					}
				}else {
					$this->load->view('user/user_resetpassword');
				}
			}
		}else {
			redirect(site_url('user'));
		}
	}
	function forgotpsw(){
		if (!isset($_GET['key'])){
			$this->form_validation->set_rules('captcha','验证码','required');
			$this->form_validation->set_rules('email', '邮箱','required|valid_email',"邮箱格式错误。");
			if ($this->form_validation->run()){
				$old_forgot_key_time=$this->user_model->get_forgot_key_time($_POST['email']);
				if (!(time()-$old_forgot_key_time>60)){
					$data['error']="验证邮件已发送,请一分钟后重新获取!";
					$this->load->view('user/forgotpsw',$data);
				}else {
					//验证码是否正确
					if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
						//echo "ss";
						$user_email=$_POST['email'];
						$range = array_merge(range(1, 9) , range('A', 'Z'));//数字字母
						for ($i=1;$i<32;$i++){
							$key_index=rand(0, count($range) - 1);
							@$key.=$range[$key_index];
						}
						$forgot_key=md5($key);
						//存key //重新初始化时间
						$update_result = $this->user_model->forgot_key_save($forgot_key,$user_email);
						if ($update_result){
							//发信
							$this->load->library('email');
							$this->config->load('email');
								$from = $this->config->item('mail_from'); //
								$to =$user_email;
								//查询用户名
								$sql="SELECT `name` FROM  `user` WHERE  `email` =  '".$user_email."' LIMIT 0 , 30";
								$result=$this->db->query($sql);
								foreach($result->result_array() as $user);
								//载入邮件配置
								header("Content-type: text/html; charset=utf-8");
								$subject = $this->config->item('subject');
								$body = $user['name']."&nbsp;你好,欢迎回到失物招领平台,点击以下链接修改帐号密码:<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']."?key=".$forgot_key."&email=".$user_email."\">http://".$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']."?key=".$forgot_key."&email=".$user_email."</a>";
							 $config['protocol'] = $this->config->item('protocol');//sendmail or smtp
							 $config['charset'] = 'utf-8';
							 $config['smtp_host'] = $this->config->item('smtp_host');//	无默认值	无	SMTP 服务器地址。
							 $config['smtp_user']= $this->config->item('smtp_user');	//无默认值	无	SMTP 用户账号。
							 $config['smtp_pass']= $this->config->item('smtp_pass');	//无默认值	无	SMTP 密码。
							 $config['smtp_port']= $this->config->item('smtp_port');	//无	SMTP 端口。
							 $config['smtp_timeout'] = '5';
							 $config['newline'] = "\r\n";
							 $config['crlf'] = "\r\n";
							 $this->email->initialize($config);
							 	$mailtype = $this->config->item('mailtype');
							 $this->email->set_mailtype($mailtype);
							 	$mailer_name =$this->config->item('mailer_name');
							 $this->email->from($from, $mailer_name);
							 $this->email->to($to);
							 $this->email->subject($subject);
							 $this->email->message($body);
							 if ($this->email->send()){
							 	$this->session->set_userdata('forgot_key_time',time());
							 }
							$data['error']="<font color='red'>邮件已发出,请查看邮箱并找回密码!</font>";
							if (isset($data)){
								$this->load->view('user/forgotpsw',$data);
							}
						}else {
							$data['error']="没有查询到此用户相关信息!";
							$this->load->view('user/forgotpsw',$data);
						}
						
					}else {
						//验证码错误的异常处理
						$data['error']="验证码错误!";
						$this->load->view('user/forgotpsw',$data);
					}
				}
			}else {
				//对没有验证码的情况进行处理 /或者是第一次打开页面
				$this->load->view('user/forgotpsw');
			}
		}else {
			$forgot_key = $_GET['key'];
			$user_email=$_GET['email'];
			$old_forgot_key = $this->user_model->get_forgot_key($user_email);
			if ($forgot_key==$old_forgot_key&&$forgot_key!='0'){
				
				$this->session->set_userdata('real_forgot', '1');
				$data['error']="用户身份验证成功!正在跳转至密码修改……<br>";
				//销毁时间有效参数
				//$this->session->unset_userdata('forgot_key_time');
				$this->load->view('error',$data);
				header("refresh:1;url=".site_url('user/chpsw')."?email=".$user_email."&key=".$forgot_key);
			}else {
				$data['error']="验证邮件错误,请重新获取!";
				$this->load->view('user/forgotpsw',$data);
			}
		}
	}
	function chpsw(){
			@$user_email=$_GET['email'];
			@$forgot_key=$_GET['key'];
			$old_forgot_key = $this->user_model->get_forgot_key($user_email);
			if ($forgot_key==$old_forgot_key&&$forgot_key!='0'&&$user_email!=''&&$forgot_key!=''){
				if (@$this->session->userdata['real_forgot']=='1'){
					//设置表单验证的规则
					$this->form_validation->set_rules('new_password', '密码', 'required|matches[new_passconf]');
					$this->form_validation->set_rules('new_passconf', '确认密码', 'required');
					if ($this->form_validation->run()){
						if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
							if ($this->input->post('new_password')!=''){
									$new_password = $this->input->post('new_password');
									//echo $new_password."___".$user_email."__".$forgot_key;
									$result=$this->user_model->update_email_psw($new_password,$user_email,$forgot_key);
									
									if (!$result){
										$data['error']= "修改密码失败,请重试.";
										$this->load->view('user/chpsw',$data);
									}else {
										//destroy key 
										$this->user_model->destroy_chpsw_key($user_email,$forgot_key);
										//unset session
										$this->session->unset_userdata('real_forgot');
										$data['error']= "密码修改成功.";
										$this->load->view('user/chpsw',$data);
									}
							}else {
								$data['error']= "密码不能为空!";
								$this->load->view('user/chpsw',$data);
							}
						}else {
							$data['error']= "验证码错误.";
							$this->load->view('user/chpsw',$data);
						}
					}else {
						$this->load->view('user/chpsw');
					}
				}else {
					$data['error']="没有权限!正在跳转至身份验证……<br>";
					$this->load->view('error',$data);
					header("refresh:1;url=".site_url('user/forgotpsw'));
				}
			}else {
				$data['error']="验证邮件错误,请重新获取!";
				$this->load->view('user/forgotpsw',$data);
			}
	}
	private function make_key_and_mail(){
		//时间间隔
		$old_key_time=$this->user_model->get_key_time();
		//时间间隔判断1*60秒
		if (time()-$old_key_time>60){
			//造key
			$range = array_merge(range(1, 9) , range('A', 'Z'));//数字字母
			for ($i=1;$i<32;$i++){
				$key_index=rand(0, count($range) - 1);
				@$key.=$range[$key_index];
			}
			$confirm_key=md5($key);
			//存key //重新初始化时间
			$update_result = $this->user_model->key_save($confirm_key);
			//激活马是否转存成功
			//echo $update_result;
			if ($update_result){
				//发信
					$this->load->library('email');
					$this->config->load('email');
						$from = $this->config->item('mail_from'); //
						$to =$this->session->userdata('email');
						header("Content-type: text/html; charset=utf-8");
						$subject = $this->config->item('subject');
						$body = "你好,欢迎注册失物招领平台,点击以下链接激活帐号:<a href=\"".site_url('user/confirm')."?key=".$confirm_key."\">".site_url('user/confirm')."?key=".$confirm_key."</a>";
					 $config['protocol'] = $this->config->item('protocol');//sendmail or smtp
					 $config['charset'] = 'utf-8';
					 $config['smtp_host'] = $this->config->item('smtp_host');//	无默认值	无	SMTP 服务器地址。
					 $config['smtp_user']= $this->config->item('smtp_user');	//无默认值	无	SMTP 用户账号。
					 $config['smtp_pass']= $this->config->item('smtp_pass');	//无默认值	无	SMTP 密码。
					 $config['smtp_port']= $this->config->item('smtp_port');	//无	SMTP 端口。
					 $config['smtp_timeout'] = '5';
					 $config['newline'] = "\r\n";
					 $config['crlf'] = "\r\n";
					 $this->email->initialize($config);
					 	$mailtype = $this->config->item('mailtype');
					 $this->email->set_mailtype($mailtype);
					 	$mailer_name =$this->config->item('mailer_name');
					 $this->email->from($from, $mailer_name);
					 $this->email->to($to);
					 $this->email->subject($subject);
					 $this->email->message($body);
					 $this->email->send();
				return $data['error']="<font color='red'>验证信息已发送成功,请稍候查收邮件激活用户,未激活用户发布信息后无法再次编辑或删除!</font>";
				//$this->load->view('user/user_confirm',$data);
			}else {
				//激活码转存失败
				return $data['error']="数据库操作失败!";
				//$this->load->view('user/user_confirm',$data);
			}
		}else {
			//间隔不足五分钟的错误提示处理
			return  $data['error']="验证邮件已发送,请一分钟后重新获取!";
			//$this->load->view('user/user_confirm',$data);
		}
	}
	//更改邮箱或激活邮箱
	function confirm(){
		//是否为登陆用户
		if ($this->basic->is_login()){
			$user_status = $this->user_model->get_user_status();
			if ($user_status){
				$data['error']="用户无需重新激活!正在跳转到用户中心……<br>";
				$this->load->view('error',$data);
				header("refresh:1;url=".site_url('user'));
			}else {		
				//连接地治里是否有激活马
				if (!isset($_GET['key'])){
					//有模有验证码
					if (isset($_POST['captcha'])){
						//验证码是否正确
						if ($this->input->post('captcha')==$this->session->userdata('auth_code')){
							//echo "ss";
							$data['error']=$this->make_key_and_mail();
							if (isset($data)){
								$this->load->view('user/user_confirm',$data);
							}else {
								$this->load->view('user/user_confirm');
							}
						}else {
							//验证码错误的异常处理
							$data['error']="验证码错误!";
							$this->load->view('user/user_confirm',$data);
						}
					}else {
						//对没有验证码的情况进行处理 /或者是第一次打开页面
						$this->load->view('user/user_confirm');
					}
				}else {
					//对激活码进行激活
					$confirm_key = $_GET['key'];
					$old_confirm_key = $this->user_model->get_key();
					if ($confirm_key==$old_confirm_key){
						$ch_result = $this->user_model->ch_user_status();
						if ($ch_result){
							$data['error']="帐户激活成功!正在跳转到用户中心……<br>";
							$this->load->view('error',$data);
							header("refresh:1;url=".site_url('user'));
							
						}
					}else {
						$data['error']="激活码已失效,请重新获取!";
						$this->load->view('user/user_confirm',$data);
					}
				}
			}
		}else {
			$data['error']="请先 ".anchor('user/login','登陆')." 后访问。";
			$this->load->view('user/user_confirm',$data);
		}
		
	}
	function profile(){
		if ($this->basic->is_login()){
			if (isset($_GET['name'])){
				if ($_GET['name']!=null){
					if ($this->user_model->get_user_by_name($_GET['name'])!=false){
						
						 $username=$_GET['name'];
						 $lost=$this->post_model->get_by_user($username,0,10, 0);
						 $found=$this->post_model->get_by_user($username,1,10, 0);
						 //数组转换
						 $a=0;
						 $str_a="";
						 $str_b="";
						 while ($a<2){
						 	//根据lost和found 分情况讨论
						 	if ($a==0){
						 		$post=$lost;
						 		$url_1="lost/";
						 	}elseif ($a==1){
						 		$post=$found;
						 		$url_1="found/";
						 	}
						 	//从数组中转成前台代码
						 	if(isset($post)){
								$i=1; 
								foreach ($post as $row)
									{
										$post[$i] = $row; 
										if ($i%2==1){
											$str1= "<tr class=\"table_post_tr\">";
										}else {
											$str1= "<tr class=\"table_post_tr_1\">";
										}
										
										$post[$i]['type'] = $this->post_model->get_type($post[$i]['type']);
										if ($post[$i]['type']==false){
											$post[$i]['type']="其他物品";
										}
										if ($post[$i]['status']=='0'){
											$post[$i]['statusname']="等待审核";
										}elseif ($post[$i]['status']=='1'){
											$post[$i]['statusname']="已审核";
										}elseif ($post[$i]['status']=='2'){
											$post[$i]['statusname']="已失效";
										}else {
											$post[$i]['statusname']="未知";
										}
										//截取指定长度字符串
										if (isset($post[$i]['title'])){
											if ($this->basic->Counti($post[$i]['title'])>10){
												$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,18);
											}
										}
										if (isset($post[$i]['place'])){
											if ($this->basic->Counti($post[$i]['place'])>10){
												$post[$i]['place']=$this->basic->utfSubstr($post[$i]['place'],0,10);
											}
										}
										if (isset($post[$i]['time'])){
											if ($this->basic->Counti($post[$i]['time'])>10){
												$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
											}
										}
										if ($post[$i]['status']=='2'){
											$close_url="&mod=reset \">激活</a>";
										}else {
											$close_url="\">关闭</a>";
										}
										$str2= "<td align=\"center\" >".$post[$i]['type']."</td>";
										$str3= "<td class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['title']."</a>"."</td>";
										$str4= "<td align=\"center\">".$post[$i]['place']."</td>";
										$str5= "<td align=\"center\">".$post[$i]['time']."</td>";
										$str6= "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">详情</a>"."</td>";
										$str7= "<td align=\"center\">".$post[$i]['statusname']."</td>";
										if ($this->session->userdata['anonymous']||$this->user_model->get_user_status()=='0'||strtolower($this->session->userdata['name'])!=$username){
											$str8="<td  class=\"td_a\">&nbsp;</td>";
											$str9=  "<td  class=\"td_a\">&nbsp;</td>";
											$str10=  "<td  class=\"td_a\">&nbsp;</td>";
										}else {
											$str8="<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."drop")."?id=".$post[$i]['id']."&redirect=".current_url().$close_url."</td>";
											$str9=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."edit")."?id=".$post[$i]['id']."\">编辑</a>"."</td>";
											$str10=  "<td  class=\"td_a\" align=\"center\">"."<a href=\"".site_url($url_1."del")."?id=".$post[$i]['id']."&redirect=".current_url()."\">删除</a>"."</td>";
											
										}
										$str11="</tr>";
										//得到前台代码
										if ($a==1){
											$str_a=$str_a.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
											$found_list=$str_a;
										}elseif ($a==0){
											$str_b=$str_b.$str1.$str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11;
											$lost_list=$str_b;
										}
										$i++; 
									};					
								}
								$a++;
						 } 
						 //传入视图
						 if (isset($found_list))
						 $data['found_list']=$found_list;
						 if (isset($lost_list))
						 $data['lost_list']=$lost_list;
			
						if (isset($data)){
							//载入登陆用户的视图。
						$this->load->view('user/user_profile',$data);
						}else {
							$this->load->view('user/user_profile');
						}
					}else {
						$data['error']="查无此人,正在跳转至用户中心.";
						$this->load->view('error',$data);
						header("refresh:2;url=".site_url('user'));
					}
				}else {
					$data['error']="查无此人,正在跳转至用户中心.";
					$this->load->view('error',$data);
					header("refresh:2;url=".site_url('user'));
				}
			}else {
				header("refresh:0;url=".site_url('user'));
			}
		}else {
			$data['error']="请先 ".anchor('user/login','登陆')." 后访问。";
			$this->load->view('error',$data);
		}
	}
	
}

