<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class Gateways extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO gateways(`short_name`, `description`, `endpoint`, `auth`, `direction`, `status`) VALUES('".$data['short_name']."', '".$data['description']."', '".$data['endpoint']."', '".$data['auth']."', '".$data['direction']."', '".$data['status']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function all() {
		$query = "SELECT * FROM gateways";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function deleteByID($id){
		$query = "DELETE FROM gateways WHERE id='".$id."'";
		return $this->db->query($query);
	}

	public function update($data){
		$query = "UPDATE gateways SET short_name='".$data['short_name']."', description='".$data['description']."', endpoint='".$data['endpoint']."', auth='".$data['auth']."', direction='".$data['direction']."', status='".$data['status']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}
}