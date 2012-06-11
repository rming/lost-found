<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_model extends CI_Model {

	
	
	function postcheck(){
		
			$this->db->where('title', $this->input->post('title') );
			$this->db->where('category', @$_GET['cate'] );
			$this->db->where('author',strtolower($this->session->userdata('name')) );
			$q = $this->db->get('post');
			if ($q->num_rows()>0){
				$q=1;
			}
			else {
				$q=0;
			}
			return $q;
	}

	function postsave($description){
		if (CHECK){
			$status= 0 ;
		}else {
			$status= 1 ;
		}
		$postdata= array(
				"title" => $this->input->post('title'),
				"category" =>   $_GET['cate'],
				"type" =>  $this->input->post('type'),
				"place" =>   $this->input->post('place'),
				"time" => $this->input->post('time'),
				"link_man"=>$this->input->post('link_man'),
				"link_phone" => $this->input->post('link_phone'),
				"link_email" =>  $this->input->post('link_email'),
				"link_qq" =>   $this->input->post('link_qq'),
				"description" => $description,
				"post_time" =>  date("Y-m-d G:i:s"),
				"author" => strtolower($this->session->userdata['name']),
				"status" => $status,
			 );
		$insert_result=$this->db->insert('post', $postdata); 
		return $insert_result;		 
	}
	//更新信息
	function postupdate($description){
		if (CHECK){
			$status= 0 ;
		}else {
			$status= 1 ;
		}
		$postdata= array(
				"title" => $this->input->post('title'),
				"category" =>   $_GET['cate'],
				"type" =>  $this->input->post('type'),
				"place" =>   $this->input->post('place'),
				"time" => $this->input->post('time'),
				"link_man"=>$this->input->post('link_man'),
				"link_phone" => $this->input->post('link_phone'),
				"link_email" =>  $this->input->post('link_email'),
				"link_qq" =>   $this->input->post('link_qq'),
				"description" => $description,
				"post_time" =>  date("Y-m-d G:i:s"),
				"author" => strtolower($this->session->userdata['name']),
				"status" => $status,
			 );
		$this->db->where('id',$_GET['id'] );
		$update_result=$this->db->update('post', $postdata); 
		return $update_result;		
	}
	function get_type($tid){
		$type_get = $this->db->get_where('type', array('tid' => $tid), 1, 0);
		if (isset($type_get)){
			foreach ($type_get->result() as $row)
			{
			$type = array(
					"id" => $row->id,
					"tid" =>  $row->tid,
					"tname" =>   $row->tname,
				 );
			}
		}
		if (isset($type['tname'])){
			return $type['tname'];
		}else {
			return false;
		}
	}

	//获取指定目录文章
	public  function get_by_order($cate,$limit,$offset){
		$this->db->order_by("id", "desc");
		$post_get = $this->db->get_where('post', array('category' => $cate,"status" =>'1'), $limit, $offset);
		if (isset($post_get)){
			$i=1;
			foreach ($post_get->result() as $row)
					{
					$post[$i] = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
						 $i++;
				}
			}
		if (isset($post)){
			return $post;
		}
	}
	
	//通过cete和id获取文章信息
	public  function get_by_cate_id($post_id,$cate)
	{
		if(isset($post_id)&&isset($cate)){
			$this->db->where('category',$cate );
			$post_get = $this->db->get_where('post', array('id' => $post_id), 1, 0);
			if (isset($post_get)){
				foreach ($post_get->result() as $row)
					{
					$post = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
					}
				}
			if (isset($post)){
				return $post;
			}
		}
	}
	
	public  function get_by_order_tid($cate,$status,$tid,$limit,$offset){
			$this->db->order_by("id", "desc");
			$post_get = $this->db->get_where('post', array('category' => $cate,'status'=>$status,'type'=>$tid), $limit, $offset);
			if (isset($post_get)){
			$i=1;
			foreach ($post_get->result() as $row)
					{
					$post[$i] = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
						 $i++;
				}
			}
		if (isset($post)){
			return $post;
		}
	}
	public  function get_by_order_status($username,$cate,$status,$limit,$offset){
			$this->db->order_by("id", "desc");
			$post_get = $this->db->get_where('post', array('category' => $cate,'status'=>$status,'author'=>$username), $limit, $offset);
			if (isset($post_get)){
			$i=1;
			foreach ($post_get->result() as $row)
					{
					$post[$i] = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
						 $i++;
				}
			}
		if (isset($post)){
			return $post;
		}
	}
	//通过id获取文章信息
	public  function get_by_id($post_id)
	{
		if(isset($post_id)){
			$post_get = $this->db->get_where('post', array('id' => $post_id), 1, 0);
			if (isset($post_get)){
				foreach ($post_get->result() as $row)
					{
					$post = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
					}
				}
			if (isset($post)){
				return $post;
			}
		}
	}
	//获取指定用户的信息。
	public  function get_by_user($user,$cate="1",$limit, $offset)
	{
		if(!empty($user)){
			$user=strtolower($user);
			$this->db->order_by("id", "desc");
			$post_get = $this->db->get_where('post', array('author' => $user,'category'=>$cate),$limit, $offset);
			if (isset($post_get)){
				$i=1;
				foreach ($post_get->result() as $row)
					{
					$post[$i] = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
						 $i++;
					}
				}
			if (isset($post)){
				return $post;
			}
		}
	}
	public  function get_by_user_id($user,$id)
	{
		if(isset($user)){
			$user=strtolower($user);
			$post_get = $this->db->get_where('post', array('author' => $user,'id'=>$id),1, 0);
			if (isset($post_get)){
				foreach ($post_get->result() as $row)
					{
					$post = array(
							"id" => $row->id,
							"title" =>  $row->title,
							"category" =>   $row->category,
							"type" =>  $row->type,
							"place" =>   $row->place,
							"time" =>$row->time,
							"link_man"=>$row->link_man,
							"link_phone" =>   $row->link_phone,
							"link_email" =>   $row->link_email,
							"link_qq" =>   $row->link_qq,
							"description" => stripslashes($row->description),
							"post_time" =>   $row->post_time,
							"author" =>   $row->author,
							"status" =>   $row->status,
							"num"=> $post_get->num_rows(),
						 );
					}
				}
			if (isset($post)){
				return $post;
			}
		}
	}
	public  function search($cate,$keyword,$limit,$offset){
		/*
		$this->db->like('title', $keyword);
		$this->db->where('category', $cate);
		$this->db->or_like('description', $keyword); 
		$this->db->where('category', $cate);
		$this->db->order_by("id", "desc");
		//echo $cate;
		$post_get = $this->db->get('post',$limit,$offset);
		
		*/
		$query="SELECT *  FROM `post` WHERE `title` LIKE '%".$keyword."%' AND `category` = ".$cate. " AND `status` = 1 OR `description` LIKE '%".$keyword."%' AND `category` = ".$cate." AND `status` = 1 ORDER BY  `id` DESC  LIMIT ".$offset .",".$limit ;
		$post_get=$this->db->query($query);
		if (isset($post_get)){
			$i=1;
			foreach ($post_get->result() as $row)
				{
				$post[$i] = array(
						"id" => $row->id,
						"title" =>  $row->title,
						"category" =>   $row->category,
						"type" =>  $row->type,
						"place" =>   $row->place,
						"time" =>$row->time,
						"link_man"=>$row->link_man,
						"link_phone" =>   $row->link_phone,
						"link_email" =>   $row->link_email,
						"link_qq" =>   $row->link_qq,
						"description" => stripslashes($row->description),
						"post_time" =>   $row->post_time,
						"author" =>   $row->author,
						"status" =>   $row->status,
						"num"=> $post_get->num_rows(),
					 );
					 //print_r($post[$i]);
					$i++;
					
				}
			}
			if (isset($post)){
				//print_r($post);
				return $post;
				
			}
	
	}
	
	public  function search_num($cate,$keyword){
		$query="SELECT *  FROM `post` WHERE `title` LIKE '%".$keyword."%' AND `category` = ".$cate. " AND `status` = 1 OR `description` LIKE '%".$keyword."%' AND `category` = ".$cate." AND `status` = 1 ORDER BY  `id` DESC  " ;
		$post_get=$this->db->query($query);
		if (isset($post_get)){
				return  $post_get->num_rows();
			}else{
				return FALSE;
			}
			
	}
}