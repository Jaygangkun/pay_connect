<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class TxnPurpose extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO txn_purpose(`code`, `description`) VALUES('".$data['code']."', '".$data['description']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function all(){
		$query = "SELECT * FROM txn_purpose";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function deleteByID($id){
		$query = "DELETE FROM txn_purpose WHERE id='".$id."'";
		return $this->db->query($query);
	}
}