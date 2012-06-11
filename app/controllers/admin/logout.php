<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('admin_user_model');
	}
	function  index(){
		if ($this->admin_user_model->is_admin_login()){
			$this->session->sess_destroy();
			$data = array(
	   				'error_title' =>"注销成功",
	   				'error' =>"帐号已注销,正在跳转到首页.",
	   			);
	   			$this->load->view('admin/admin_error',$data);
	   			header("refresh:2;url=".site_url());
			}else {
			$data = array(
	   			'error_title' =>"未登陆",
	   			'error' =>"尚未登陆,无需注销,正在跳转到首页.",
	   		);
	   		$this->load->view('admin/admin_error',$data);
	   		header("refresh:2;url=".site_url());
			}
		
	}
}