<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class BatchRecords extends CI_Model
{
	public function add($data){
		$query = "INSERT INTO batch_records(`batch_file_id`, `payment_seq`, `transaction_ref`, `beneficiary_name`, `account_number`, `amount_pay`, `department`, `benef_bank`, `bank_biccode`, `status`) VALUES('".$data['batch_file_id']."', '".$data['payment_seq']."', '".$data['transaction_ref']."', '".$data['beneficiary_name']."', '".$data['account_number']."', '".$data['amount_pay']."', '".$data['department']."', '".$data['benef_bank']."', '".$data['bank_biccode']."', '".$data['status']."')";
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function loadByBatchFileID($batch_file_id){
		$query = "SELECT * FROM batch_records WHERE batch_file_id='".$batch_file_id."'";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	public function updateApiResult($data) {
		$query = "UPDATE batch_records SET status='".$data['status']."', resp_rcvStatus='".$data['resp_rcvStatus']."', resp_errorMsg='".$data['resp_errorMsg']."' WHERE id='".$data['id']."'";

        return $this->db->query($query);
	}
}