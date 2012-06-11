<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends  CI_Controller{
function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('basic');
		$this->load->model('post_model');
	}
	//搜索功能
	function index(){
		if (isset($_GET['keyword'])&&isset($_GET['cate'])){
			if (isset($_GET['page'])){
				$page=$_GET['page'];
				$page=str_replace (".html",'',$page );
			}else {
				$page=1;
			}
			$keyword = $_GET['keyword'];
			$cate=$_GET['cate'];
			$limit=10;
			$offset=($page-1)*10;
			$search_post = $this->post_model->search($cate,$keyword,$limit,$offset);
			
			if (isset($search_post)){
				//分页
				$search_num = $this->post_model->search_num($cate,$keyword);
				$count = $search_num;
				//echo $search_num;
				$config['page_url'] =site_url('search').'?keyword='.$keyword.'&cate='.$cate.'&page=';  
				$config['page_size'] = 10 ;//每页几篇
				$config['rows_num'] = $count;  //一共多少文章
				$config['page_num'] = $page; //当前页页码
				$this->load->library('pagina');  
				$this->pagina->init($config);  
				$data['page_nav']=$this->pagina->create_links();
			 	//从数组中转成前台代码
			 	$str="";
			 	$i=1;
			 	if (isset($cate)&&$cate=="1"){
			 		
			 		$url_1="found/";
			 	}else {
			 		$url_1="lost/";
			 	}
			 	
				foreach ($search_post as $row)
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
						if ($this->basic->Counti($post[$i]['time'])>18){
							$post[$i]['time']=$this->basic->utfSubstr($post[$i]['time'],0,18);
						}
					}
					
					if (isset($post[$i]['description'])){
						if ($this->basic->Counti($post[$i]['description'])>24){
							$post[$i]['description']=$this->basic->utfSubstr($post[$i]['description'],0,39);
						}
					}
					//格式化文本
					$post[$i]['description']=strip_tags($post[$i]['description']);
					
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
				if (!isset($str)){
					$data['error']="没有查询到相关数据。";
					$this->load->view('search',$data);
				}else {
					$data['post']=$str;
					$this->load->view('search',$data);
				}				
			}else {
				$data['error']="没有查询到相关数据。";
				$this->load->view('search',$data);
			}
		}else {
			$this->load->view('search');
		}
		
		
		
		
		
	}
}