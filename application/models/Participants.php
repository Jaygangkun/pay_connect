<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class Participants extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO participants(`bic_swift_code`, `sort_code`, `short_name`, `participant_name`, `account_number`, `status`) VALUES('".$data['bic_swift_code']."', '".$data['sort_code']."', '".$data['short_name']."', '".$data['participant_name']."', '".$data['account_number']."', '".$data['status']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function update($data){
		$query = "UPDATE participants SET bic_swift_code='".$data['bic_swift_code']."', sort_code='".$data['sort_code']."', short_name='".$data['short_name']."', participant_name='".$data['participant_name']."', account_number='".$data['account_number']."', status='".$data['status']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}

	public function all() {
		$query = "SELECT * FROM participants";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function existBicSwiftCode($bic_swift_code){
		
		$query = "SELECT * FROM participants WHERE bic_swift_code='".$bic_swift_code."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

	public function deleteByID($id){
		$query = "DELETE FROM participants WHERE id='".$id."'";
		return $this->db->query($query);
	}
}