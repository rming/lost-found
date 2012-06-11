<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feedback extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('basic');
	}
	//文章列表功能
   	function index(){
   		$this->load->view('feedback');
   	}
   	
   	
}