<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends  CI_Controller{
	function __construct(){
		parent::__construct();
	}
	//文章列表功能
   	function index(){
   		redirect(site_url('admin/login'));
	}


}