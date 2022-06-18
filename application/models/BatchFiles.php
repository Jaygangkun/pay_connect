<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class BatchFiles extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO batch_files(`ref_id`, `file_name`, `batch_number`, `file_batch_number`, `account`, `ordCust_name`,`date`, `batch_amount`, `currency`, `total_records`, `status`, `upload_at`) VALUES(".$this->db->escape($data['ref_id']).", ".$this->db->escape($data['file_name']).", ".$this->db->escape($data['batch_number']).", ".$this->db->escape($data['file_batch_number']).", ".$this->db->escape($data['account']).", ".$this->db->escape($data['ordCust_name']).", ".$this->db->escape($data['date']).", ".$this->db->escape($data['batch_amount']).", ".$this->db->escape($data['currency']).", ".$this->db->escape($data['total_records']).", '".$data['status']."', NOW())";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function addRefID($ref_id){

		$query = "SELECT * FROM batch_files WHERE ref_id='".$ref_id."'";

		$query_result = $this->db->query($query)->result_array();
		if(count($query_result) > 0) {
			return $query_result[0]['id'];
		}
		
		$query = "INSERT INTO batch_files(`ref_id`, `batch_number`, `batch_amount`, `status`, `upload_at`, `submit_at`) VALUES('".$ref_id."', '".$ref_id."', '0', 'UPLOADED', NOW(), NOW())";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function existBatchFileName($file_name){
		
		$query = "SELECT * FROM batch_files WHERE file_name='".$file_name."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

	public function existBatchNumber($batch_number){
		
		$query = "SELECT * FROM batch_files WHERE batch_number='".$batch_number."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}

	public function existFileBatchNumber($batch_number){
		
		$query = "SELECT * FROM batch_files WHERE file_batch_number='".$batch_number."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}
	
	public function all(){
		$query = "SELECT * FROM batch_files ORDER BY `ID` DESC";
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function deleteByID($id){
		$query = "DELETE FROM batch_files WHERE id='".$id."'";
		return $this->db->query($query);
	}

	public function allScheduled(){
		$query = "SELECT * FROM batch_files WHERE LOWER(status)='submitted' ORDER BY `ID` DESC";
		return $this->db->query($query)->result_array();
	}

	public function allByStatus($status){
		$query = "SELECT * FROM batch_files WHERE LOWER(status)=LOWER('".$status."')";
		return $this->db->query($query)->result_array();
	}

	public function getByID($id){
		$query = "SELECT * FROM batch_files WHERE id='".$id."'";
		$query_result = $this->db->query($query)->result_array();
		
		if(count($query_result) > 0) {
			return $query_result[0];
		}

		return null;
		
	}

	public function allByDate($date_from, $date_to){
		$query_condition = '';
		if($date_from != null) {
			$query_condition = ' WHERE STR_TO_DATE(date, "%m/%d/%Y") >= STR_TO_DATE("'.$date_from.'", "%m/%d/%Y")';
		}

		if($date_to != null) {
			if($query_condition == '') {
				$query_condition = ' WHERE STR_TO_DATE(date, "%m/%d/%Y") <= STR_TO_DATE("'.$date_to.'", "%m/%d/%Y")';
			}
			else {
				$query_condition .= ' AND STR_TO_DATE(date, "%m/%d/%Y") <= STR_TO_DATE("'.$date_to.'", "%m/%d/%Y")';
			}
			
		}

		// SELECT * FROM batch_files WHERE STR_TO_DATE(date, '%m/%d/%Y') >= STR_TO_DATE('08/13/2022', '%m/%d/%Y');
		// SELECT STR_TO_DATE(date, '%m/%d/%Y') FROM batch_files;

		$query = "SELECT * FROM batch_files".$query_condition.' ORDER BY `ID` DESC';
		$query_result = $this->db->query($query)->result_array();
		return $query_result;
	}

	public function updateSubmitResult($data) {
		$query = "UPDATE batch_files SET status='".$data['status']."', submit_at=NOW()  WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}

	public function updateApiResult($data) {
		$query = "UPDATE batch_files SET status='".$data['status']."', error_msg='".$data['error_msg']."' WHERE batch_number='".$data['batch_number']."'";

        return $this->db->query($query);
	}

	public function updateStatus($id, $status) {
		$query = "UPDATE batch_files SET status='".$status."', authorise_at=NOW()  WHERE id='".$id."'";

        return $this->db->query($query);
	}

	public function manualSubmit($data) {
		$query = "UPDATE batch_files SET account='".$data['account']."', ordCust_name='".$data['ordCust_name']."', batch_amount= cast(batch_amount AS DECIMAL(10, 2)) + cast('".$data['batch_amount']."' AS DECIMAL(10, 2)), currency='".$data['currency']."', total_records='".$data['total_records']."', status='UPLOADED', `date`='".$data['date']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}

	public function getIDFromBatchNumber($batch_number){
		
		$query = "SELECT * FROM batch_files WHERE batch_number='".$batch_number."'";
		
		$batch_files = $this->db->query($query)->result_array();

		foreach($batch_files as $batch_file) {
			return $batch_file['id'];
		}

		return null;
	}
}