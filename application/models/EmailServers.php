<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class EmailServers extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO email_servers(`host`, `port`, `user`, `password`, `sender`, `ssl_tls`, `default`) VALUES('".$data['host']."', '".$data['port']."', '".$data['user']."', '".$data['password']."', '".$data['sender']."', '".$data['ssl_tls']."', '".$data['default']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function all() {
		$query = "SELECT * FROM email_servers";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function deleteByID($id){
		$query = "DELETE FROM email_servers WHERE id='".$id."'";
		return $this->db->query($query);
	}

	public function update($data){
		$query = "UPDATE email_servers SET host='".$data['host']."', port='".$data['port']."', user='".$data['user']."', password='".$data['password']."', sender='".$data['sender']."', ssl_tls='".$data['ssl_tls']."', `default`='".$data['default']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}
}