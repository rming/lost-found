<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lost extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('basic');
		$this->load->model('post_model');
		$this->load->model('user_model');
		$this->load->library('authcode');
	}
	//文章列表功能
   	function index(){
   		if (isset($_GET['tid'])){
			$tid=$_GET['tid'];
			if (isset($_GET['page'])){
				$page=$_GET['page'];
			}else {
				$page=1;
			}
			$cate="0";
   			$status='1';
   			$post=$this->post_model->get_by_order_tid($cate,$status,$tid,10,10*($page-1));
   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1 AND type=".$tid;
   			$config['page_url'] = site_url('lost').'?tid='.$tid.'&page=';  
   			$this->load->library('pagina');  
		}else {
   			$page = $this->uri->segment(3, 1);
   			$cate="0";
   			$post=$this->post_model->get_by_order($cate,10,10*($page-1));
   			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1";
   			$config['page_url'] = 'lost/page';  
   			$this->load->library('custom_pagination');
   			
		}
	   //根据page参数设置获得页码
	   //$page = $this->uri->segment(3, 1);
		//根据cate参数获取那个目录
		 //$cate="0";
		 //查询验证
		 //$post=$this->post_model->get_by_order($cate,10,10*($page-1));
			 
		if (!isset($post)){
			$data['error']="没有查询到相关数据。";
			$this->load->view('lost/lost_list',$data);
		}else{
			//分页
			//$sql="SELECT COUNT(*) AS count FROM post WHERE category=0";
			$result=@mysql_fetch_array(mysql_query($sql));
			$count=$result['count']; 
			//$config['page_url'] = 'lost/page';  
			$config['page_size'] = 10 ;//每页几篇
			$config['rows_num'] = $count;  //一共多少文章
			$config['page_num'] = $page; //当前页页码
			//$this->load->library('custom_pagination');  
			//$this->custom_pagination->init($config);  
			//$data['page_nav']=$this->custom_pagination->create_links();
		 	//从数组中转成前台代码
	 		if (isset($_GET['tid'])){
				$this->pagina->init($config);  
				$data['page_nav']=$this->pagina->create_links();
			}else {
				$this->custom_pagination->init($config);  
				$data['page_nav']=$this->custom_pagination->create_links();
			}
				
		 	$str="";
		 	$i=1;
		 	$url_1="lost/";
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
				//截取指定长度字符串
				if (isset($post[$i]['title'])){
					if ($this->basic->Counti($post[$i]['title'])>12){
						$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,27);
					}
				}
				if (isset($post[$i]['place'])){
					if ($this->basic->Counti($post[$i]['place'])>9){
						$post[$i]['place']=$this->basic->utfSubstr($post[$i]['place'],0,10);
					}
				}
				if (isset($post[$i]['time'])){
					if ($this->basic->Counti($post[$i]['time'])>10){
						$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
					}
				}
				//格式化文本
				$post[$i]['description']=strip_tags($post[$i]['description']);

				if (isset($post[$i]['description'])){
					if ($this->basic->Counti($post[$i]['description'])>20){
						$post[$i]['description']=$this->basic->utfSubstr($post[$i]['description'],0,39);
					}
				}
				$str2= "<td align=\"center\" >".$post[$i]['type']."</td>";
				$str3= "<td class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['title']."</a>"."</td>";
				$str4= "<td align=\"center\">".$post[$i]['place']."</td>";
				$str5= "<td align=\"center\">".$post[$i]['time']."</td>";
				$str6= "<td  class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['description']."</a>"."</td>";
				$str7= "</tr>";
				//得到前台代码
				$str=$str.$str1.$str2.$str3.$str4.$str5.$str6.$str7;
				$i++; 
			};					
		}
		//加载文章
		if (isset($str)){
			$data['post']=$str;
			$this->load->view('lost/lost_list',$data);
		}
		
	}
	//post用户登录后的发表丢失的信息。
	function content(){
		//获取uri中得id
		$id = $this->uri->segment(2, 0);
		$cate="0";
		$post=$this->post_model->get_by_cate_id($id,$cate);
		if (!isset($post)){
			$data['error']="没有查询到相关记录。";
			$this->load->view('error',$data);
		}else{
			if (isset($_POST['captcha'])){
				if ($_POST['captcha'] ==$this->session->userdata('auth_code')){
					if (isset($post['link_phone'])) 
					$contact_phone="<li><span class=\"detail_t\">手机号：</span><span class=\"detail_c\" style=\"color:red;\"><p>".$post['link_phone']."</p></span></li>";
					if (isset($post['link_email']))
					$contact_email="<li><span class=\"detail_t\">邮箱：</span><span class=\"detail_c\" style=\"color:red;\"><p>".$post['link_email']."</p></span></li>";
					if (isset($post['link_qq']))
					$contact_qq="<li><span class=\"detail_t\">QQ：</span><span class=\"detail_c\" style=\"color:red;\"><p>".$post['link_qq']."</p></span></li>";
					$contact=$contact_phone.$contact_email.$contact_qq;
					$data['contact']=$contact;
				}
				else {
					$data['contact']="<li><span class=\"detail_t\"></span><span class=\"detail_c\" style=\"color:red;\"><p>验证码错误！</p></span></li>";
					$data['captcha_error']=1;
				}
			}
			if ($this->_is_this_author($post)){
				if ($post['status']=='2'){
					$close_url="&mod=reset \">激活</a>";
				}else {
					$close_url="\">关闭</a>";
				}
				$str1="<div class=\"link_str\"><a href=\"".site_url("found/drop")."?id=".$post['id']."&redirect=".current_url().$close_url;
				$str2="<a href=\"".site_url("found/edit")."?id=".$post['id']."\">编辑</a>";
				$str3= "<a href=\"".site_url("found/del")."?id=".$post['id']."&redirect=".site_url('found')."\">删除</a></div>";
				$data['link_str']=$str1.$str2.$str3;
			}	
			$data['post']=$post;
			$this->load->view('lost/lost_page',$data);
		}
	}
	function del(){
			@$post_id=$_GET['id'];
			@$redirect=$_GET['redirect'];
			@$username=strtolower($this->session->userdata('name'));
		if (isset($post_id)&&isset($username)){
			if ($username!=""&&$username!="anonymous"&&$this->user_model->get_user_status()!='0'){
				$find=$this->post_model->get_by_user_id($username,$post_id);
			}
		}
		if (isset($find)){
			$result=$this->db->delete('post', array('id' => $post_id,'author' => strtolower($this->session->userdata('name')))  );
			if ($redirect!=null){
				header("refresh:2;url=".$redirect);
			}else {
				header("refresh:2;url=".site_url());
			}
			$data['error']="删除成功！正在返回……<br>";
			$this->load->view('error',$data);
		}else {
			if ($redirect!=null){
				header("refresh:2;url=".$redirect);
			}else {
				header("refresh:2;url=".site_url());
			}
			$data['error']="没有权限或信息不存在！<br>";
			$this->load->view('error',$data);
		}
		
	}
	function drop(){
			@$post_id=$_GET['id'];
			@$redirect=$_GET['redirect'];
			@$username=strtolower($this->session->userdata('name'));
		if (isset($post_id)&&isset($username)){
			if ($username!=""&&$username!="anonymous"&&$this->user_model->get_user_status()!='0'){
				$find=$this->post_model->get_by_user_id($username,$post_id);
			}
		}
		if (isset($find)){
			if (isset($_GET['mod'])){
				if ($_GET['mod']=='reset'){
					if (CHECK){
						$status= 0 ;
					}else {
						$status= 1 ;
					}
				}else {
					$status='2';
				}
			}else {
				$status='2';
			}
			$result=$this->db->query("UPDATE  `find`.`post` SET  `status` =  ".$status." WHERE  `post`.`id` =".$post_id);
			if ($redirect!=null){
				header("refresh:2;url=".$redirect);
			}else {
				header("refresh:2;url=".site_url());
			}
			if (isset($_GET['mod'])){
				if ($_GET['mod']=='reset'){
					$data['error']="激活成功！正在返回……<br>";
				}else {
					$data['error']="关闭成功！正在返回……<br>";
				}
			}else {
				$data['error']="关闭成功！正在返回……<br>";
			}
			$this->load->view('error',$data);
		}else {
			if ($redirect!=null){
				header("refresh:2;url=".$redirect);
			}else {
				header("refresh:2;url=".site_url());
			}
			$data['error']="没有权限或信息不存在！<br>";
			$this->load->view('error',$data);
		}
		
	}
	
	function edit(){
		//获取编辑信息id
		@$post_id=$_GET['id'];
		$username=strtolower($this->session->userdata('name'));
		if (isset($post_id)&&isset($username)){
			if ($username!=""&&$username!="anonymous"&&$this->user_model->get_user_status()!='0'){
				$find=$this->post_model->get_by_user_id($username,$post_id);
			}
		}
		if (!isset($find)){
			$data['error']="没有权限或信息不存在！<br>";
			$this->load->view('error',$data);
			header("refresh:2;url=".site_url('user'));
		}else {
			$_GET['cate'] = "0";
			//获得信息详情
			if (isset($_REQUEST['description'])){
				$description=$_REQUEST['description'];
			}else {
				$description="没有留下详细信息。";
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
			$this->form_validation->set_rules('checkbox', 'checkbox','TRUE');
			//post数据不为空时进行数据处理
			if ($this->input->post('title')!=""){
				//表单数据验证
				if ($this->form_validation->run()){
					//检查是否为重复提交
					if($this->post_model->postupdate($description)){
							$data['error']= "更新成功！";
						}else {
							$data['error']= "更新失败，请重试。";
						}
				}
			}
		$editdata=$this->post_model->get_by_user_id($username,$post_id);
		if (isset($data)){
			$editdata['error']=$data['error'];
		}
		$this->load->view('lost/lost_edit',$editdata);
		}

	}
	function _is_this_author($post) {
		@$username = $this->session->userdata['name'];
		if ($username!=""&&$username!="anonymous"&&$this->user_model->get_user_status()!='0'){

			if ($post['author']==strtolower($username)){
				$is_the_author=1;
			}else {
				$is_the_author=0;
			}
		}else {
			//echo $this->user_model->get_user_status();
			$is_the_author=0;
		};
		return $is_the_author;
	}
	
}