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
		$sql = "SELECT * FROM email_servers WHERE `default`='1'";
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
    function roleName($roles, $role_id){
		foreach($roles as $role) {
			if($role['id'] == $role_id) {
				return $role['name'];
			}
		}
		return $role_id;
	}
}

if(!function_exists('isAdmin')){
    function isAdmin($roles_str){
		$roles = explode(',', $roles_str);
		foreach($roles as $role) {
			if($role == 1) {
				return true;
			}
		}
		return false;
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
    function apiBuilkUpload($data){		
		set_time_limit(0);
		$ci =& get_instance();
		$ci->load->database();
		$sql = "SELECT * FROM gateways WHERE status='Active'";
		$q = $ci->db->query($sql);
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $gateway)
			{
				$curl = curl_init();
		
				$post_fields = json_encode(array(
					"processType" => $data['processType'],
					"BatchNumber" => $data['BatchNumber'],
					"BatchAmount" => $data['BatchAmount'],
					"NoOfPayment" => $data['NoOfPayment'],
					"batchDate" => $data['batchDate'],
					"txnReferences" => $data['txnReferences']
				));
				// $post_fields = str_replace('\"', '"', $post_fields);
		
				curl_setopt_array($curl, array(
					CURLOPT_URL => $gateway->endpoint,
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
						'Authorization: '.$gateway->auth,
						'Content-Type: text/json',
						'Cookie: JSESSIONID=F6D1AB7C27064B724868303B94CCB76D'
					),
				));
		
				writeLog('>>>>>>>>api calling'.$gateway->endpoint);
				writeLog('>>>>>>>>post_fields');
				writeLog($post_fields);

				$response = curl_exec($curl);
		
				writeLog('>>>>>>>>response');
				writeLog($response);
				
				if(curl_exec($curl) === false)
				{
					writeLog('>>>>>>>>error');
					writeLog(curl_error($curl));
					writeLog('<<<<<<<<');
					
					return array(
						'server_error' => true,
						'error_message' => curl_error($curl)
					);
				}		

				writeLog('<<<<<<<<');
				curl_close($curl);
		
				return json_decode($response, true);		
			}
		}

	}
}

if(!function_exists('genBatchNumber')){
    function genBatchNumber(){
		$date = new DateTime();
		$DDMMYYYY = $date->format('d').$date->format('m').$date->format('Y');
		$NNNN = 1;

		$ci =& get_instance();
		$ci->load->database();
		$sql = "SELECT count(*) as total FROM batch_files WHERE DATE(`upload_at`)=DATE(NOW())";
		$q = $ci->db->query($sql);
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $batch_files) {
				$NNNN = $batch_files->total + 1;
				break;
			}
		}

		$NNNN = str_pad($NNNN, 4, '0', STR_PAD_LEFT);

		return "MOF".$DDMMYYYY."BP".$NNNN;
	}
}

if(!function_exists('genTransactionRef')){
    function genTransactionRef($batch_file_id, $paramNNN = null){
		$date = new DateTime();
		$DDMMYYYY = $date->format('d').$date->format('m').$date->format('Y');
		$NNNN = 1;
		$batch_ref = null;

		if($batch_file_id != null) {
			$ci =& get_instance();
			$ci->load->database();
			$sql = "SELECT count(*) as total FROM batch_records WHERE `batch_file_id`='".$batch_file_id."'";
			$q = $ci->db->query($sql);
			if($q->num_rows() > 0)
			{
				foreach($q->result() as $batch_files) {
					$NNNN = $batch_files->total + 1;
					break;
				}

			}

			$sql = "SELECT batch_number FROM batch_files WHERE `id`='".$batch_file_id."'";
			$q = $ci->db->query($sql);
			if($q->num_rows() > 0)
			{
				foreach($q->result() as $batch_files) {
					$batch_ref = $batch_files->batch_number;
					break;
				}

			}

		}

		if($batch_ref == null) {
			$batch_ref = genBatchNumber();
		}
		
		if($paramNNN) {
			$NNNN = $paramNNN;
		}

		$NNNN = str_pad($NNNN, 4, '0', STR_PAD_LEFT);

		//RB	return "MOF".$DDMMYYYY.$NNNN;
		return $batch_ref."-".$NNNN;
	}
}

?>