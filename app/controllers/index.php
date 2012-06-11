<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends  CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('basic');
		$this->load->model('post_model');
	}
	//文章列表功能
   	function index(){
		//查询验证
		 $lost=$this->post_model->get_by_order(0,5,0);
		 $found=$this->post_model->get_by_order(1,5,0);
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
						//截取指定长度字符串

						if (isset($post[$i]['title'])){
							if ($this->basic->Counti($post[$i]['title'])>8){
								$post[$i]['title']=$this->basic->utfSubstr($post[$i]['title'],0,23);
							}
						}
						if (isset($post[$i]['place'])){
							if ($this->basic->Counti($post[$i]['place'])>8){
								$post[$i]['place']=$this->basic->utfSubstr($post[$i]['place'],0,10);
							}
						}
						if (isset($post[$i]['time'])){
							if ($this->basic->Counti($post[$i]['time'])>10){
								$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
							}
						}
						$str2= "<td align=\"center\" >".$post[$i]['type']."</td>";
						$str3= "<td class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">".$post[$i]['title']."</a>"."</td>";
						$str4= "<td align=\"center\">".$post[$i]['place']."</td>";
						$str5= "<td align=\"center\">".$post[$i]['time']."</td>";
						$str6= "<td align=\"center\" class=\"td_a\">"."<a href=\"".site_url($url_1.$post[$i]['id'])."\">详情</a>"."</td>";
						$str7= "</tr>";
						//得到前台代码
						if ($a==1){
							$str_a=$str_a.$str1.$str2.$str3.$str4.$str5.$str6.$str7;
							$found_list=$str_a;
						}elseif ($a==0){
							$str_b=$str_b.$str1.$str2.$str3.$str4.$str5.$str6.$str7;
							$lost_list=$str_b;
						}
						$i++; 
					};					
				}
				$a++;
		 } 
		 //传入视图
		 if (isset($found_list)){
		 	$data['found_list']=$found_list;
		 }
		 
		 if (isset($lost_list)){
		 	$data['lost_list']=$lost_list;
		 }
		 
		 if (isset($data)){
		 	$this->load->view("index",$data);
		 }else {
		 	{
		 		$this->load->view("index");
		 	};
		 }

	}
	
}