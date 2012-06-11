<?php

class Imgauthcode extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Authcode');
	}

	/**
	 * 显示图片
	 *
	 */
	function show()
	{
		$this->authcode->show();
	}

	/**
	 * js调用显示图片
	 *
	 */
	function show_script()
	{
		$this->authcode->showScript();
	}
	
	/**
	 * ajax验证
	 *
	 */
	function check()
	{
		if ($this->authcode->check($this->uri->segment(3))) {
			$xml_data['result'] = 'succeed';
			$this->load->library('My_Xml');
			echo XML_serialize($xml_data);
		} else {
			echo '验证码不正确，请重新输入';
		}		
	}
}
