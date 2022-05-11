<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller {

	public function __construct(){
		
        parent::__construct();

		$this->load->model("BatchFiles");
		$this->load->model("Users");
		$this->load->model("UserActivities");

		$this->load->library('mailer');
	}

	public function index(){
		if(!isset($_SESSION['user'])){
			redirect('/login');
		}
		else{
			redirect('/dashboard');
		}
	}

	public function login(){
		// $_SESSION['user_id'] = 1;
		// $_SESSION['role'] = 1;
		// redirect(base_url('/dashboard'), 'refresh');
		// return;
		if($this->input->post('submit')){

			if($this->input->post('user_name') == '' || $this->input->post('password') == '') {
				$this->session->set_flashdata('warning', 'Please input both user name and password!');
				redirect(base_url('/login'));
			}

			if(!$this->Users->checkLogin($this->input->post('user_name'), $this->input->post('password'))) {
				$this->session->set_flashdata('warning', 'User not exist!');
				redirect(base_url('/login'), 'refresh');
			}

			if(!$this->Users->isResetPassword($this->input->post('user_name'))) {
				redirect(base_url('/recovery-password'), 'refresh');
			}
			
			$result = $this->Users->getByUsername($this->input->post('user_name'));
			if($result == null) {
				$this->session->set_flashdata('warning', 'User not find!');
				redirect(base_url('/login'), 'refresh');
			}

			if($result['login_status'] == 1) {
				// $this->session->set_flashdata('warning', 'User already login now!');
				// redirect(base_url('/login'), 'refresh');
			}

			if($result['status'] == 'deactive') {
				$this->session->set_flashdata('warning', 'User is deactive now!');
				redirect(base_url('/login'), 'refresh');
			}

			$this->Users->updateLoginStatus($result['id'], 1);

			$this->UserActivities->add(array(
				'user_id' => $result['id'],
				'ip' => getIP(),
				'activity' => 'login'
			));

			$_SESSION['user'] = $result;

			redirect(base_url('/dashboard'), 'refresh');

		    // for google recaptcha
    		// $this->form_validation->set_rules('email', 'Email', 'trim|required');
			// $this->form_validation->set_rules('password', 'Password', 'trim|required');

			// if ($this->form_validation->run() == FALSE) {
			// 	$this->load->view('auth/login');
			// }
			// else {

				

			// 	$results = $this->Users->exist($this->input->post('email'), $this->input->post('password'));
			// 	if(count($results)){
			// 		$result = $results[0];
			// 		if($result['is_verify'] == 0){
			//     		$this->session->set_flashdata('warning', 'Please verify your email address!');
			// 			redirect(base_url('/login'));
			// 			exit;
			//     	}
			// 		if($result['is_active'] == 0){
			//     		$this->session->set_flashdata('warning', 'Your account has been deactivated!');
			// 			redirect(base_url('/login'));
			// 			exit;
			//     	}
				
			// 		$_SESSION['user_id'] = $result['id'];
			// 		$_SESSION['role'] = $result['role'];

			// 		redirect(base_url('/dashboard'), 'refresh');
				
			// 	}
			// 	else{
			// 		$data['msg'] = 'Invalid Email or Password!';
			// 		$this->load->view('auth/login', $data);
			// 	}
			// }
		}
		else{
			unset($_SESSION['user']);
			$this->load->view('auth/login');
		}
	}

	public function logout() {
		if(isset($_SESSION['user'])) {
			$this->UserActivities->add(array(
				'user_id' => $_SESSION['user']['id'],
				'ip' => getIP(),
				'activity' => 'logout'
			));
	
			$this->Users->updateLoginStatus($_SESSION['user']['id'], 0);
		}
		

		unset($_SESSION['user']);
		$this->load->view('auth/login');
	}

	public function recoveryPassword(){
		
		if($this->input->post('submit')){
		                
			if($this->input->post('email') == '') {
				$this->session->set_flashdata('warning', 'Please input your email address!');
				redirect(base_url('/recovery-password'));
			}

			if(!$this->Users->existEmail($this->input->post('email'))) {
				$this->session->set_flashdata('warning', 'email doesn\'t exist!');
				redirect(base_url('/recovery-password'));
			}

			$reset_token = bin2hex(openssl_random_pseudo_bytes(16));
			$this->Users->updateResetToken($this->input->post('email'), $reset_token);
			
			$reset_page_link = base_url('/reset-password')."/".$reset_token;

			sendMail($this->input->post('email'), 'Reset password', 'this is reset link<br><a href="'.$reset_page_link.'">'.$reset_page_link."</a>");
			$this->session->set_flashdata('success', 'reset password link sent');
			redirect(base_url('/recovery-password'));

			return;

			//checking server side validation
			// $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
			// if ($this->form_validation->run() === FALSE) {
			// 	$this->load->view('auth/forgot-password');
			// 	return;
			// }
			// $email = $this->input->post('email');
			// $response = $this->Users->check_user_mail($email);
			// if($response){
			// 	$rand_no = rand(0,1000);
			// 	$pwd_reset_code = md5($rand_no.$response['id']);
			// 	$this->Users->update_reset_code($pwd_reset_code, $response['id']);

			// 	$result = $this->mailer->sendResetPasswordMail(array(
			// 		'username' => strtoupper($response['first_name'].' '.$response['last_name']),
			// 		'reset_link' => base_url('/reset-password/').$pwd_reset_code,
			// 		'to' => $response['email']
			// 	));

			// 	if($result['success']){
			// 		$this->session->set_flashdata('success', 'We have sent instructions for resetting your password to your email');
			// 		redirect(base_url('/forgot-password'));
			// 	}
			// 	else{
			// 		$this->session->set_flashdata('error', 'There is the problem on your email');
			// 		redirect(base_url('/forgot-password'));
			// 	}
			// }
			// else{
			// 	$this->session->set_flashdata('error', 'The Email that you provided are invalid');
			// 	redirect(base_url('/forgot-password'));
			// }
		}
		else{
			$this->load->view('auth/recovery-password');	
		}
	}

	public function resetPassword($reset_token){
		if($this->input->post('submit')){
			// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			// $this->form_validation->set_rules('re_password', 'Password Confirmation', 'trim|required|matches[password]');

			// if ($this->form_validation->run() == FALSE) {
			// 	$data['reset_token'] = $reset_token;
			// 	$this->session->set_flashdata('waring','Please use same pas');
			// 	$this->load->view('auth/reset-password',$data);
			// }   
			if($this->input->post('password') == '' || $this->input->post('re_password') == '') {
				$this->session->set_flashdata('warning','Please input 2 fields');
				redirect(base_url('/reset-password').'/'.$reset_token);
				// $data['reset_token'] = $reset_token;
				// $this->load->view('auth/reset-password',$data);
			}
			if($this->input->post('password') != $this->input->post('re_password')) {
				$this->session->set_flashdata('warning','Please use same fields');
				redirect(base_url('/reset-password').'/'.$reset_token);
				// $data['reset_token'] = $reset_token;
				// $this->load->view('auth/reset-password',$data);
			}

			$this->Users->resetPassword($reset_token, $this->input->post('password'));
			$this->session->set_flashdata('success','New password has been Updated successfully');
			redirect(base_url('/login'));
		}
		else{
			
			if($this->Users->existResetToken($reset_token)){
				$data['reset_token'] = $reset_token;
				$this->load->view('auth/reset-password',$data);
			}
			else{
				$this->session->set_flashdata('error','Password Reset Code is either invalid or expired.');
				redirect(base_url('/forgot-password'));
			}
		}
	}

	public function dashboard(){
		if(!isset($_SESSION['user'])){
			redirect(base_url('/login'));
		}

		$data = array();

		$data['title'] = 'Dashboard';
		$data['sub_page'] = 'dashboard';

		if($_SESSION['user']['role'] == 1) {
			// Admin
			$data['batch_files'] = array(
				'processed' => count($this->BatchFiles->allByStatus('processed')),
				'pending' => count($this->BatchFiles->allByStatus('pending')),
				'total' => count($this->BatchFiles->all()),
			);
		}
		else {
			$data['batch_files'] = array(
				'processed' => count($this->BatchFiles->allByStatus('processed')),
				'pending' => count($this->BatchFiles->allByStatus('pending')),
				'acked' => count($this->BatchFiles->allByStatus('acked')),
			);
		}
		

		$this->load->view('dashboard/basic', $data);
	}

}
