<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class APIController extends CI_Controller {

    public function __construct(){
		
        parent::__construct();

        $this->load->model("BatchFiles");
        $this->load->model("BatchRecords");
    }
    
    public function refGenerate() {
        // echo genBatchNumber();
        echo genTransactionRef(null);
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
            $batch_records = $this->BatchRecords->loadByBatchFileID($batch_file_id);
            foreach($batch_records as $batch_record) {
                $record_found = false;
                foreach($txnReferences as $txnReference) {
                    if($batch_record['transaction_ref'] == $txnReference['txnRef']) {
                        $record_found = true;
    
                        $this->BatchRecords->updateApiBulkResult(array(
                            'transaction_ref' => $txnReference['txnRef'],
                            'resp_rcvStatus' => $txnReference['procStatus'],
                            'resp_errorMsg' => $txnReference['errorMsg']
                        ));
    
                        $txn_error_messages .= $txnReference['errorMsg']."<br>";
    
                        break;
                    }
                }
                
                if(!$record_found) {
                    $this->BatchRecords->updateApiBulkResult(array(
                        'transaction_ref' => $batch_record['transaction_ref'],
                        'resp_rcvStatus' => $body_data['BatchStatus'],
                        'resp_errorMsg' => ''
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