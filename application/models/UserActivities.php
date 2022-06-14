<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class UserActivities extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO user_activities(`user_id`, `ip`, `date`, `activity`) VALUES('".$data['user_id']."', '".$data['ip']."', NOW(), '".$data['activity']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function allByDate($date_from, $date_to){
		$query_condition = '';
		if($date_from != null) {
			$query_condition = ' WHERE date >= STR_TO_DATE("'.$date_from.'", "%m/%d/%Y")';
		}

		if($date_to != null) {
			if($query_condition == '') {
				$query_condition = ' WHERE date <= STR_TO_DATE("'.$date_to.'", "%m/%d/%Y")';
			}
			else {
				$query_condition .= ' AND date <= STR_TO_DATE("'.$date_to.'", "%m/%d/%Y")';
			}
			
		}

		// SELECT * FROM batch_files WHERE STR_TO_DATE(date, '%m/%d/%Y') >= STR_TO_DATE('08/13/2022', '%m/%d/%Y');
		// SELECT STR_TO_DATE(date, '%m/%d/%Y') FROM batch_files;

		$query = "SELECT * FROM user_activities JOIN users ON user_activities.user_id = users.id".$query_condition.' ORDER BY user_activities.ID DESC';
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

}