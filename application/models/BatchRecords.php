<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
Class BatchRecords extends CI_Model
{
	public function add($data){
		
		$query = "INSERT INTO batch_records(`batch_file_id`, `payment_seq`, `transaction_ref`, `beneficiary_name`, `account_number`, `amount_pay`, `department`, `benef_bank`, `bank_biccode`, `uploader`, `txn_purpose`) VALUES(".$this->db->escape($data['batch_file_id']).", ".$this->db->escape($data['payment_seq']).", ".$this->db->escape($data['transaction_ref']).", ".$this->db->escape($data['beneficiary_name']).", ".$this->db->escape($data['account_number']).", ".$this->db->escape($data['amount_pay']).", ".$this->db->escape($data['department']).", ".$this->db->escape($data['benef_bank']).", ".$this->db->escape($data['bank_biccode']).", ".$this->db->escape($data['uploader']).", '".$data['txn_purpose']."')";
		
        $this->db->query($query);

		return $this->db->insert_id();
	}

	public function addBulk($bulk){

        $this->db->insert_batch('batch_records', $bulk);

		return;
	}

	public function loadByBatchFileID($batch_file_id){
		$query = "SELECT * FROM batch_records WHERE batch_file_id='".$batch_file_id."'";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	public function loadUnProcessedByBatchFileID($batch_file_id){
		$query = "SELECT * FROM batch_records WHERE batch_file_id='".$batch_file_id."' AND `processed` != 1";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	public function loadByBatchFileIDAndTxnRef($batch_file_id, $txn_ref){
		$query = "SELECT * FROM batch_records WHERE batch_file_id='".$batch_file_id."' AND transaction_ref='".$txn_ref."'";
		$query_result = $this->db->query($query)->result_array();
		
		return $query_result;
	}

	public function updateApiResult($data) {
		$query = "UPDATE batch_records SET txn_purpose='".$data['txn_purpose']."', resp_statusCode='".$data['statusCode']."', resp_rcvStatus='".$data['rcvStatus']."', resp_errorMsg='".$data['errorMsg']."', `processed`=1 WHERE payment_seq='".$data['PaymentSeq']."' AND transaction_ref='".$data['txnRef']."'";

        return $this->db->query($query);
	}

	public function updateBatchRecordApiBulkResult($data) {
		$query = "UPDATE batch_records SET resp_rcvStatus='".$data['resp_rcvStatus']."', resp_errorMsg='".$data['resp_errorMsg']."' WHERE transaction_ref='".$data['transaction_ref']."' AND batch_file_id='".$data['batch_file_id']."'";

        return $this->db->query($query);
	}

	public function updateAllBatchRecordsApiBulkResult($data) {
		$query = "UPDATE batch_records SET resp_rcvStatus='".$data['resp_rcvStatus']."', resp_errorMsg='".$data['resp_errorMsg']."' WHERE batch_file_id='".$data['batch_file_id']."'";

        return $this->db->query($query);
	}

	public function updateApiResultByTxn($data) {
		$query = "UPDATE batch_records SET resp_rcvStatus='".$data['resp_rcvStatus']."', resp_errorMsg='".$data['resp_errorMsg']."' WHERE transaction_ref='".$data['transaction_ref']."'";

        return $this->db->query($query);
	}

	public function updateAuthoriseByBatchFile($batch_file_id, $authoriser, $status) {
		$query = "UPDATE batch_records SET resp_rcvStatus='".$status."', authoriser='".$authoriser."' WHERE batch_file_id='".$batch_file_id."'";

        return $this->db->query($query);
	}

	public function existTransactionRef($transaction_ref){
		
		$query = "SELECT * FROM batch_records WHERE transaction_ref='".$transaction_ref."'";

		$query_result = $this->db->query($query)->result_array();
		return count($query_result) > 0;
	}
}