<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class APIController extends CI_Controller {

    public function __construct(){
		
        parent::__construct();

        $this->load->model("BatchFiles");
        $this->load->model("BatchRecords");
    }
    
    public function transactionGenerate() {
        echo genTransactionRef(null);
    }

    public function batchGenerate() {
        echo genBatchNumber();
    }

    public function payUpdate() {
        
        $body_data = json_decode(file_get_contents('php://input'), true);

        if(!isset($body_data['BatchNumber'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'BatchNumber empty'
            ));

            return;
        }

        if(!isset($body_data['BatchStatus'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'BatchStatus empty'
            ));

            return;
        }

        if(!isset($body_data['statusCode'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'statusCode empty'
            ));

            return;
        }

        if(!isset($body_data['txnReferences'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'txnReferences empty'
            ));

            return;
        }

        if(!$this->BatchFiles->existBatchNumber($body_data['BatchNumber'])) {
            echo json_encode(array(
                'success' => false,
                'message' => "Invalid batch number or transaction ref"
            ));
            return;    
        }

        $txn_error_messages = '';        

        $resp_transactions_missing = [];
        $txnReferences = $body_data['txnReferences'];        
        
        $batch_file_id = $this->BatchFiles->getIDFromBatchNumber($body_data['BatchNumber']);

        if($batch_file_id) {
            $this->BatchRecords->updateAllBatchRecordsApiBulkResult(array(
                'batch_file_id' => $batch_file_id,
                'resp_rcvStatus' => $body_data['BatchStatus'],
                'resp_errorMsg' => ''
            ));

            foreach($txnReferences as $txnReference) {
                $batch_records = $this->BatchRecords->loadByBatchFileIDAndTxnRef($batch_file_id, $txnReference['txnRef']);
                if(count($batch_records) > 0) {
                    $this->BatchRecords->updateBatchRecordApiBulkResult(array(
                        'batch_file_id' => $batch_file_id,
                        'transaction_ref' => $txnReference['txnRef'],
                        'resp_rcvStatus' => $txnReference['procStatus'],
                        'resp_errorMsg' => $txnReference['errorMsg']
                    ));
                }
            }
    
            $this->BatchFiles->updateApiResult(array(
                'batch_number' => $body_data['BatchNumber'],
                'status' => $body_data['BatchStatus'],
                'error_msg' => $txn_error_messages
            ));
        }
        else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Not Found Batch File'
            ));
            return;
        }
        

        if(count($resp_transactions_missing) != 0) {
            echo json_encode(array(
                'success' => false,
                'message' => 'missing transactions:'.implode(',', $resp_transactions_missing)
            ));
            return;
        }

        echo json_encode(array(
            'success' => true
        ));
    }
}