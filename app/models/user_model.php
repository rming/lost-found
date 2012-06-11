<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function user_login_check(){
		$password=$this->input->post('password');
		$this->db->where('name',strtolower($this->input->post('name')) );
		$this->db->where('password',md5($password));
		//echo "mima".$this->input->post('password');
		$q = $this->db->get('user');
		if ($q->num_rows()>0){
			return $q->num_rows();
		}else {
			return $result='0';
		}
	}
	function user_psw_check($username,$old_password){
		$this->db->where('name',strtolower($username));
		$this->db->where('password',md5($old_password));
		
		$q = $this->db->get('user');
		if ($q->num_rows()>0){
			return $q->num_rows();
		}else {
			return $result='0';
		}
	}
	
	function  user_psw_update($username,$new_password){
		$update_user = array(
			'name'=>strtolower($username),
			'id'=>$this->session->userdata('id'),
			'password'=>md5($new_password),
			'email'=>$this->session->userdata('email'),
			'registerTime'=>$this->session->userdata('registerTime'),
			'ip'=>$this->session->userdata('ip'),
			'status'=>$this->session->userdata('status'),
            );
		$this->db->where('name', strtolower($username));
		$result=$this->db->update('user', $update_user); 
		return $result;
	}
	function  update_email_psw($new_password,$user_email,$forgot_key){
        $update_user = array(
			'password'=>md5($new_password),
            );
		$this->db->where('email', strtolower($user_email));
		$this->db->where('forgot_key', $forgot_key);
		$result=$this->db->update('user', $update_user); 
		//print_r($_SERVER);
		return $result;
	}
	function  destroy_chpsw_key($user_email,$forgot_key){
        $update_user = array(
			'forgot_key'=> '0',
        	'forgot_key_time'=>'0',
            );
		$this->db->where('email', strtolower($user_email));
		$this->db->where('forgot_key', $forgot_key);
		$result=$this->db->update('user', $update_user); 
		return $result;
	}
	function user_reg_check(){
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
	
	function user_reg(){
		$user_data=array(
	 		'name'=>strtolower($this->input->post('name')),
	 		'password'=>md5($this->input->post('password')),
	 		'email'=>strtolower($this->input->post('email')),
	 		'registerTime'=>date("Y-m-d G:i:s"),
	 		'ip'=>$_SERVER['REMOTE_ADDR'],
	 		'status'=>0,
		 	);
			$insert_result=$this->db->insert('user', $user_data); 
			return $insert_result;
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

	function key_save($confirm_key){
		$userdata = $this->get_user_by_name(strtolower($this->session->userdata('name')));
		$userdata['key_time']=time();
		$userdata['key']=$confirm_key;
		$this->db->where('name',strtolower($this->session->userdata('name')) );
		$update_result=$this->db->update('user', $userdata); 
		return $update_result;
	}


	function get_key_time(){
		$this->db->where('name',strtolower($this->session->userdata('name')));
		$this->db->select('key_time');
		$q = $this->db->get('user');
		if (isset($q)){
			foreach ($q->result() as $row){
				$old_key_time= $row->key_time;
			}
		}
		if (isset($old_key_time)){
			return $old_key_time;
		}
	}
	
	function get_key(){
		$this->db->where('name',strtolower($this->session->userdata('name')));	
		$this->db->select('key');
		$q = $this->db->get('user');
		if (isset($q)){
			foreach ($q->result() as $row){
				$old_key= $row->key;
			}
		}
		if (isset($old_key)){
			return $old_key;
		}
	}
	function forgot_key_save($forgot_key,$user_email){
		//查询是否有这个用户，没有则返回数据库操作失败0
		$this->db->where('email',strtolower($user_email));	
		$q = $this->db->get('user');
		if (isset($q)){
				foreach ($q->result() as $row){
					$old_forgot_key= $row->forgot_key;
				}
			}
		if (isset($old_forgot_key)){
			$userdata['forgot_key']=$forgot_key;
			$userdata['forgot_key_time']=time();
			$this->db->where('email',strtolower($user_email) );
			$update_result=$this->db->update('user', $userdata); 
			return $update_result;
		}else {
			return '0';
		}
		
		
	}
	function get_forgot_key_time($user_email){
		$this->db->where('email',strtolower($user_email));	
		$this->db->select('forgot_key_time');
		$q = $this->db->get('user');
		if (isset($q)){
			foreach ($q->result() as $row){
				$old_forgot_key_time= $row->forgot_key_time;
			}
		}
		if (isset($old_forgot_key_time)){
			return $old_forgot_key_time;
		}
	}
	function get_forgot_key($user_email){
			$this->db->where('email',strtolower($user_email));	
			$this->db->select('forgot_key');
			$q = $this->db->get('user');
			if (isset($q)){
				foreach ($q->result() as $row){
					$old_key= $row->forgot_key;
				}
			}
			if (isset($old_key)){
				return $old_key;
			}
		}
		
		
	function get_user_status(){
		$this->db->where('name',strtolower($this->session->userdata('name')));	
		$this->db->select('status');
		$q = $this->db->get('user');
		if (isset($q)){
			foreach ($q->result() as $row){
				$status= $row->status;
			}
		}
		if (isset($status)){
			return $status;
		}
	}
	function ch_user_status(){
		$userdata = $this->get_user_by_name(strtolower($this->session->userdata('name')));
		$userdata['key_time']='0';
		$userdata['key']='0';
		$userdata['status']='1';
		$this->db->where('name',strtolower($this->session->userdata('name')) );
		$update_result=$this->db->update('user', $userdata); 
		return $update_result;
	}
	
}
	

