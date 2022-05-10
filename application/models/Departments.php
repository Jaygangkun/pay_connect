<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class Departments extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO departments(`name`) VALUES('".$data['name']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function all(){
		$query = "SELECT * FROM departments";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function existDepartment($name){
		
		$query = "SELECT * FROM departments WHERE name='".$name."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

}