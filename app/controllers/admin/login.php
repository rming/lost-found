<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('admin_user_model');
	}
	//文章列表功能
   	function index(){
   		if ($this->admin_user_model->is_admin_login()){
   			$data = array(
   				'error_title' =>"用户已登陆",
   				'error' =>$this->session->userdata('name')."&nbsp;已经登陆,正在跳转到后台管理页面.",
   			);
   			$this->load->view('admin/admin_error',$data);
   			header("refresh:1;url=".site_url('admin/home'));
   		}else {
   			//设置表单验证的规则
			$this->form_validation->set_rules('username','用户名','required');
			$this->form_validation->set_rules('password', '密码', 'required');
			if (!$this->form_validation->run()){
				$this->load->view('admin/admin_login');
			}else {
				if ($this->input->post('captcha')!=$this->session->userdata('auth_code')){
					$data = array(
   					'error_title' =>"验证码错误",
   					'error' =>"验证码错误,请重新输入.",
   					);
		   			$this->load->view('admin/admin_error',$data);
		   			header("refresh:1;url=".site_url('admin/login'));
				}else {
					$login_result = $this->admin_user_model->admin_login_check();
			   		if ($login_result==1){
			   			//保存用户信息设置ci的session
						$l_name=strtolower($this->input->post('username'));
						$userdata=$this->admin_user_model->get_user_by_name($l_name);
						$userdata['is_login']= TRUE;
						$userdata['anonymous']=FALSE;
						$userdata['name']=$this->input->post('username');
						//设置session
						$this->session->set_userdata($userdata);
			   			$data = array(
	   					'error_title' =>"登陆成功",
	   					'error' =>$this->session->userdata('name')."&nbsp;登陆成功,正在跳转到后台管理页面.",
	   					);
			   			$this->load->view('admin/admin_error',$data);
			   			header("refresh:1;url=".site_url('admin/home'));
			   		}else {
			   			$data = array(
			   			'error_title' =>"登陆失败",
	   					'error' =>"帐号错误或没有权限 ,请重试.",
	   					);
			   			$this->load->view('admin/admin_error',$data);
			   			header("refresh:1;url=".site_url('admin/login'));
			   		}
				}
			}
   			
   		}
   		
	}
	
}