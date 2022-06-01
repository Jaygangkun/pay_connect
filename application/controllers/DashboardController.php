<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

	public function __construct(){
		
        parent::__construct();

		$this->load->model("BatchFiles");
		$this->load->model("BatchRecords");
		$this->load->model("Participants");
		$this->load->model("EmailServers");
		$this->load->model("Gateways");
		$this->load->model("Users");
		$this->load->model("UserActivities");
		$this->load->model("Departments");

		$this->load->library('mailer');
	}

	public function pageFileUpload(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'File Upload';
		$data['sub_page'] = 'file-upload';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageManualCapture(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Manual Capture';
		$data['sub_page'] = 'manual-capture';

		$data['departments'] = $this->Departments->all();
		$data['participants'] = $this->Participants->all();

		$this->load->view('dashboard/basic', $data);
	}

	public function pageSchedulePayments(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Schedule Payments';
		$data['sub_page'] = 'schedule-payments';

		$this->load->view('dashboard/basic', $data);
	}

	public function pagePaymentActivity(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Payment Activity';
		$data['sub_page'] = 'payment-activity';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageParticipants(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Participants';
		$data['sub_page'] = 'participants';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageBatchFileView($batch_file_id){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'BatchFile View';
		$data['sub_page'] = 'batch-file-view';

		$data['batch_file'] = $this->BatchFiles->getByID($batch_file_id);
		$data['batch_file_id'] = $batch_file_id;
		
		$this->load->view('dashboard/basic', $data);
	}

	public function pageTransactions(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Transactions';
		$data['sub_page'] = 'payment-activity';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageEmailServer(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Email Server';
		$data['sub_page'] = 'email-server';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageAPIGateways(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'API Gateway';
		$data['sub_page'] = 'api-gateways';

		$this->load->view('dashboard/basic', $data);
	}

	public function pageUsers(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}
		
		$data = array();
		$data['title'] = 'User Activity';
		$data['sub_page'] = 'users';

		$data['departments'] = $this->Departments->all();

		$this->load->view('dashboard/basic', $data);
	}

	public function pageUserActivities(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();
		$data['title'] = 'Users';
		$data['sub_page'] = 'user-activities';

		$this->load->view('dashboard/basic', $data);
	}

	public function apiUpload()	 {
		$uploaddir = 'uploads/';
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		
		if($this->BatchFiles->existBatchFileName($_FILES['file']['name'])) {
			$this->output->set_status_header('400'); //Triggers the jQuery error callback
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('error' => 'Filename already exists!'))); //Triggers the jQuery error callback
			return;
		}

		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			// echo "File is valid, and was successfully uploaded.\n";
			
			$lines = [];
			$file = fopen($uploadfile, 'r');              // Open the file                     
			while (($line = fgetcsv($file)) !== FALSE) {    // Read one line
				$lines[] = $line;                            // Add the line in the main array
			}
			fclose($file);

			$line_index = 0;
			$account = '';
			$date = '';
			$batch_number = '';
			$batch_amount = '';
			$currency = '';
			$total_records = '';

			$batch_file_id = null;

			$batch_files_add_item = [];
			$batch_records_add_list = [];

			$bic_error = false;
			$bic_missing_list = [];

			$department_error = false;
			$department_missing_list = [];

			$records_amount_sum = 0;
			$batch_total_amount = 0;
			foreach($lines as $line) {

				if($line_index == 0) {
					$account = $line[1];
					$date = $line[2];
					// $batch_number = $line[3];
					$batch_number = genBatchNumber();
					$batch_amount = $line[4];
					$currency = $line[5];
					$total_records = $line[6];

					if($this->BatchFiles->existBatchNumber($batch_number)) {
						$this->output->set_status_header('400'); //Triggers the jQuery error callback
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('error' => 'Batch number already exists!'))); //Triggers the jQuery error callback
						return;
					}

					if($total_records != count($lines) - 1) {
						$this->output->set_status_header('400'); //Triggers the jQuery error callback
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('error' => 'Total records not same!'))); //Triggers the jQuery error callback
						return;
					}

					$batch_files_add_item = array(
						'file_name' => $_FILES['file']['name'],
						'batch_number' => $batch_number,
						'account' => $account,
						'date' => $date,
						'batch_amount' => $batch_amount,
						'currency' => $currency,
						'total_records' => $total_records,
						'status' => 'Uploaded',
					);
					$batch_total_amount = floatval($batch_amount);
					$line_index ++;
					continue;
				}

				// $transaction_ref = refGenerate();
				// $transaction_ref = genTransactionRef();

				// check bic code
				
				if(!$this->Participants->existBicSwiftCode($line[6])) {
					$bic_error = true;

					if(!in_array($line[6], $bic_missing_list)) {
						$bic_missing_list[] = $line[6];
					}
					
				}

				if(!$this->Departments->existDepartment($line[4])) {
					$department_error = true;

					if(!in_array($line[4], $department_missing_list)) {
						$department_missing_list[] = $line[4];
					}
					
				}

				$batch_records_add_list[] = array(
					'payment_seq' => $line_index,
					// 'transaction_ref' => $transaction_ref,
					'beneficiary_name' => $line[1],
					'account_number' => $line[2],
					'amount_pay' => $line[3],
					'department' => $line[4],
					'benef_bank' => $line[5],
					'bank_biccode' => $line[6],
					'status' => '', 
				);

				$records_amount_sum += floatval($line[3]);
				$line_index++;
			}

			// check total amount
			if($records_amount_sum != $batch_total_amount) {
				$this->output->set_status_header('400'); //Triggers the jQuery error callback
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('error' => 'Total Amount on Batch is wrong!'))); //Triggers the jQuery error callback
				return;
			}

			$error_message = '';
			if($bic_error) {
				$error_message = 'BICCode is Missing!<br>'.implode(',', $bic_missing_list);
			}

			if($department_error) {
				if($error_message == '') {
					$error_message = 'Department is Missing!<br>'.implode(',', $department_missing_list);
				}
				else {
					$error_message .= '<br>Department is Missing!<br>'.implode(',', $department_missing_list);
				}
				
			}

			if($error_message != '') {
				$this->output->set_status_header('400'); //Triggers the jQuery error callback
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('error' => $error_message))); //Triggers the jQuery error callback
				return;
			}


			$batch_file_id = $this->BatchFiles->add($batch_files_add_item);

			foreach($batch_records_add_list as $batch_records_add_item) {
				$new_batch_records_add_item = $batch_records_add_item;
				$new_batch_records_add_item['batch_file_id'] = $batch_file_id;
				$new_batch_records_add_item['transaction_ref'] = genTransactionRef($batch_file_id);

				$this->BatchRecords->add($new_batch_records_add_item);
			}

			echo json_encode(array(
				'success' => true
			));
			// echo json_encode(array(
			// 	'id' => $batch_file_id,
			// 	'batch_number' => $batch_number,
			// 	'account' => $account,
			// 	'date' => $date,
			// 	'batch_amount' => $batch_amount,
			// 	'currency' => $currency,
			// 	'total_records' => $total_records,
			// 	'status' => '', 
			// ));
		} else {
			$this->output->set_status_header('400'); //Triggers the jQuery error callback
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('error' => 'File uploading failed!'))); //Triggers the jQuery error callback
		}

	}

	public function apiDeleteBatchFile() {
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		if($id) {
			$this->BatchFiles->deleteByID($id);
			echo json_encode(array(
				'success' => true
			));
		}
		else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Batch file ID empty'
			));
		}
	}

	public function apiSubmitBatchFile() {
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		if($id) {
			$batch_file = $this->BatchFiles->getByID($id);
			$batch_records = $this->BatchRecords->loadByBatchFileID($id);

			$batch_file_submit_error = false;
			$batch_record_index = 1;
			foreach($batch_records as $batch_record) {
				$date = new DateTime();
				$resp = apiBuilkUpload(array(
					'process_type' => $this->config->item('api_process_type'),
					'batch_number' => $batch_file['batch_number'],
					'no_of_payment' => $batch_file['total_records'],
					'payment_seq' => $batch_record_index,
					'payment_seq' => $batch_record['payment_seq'],
					'batch_date' => $batch_file['date'],
					'txn_ref' => $batch_record['transaction_ref'],
					'txn_curr' => $batch_file['currency'],
					'settlement_date' => $date->format('Y').$date->format('m').$date->format('d'),
					'ord_cust_account' => '',
					'ord_cust_name' => '',
					'department' => $batch_record['department'],
					'txn_purpose' => '',
					'ben_bank_bic' => $batch_record['bank_biccode'],
					'ben_account' => $batch_record['account_number'],
					'ben_name' => $batch_record['beneficiary_name'],
					'ben_cr_amount' => $batch_record['amount_pay'],
					'batch_inputter' => $this->config->item('api_batch_inputter'),
					'batch_authoriser' => $this->config->item('api_batch_authoriser'),
					'process_date' => $date->format('Y').$date->format('m').$date->format('d'),
					'process_time' => $date->format('H').$date->format('i').$date->format('s')
				));

				if(isset($resp['server_error']) && $resp['server_error']) {
					echo json_encode(array(
						'success' => false,
						'message' => $resp['error_message']
					));
					return;
				}

				if($resp['statusCode'] == '77') {
					$batch_file_submit_error = true;
				}

				$this->BatchRecords->updateApiResult(array(
					'id' => $batch_record['id'],
					'status' => $resp['statusCode'] == '77' ? 2 : 1,
					'resp_rcvStatus' => $resp['rcvStatus'],
					'resp_errorMsg' => $resp['errorMsg']
				));

				$batch_record_index++;
			}

			// $this->BatchFiles->updateSubmitResult(array(
			// 	'id' => $batch_file['id'],
			// 	'status' => $batch_file_submit_error ? 'Error' : 'Submitted',
			// ));

			$this->BatchFiles->updateStatus($id, 'SUBMITTED');

			$this->UserActivities->add(array(
				'user_id' => $_SESSION['user']['id'],
				'ip' => getIP(),
				'activity' => 'submit'
			));

			echo json_encode(array(
				'success' => true,
			));
		}
		else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Batch file ID empty'
			));
		}
	}

	public function apiAuthoriseBatchFile() {
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		if($id) {
			$this->BatchFiles->updateStatus($id, 'AUTHORISED');
			$this->BatchRecords->updateStatusByBatchFile($id, 'AUTHORISED');

			$this->UserActivities->add(array(
				'user_id' => $_SESSION['user']['id'],
				'ip' => getIP(),
				'activity' => 'authorise'
			));

			echo json_encode(array(
				'success' => true,
			));
		}
		else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Batch file ID empty'
			));
		}
	}

	public function apiLoadBatchFiles() {
		$resp = array(
			'data' => []
		);

		$batch_files = $this->BatchFiles->all();
		$batch_file_index = 1;
		foreach($batch_files as $batch_file) {
			$resp['data'][] = array(
				$batch_file_index,
				$batch_file['account'],
				$batch_file['date'],
				$batch_file['batch_number'],
				$batch_file['batch_amount'],
				$batch_file['currency'],
				$batch_file['total_records'],
				'<span class="text-capitalize">'.$batch_file['status']."</span>",
				'<div class="btn-group-wrap d-flex align-items-center">
					<div class="btn-group btn-group-actions">
						<button type="button" class="btn btn-default">Action</button>
						<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu" role="menu">
							<span class="dropdown-item action-view" data-id="'.$batch_file['id'].'">View</span>
							<span class="dropdown-item action-delete" data-id="'.$batch_file['id'].'" data-status="'.$batch_file['status'].'">Delete</span>
							<span class="dropdown-item action-authorise" data-id="'.$batch_file['id'].'" data-status="'.$batch_file['status'].'">Authorise</span>
							<span class="dropdown-item action-submit" data-id="'.$batch_file['id'].'" data-status="'.$batch_file['status'].'">Submit</span>
						</div>
					</div>
					<div class="actions-loading-wrap">
						<div class="actions-loader"></div>
					</div>
				</div>',
			);

			$batch_file_index++;
		}

		echo json_encode($resp);
	}

	public function apiLoadBatchRecords($batch_file_id) {
		$resp = array(
			'data' => []
		);

		$batch_records = $this->BatchRecords->loadByBatchFileID($batch_file_id);
		foreach($batch_records as $batch_record) {
			$resp['data'][] = array(
				$batch_record['transaction_ref'],
				$batch_record['beneficiary_name'],
				$batch_record['account_number'],
				$batch_record['amount_pay'],
				$batch_record['department'],
				$batch_record['benef_bank'],
				$batch_record['bank_biccode'],
				$batch_record['resp_rcvStatus']
			);

		}

		echo json_encode($resp);
	}

	public function apiLoadBatchFilesSubmitted() {
		$resp = array(
			'data' => []
		);

		$batch_files = $this->BatchFiles->allScheduled(); // submitted or authorized
		$batch_file_index = 1;
		foreach($batch_files as $batch_file) {
			$resp['data'][] = array(
				$batch_file_index,
				$batch_file['account'],
				$batch_file['date'],
				$batch_file['batch_number'],
				$batch_file['batch_amount'],
				$batch_file['currency'],
				$batch_file['total_records'],
				'<span class="text-capitalize">'.$batch_file['status']."</span>",
				'<div class="btn-group-wrap d-flex align-items-center">
					<div class="btn-group btn-group-actions">
						<button type="button" class="btn btn-default">Action</button>
						<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu" role="menu">
							<span class="dropdown-item action-view" data-id="'.$batch_file['id'].'">View</span>
							<span class="dropdown-item action-delete" data-id="'.$batch_file['id'].'" data-status="'.$batch_file['status'].'">Delete</span>
							<span class="dropdown-item action-authorise" data-id="'.$batch_file['id'].'" data-status="'.$batch_file['status'].'">Authorise</span>
							<span class="dropdown-item action-resubmit" data-id="'.$batch_file['id'].'" >Resubmit</span>
						</div>
					</div>
					<div class="actions-loading-wrap">
						<div class="actions-loader"></div>
					</div>
				</div>'
			);

			$batch_file_index++;
		}

		echo json_encode($resp);
	}

	public function apiLoadPaymentActivities() {
		$resp = array(
			'data' => []
		);

		$date_from = null;
		$date_to = null;

		if(isset($_GET['date_from']) && $_GET['date_from'] != '') {
			$date_from = $_GET['date_from'];
		}

		if(isset($_GET['date_to']) && $_GET['date_to'] != '') {
			$date_to = $_GET['date_to'];
		}

		$batch_files = $this->BatchFiles->allByDate($date_from, $date_to); // submitted or authorized

		$batch_file_index = 1;
		foreach($batch_files as $batch_file) {
			$resp['data'][] = array(
				$batch_file_index,
				$batch_file['account'],
				$batch_file['date'],
				$batch_file['batch_number'],
				$batch_file['batch_amount'],
				$batch_file['currency'],
				$batch_file['total_records'],
				$batch_file['status'],
				$batch_file['id'],
			);

			$batch_file_index++;
		}

		echo json_encode($resp);
	}

	public function apiUploadManual() {
		$batch_ref = isset($_POST['batch_ref']) ? $_POST['batch_ref'] : '';
		$transaction_ref = isset($_POST['transaction_ref']) ? $_POST['transaction_ref'] : '';
		$account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
		$beneficiary_name = isset($_POST['beneficiary_name']) ? $_POST['beneficiary_name'] : '';
		$department = isset($_POST['department']) ? $_POST['department'] : '';
		$benef_bank = isset($_POST['benef_bank']) ? $_POST['benef_bank'] : '';
		$bank_biccode = isset($_POST['bank_biccode']) ? $_POST['bank_biccode'] : '';
		$amount_pay = isset($_POST['amount_pay']) ? $_POST['amount_pay'] : '';

		if($batch_ref == '') {
			echo json_encode(array(
				'success' => false,
				'message' => 'Batch Ref Number empty'
			));
			return;
		}

		$batch_file_id = $this->BatchFiles->addRefID($batch_ref);
		$payment_seq = count($this->BatchRecords->loadByBatchFileID($batch_file_id)) + 1;

		$this->BatchRecords->add(array(
			'batch_file_id' => $batch_file_id,
			'payment_seq' => $payment_seq,
			'transaction_ref' => $transaction_ref,
			'beneficiary_name' => $beneficiary_name,
			'account_number' => $account_number,
			'amount_pay' => $amount_pay,
			'department' => $department,
			'benef_bank' => $benef_bank,
			'bank_biccode' => $bank_biccode,
			'status' => '1', 
		));

		$date = new DateTime();
		$this->BatchFiles->manualSubmit(array(
			'id' => $batch_file_id,
			'batch_amount' => $amount_pay == '' ? 0 : $amount_pay,
			'currency' => 'USD',
			'total_records' => $payment_seq,
			'date' => $date->format('m')."/".$date->format('d')."/".$date->format('Y')
		));

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiParticipantAdd() {

		if($this->Participants->existBicSwiftCode(isset($_POST['bic_swift_code']) ? $_POST['bic_swift_code'] : '')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'BIC/SWIFT Code already exists!'
			));
		}
		else {
			$this->Participants->add(array(
				'bic_swift_code' => isset($_POST['bic_swift_code']) ? $_POST['bic_swift_code'] : '',
				'sort_code' => isset($_POST['sort_code']) ? $_POST['sort_code'] : '',
				'account_number' => isset($_POST['account_number']) ? $_POST['account_number'] : '',
				'short_name' => isset($_POST['short_name']) ? $_POST['short_name'] : '',
				'participant_name' => isset($_POST['participant_name']) ? $_POST['participant_name'] : '',
				'account_number' => isset($_POST['account_number']) ? $_POST['account_number'] : '',
				'status' => isset($_POST['status']) ? $_POST['status'] : ''
			));

			echo json_encode(array(
				'success' => true
			));
		}
	}

	public function apiParticipantUpdate() {

		if($this->Participants->existBicSwiftCode(isset($_POST['bic_swift_code']) ? $_POST['bic_swift_code'] : '')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'BIC/SWIFT Code already exists!'
			));
		}
		else {
			$this->Participants->update(array(
				'id' => isset($_POST['participant_id']) ? $_POST['participant_id'] : '',
				'bic_swift_code' => isset($_POST['bic_swift_code']) ? $_POST['bic_swift_code'] : '',
				'sort_code' => isset($_POST['sort_code']) ? $_POST['sort_code'] : '',
				'account_number' => isset($_POST['account_number']) ? $_POST['account_number'] : '',
				'short_name' => isset($_POST['short_name']) ? $_POST['short_name'] : '',
				'participant_name' => isset($_POST['participant_name']) ? $_POST['participant_name'] : '',
				'account_number' => isset($_POST['account_number']) ? $_POST['account_number'] : '',
				'status' => isset($_POST['status']) ? $_POST['status'] : ''
			));

			echo json_encode(array(
				'success' => true
			));
		}
	}

	public function apiParticipantDelete() {
		$this->Participants->deleteByID(isset($_POST['participant_id']) ? $_POST['participant_id'] : '');

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiParticipantsLoad() {
		$resp = array(
			'data' => []
		);

		$participants = $this->Participants->all();

		foreach($participants as $participant) {
			$resp['data'][] = array(
				$participant['short_name'],
				$participant['participant_name'],
				$participant['sort_code'],
				$participant['bic_swift_code'],
				$participant['account_number'],
				"<span class='text-uppercase text-".statusColor($participant['status'])."'>".$participant['status']."</span>",
				$participant['status'],
				$participant['id'],
			);

		}

		echo json_encode($resp);
	}

	public function apiEmailServersLoad() {
		$resp = array(
			'data' => []
		);

		$email_servers = $this->EmailServers->all();

		$email_server_index = 1;
		foreach($email_servers as $email_server) {
			$resp['data'][] = array(
				$email_server_index,
				$email_server['host'],
				$email_server['user'],
				$email_server['sender'],
				$email_server['port'],
				$email_server['ssl_tls'] == 1 ? "<div class='text-center text-primary'><i class='fas fa-check'></i></div>" : "",
				$email_server['default'] == 1 ? "<div class='text-center text-primary'><i class='fas fa-check'></i></div>" : "",
				"<span class='btn btn-danger btn-delete' server-id='".$email_server['id']."'>Delete</span>",
				$email_server['password'],
				$email_server['ssl_tls'] == 1 ? true : false,
				$email_server['default'] == 1 ? true : false,
				$email_server['id'],
			);

			$email_server_index++;
		}

		echo json_encode($resp);
	}

	public function apiEmailServerAdd() {

		$this->EmailServers->add(array(
			'host' => isset($_POST['host']) ? $_POST['host'] : '',
			'port' => isset($_POST['port']) ? $_POST['port'] : '',
			'user' => isset($_POST['user']) ? $_POST['user'] : '',
			'password' => isset($_POST['password']) ? $_POST['password'] : '',
			'sender' => isset($_POST['sender']) ? $_POST['sender'] : '',
			'ssl_tls' => isset($_POST['ssl_tls']) ? $_POST['ssl_tls'] : '',
			'default' => isset($_POST['default']) ? $_POST['default'] : ''
		));

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiEmailServerDelete() {
		$this->EmailServers->deleteByID(isset($_POST['server_id']) ? $_POST['server_id'] : '');

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiEmailServerUpdate() {
		$this->EmailServers->update(array(
			'id' => isset($_POST['email_server_id']) ? $_POST['email_server_id'] : '',
			'host' => isset($_POST['host']) ? $_POST['host'] : '',
			'port' => isset($_POST['port']) ? $_POST['port'] : '',
			'user' => isset($_POST['user']) ? $_POST['user'] : '',
			'password' => isset($_POST['password']) ? $_POST['password'] : '',
			'sender' => isset($_POST['sender']) ? $_POST['sender'] : '',
			'ssl_tls' => isset($_POST['ssl_tls']) ? $_POST['ssl_tls'] : '',
			'default' => isset($_POST['default']) ? $_POST['default'] : ''
		));

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiGatewaysLoad() {
		$resp = array(
			'data' => []
		);

		$gateways = $this->Gateways->all();

		foreach($gateways as $gateway) {
			$resp['data'][] = array(
				$gateway['short_name'],
				$gateway['description'],
				$gateway['direction'],
				$gateway['endpoint'],
				"<span class='text-uppercase text-".statusColor($gateway['status'])."'>".$gateway['status']."</span>",
				"<span class='btn btn-danger btn-delete' gateway-id='".$gateway['id']."'>Delete</span>",
				$gateway['status'],
				$gateway['id'],
				$gateway['auth'],
			);
		}

		echo json_encode($resp);
	}

	public function apiGatewayAdd() {

		$this->Gateways->add(array(
			'short_name' => isset($_POST['short_name']) ? $_POST['short_name'] : '',
			'description' => isset($_POST['description']) ? $_POST['description'] : '',
			'endpoint' => isset($_POST['endpoint']) ? $_POST['endpoint'] : '',
			'auth' => isset($_POST['auth']) ? $_POST['auth'] : '',
			'direction' => isset($_POST['direction']) ? $_POST['direction'] : '',
			'status' => isset($_POST['status']) ? $_POST['status'] : ''
		));

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiGatewayDelete() {
		$this->Gateways->deleteByID(isset($_POST['gateway_id']) ? $_POST['gateway_id'] : '');

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiGatewayUpdate() {
		$this->Gateways->update(array(
			'id' => isset($_POST['gateway_id']) ? $_POST['gateway_id'] : '',
			'short_name' => isset($_POST['short_name']) ? $_POST['short_name'] : '',
			'description' => isset($_POST['description']) ? $_POST['description'] : '',
			'endpoint' => isset($_POST['endpoint']) ? $_POST['endpoint'] : '',
			'auth' => isset($_POST['auth']) ? $_POST['auth'] : '',
			'direction' => isset($_POST['direction']) ? $_POST['direction'] : '',
			'status' => isset($_POST['status']) ? $_POST['status'] : ''
		));

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiUsersLoad() {
		$resp = array(
			'data' => []
		);

		$users = $this->Users->all();
		$user_index = 1;

		foreach($users as $user) {
			$roles = explode(',', $user['role']);
			$role_html = '';
			foreach($roles as $role) {
				$role_html .= '<span class="badge badge-success text-uppercase mr-1">'.roleName($role).'</span>';
			}
			
			$resp['data'][] = array(
				$user_index,
				$user['user_name'],
				$user['full_name'],
				$user['email'],
				$user['name'],
				$role_html,
				strtolower($user['status']) == 'active' ? 
				"<span class='btn btn-danger btn-deactivate' user-id='".$user['id']."'>Deactivate</span>"
				:
				"<span class='btn btn-success btn-activate' user-id='".$user['id']."'>Activate</span>",
			);

			$user_index++;
		}

		echo json_encode($resp);
	}

	public function apiUserAdd() {

		if($this->Users->exist(isset($_POST['user_name']) ? $_POST['user_name'] : '', isset($_POST['email']) ? $_POST['email'] : '')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'same username and email already exist!',
			));
			return;
		}

		if($this->Users->existEmail(isset($_POST['email']) ? $_POST['email'] : '')) {
			echo json_encode(array(
				'success' => false,
				'message' => 'same email already exist!',
			));
			return;
		}
		
		
		$this->Users->add(array(
			'user_name' => isset($_POST['user_name']) ? $_POST['user_name'] : '',
			'full_name' => isset($_POST['full_name']) ? $_POST['full_name'] : '',
			'email' => isset($_POST['email']) ? $_POST['email'] : '',
			'role' => isset($_POST['role']) ? implode(',', $_POST['role']) : '',
			'department' => isset($_POST['department']) ? $_POST['department'] : '',
			'comments' => isset($_POST['comments']) ? $_POST['comments'] : '',
			'status' => isset($_POST['status']) ? $_POST['status'] : ''
		));

		if(isset($_POST['email'])) {
			// $url = base_url('/login');
			$username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
			$password = $this->config->item('user_password_default');
			sendMail($_POST['email'], 'Added User', 'User added<br>username:'.$username."<br>password:".$password);
		}

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiUserChangeActive() {
		$this->Users->updateStatus(isset($_POST['user_id']) ? $_POST['user_id'] : '', isset($_POST['status']) ? $_POST['status'] : '');

		echo json_encode(array(
			'success' => true
		));
	}

	public function apiLoadUserActivities() {
		$resp = array(
			'data' => []
		);

		$date_from = null;
		$date_to = null;

		if(isset($_GET['date_from']) && $_GET['date_from'] != '') {
			$date_from = $_GET['date_from'];
		}

		if(isset($_GET['date_to']) && $_GET['date_to'] != '') {
			$date_to = $_GET['date_to'];
		}

		// $this->UserActivities->add(array(
		// 	'user_id' => 1,
		// 	'ip' => '172.16.1.45',
		// 	'activity' => 1
		// ));

		$user_activities = $this->UserActivities->allByDate($date_from, $date_to); // submitted or authorized

		$user_activity_index = 1;
		foreach($user_activities as $user_activity) {
			$resp['data'][] = array(
				$user_activity_index,
				$user_activity['full_name'],
				$user_activity['ip'],
				$user_activity['date'],
				"<span class='text-uppercase'>".$user_activity['activity']."</span>",
			);

			$user_activity_index++;
		}

		echo json_encode($resp);
	}

	public function apiDepartmentAdd() {
		$this->Departments->add(array(
			'name' => isset($_POST['name']) ? $_POST['name'] : ''
		));

		$departments = $this->Departments->all();
		$html = '';
		foreach($departments as $department) {
			$html .= '<option value="'.$department['id'].'">'.$department['name'].'</option>';
		}

		$html .= '<option value="-1">OTHERS</option>';

		echo json_encode(array(
			'success' => true,
			'html' => $html
		));
	}

	public function apiAutoLogout() {
		if(isset($_POST['user_id'])) {
			$this->UserActivities->add(array(
				'user_id' => $_POST['user_id'],
				'ip' => getIP(),
				'activity' => 'logout'
			));
	
			$this->Users->updateLoginStatus($_POST['user_id'], 0);

			unset($_SESSION['user']);
			
			echo json_encode(array(
				'success' => false
			));
		}
	}
}
