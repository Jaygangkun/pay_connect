<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class Users extends CI_Model
{
	
	public function add($data){
		$query = "INSERT INTO users(`user_name`, `password`, `full_name`, `email`, `role`, `department_id`, `comments`, `status`) VALUES('".$data['user_name']."', PASSWORD('".$this->config->item('user_password_default')."'), '".$data['full_name']."', '".$data['email']."', '".$data['role']."', '".$data['department']."', '".$data['comments']."', '".$data['status']."')";
		$query_result = $this->db->query($query);
		
		return $this->db->insert_id();
	}

	public function all(){
		$query = "SELECT * FROM users JOIN departments ON departments.id=users.department_id";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	public function updateStatus($user_id, $status) {
		$query = "UPDATE users SET status='".$status."' WHERE id='".$user_id."'";
		$this->db->query($query);
		return true;
	}

	public function updateLoginStatus($user_id, $login_status) {
		$query = "UPDATE users SET login_status='".$login_status."' WHERE id='".$user_id."'";
		$this->db->query($query);
		return true;
	}

	public function checkLogin($user_name, $password){
		$query = "SELECT * FROM users WHERE user_name='".$user_name."' AND password=PASSWORD('".$password."')";
		$query_result = $this->db->query($query)->result_array();
		
		if(count($query_result) > 0) {
			return true;
		}
		return false;
	}

	public function existEmail($email){
		$query = "SELECT * FROM users WHERE email='".$email."'";
		$query_result = $this->db->query($query)->result_array();
		
		if(count($query_result) > 0) {
			return true;
		}
		return false;
	}

	public function isResetPassword($user_name){
		$query = "SELECT * FROM users WHERE user_name='".$user_name."'";
		$query_result = $this->db->query($query)->result_array();
		
		if(count($query_result) > 0) {
			return $query_result[0]['reset_password'] == 1 ? true : false;
		}

		return false;
	}

	public function exist($user_name, $email){
		
		$query = "SELECT * FROM users WHERE user_name='".$user_name."' AND email='".$email."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

	public function updateResetToken($email, $reset_token) {
		$query = "UPDATE users SET reset_token='".$reset_token."' WHERE email='".$email."'";
		$this->db->query($query);
		return true;
	}

	public function existResetToken($reset_token){
		
		$query = "SELECT * FROM users WHERE reset_token='".$reset_token."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

	public function resetPassword($reset_token, $password) {
		$query = "UPDATE users SET reset_token='', password=PASSWORD('".$password."'), reset_password='1' WHERE reset_token='".$reset_token."'";
		$this->db->query($query);
		return true;
	}
	
	public function getByUsername($user_name) {
		$query = "SELECT * FROM users WHERE user_name='".$user_name."'";

		$query_result = $this->db->query($query)->result_array();
		if(count($query_result) > 0) {
			return $query_result[0];
		}

		return false;
	}
}