<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('admin_user_model');
	}
	//跳转
   	function index(){
   		if ($this->admin_user_model->is_admin_login()){
	   		//查询等待审核的信息数量
	   		$sql="SELECT COUNT(*) AS count FROM post WHERE status=0";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['uncheck_num']=$result['count']; //all
			$sql="SELECT COUNT(*) AS count FROM post WHERE  category=1 AND status=0";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['uncheck_found_num']=$result['count']; //found
			
			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=0";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['uncheck_lost_num']=$result['count']; //lost
			
			$sql="SELECT COUNT(*) AS count FROM post WHERE category=0 AND status=1";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['check_lost_num']=$result['count']; //
			
			$sql="SELECT COUNT(*) AS count FROM post WHERE  category=1 AND status=1";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['check_found_num']=$result['count']; 
			
			$sql="SELECT COUNT(*) AS count FROM post WHERE  category=1 AND status=2";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['drop_found_num']=$result['count']; 
			
			$sql="SELECT COUNT(*) AS count FROM post WHERE  category=0 AND status=2";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['drop_lost_num']=$result['count']; 
			//查询等待认证用户数量
			$sql="SELECT COUNT(*) AS count FROM user WHERE status=0";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['uncheck_user_num']=$result['count']; //
			$sql="SELECT COUNT(*) AS count FROM user WHERE status=1 OR  status=2";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['check_user_num']=$result['count']; //
			$sql="SELECT COUNT(*) AS count FROM user WHERE status=2";
			@$result=mysql_fetch_array(mysql_query($sql));
			$data['check_admin_num']=$result['count']; //
	   		$this->load->view('admin/admin_home',$data);
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