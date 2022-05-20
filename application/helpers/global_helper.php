<?php

// include(APPPATH.'libraries/simple_html_dom.php');

require_once APPPATH."libraries/PHPMailer/Exception.php";
require_once APPPATH."libraries/PHPMailer/PHPMailer.php";
require_once APPPATH."libraries/PHPMailer/SMTP.php";

use Dompdf\Dompdf;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!function_exists('writeLog')){
    function writeLog($log){
		$fp = fopen('logs.txt', 'a');
		fwrite($fp, date('y-m-j h:i:s       ').$log.PHP_EOL);  
		fclose($fp);  
	}
}

if(!function_exists('config')){
    function config($item){
		$ci=& get_instance();
		return $ci->config->item($item);
	}
}

if(!function_exists('sendMail')){
    function sendMail($to, $subject, $body){
		$ci =& get_instance();
		$ci->load->database();
		$sql = "SELECT * FROM email_servers WHERE default='1'";
		$q = $ci->db->query($sql);
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $data)
			{
// 				echo $data->ssl_tls ? 'ssl'."<br>" : ''."<br>";
// continue;
				$mail = new PHPMailer();

				$mail->IsSMTP();
				$mail->Host = $data->host;
				$mail->Port = $data->port;
				$mail->SMTPAuth = true;
				$mail->Username = $data->user;
				$mail->Password = $data->password;
				$mail->SMTPSecure = $data->ssl_tls ? 'ssl' : '';
				$mail->SMTPDebug  = 0;  
				$mail->SMTPAuth   = TRUE;

				$mail->isHTML();

				$mail->From = $data->user;
				$mail->FromName = $data->sender;

				$mail->Subject = $subject;
				$mail->Body    = $body;
				$mail->AddAddress($to);

				if(!$mail->Send()) {
					// echo $mail->ErrorInfo;
					writeLog("sendMail fail:".$data->host);
					writeLog($mail->ErrorInfo);
					return false;
				}
				writeLog("sendMail success:".$data->host);
				return true;
			}
		}
	}
}

if(!function_exists('getIP')){
    function getIP(){
		$ipaddress = getenv("REMOTE_ADDR") ;
		return $ipaddress;
	}
}

if(!function_exists('refGenerate')){
    function refGenerate(){
		return uniqid();
	}
}

if(!function_exists('roleName')){
    function roleName($role){
		switch($role) {
			case '1': return 'Admin';
			case '2': return 'Supervisor';
			case '3': return 'Authoriser';
			case '4': return 'Uploader';
		}
	}
}

if(!function_exists('ableAuthorise')){
    function ableAuthorise($role){
		$roles = explode(',', $role);
		foreach($roles as $role) {
			if($role == 4) { //uploader
				continue;
			}
			else {
				return true;
			}
		}

		return false;
	}
}

if(!function_exists('ableSubmit')){
    function ableSubmit($role){
		$roles = explode(',', $role);
		foreach($roles as $role) {
			if($role == 4) { // uploader
				continue;
			}
			else {
				return true;
			}
		}

		return false;
	}
}

if(!function_exists('ableUpload')){
    function ableUpload($role){
		$roles = explode(',', $role);
		foreach($roles as $role) {
			if($role == 3) { // authoriser
				continue;
			}
			else {
				return true;
			}
		}

		return false;
	}
}

if(!function_exists('activityCode')){
    function activityCode($name){
		switch(strtolower($name)) {
			case 'login': return 1;
			case 'upload': return 2;
			case 'submit': return 3;
		}
	}
}

if(!function_exists('activityName')){
    function activityName($code){
		switch($code) {
			case '1': return 'Login';
			case '2': return 'Upload';
			case '3': return 'Submit';
		}
	}
}

if(!function_exists('statusName')){
    function statusName($status){
		switch($status) {
			case '1': return 'Submitted';
			case '2': return 'Error';
			case '3': return 'Pending';
			case '4': return 'Authorised';
			case '5': return 'Processed';
			case '6': return 'Partial';
			case '7': return 'Acked';
			case '8': return 'In Progress';

			case '20': return 'Active';
			case '21': return 'Suspended';
			case '22': return 'Insolvent';
			case '23': return 'Liquidated';

			case '30': return 'Active';
			case '31': return 'Suspended';
		}
	}
}

if(!function_exists('statusColor')){
    function statusColor($status){
		switch(strtolower($status)) {
			case 'submitted': return 'primary';
			case 'error': return 'danger';
			case 'pending': return 'pending';
			case 'authorised': return 'success';
			case 'processed': return 'success';
			case 'partial': return 'pending';
			case 'acked': return 'primary';
			case 'in progress': return 'primary';

			case 'active': return 'primary';
			case 'suspended': return 'danger';
			case 'insolvent': return 'pending';
			case 'liquidated': return 'secondary';
		}
	}
}

if(!function_exists('apiBuilkUpload')){
    function apiBuilkUpload($api_url, $data){		
		$ci =& get_instance();
		$ci->load->database();
		$sql = "SELECT * FROM gateways WHERE status='Active'";
		$q = $ci->db->query($sql);
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $data)
			{
				$curl = curl_init();
		
				$post_fields = json_encode(array(
					"processType" => $data['process_type'],
					"BatchNumber" => $data['batch_number'],
					"NoOfPayment" => $data['no_of_payment'],
					"PaymentSeq" => $data['payment_seq'],
					"batchDate" => $data['batch_date'],
					"txnRef" => $data['txn_ref'],
					"txnCurr" => $data['txn_curr'],
					"settlementDate" => $data['settlement_date'],
					"ordCustAccount" => $data['ord_cust_account'],
					"ordCusName" => $data['ord_cust_name'],
					"txnPurpose" => $data['txn_purpose'],
					"benBankBIC" => $data['ben_bank_bic'],
					"benAccount" => $data['ben_account'],
					"benName" => $data['ben_name'],
					"benCrAmount" => $data['ben_cr_amount'],
					"batchInputter" => $data['batch_inputter'],
					"batchAuthoriser" => $data['batch_authoriser'],
					"processDate" => $data['process_date'],
					"processTime" => $data['process_time']
				));
				// $post_fields = str_replace('\"', '"', $post_fields);
		
				curl_setopt_array($curl, array(
					CURLOPT_URL => $data->endpoint,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYHOST=> false,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS =>$post_fields,
					CURLOPT_HTTPHEADER => array(
						'Authorization: '.$data->auth,
						'Content-Type: text/plain',
						'Cookie: JSESSIONID=F6D1AB7C27064B724868303B94CCB76D'
					),
				));
		
				$response = curl_exec($curl);
		
				writeLog('>>>>>>>>post_fields');
				writeLog($post_fields);
				writeLog('>>>>>>>>response');
				writeLog($response);
				writeLog('>>>>>>>>error');
				writeLog(curl_error($curl));
				writeLog('<<<<<<<<');
		
				curl_close($curl);
		
				return json_decode($response, true);		
			}
		}

	}
}

?>