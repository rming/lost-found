<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	function is_admin_login(){
		if ($this->session->userdata('is_login')&&$this->session->userdata('status')==2){
				return TRUE;
			}else {
				return false;
			}
	}
	function admin_login_check(){
		$password=$_POST['password'];
		$this->db->where('name',strtolower($_POST['username']) );
		$this->db->where('password',md5($password));
		$this->db->where('status','2');
		$q = $this->db->get('user');
		if ($q->num_rows()>0){
			return $q->num_rows();
		}else {
			return $result='0';
		}
	}
	function user_add($status){
		$user_data=array(
	 		'name'=>strtolower($this->input->post('name')),
	 		'password'=>md5($this->input->post('password')),
	 		'email'=>strtolower($this->input->post('email')),
	 		'registerTime'=>date("Y-m-d G:i:s"),
	 		'ip'=>$_SERVER['REMOTE_ADDR'],
	 		'status'=>$status,
		 	);
			$insert_result=$this->db->insert('user', $user_data); 
			return $insert_result;
	}
	function user_add_check(){
		$this->db->where('name',strtolower($this->input->post('name')) );
		$q = $this->db->get('user');
		if ($q->num_rows()>0){
			$reg_error['name']='1';
		}else {
			$reg_error['name']='0';
		}
		$this->db->where('email',strtolower($this->input->post('email')) );
		$q = $this->db->get('user');
		if ($q->num_rows()>0){
			$reg_error['email']='1';
		}else {
			$reg_error['email']='0';
		}
		if ($reg_error['name']&&$reg_error['email']){
			return $error="用户名和邮箱都被占用。";
		}elseif ($reg_error['name']=='0'&&$reg_error['email']) {
			return $error="邮箱被占用。";
		}elseif ($reg_error['name']&&$reg_error['email']=='0'){
			return $error="用户名被占用。";
		}else {
			return $error='0';
		}
	}
	function user_update($userdata){
		$update_user = array(
			'name'=>strtolower($_POST['name']),
			'id'=>$userdata['id'],
			'password'=>$userdata['password'],
			'email'=>$_POST['email'],
			'registerTime'=>$userdata['registerTime'],
			'ip'=>$userdata['ip'],
			'status'=>$_POST['status'],
            );
		$this->db->where('id', $userdata['id']);
		$result=$this->db->update('user', $update_user); 
		return $result;
	}

	function get_user_by_name($username){
		$user = $this->db->get_where('user', array('name' => $username), 1, 0);
		if (isset($user)){
			foreach ($user->result() as $row){
			$userdata = array(
					'id' => $row->id,
					'name' =>  $row->name,
					'password' =>   $row->password,
					'email' =>  $row->email,
					'registerTime' =>   $row->registerTime,
					'ip' =>$row->ip,
					'status'=>$row->status,
					 );
			}
		}
		if (isset($userdata)){
			return $userdata;
		}else {
			return false;
		}
	}		
	function get_user_by_status($status,$limit,$offset,$status2=NULL){
		
		if (!empty($status2)){
			$sql="SELECT * FROM user WHERE status=".$status." OR status=".$status2." LIMIT ".$offset.",".$limit;
		}else {
			$sql="SELECT * FROM user WHERE status=".$status." LIMIT ".$offset.",".$limit;;
		}
		$user = $this->db->query($sql);
		if (isset($user)){
			$i=1;
			foreach ($user->result() as $row){
			$userdata[$i] = array(
					'id' => $row->id,
					'name' =>  $row->name,
					'password' =>   $row->password,
					'email' =>  $row->email,
					'registerTime' =>   $row->registerTime,
					'ip' =>$row->ip,
					'status'=>$row->status,
					 );
		 	$i++;
			}
		}
		if (isset($userdata)){
			//print_r($userdata);
			return $userdata;
		}else {
			return false;
		}
	}		
}
	

