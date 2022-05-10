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

		$query = "SELECT * FROM user_activities JOIN users ON user_activities.user_id = users.id".$query_condition;
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}













	public function load($user_id){
		$query = "SELECT * FROM reports WHERE user_id='".$user_id."' ORDER BY title ASC";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	

	public function update($data){

		$query = "UPDATE reports SET title='".$data['title']."', conditions='".$data['conditions']."', study='".$data['study']."', country='".$data['country']."', terms='".$data['terms']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}

	

	public function duplicateByID($id){
		
		$query_get = "SELECT * FROM reports WHERE id='".$id."'";
		$results_get = $this->db->query($query_get)->result_array();

		if(count($results_get) > 0){
			$report = $results_get[0];

			// clone
			$query = "INSERT INTO reports(`title`, `conditions`, `study`, `country`, `terms`, `created_at`, `user_id`) VALUES('".$report['title']."', '".$report['conditions']."', '".$report['study']."', '".$report['country']."', '".$report['terms']."', NOW(), '".$report['user_id']."')";
			$this->db->query($query);

			return $this->db->insert_id();
		}

		return null;
	}

	public function updateField($data){
		$update_set = '' ;
		if(isset($data['reporting'])){
			if($update_set == ''){
				$update_set = "reporting='".$data['reporting']."'";
			}
		}

		if(isset($data['status'])){
			if($update_set == ''){
				$update_set = "status='".$data['status']."'";
			}
			else{
				$update_set .= ", status='".$data['status']."'";
			}
		}
		$query = "UPDATE reports SET ".$update_set." WHERE id='".$data['id']."'";		

		return $this->db->query($query);
	}

	public function search($keyword, $sort, $user_id){
		
		$query = '';

		if($sort == 'az'){
			$orderby = 'ORDER BY title ASC';
		}
		else if($sort == 'newold'){
			$orderby = 'ORDER BY status ASC';
		}
		else if($sort == 'oldnew'){
			$orderby = 'ORDER BY status DESC';
		}

		if($keyword == ''){
			$query = "SELECT * FROM reports WHERE user_id='".$user_id."' ".$orderby;
		}
		else{
			$query = "SELECT * FROM reports WHERE (title LIKE '%".$keyword."%' OR conditions LIKE '%".$keyword."%' OR study LIKE '%".$keyword."%' OR country LIKE '%".$keyword."%' OR terms LIKE '%".$keyword."%') AND user_id='".$user_id."' ".$orderby;
		}

		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	

	public function updateGuids($report_id, $data){
		$query = "UPDATE reports SET pubDate='".$data['pubDate']."', guids='".$data['guids']."' WHERE id='".$report_id."'";		
		return $this->db->query($query);
	}
}