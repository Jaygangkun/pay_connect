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

    public function processPendingBatchFile() {
        set_time_limit(0);
        $batch_files = $this->BatchFiles->getSubmitRequsted();
        foreach($batch_files as $batch_file) {
            writeLog('*****cronjob processPendingBatchFile start:'.$batch_file['id']);

            $batch_records = $this->BatchRecords->loadByBatchFileID($batch_file['id']);

			$batch_file_submit_error = false;
			$api_txn_count = 0;
			$api_txn_data = array();
			foreach($batch_records as $batch_record) {
				$date = new DateTime();				
				$api_txn_data[] = array(
					'PaymentSeq' => $batch_record['payment_seq'],
					'txnRef' => $batch_record['transaction_ref'],
					'txnCurr' => $batch_file['currency'],
					'settlementDate' => $date->format('Y').$date->format('m').$date->format('d'),
					'ordCustAccount' => $batch_file['account'],
					'ordCusName' => $batch_file['ordCust_name'],
					'benDepart' => $batch_record['department'],
					'txnPurpose' => $batch_file['submit_purpose'],
					'benBankBIC' => $batch_record['bank_biccode'],
					'benAccount' => $batch_record['account_number'],
					'benName' => $batch_record['beneficiary_name'],
					'benCrAmount' => $batch_record['amount_pay'],
					'batchInputter' => $batch_record['uploader'],
					'batchAuthoriser' => $batch_record['authoriser'],
					'processDate' => $date->format('Y').$date->format('m').$date->format('d'),
					'processTime' => $date->format('H').$date->format('i').$date->format('s')
				);

				$api_txn_count++;
				if($api_txn_count == $this->config->item('api_txn_limit')) {
					
					$resp = apiBuilkUpload(array(
						'processType' => $this->config->item('api_process_type'),
						'BatchNumber' => $batch_file['batch_number'],
						'BatchAmount' => $batch_file['batch_amount'],
						'NoOfPayment' => $batch_file['total_records'],
						'batchDate' => $date->format('Y').$date->format('m').$date->format('d'),
						'txnReferences' => $api_txn_data
					));

					if(isset($resp['server_error']) && $resp['server_error']) {
                        writeLog('*****cronjob processPendingBatchFile failed:'.$resp['error_message']);
						return;
					}
	
					if(isset($resp['error'])) {
                        writeLog('*****cronjob processPendingBatchFile failed:'.$resp['error'].' '.$resp['path']);
						return;
					}


					if(isset($resp['txnReferences'])) {
						foreach($resp['txnReferences'] as $txn_reference) {
							$this->BatchRecords->updateApiResult(array(
								'PaymentSeq' => $txn_reference['PaymentSeq'],
								'txnRef' => $txn_reference['txnRef'],
								'txn_purpose' => $batch_file['submit_purpose'],
								'rcvStatus' => $txn_reference['rcvStatus'],
								'statusCode' => $txn_reference['statusCode'],
								'errorMsg' => $txn_reference['errorMsg'],
							));
						}
					}
					else {
                        writeLog('*****cronjob processPendingBatchFile failed: No get Response from API');
						return;
					}
	
					$api_txn_count = 0;
					$api_txn_data = array();
					continue;
				}					
			}

			if(count($api_txn_data) > 0) {
				$resp = apiBuilkUpload(array(
					'processType' => $this->config->item('api_process_type'),
					'BatchNumber' => $batch_file['batch_number'],
					'BatchAmount' => $batch_file['batch_amount'],
					'NoOfPayment' => $batch_file['total_records'],
					'batchDate' => $date->format('Y').$date->format('m').$date->format('d'),
					'txnReferences' => $api_txn_data
				));

				if(isset($resp['server_error']) && $resp['server_error']) {
                    writeLog('*****cronjob processPendingBatchFile failed:'.$resp['error_message']);
					return;
				}

				if(isset($resp['error'])) {
                    writeLog('*****cronjob processPendingBatchFile failed:'.$resp['error'].' '.$resp['path']);
					return;
				}

				if(isset($resp['txnReferences'])) {
					foreach($resp['txnReferences'] as $txn_reference) {
						$this->BatchRecords->updateApiResult(array(
							'PaymentSeq' => $txn_reference['PaymentSeq'],
							'txnRef' => $txn_reference['txnRef'],
							'txn_purpose' => $batch_file['submit_purpose'],
							'rcvStatus' => $txn_reference['rcvStatus'],
							'statusCode' => $txn_reference['statusCode'],
							'errorMsg' => $txn_reference['errorMsg'],
						));
					}
				}
				else {
                    writeLog('*****cronjob processPendingBatchFile failed: No get Response from API');
					return;
				}
			}

            writeLog('*****cronjob processPendingBatchFile finish:'.$batch_file['id']);

        }
    }
}